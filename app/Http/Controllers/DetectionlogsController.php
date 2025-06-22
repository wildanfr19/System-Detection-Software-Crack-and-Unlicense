<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetectionLog;
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
          $logs = DetectionLog::orderBy('detected_at', 'desc')->paginate(20);
          return view('logs.index', compact('logs'));
    }
}
