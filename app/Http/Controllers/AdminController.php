<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Project;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalProjects = Project::count();
        $totalActivities = ActivityLog::count();

        $recentUsers = User::latest()->limit(5)->get();
        $recentActivities = ActivityLog::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalProducts', 'totalProjects', 
            'totalActivities', 'recentUsers', 'recentActivities'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function userShow(User $user)
    {
        $products = $user->products()->latest()->limit(10)->get();
        $projects = $user->projects()->latest()->limit(10)->get();
        
        return view('admin.user-show', compact('user', 'products', 'projects'));
    }

    public function userSuspend(User $user)
    {
        $user->update(['is_active' => false]);
        
        return back()->with('success', 'User suspended successfully!');
    }

    public function userActivate(User $user)
    {
        $user->update(['is_active' => true]);
        
        return back()->with('success', 'User activated successfully!');
    }

    public function userDelete(User $user)
    {
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // Implement settings update logic
        return back()->with('success', 'Settings updated successfully!');
    }
}