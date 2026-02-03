<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function send(User $user)
    {
        $sender = auth()->user();

        if ($sender->id === $user->id) {
            return back()->with('error', "Tu ne peux pas t'ajouter toi-même.");
        }

        // déjà ami ?
        $alreadyFriend = $sender->friends()->where('users.id', $user->id)->exists();
        if ($alreadyFriend) {
            return back()->with('error', "Vous êtes déjà amis.");
        }

        // demande déjà envoyée ?
        $exists = FriendRequest::where('sender_id', $sender->id)
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return back()->with('error', "Demande déjà envoyée.");
        }

        // demande inverse en attente ?
        $reverse = FriendRequest::where('sender_id', $user->id)
            ->where('receiver_id', $sender->id)
            ->where('status', 'pending')
            ->first();

        if ($reverse) {
            return back()->with('error', "Cette personne t’a déjà envoyé une demande. Va l’accepter/rejeter.");
        }

        $friendRequest = FriendRequest::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $user->id,
            'status'      => 'pending',
        ]);

        $user->notify(new FriendRequestNotification($friendRequest));

        return back()->with('success', "Demande envoyée ✅");
    }

    public function accept(Request $request, FriendRequest $friendRequest)
    {
        $user = auth()->user();

        if ($friendRequest->receiver_id !== $user->id || $friendRequest->status !== 'pending') {
            abort(403);
        }

        $friendRequest->update(['status' => 'accepted']);

        // créer amitié dans les 2 sens
        $user->friends()->syncWithoutDetaching([$friendRequest->sender_id]);
        User::find($friendRequest->sender_id)->friends()->syncWithoutDetaching([$user->id]);

        // marquer notif comme lue si envoyée
        if ($request->filled('notification_id')) {
            $user->notifications()->where('id', $request->notification_id)->update(['read_at' => now()]);
        }

        return back()->with('success', "Demande acceptée ✅");
    }

    public function reject(Request $request, FriendRequest $friendRequest)
    {
        $user = auth()->user();

        if ($friendRequest->receiver_id !== $user->id || $friendRequest->status !== 'pending') {
            abort(403);
        }

        $friendRequest->update(['status' => 'rejected']);

        if ($request->filled('notification_id')) {
            $user->notifications()->where('id', $request->notification_id)->update(['read_at' => now()]);
        }

        return back()->with('success', "Demande refusée ❌");
    }
}
