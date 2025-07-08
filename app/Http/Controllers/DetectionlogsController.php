<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetectionLog;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogExport;
class DetectionlogsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pc_name' => 'required|string',
            'user_name' => 'required|string',
            'app_name' => 'required|string',
            'detected_at' => 'required|date',
            'ip_address' => 'nullable|ip',
            'mac_address' => 'nullable|string',
            'path' => 'nullable|string',
            'source' => 'nullable|string',
        ]);

        $data = DetectionLog::create($validated);

        return response()->json(['message' => 'Log saved successfully.']);
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
            ->orderBy('latest_detected_at', 'desc')
            ->paginate(20);
        // dd($logs);
        return view('logs.index', compact('logs'));
    }

    public function showDetail(Request $request, $params)
    {
        if ($request->ajax()) {
            $data = DetectionLog::query()->where('pc_name', $params)->get();
            return DataTables::of($data)->make(true);
        }
    }

    public function export(Request $request)
    {
        $filename = 'detection_logs_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new LogExport, $filename);
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
            ->orderBy('latest_detected_at', 'desc')->get();
        return response()->json($logs);
    }
}
