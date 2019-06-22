<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\ChatMember;
use App\Models\ChatRoom;

class ChatInvitation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;
    public $type;
    public $chatMember;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatRoom $chatRoom, ChatMember $chatMember)
    {
        //
        
        $this->name = $chatRoom->name;
        $this->type = $chatRoom->chat_type;
        $this->chatMember = $chatMember;
        $this->userId = $chatMember->user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('invitation.'.$this->chatMember->user);
        return new PrivateChannel('invitation.'.$this->userId);
    }

    public function broadcastWith(){
        return [
            "chatRoom" => $this->name,
            "chatType" => $this->type,
            "chatMember" => $this->chatMember
        ];
    }
}
