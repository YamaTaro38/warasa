<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $totalProducts = Product::where('user_id', $user->id)->where('is_archived', false)->count();
        $publishedProducts = Product::where('user_id', $user->id)->where('status', 'published')->count();
        $draftProducts = Product::where('user_id', $user->id)->where('status', 'draft')->count();
        $totalProjects = Project::where('user_id', $user->id)->where('is_archived', false)->count();
        
        $products = Product::where('user_id', $user->id)->where('is_archived', false)->get();
        $portfolioValue = $products->sum(fn($p) => $p->price * $p->stock);
        $averagePrice = $products->avg('price') ?? 0;
        $lowStockProducts = $products->where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStock = $products->where('stock', '<=', 0)->count();
        
        $recentProducts = Product::where('user_id', $user->id)
            ->with('category', 'images')
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $recentActivities = ActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $month->format('M'),
                'products' => Product::where('user_id', $user->id)
                    ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                    ->count(),
            ];
        }
        
        $statusChart = [
            ['label' => 'Published', 'value' => $publishedProducts, 'color' => '#10b981'],
            ['label' => 'Draft', 'value' => $draftProducts, 'color' => '#f59e0b'],
        ];

        return view('dashboard', compact(
            'totalProducts', 'publishedProducts', 'draftProducts', 
            'totalProjects', 'portfolioValue', 'averagePrice',
            'lowStockProducts', 'outOfStock',
            'recentProducts', 'recentActivities',
            'monthlyStats', 'statusChart'
        ));
    }
}