<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\NewChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Get all accepted friends regardless of direction
        $friends = User::where(function($q) use ($user) {
            $q->whereHas('friendships', function($query) use ($user) {
                $query->where('friend_id', $user->id)->where('status', 'accepted');
            })->orWhereHas('friendsOf', function($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'accepted');
            });
        });
        if ($request->filled('search')) {
            $search = $request->input('search');
            $friends = $friends->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }
        $friends = $friends->get()->map(function($friend) use ($user) {
            $friend->is_online = $friend->is_online();
            // Placeholder: Replace with real unread count logic
            $friend->unread_count = 0;
            return $friend;
        });
        return view('chat.index', compact('friends'));
    }

    public function show(User $user)
    {
        $messages = ChatMessage::where(function($query) use ($user) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('chat.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => $request->message
        ]);

        // Notify the receiver
        if ($user->id !== Auth::id()) {
            $user->notify(new NewChatMessageNotification(Auth::user(), $request->message));
        }

        return back();
    }

    public function markAsRead(User $user)
    {
        ChatMessage::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
