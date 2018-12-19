<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'chat_member', // messages recipient
        'chat_text', // messages text
        'url_image', // url attachment
        'url_voice', // url voice messages
        'read', // messages read/unread status
        'created_by' // messages sender
    ];

    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
