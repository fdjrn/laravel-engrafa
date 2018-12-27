<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\ChatRoom;
use App\Models\ChatMember;

class ChatController extends Controller
{
    //
    public function index(){
    	return view("chat.chat");
    }

    public function invite(Request $request){
    	$name = Auth::user()->id.'|'.$request->userId;
        $nameOtherwise = $request->userId.'|'.Auth::user()->id;

        $chatRoom = ChatRoom::where('name',$name)
            ->orWhere('name',$nameOtherwise)
            ->first();
        if ($chatRoom != null) {
            # code...
            // dd($chatRoom->name);
            $chatRoom->name = $this->castChatRoomName($chatRoom->name);
            return response()->json(
                array(
                    'chatRoom'=> $chatRoom,
                    'exist'=> 1
                )
            );
        }

        //save chat room
        $chatRoom = new ChatRoom;
        $chatRoom->name = $name;
        $chatRoom->chat_type = $request->chatType;
        $chatRoom->created_by = Auth::user()->id;
        $chatRoom->save();

        //save chat member
        $chatMember = new ChatMember;
        $chatMember->chat_room = $chatRoom->id;
        $chatMember->unread_messages = 0;
        $chatMember->created_by = Auth::user()->id;
        $chatMember->user = Auth::user()->id;
        $chatMember->save();

        $chatMember = new ChatMember;
        $chatMember->chat_room = $chatRoom->id;
        $chatMember->unread_messages = 0;
        $chatMember->created_by = Auth::user()->id;
        $chatMember->user = $request->userId;
        $chatMember->save();

        $chatRoom->name = $this->castChatRoomName($chatRoom->name);
        return response()->json(array(
                    'chatRoom'=> $chatRoom,
                    'exist'=>0
                )
        );
    }

    public function getChatRoom(){
    	$chatRooms = ChatRoom::join('chat_room_members','chat_room_members.chat_room','chat_rooms.id')
            ->where('user',Auth::user()->id)
            ->where('chat_type','<>','3-Survey')
            ->orderBy('chat_rooms.updated_at','desc')
            ->get();

        foreach ($chatRooms as $chatRoom) {
            # code...
            if ($chatRoom->chat_type == '1-Personal') {
                # code...
                $chatRoom->name = $this->castChatRoomName($chatRoom->name);
            }
        }

    	return response()->json($chatRooms);
    }

    public function getUserAvailable(){
    	$users = User::where('id','<>',Auth::user()->id)->get();

    	return response()->json($users);
    }

    private function castChatRoomName($name){
        $names = explode("|", $name);
        $user1 = User::find($names[0]);
        $user2 = User::find($names[1]);
        return $user1->name."|".$user2->name;
    }
}
