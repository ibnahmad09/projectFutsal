<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use App\Models\User;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Data untuk booking trends
        $bookingTrends = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->pluck('count')
                ->toArray()
        ];

        // Data untuk user growth
        $userGrowth = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->pluck('count')
                ->toArray()
        ];

        // Data untuk field performance
        $fieldPerformance = [
            'labels' => Field::pluck('name')->toArray(),
            'data' => Field::withCount('bookings')->pluck('bookings_count')->toArray()
        ];

        // Data untuk revenue
        $revenueData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => Booking::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
                ->groupBy('month')
                ->pluck('total')
                ->toArray()
        ];

        return view('admin.analytics', compact(
            'bookingTrends',
            'userGrowth',
            'fieldPerformance',
            'revenueData'
        ));
    }
} 