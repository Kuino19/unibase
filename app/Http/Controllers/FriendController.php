<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $users = User::where('id', '!=', Auth::id())
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', "%$query%")
                        ->orWhere('email', 'like', "%$query%") ;
                });
            })
            ->get();
        return view('friends.index', compact('users'));
    }
}
