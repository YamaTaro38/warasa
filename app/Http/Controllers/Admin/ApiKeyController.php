<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Services\MultiProviderAIService;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    protected $aiService;
    
    public function __construct(MultiProviderAIService $aiService)
    {
        $this->aiService = $aiService;
    }
    
    public function index()
    {
        $keys = ApiKey::orderBy('provider')->orderBy('priority', 'desc')->get();
        return view('admin.api-keys.index', compact('keys'));
    }
    
    public function create()
    {
        return view('admin.api-keys.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'provider' => 'required|in:gemini,pollinations',
            'key' => 'required|unique:api_keys',
            'priority' => 'integer',
        ]);
        
        ApiKey::create($request->only(['provider', 'key', 'priority']));
        return redirect()->route('admin.api-keys.index')->with('success', 'API Key added');
    }
    
    public function edit(ApiKey $apiKey)
    {
        return view('admin.api-keys.edit', compact('apiKey'));
    }
    
    public function update(Request $request, ApiKey $apiKey)
    {
        $request->validate([
            'priority' => 'integer',
            'status' => 'in:active,limited,disabled',
        ]);
        
        $apiKey->update($request->only(['priority', 'status']));
        return redirect()->route('admin.api-keys.index')->with('success', 'Updated');
    }
    
    public function destroy(ApiKey $apiKey)
    {
        $apiKey->delete();
        return redirect()->route('admin.api-keys.index')->with('success', 'Deleted');
    }
    
    public function checkNow()
    {
        $this->aiService->checkAllGeminiKeys();
        return redirect()->back()->with('success', 'All keys checked');
    }
}