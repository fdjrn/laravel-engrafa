<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\Chat;
use App\Models\ChatMember;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $chat;
    public $chatMember;


    public function __construct(Chat $chat, ChatMember $chatMember)
    {
        $this->chat = $chat;
        $this->chatMember = $chatMember;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->chatMember->user);
    }

    public function broadcastWith()
    {
        return [
            'chatMember' => $this->chatMember,
            'chat' =>  $this->chat
        ];
    }
}
