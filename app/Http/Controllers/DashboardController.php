<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // Recent products for table
        $recentProducts = Product::where('user_id', $user->id)
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Chart data: products created per month (last 6 months)
        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');
            $chartData[] = Product::where('user_id', $user->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Published vs Draft for donut chart
        $donutData = [$publishedProducts, $draftProducts];

        return view('dashboard.index', compact(
            'totalProducts', 'publishedProducts', 'draftProducts', 'totalProjects',
            'portfolioValue', 'averagePrice', 'recentProducts',
            'chartLabels', 'chartData', 'donutData'
        ));
    }
}
