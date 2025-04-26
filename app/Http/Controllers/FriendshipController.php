<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function sendRequest(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot add yourself as a friend.');
        }

        $exists = Friendship::where(function($q) use ($user) {
            $q->where('user_id', Auth::id())->where('friend_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('user_id', $user->id)->where('friend_id', Auth::id());
        })->exists();

        if ($exists) {
            return back()->with('error', 'Friend request already sent or you are already friends.');
        }

        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
            'status' => 'pending',
        ]);

        // Notify the recipient
        $user->notify(new FriendRequestNotification(Auth::user()));

        return back()->with('success', 'Friend request sent!');
    }

    public function acceptRequest(Friendship $friendship)
    {
        if ($friendship->friend_id !== Auth::id()) {
            abort(403);
        }
        $friendship->update(['status' => 'accepted']);
        return back()->with('success', 'Friend request accepted!');
    }

    public function removeFriend(User $user)
    {
        Friendship::where(function($q) use ($user) {
            $q->where('user_id', Auth::id())->where('friend_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('user_id', $user->id)->where('friend_id', Auth::id());
        })->delete();

        return back()->with('success', 'Friend removed.');
    }
}
