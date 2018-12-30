<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\Notifications;
use App\Models\NotificationReceivers;
use App\User;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $notification;
    public $notificationReceiver;
    public $user;

    public function __construct(Notifications $notification, NotificationReceivers $notificationReveiver, User $user)
    {
        //
        $this->notification = $notification;
        $this->notificationReceiver = $notificationReveiver;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification.'.$this->notificationReceiver->receiver);
    }

    public function broadcastWith(){
        return [
            'notification' => $this->notification,
            'notificationReveiver' => $this->notificationReceiver,
            'user' => $this->user
        ];
    }
}
