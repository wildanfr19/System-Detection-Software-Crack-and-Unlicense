<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetectionLog;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class DetectionlogsController extends Controller
{
    /**
     * Dashboard charts-only view (no table). Charts fetch data via AJAX routes.
     */
    public function dashboard()
    {
        // Totals for info cards (exclude Clean PC from detection totals)
        $totalDetected = DetectionLog::where('source', '!=', 'Clean PC')->count();
        $totalPCs = DetectionLog::where('source', '!=', 'Clean PC')
            ->distinct('pc_name')->count('pc_name');

            //    $totalUsers = DetectionLog::where('source', '!=', 'Clean PC')
            // ->whereNotNull('user_name')
            // ->distinct('user_name')->count('user_name');
        // Count unique user+IP pairs. This treats the same user on different IPs as separate
        // occurrences (useful when user_name may be reused across devices/networks).
        // We use CONCAT with a separator for portability across DBs instead of COUNT(DISTINCT col1, col2).
        $totalUsers = (int) DetectionLog::where('source', '!=', 'Clean PC')
            ->whereNotNull('user_name')
            ->whereNotNull('ip_address')
            ->select(DB::raw('COUNT(DISTINCT CONCAT(user_name, "||", ip_address)) as cnt'))
            ->value('cnt');
        $totalApps = DetectionLog::where('source', '!=', 'Clean PC')
            ->whereNotNull('app_name')
            ->where('app_name', '<>', '')
            ->distinct('app_name')->count('app_name');

        return view('logs.dashboard', compact('totalDetected', 'totalPCs', 'totalUsers', 'totalApps'));
    }
    public function store(Request $request)
    {
        try {
            $payload = $request->json()->all();

            $rules = [
                'pc_name' => 'required|string',
                'user_name' => 'required|string',
                // app_name may be null for Clean PC entries
                'app_name' => 'nullable|string',
                // detected_at may be null (client may send null for Clean PC); fill server-side if missing
                'detected_at' => 'nullable|date',
                'ip_address' => 'nullable|ip',
                'mac_address' => 'nullable|string',
                'path' => 'nullable|string',
                'source' => 'nullable|string',
            ];

            $validator = \Validator::make($payload, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $validated = $validator->validated();
            // Ensure app_name is not null because DB schema defines it as non-nullable
            if (! array_key_exists('app_name', $validated) || $validated['app_name'] === null) {
                $validated['app_name'] = '';
            }

            // Server-side dedupe: if a record already exists, skip insert and return 200
            $pc = $validated['pc_name'] ?? null;
            $path = $validated['path'] ?? null;
            $app  = $validated['app_name'] ?? null;

            $exists = false;
            // If a path is provided, only dedupe by exact path (folder/file location).
            // This prevents skipping same-named folders that exist in different locations.
            if ($pc && $path) {
                $exists = DetectionLog::where('pc_name', $pc)->where('path', $path)->exists();
            } elseif ($pc && $app !== null && $app !== '') {
                // Only check by app_name when no path was provided (e.g., installed-app reports)
                $exists = DetectionLog::where('pc_name', $pc)->where('app_name', $app)->exists();
            }

            if ($exists) {
                return response()->json(['message' => 'Already exists'], 200);
            }

            // If detected_at isn't provided, set it to now
            if (empty($validated['detected_at'])) {
                $validated['detected_at'] = Carbon::now()->toDateTimeString();
            }

            // If there are any 'Clean PC' marker rows for this PC, remove them
            // and always insert the new detection. Wrap in a transaction to avoid
            // races where a Clean PC is removed but the new detection isn't saved.
            DB::transaction(function () use ($pc, $validated) {
                DetectionLog::where('pc_name', $pc)->where('source', 'Clean PC')->delete();
                DetectionLog::create($validated);
            });

            // For client compatibility treat saved as 200 OK (agent expects 200)
            return response()->json(['message' => 'Log saved successfully.'], 200);
        } catch (\Exception $e) {
            \Log::error('Detection log store error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    public function index()
    {
        $logs = DetectionLog::selectRaw('
                    pc_name,
                    MAX(detected_at) as latest_detected_at,
                    MAX(user_name) as user_name,
                    MAX(ip_address) as ip_address,
                    MAX(mac_address) as mac_address
                ')
            ->groupBy('pc_name')
            ->where('source', '!=', 'Clean PC')
            ->orderBy('latest_detected_at', 'desc')

            ->paginate(20);
        // dd($logs);
        return view('logs.index', compact('logs'));
    }

    public function showDetail(Request $request, $params)
    {
        if ($request->ajax()) {
            $data = DetectionLog::query()->where('pc_name', $params)->where('source','!=','Clean PC')->get();
            return DataTables::of($data)
            ->make(true);
        }
    }

    public function export(Request $request)
    {
        $filename = 'detection_logs_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new LogExport, $filename);
    }
    public function exportClean(Request $request)
    {
        $filename = 'clean_pc_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new \App\Exports\CleanPcExport, $filename);
    }

    public function getLiveLogs(Request $request)
    {
        $logs = DetectionLog::selectRaw('
                    pc_name,
                    MAX(detected_at) as latest_detected_at,
                    MAX(user_name) as user_name,
                    MAX(ip_address) as ip_address,
                    MAX(mac_address) as mac_address
                ')
            ->groupBy('pc_name')
            ->where('source','!=','Clean PC')
            ->orderBy('latest_detected_at', 'desc')->get();
        return response()->json($logs);
    }

    /**
     * Return simple stats: detections per day for the last N days (default 7).
     */
    public function stats(Request $request)
    {
        $days = (int) $request->get('days', 7);
        $start = Carbon::now()->subDays($days - 1)->startOfDay();

        $rows = DetectionLog::selectRaw('DATE(detected_at) as date, COUNT(*) as count')
            ->whereNotNull('detected_at')
            ->where('detected_at', '>=', $start)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        $labels = [];
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i)->format('Y-m-d');
            $labels[] = $d;
            $data[] = isset($rows[$d]) ? (int)$rows[$d] : 0;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    /**
     * Stats per PC Name (bar chart): counts within last N days (default 7), limited by top M (default 10).
     */
    public function statsPerPc(Request $request)
    {
        $days = (int) $request->get('days', 7);
        $limit = (int) $request->get('limit', 10);
        $start = Carbon::now()->subDays($days - 1)->startOfDay();

        $baseQuery = DetectionLog::selectRaw('pc_name, COUNT(*) as count')
            ->whereNotNull('pc_name')
            ->where('detected_at', '>=', $start)
            ->groupBy('pc_name')
            ->where('source','!=','Clean PC')
            ->orderByDesc('count');

        // Get limited rows for chart
        $rows = (clone $baseQuery)->limit($limit)->get();

        // Also compute total distinct PCs in range (for UI info)
        $totalDistinct = DetectionLog::whereNotNull('pc_name')
            ->where('detected_at', '>=', $start)
            ->where('source','!=','Clean PC')
            ->distinct('pc_name')->count('pc_name');

        $labels = $rows->pluck('pc_name');
        $data = $rows->pluck('count')->map(fn ($v) => (int) $v);

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'meta' => [
                'days' => $days,
                'limit' => $limit,
                'totalDistinct' => (int) $totalDistinct,
                'returned' => count($data),
            ],
        ]);
    }
    public function cleanList(Request $request)
    {
        if ($request->ajax()) {
            $rows = DetectionLog::selectRaw('
                    pc_name,
                    MAX(detected_at) as latest_detected_at,
                    MAX(user_name) as user_name,
                    MAX(ip_address) as ip_address,
                    MAX(mac_address) as mac_address
                ')
                ->where('source', 'Clean PC')
                ->groupBy('pc_name')
                ->orderBy('latest_detected_at', 'desc')
                ->get();

            return DataTables::of($rows)
                ->editColumn('latest_detected_at', function ($row) {
                    return $row->latest_detected_at;
                })
                ->make(true);
        }

        // Non-AJAX access can redirect to dashboard or return empty
        return redirect('/dashboard');
    }
}
