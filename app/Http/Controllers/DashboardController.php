<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
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
        $topProducts = Product::where('user_id', $user->id)->with('category', 'images')->orderBy('price', 'desc')->limit(5)->get();

        return view('dashboard', compact('totalProducts', 'publishedProducts', 'draftProducts', 'totalProjects', 'portfolioValue', 'averagePrice', 'topProducts'));
    }
}
