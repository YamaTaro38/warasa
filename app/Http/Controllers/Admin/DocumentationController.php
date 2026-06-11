<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentationController extends Controller
{
    public function index()
    {
        $documentations = Documentation::orderBy('sort_order')->orderBy('title')->paginate(20);
        return view('admin.documentations.index', compact('documentations'));
    }

    public function create()
    {
        return view('admin.documentations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ]);

        $validated['uuid'] = Str::uuid()->toString();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published', true);

        Documentation::create($validated);

        return redirect()->route('admin.documentations.index')
            ->with('success', 'Documentation created successfully');
    }

    public function edit(Documentation $documentation)
    {
        return view('admin.documentations.edit', compact('documentation'));
    }

    public function update(Request $request, Documentation $documentation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published', true);

        $documentation->update($validated);

        return redirect()->route('admin.documentations.index')
            ->with('success', 'Documentation updated successfully');
    }

    public function destroy(Documentation $documentation)
    {
        $documentation->delete();
        return redirect()->route('admin.documentations.index')
            ->with('success', 'Documentation deleted successfully');
    }

    public function togglePublished(Documentation $documentation)
    {
        $documentation->update(['is_published' => !$documentation->is_published]);
        return back()->with('success', 'Documentation status updated');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $image = $request->file('image');
        $path = $image->store('documentations', 'public');

        return response()->json([
            'location' => asset('storage/' . $path)
        ]);
    }
}
