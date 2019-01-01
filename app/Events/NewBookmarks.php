<?php

namespace App\Events;

use App\Models\Bookmark;
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

class NewBookmarks implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $bookmark;
    public $user;

    public function __construct(Bookmark $bookmark, User $user)
    {
        $this->bookmark = $bookmark;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('bookmark.'.$this->user->id);
    }

    public function broadcastWith(){
        return [
            'bookmark' => $this->bookmark,
            'user' => $this->user
        ];
    }
}
