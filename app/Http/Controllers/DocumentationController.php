<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function index(Request $request)
    {
        $query = Documentation::published()->ordered();

        if ($search = $request->get('q')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $documentations = $query->get();

        // Group by category for display
        $categories = $documentations->groupBy('category');

        $searchQuery = $search ?? '';
        $resultsCount = $documentations->count();

        return view('docs', compact('categories', 'searchQuery', 'resultsCount'));
    }

    public function show($slug)
    {
        $doc = Documentation::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $sidebar = Documentation::published()
            ->ordered()
            ->get()
            ->groupBy('category');

        return view('docs-show', compact('doc', 'sidebar'));
    }
}