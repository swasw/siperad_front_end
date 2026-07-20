<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Get logs ordered by latest
        $logs = ActivityLog::orderBy('created_at', 'desc')->get();
        $title = 'Activity Log';
        return view('admin.activity-log.index', compact('logs', 'title'));
    }
}
