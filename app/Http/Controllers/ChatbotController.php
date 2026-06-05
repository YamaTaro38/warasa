<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\ActivityLog;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        $sessions = ChatSession::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $currentSession = $sessions->first();

        if ($currentSession) {
            $messages = ChatMessage::where('session_id', $currentSession->id)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $messages = collect();
        }

        return view('chatbot.index', compact('sessions', 'currentSession', 'messages'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'session_id' => 'nullable|exists:chat_sessions,id',
        ]);

        // Get or create session
        $session = ChatSession::firstOrCreate(
            ['id' => $request->session_id, 'user_id' => Auth::id()],
            ['title' => substr($validated['message'], 0, 50)]
        );

        // Save user message
        $userMessage = ChatMessage::create([
            'session_id' => $session->id,
            'role' => 'user',
            'content' => $validated['message'],
        ]);

        // Get AI response
        $aiResponse = $this->aiService->chat($validated['message'], $session->id);

        // Save AI response
        $assistantMessage = ChatMessage::create([
            'session_id' => $session->id,
            'role' => 'assistant',
            'content' => $aiResponse,
        ]);

        // Update session timestamp
        $session->touch();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'chat',
            'description' => 'Chat with AI',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => $assistantMessage,
            'session_id' => $session->id,
        ]);
    }

    public function sessions()
    {
        $sessions = ChatSession::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'title' => $session->title,
                    'updated_at' => $session->updated_at->diffForHumans(),
                    'message_count' => $session->messages()->count(),
                ];
            });

        return response()->json(['sessions' => $sessions]);
    }

    public function loadSession(ChatSession $session)
    {
        $this->authorize('view', $session);

        $messages = $session->messages()
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function destroySession(ChatSession $session)
    {
        $this->authorize('delete', $session);

        $session->delete();

        return redirect()->route('chatbot')
            ->with('success', 'Chat session deleted successfully!');
    }

    public function exportSession(ChatSession $session)
    {
        $this->authorize('view', $session);

        $messages = $session->messages()
            ->orderBy('created_at', 'asc')
            ->get();

        $content = "Chat Session: {$session->title}\n";
        $content .= "Date: {$session->created_at->format('Y-m-d H:i:s')}\n";
        $content .= str_repeat('=', 50) . "\n\n";

        foreach ($messages as $message) {
            $role = $message->role === 'user' ? '👤 User' : '🤖 Warasa AI';
            $content .= "[{$message->created_at->format('H:i:s')}] {$role}:\n";
            $content .= $message->content . "\n\n";
            $content .= str_repeat('-', 30) . "\n\n";
        }

        $filename = "chat_export_{$session->id}_{$session->created_at->format('Ymd')}.txt";

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}