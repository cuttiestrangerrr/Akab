<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;

class DeveloperDashboardController extends Controller
{
    /**
     * Show developer dashboard with real statistics
     */
    public function index()
    {
        $user = Auth::user();
        $serviceIds = Service::where('id_developer', $user->id)->pluck('id_service');
        
        // Get statistics from projects where user is developer
        $pengajuan = Project::where('id_developer', $user->id)->where('status', 'pending')->count();
        $disetujui = Project::where('id_developer', $user->id)->where('status', 'approved')->count();
        $ditolak = Project::where('id_developer', $user->id)->where('status', 'rejected')->count();
        $berjalan = Project::where('id_developer', $user->id)->where('status', 'in_progress')->count();
        
        // Total views for all services
        $totalKunjungan = Service::where('id_developer', $user->id)->sum('views_count');
        
        // Get monthly data for chart (last 6 months) - 5 datasets
        $monthLabels = [];
        $pengajuanData = [];
        $disetujuiData = [];
        $ditolakData = [];
        $pendapatanData = [];
        $kunjunganData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->format('M');
            
            // Pengajuan per bulan
            $pengajuanData[] = Project::where('id_developer', $user->id)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            // Disetujui per bulan
            $disetujuiData[] = Project::where('id_developer', $user->id)
                ->where('status', 'approved')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            // Ditolak per bulan
            $ditolakData[] = Project::where('id_developer', $user->id)
                ->where('status', 'rejected')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            // Pendapatan per bulan
            $pendapatanData[] = Order::whereIn('service_id', $serviceIds)
                ->where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_price');
            
            // Kunjungan (views) per bulan - approximate based on orders created that month
            // Since we don't have timestamps for views, we'll use total views / 6 as average
            // For more accurate tracking, we'd need a separate views log table
            $kunjunganData[] = round($totalKunjungan / 6);
        }
        
        return view('dashDev', compact(
            'pengajuan',
            'disetujui',
            'ditolak',
            'berjalan',
            'totalKunjungan',
            'monthLabels',
            'pengajuanData',
            'disetujuiData',
            'ditolakData',
            'pendapatanData',
            'kunjunganData'
        ));
    }
    
    /**
     * Show developer performance page with real data
     */
    public function performance()
    {
        $user = Auth::user();
        
        // Get service IDs owned by this developer
        $serviceIds = Service::where('id_developer', $user->id)->pluck('id_service');
        
        // Get orders statistics for developer's services
        $totalOrders = Order::whereIn('service_id', $serviceIds)->count();
        $completedOrders = Order::whereIn('service_id', $serviceIds)->where('status', 'completed')->count();
        $pendingOrders = Order::whereIn('service_id', $serviceIds)->where('status', 'pending')->count();
        
        // Statistics
        $stats = [
            'services' => $serviceIds->count(),
            'orders' => $totalOrders,
            'completed' => $completedOrders,
            'pending' => $pendingOrders,
        ];
        
        // Get monthly performance data (last 12 months) - multi dataset
        $monthLabels = [];
        $ordersData = [];
        $completedData = [];
        $earningsData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->format('M');
            
            // Total orders per month
            $ordersData[] = Order::whereIn('service_id', $serviceIds)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            // Completed orders per month
            $completedData[] = Order::whereIn('service_id', $serviceIds)
                ->where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            // Earnings per month
            $earningsData[] = Order::whereIn('service_id', $serviceIds)
                ->where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_price');
        }
        
        // Total earnings
        $totalEarnings = Order::whereIn('service_id', $serviceIds)
            ->where('status', 'completed')
            ->sum('total_price');
        
        // Rating
        $averageRating = $user->average_rating ?? 0;
        $totalReviews = $user->ratingsReceived()->count();
        
        return view('performaDev', compact(
            'stats',
            'monthLabels',
            'ordersData',
            'completedData',
            'earningsData',
            'totalEarnings',
            'averageRating',
            'totalReviews'
        ));
    }
}
