<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller{

    public function index(Request $request){

    $user = $request->user();

    // the query of the search
    $q = trim((string) $request->get('q', ''));

    // existing friends
    $friendIds = $user->friends()->pluck('users.id')->toArray();

    // pending requests (sent)
    $sentPending = \App\Models\FriendRequest::where('sender_id', $user->id)
        ->where('status', 'pending')
        ->pluck('receiver_id')
        ->toArray();

    // pending requests (received)
    $receivedPending = \App\Models\FriendRequest::where('receiver_id', $user->id)
        ->where('status', 'pending')
        ->pluck('sender_id')
        ->toArray();

    // exclude ids from search/suggestions
    $excludeIds = array_unique(array_merge($friendIds, $sentPending, $receivedPending, [$user->id]));

    // search results
    $results = collect();
    if ($q !== '') {
        $results = \App\Models\User::query()
            ->whereNotIn('id', $excludeIds)
            ->where(function ($query) use ($q) {
                $query->where('name', 'ilike', "%{$q}%")
                      ->orWhere('email', 'ilike', "%{$q}%")
                      ->orWhere('speciallity', 'ilike', "%{$q}%");
            })
            ->limit(20)
            ->get();
    }

    // suggestions only if no search
    $suggestions = $q === ''
        ? \App\Models\User::query()->whereNotIn('id', $excludeIds)->limit(8)->get(): collect();

    $friends = $user->friends()->limit(10)->get();
    $notifications = $user->unreadNotifications;

    if ($user->hasRole('recruteur')) {
        return view('dashboard.recruteur', compact('user', 'suggestions', 'friends', 'notifications', 'q', 'results'));
    }

    return view('dashboard.chercheur', compact('user', 'suggestions', 'friends', 'notifications', 'q', 'results'));
}

}