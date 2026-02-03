<?php

namespace App\Notifications;

use App\Models\FriendRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FriendRequestNotification extends Notification
{
    use Queueable;

    public function __construct(public FriendRequest $friendRequest) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'friend_request_id' => $this->friendRequest->id,
            'sender_id'         => $this->friendRequest->sender_id,
            'sender_name'       => optional($this->friendRequest->sender)->name,
            'message'           => 'Nouvelle demande d’amitié',
        ];
    }
}
