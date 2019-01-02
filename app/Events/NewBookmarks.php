<?php

namespace App\Events;

use App\Models\Bookmark;
use App\Models\Files;
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
    public $file;
    public $user;

    public function __construct(Bookmark $bookmark, Files $file, User $user)
    {
        $this->bookmark = $bookmark;
        $this->file = $file;
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
            'file' => $this->file,
            'user' => $this->user
        ];
    }
}
