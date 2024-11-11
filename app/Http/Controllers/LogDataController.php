<?php

namespace App\Http\Controllers;

use App\Models\LogData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogDataController extends Controller
{
    public function fetchLogs($period)
    {
        // Set date range based on the period
        $startDate = match($period) {
            'week' => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'semester' => Carbon::now()->subDays(180),
            default => Carbon::now()->subDays(30),
        };

        // Fetch and group logs by date, aggregating success, fail, and total counts
        $logs = LogData::where('log_datetime', '>=', $startDate)
            ->selectRaw('DATE(log_datetime) as date, 
                         SUM(status = "success") as success_count, 
                         SUM(status = "fail") as fail_count, 
                         COUNT(*) as total_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($logs);
    }
}
