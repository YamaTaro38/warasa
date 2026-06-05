<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChatSession;

class ChatSessionPolicy
{
    public function view(User $user, ChatSession $chatSession): bool
    {
        return $user->id === $chatSession->user_id || $user->isAdmin();
    }

    public function delete(User $user, ChatSession $chatSession): bool
    {
        return $user->id === $chatSession->user_id || $user->isAdmin();
    }
}