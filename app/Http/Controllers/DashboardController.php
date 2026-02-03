<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user();

    $friendIds = $user->friends()->pluck('users.id')->toArray();

    $sentPending = \App\Models\FriendRequest::where('sender_id', $user->id)
        ->where('status', 'pending')
        ->pluck('receiver_id')
        ->toArray();

    $receivedPending = \App\Models\FriendRequest::where('receiver_id', $user->id)
        ->where('status', 'pending')
        ->pluck('sender_id')
        ->toArray();

    $suggestions = \App\Models\User::query()
        ->whereKeyNot($user->id)
        ->whereNotIn('id', $friendIds)
        ->whereNotIn('id', $sentPending)
        ->whereNotIn('id', $receivedPending)
        ->limit(8)
        ->get();

    $friends = $user->friends()->limit(10)->get();

    $notifications = $user->unreadNotifications;

    if ($user->hasRole('recruteur')) {
        return view('dashboard.recruteur', compact('user', 'suggestions', 'friends', 'notifications'));
    }

    return view('dashboard.chercheur', compact('user', 'suggestions', 'friends', 'notifications'));
}
}
