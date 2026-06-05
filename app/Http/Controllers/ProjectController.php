<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'project_create',
            'description' => 'Created project: ' . $project->name,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $products = $project->products()
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('projects.show', compact('project', 'products'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    public function archive(Project $project)
    {
        $this->authorize('update', $project);

        $project->update(['is_archived' => true]);

        return redirect()->route('projects.index')
            ->with('success', 'Project archived successfully!');
    }

    public function restore(Project $project)
    {
        $this->authorize('update', $project);

        $project->update(['is_archived' => false]);

        return redirect()->route('projects.index')
            ->with('success', 'Project restored successfully!');
    }
}