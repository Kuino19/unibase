<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class FriendRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $fromUser;

    public function __construct(User $fromUser)
    {
        $this->fromUser = $fromUser;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'from_user_id' => $this->fromUser->id,
            'from_user_name' => $this->fromUser->name,
            'message' => 'sent you a friend request.'
        ];
    }
}
