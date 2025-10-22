<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\DetectionLog;

class DedupeController extends Controller
{
    /**
     * Check if a detection record already exists.
     * Accepts JSON POST with: { type: 'installed_app'|'suspicious_file', app_name?, path?, fingerprint? }
     * Returns JSON { exists: true|false }
     */
    public function check(Request $request)
    {
        try {
            // optional API key check (if you want to enforce it, set env APPDETECTOR_API_KEY and uncomment)
            $expectedKey = env('APPDETECTOR_API_KEY');
            if ($expectedKey) {
                $provided = $request->header('X-API-KEY');
                if ($provided !== $expectedKey) {
                    return response()->json(['error' => 'invalid api key'], 401);
                }
            }

            $type = $request->input('type');
            if ($type === 'installed_app') {
                $app = $request->input('app_name');
                $pc  = $request->input('pc_name');
                if (!$app || !$pc) {
                    return response()->json(['exists' => false]);
                }
                $exists = DetectionLog::where('pc_name', $pc)->where('app_name', $app)->exists();
                Log::info('Dedupe check installed_app', ['pc' => $pc, 'app' => $app, 'exists' => $exists]);
                return response()->json(['exists' => (bool)$exists]);
            }

            if ($type === 'suspicious_file') {
                // prefer fingerprint (if client provides it)
                $pc = $request->input('pc_name');
                // prefer path lookup; fingerprint column is not available in this schema
                $path = $request->input('path');
                if (!$path || !$pc) {
                    return response()->json(['exists' => false]);
                }
                // check by pc_name + path
                $exists = DetectionLog::where('pc_name', $pc)->where('path', $path)->exists();
                Log::info('Dedupe check path (no fingerprint column)', ['pc' => $pc, 'path' => $path, 'exists' => $exists]);
                return response()->json(['exists' => (bool)$exists]);
            }

            return response()->json(['exists' => false]);
        } catch (\Exception $e) {
            Log::warning('DedupeController error: ' . $e->getMessage());
            return response()->json(['exists' => false]);
        }
    }
}
