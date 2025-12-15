<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\User;
use App\Models\SearchLog;

class HomeController extends Controller
{
    /**
     * Show landing page with recommendations
     * Weighted algorithm: 70% most searched, 25% most viewed, 5% random
     */
    public function index()
    {
        // Featured services for carousel (top rated + most viewed)
        $featured = Service::with('developer')
            ->orderByDesc('views_count')
            ->take(6)
            ->get();
        
        // Get all categories
        $categories = ['Desain', 'Editing Video', 'Pemrograman', 'Konsultasi', 'Layanan Lain'];
        
        // Calculate recommended services using weighted algorithm
        $recommended = $this->getWeightedRecommendations();
        
        // All services grouped by category
        $servicesByCategory = [];
        foreach ($categories as $category) {
            $servicesByCategory[$category] = Service::with('developer')
                ->where('kategori', $category)
                ->orderByDesc('views_count')
                ->take(8)
                ->get();
        }
        
        // All services for "Semua" tab
        $allServices = Service::with('developer')
            ->orderByDesc('created_at')
            ->get();
        
        return view('landing', compact(
            'featured',
            'recommended',
            'categories',
            'servicesByCategory',
            'allServices'
        ));
    }
    
    /**
     * Get weighted recommendations
     * 50% most visited, 20% most searched, 14% high rating, 16% random
     * With 20% shuffle variance on each reload
     */
    private function getWeightedRecommendations($total = 8)
    {
        $viewedCount = (int) ceil($total * 0.50);  // 50% = 4 items
        $searchCount = (int) ceil($total * 0.20);  // 20% = 2 items
        $ratingCount = (int) ceil($total * 0.14);  // 14% = 1 item
        $randomCount = $total - $viewedCount - $searchCount - $ratingCount; // 16% = remaining
        
        // 20% extra candidates for shuffling variance
        $extraFactor = 1.2;
        
        $recommended = collect();
        $usedIds = [];
        
        // 1. Most visited services (50%) - get extra and shuffle
        $viewedCandidates = Service::with('developer')
            ->orderByDesc('views_count')
            ->take((int) ceil($viewedCount * $extraFactor))
            ->get()
            ->shuffle()
            ->take($viewedCount);
        
        $recommended = $recommended->concat($viewedCandidates);
        $usedIds = $recommended->pluck('id_service')->toArray();
        
        // 2. Most searched keywords (20%) - get extra and shuffle
        $topSearches = SearchLog::select('query', DB::raw('COUNT(*) as count'))
            ->groupBy('query')
            ->orderByDesc('count')
            ->take(10)
            ->pluck('query')
            ->toArray();
        
        if (!empty($topSearches)) {
            $searchCandidates = Service::with('developer')
                ->whereNotIn('id_service', $usedIds)
                ->where(function($q) use ($topSearches) {
                    foreach ($topSearches as $search) {
                        $q->orWhere('judul', 'like', "%{$search}%")
                          ->orWhere('kategori', 'like', "%{$search}%")
                          ->orWhere('deskripsi', 'like', "%{$search}%");
                    }
                })
                ->orderByDesc('views_count')
                ->take((int) ceil($searchCount * $extraFactor))
                ->get()
                ->shuffle()
                ->take($searchCount);
            
            $recommended = $recommended->concat($searchCandidates);
            $usedIds = $recommended->pluck('id_service')->toArray();
        }
        
        // 3. High rating services (14%) - get extra and shuffle
        $ratingCandidates = Service::with('developer')
            ->whereNotIn('id_service', $usedIds)
            ->whereHas('developer', function($q) {
                $q->where('average_rating', '>=', 4.0);
            })
            ->orderByDesc('views_count')
            ->take((int) ceil($ratingCount * $extraFactor))
            ->get()
            ->shuffle()
            ->take($ratingCount);
        
        $recommended = $recommended->concat($ratingCandidates);
        $usedIds = $recommended->pluck('id_service')->toArray();
        
        // 4. Random services (16%)
        if ($randomCount > 0) {
            $randomBased = Service::with('developer')
                ->whereNotIn('id_service', $usedIds)
                ->inRandomOrder()
                ->take($randomCount)
                ->get();
            
            $recommended = $recommended->concat($randomBased);
        }
        
        // Fill if not enough
        if ($recommended->count() < $total) {
            $usedIds = $recommended->pluck('id_service')->toArray();
            $fillCount = $total - $recommended->count();
            
            $filler = Service::with('developer')
                ->whereNotIn('id_service', $usedIds)
                ->inRandomOrder()
                ->take($fillCount)
                ->get();
            
            $recommended = $recommended->concat($filler);
        }
        
        // Final shuffle of all recommendations for additional variety
        return $recommended->shuffle()->take($total);
    }
    
    /**
     * Track user category preference when viewing a service
     */
    public static function trackPreference($category)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $preferences = $user->category_preferences ?? [];
            
            // Increment category count
            if (isset($preferences[$category])) {
                $preferences[$category]++;
            } else {
                $preferences[$category] = 1;
            }
            
            $user->category_preferences = $preferences;
            $user->save();
        }
    }
    
    /**
     * Search services and developers
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $category = $request->input('category', '');
        
        // Log search query for recommendation algorithm
        if (!empty($query) && strlen($query) >= 2) {
            SearchLog::create([
                'query' => $query,
                'user_id' => Auth::id(),
            ]);
        }
        
        // Search services
        $servicesQuery = Service::with('developer')
            ->where(function($q) use ($query) {
                $q->where('judul', 'like', "%{$query}%")
                  ->orWhere('deskripsi', 'like', "%{$query}%")
                  ->orWhere('kategori', 'like', "%{$query}%");
            });
        
        // Filter by category if specified
        if (!empty($category)) {
            $servicesQuery->where('kategori', $category);
        }
        
        $services = $servicesQuery->orderByDesc('views_count')->get();
        
        // Search developers
        $developers = User::where('role', 'developer')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('specialization', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->take(10)
            ->get();
        
        // Get all categories for filter
        $categories = ['Desain', 'Editing Video', 'Pemrograman', 'Konsultasi', 'Layanan Lain'];
        
        return view('search', compact('query', 'services', 'developers', 'categories', 'category'));
    }
    
    /**
     * Get search suggestions for autocomplete
     */
    public function suggestions(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        // Get service titles
        $services = Service::where('judul', 'like', "%{$query}%")
            ->select('judul', 'kategori', 'id_service')
            ->take(5)
            ->get()
            ->map(fn($s) => [
                'type' => 'service',
                'label' => $s->judul,
                'category' => $s->kategori,
                'url' => route('search', ['q' => $s->judul])
            ]);
        
        // Get categories
        $categories = collect(['Desain', 'Editing Video', 'Pemrograman', 'Konsultasi', 'Layanan Lain'])
            ->filter(fn($c) => stripos($c, $query) !== false)
            ->map(fn($c) => [
                'type' => 'category',
                'label' => $c,
                'category' => $c,
                'url' => route('search', ['q' => '', 'category' => $c])
            ]);
        
        // Get developers
        $developers = User::where('role', 'developer')
            ->where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'specialization')
            ->take(3)
            ->get()
            ->map(fn($d) => [
                'type' => 'developer',
                'label' => $d->name,
                'category' => $d->specialization ?? 'Developer',
                'url' => route('search', ['q' => $d->name])
            ]);
        
        $suggestions = $services->concat($categories)->concat($developers)->take(8);
        
        return response()->json($suggestions);
    }
}
