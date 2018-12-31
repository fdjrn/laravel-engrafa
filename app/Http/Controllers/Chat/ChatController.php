<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Models\ChatRoom;
use App\Models\ChatMember;
use App\Models\Chat;
use App\Models\Notifications;
use App\Models\NotificationReceivers;
use App\Events\ChatInvitation;
use App\Events\NewMessage;
use App\Events\NewNotification;

class ChatController extends Controller
{
    //
    public function index(){
    	return view("chat.chat");
    }

    public function store(Request $request){
        $chat = new Chat;
        $chat->chat_member = $request->chatRoomMemberId;
        $chat->chat_text = $request->message;
        $chat->created_by = Auth::user()->id;
        $chat->save();

        $chatMembers = ChatMember::where('chat_room', $request->chatRoomId)
            ->where('user','<>',Auth::user()->id)
            ->get();

        DB::table('chat_room_members')
            ->where('chat_room',$request->chatRoomId)
            ->update([
                'updated_at'=> date('Y-m-d H:i:s'),
                'unread_messages' => DB::raw('unread_messages+1')
            ]);

        // $notification = new Notifications;
        // $notification->notification_text = $request->message;
        // $notification->modul = '1-Chat';
        // $notification->modul_id = $request->chatRoomId;
        // $notification->created_by = Auth::user()->id;
        // $notification->save();

        foreach ($chatMembers as $chatMember) {
            // $notificationReceiver = new NotificationReceivers;
            // $notificationReceiver->notification = $notification->id;
            // $notificationReceiver->receiver = $chatMember->user;
            // $notificationReceiver->is_read = 0;
            // $notificationReceiver->created_by = Auth::user()->id;
            // $notificationReceiver->save();
            
            broadcast(new NewMessage($chat, $chatMember));
            // broadcast(new NewNotification($notification, $notificationReceiver, Auth::user()));
        }

        return response()->json($chat);
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

        $notification = new Notifications;
        $notification->notification_text = 'you are invited to chat with '.Auth::user()->name;
        $notification->modul = '1-Chat';
        $notification->modul_id = $chatRoom->id;
        $notification->created_by = Auth::user()->id;
        $notification->save();

        $notificationReceiver = new NotificationReceivers;
        $notificationReceiver->notification = $notification->id;
        $notificationReceiver->receiver = $chatMember->user;
        $notificationReceiver->is_read = 0;
        $notificationReceiver->created_by = Auth::user()->id;
        $notificationReceiver->save();

        $chatRoom->name = $this->castChatRoomName($chatRoom->name);

        broadcast(new ChatInvitation($chatRoom, $chatMember));
        broadcast(new NewNotification($notification, $notificationReceiver, Auth::user()));
        
        return response()->json(array(
                    'chatRoom'=> $chatRoom,
                    'exist'=>0
                )
        );
    }

    public function inviteGroup(Request $request){

        //save chat room

        $chatRoom = new ChatRoom;
        $chatRoom->name = $request->name;
        $chatRoom->chat_type = $request->chatType;
        $chatRoom->created_by = Auth::user()->id;
        $chatRoom->save();

        $chatMember = new ChatMember;
        $chatMember->chat_room = $chatRoom->id;
        $chatMember->unread_messages = 0;
        $chatMember->created_by = Auth::user()->id;
        $chatMember->user = Auth::user()->id;
        $chatMember->save();

        $notification = new Notifications;
        $notification->notification_text = 'you are invited to group chat '.$chatRoom->name;
        $notification->modul = '1-Chat';
        $notification->modul_id = $chatRoom->id;
        $notification->created_by = Auth::user()->id;
        $notification->save();

        foreach ($request->userId as $user) {
            # code...
            $chatMember = new ChatMember;
            $chatMember->chat_room = $chatRoom->id;
            $chatMember->unread_messages = 0;
            $chatMember->created_by = Auth::user()->id;
            $chatMember->user = (integer) $user;
            $chatMember->save();

            $notificationReceiver = new NotificationReceivers;
            $notificationReceiver->notification = $notification->id;
            $notificationReceiver->receiver = $chatMember->user;
            $notificationReceiver->is_read = 0;
            $notificationReceiver->created_by = Auth::user()->id;
            $notificationReceiver->save();
            
            broadcast(new ChatInvitation($chatRoom, $chatMember));
            broadcast(new NewNotification($notification, $notificationReceiver, Auth::user()));
        }

        return response()->json(array(
                    'chatRoom'=> $chatRoom,
                    'exist'=>0
                )
        );
    }

    public function getChatRoom($chatRoom = null){
        $chatRooms = null;
        if ($chatRoom) {
            # code...
            $chatRooms = ChatRoom::
            select('chat_rooms.*','chat_room_members.*', 'chat_rooms.updated_at as chat_room_updated_at')
            ->join('chat_room_members','chat_room_members.chat_room','chat_rooms.id')
            ->where('user',Auth::user()->id)
            ->where('chat_type','<>','3-Survey')
            ->whereRaw("lower(name) like '%".$chatRoom."%' ")
            ->orderBy('chat_rooms.updated_at','desc')
            ->get();
        }else{
            $chatRooms = ChatRoom::
            select('chat_rooms.*','chat_room_members.*', 'chat_rooms.updated_at as chat_room_updated_at')
            ->join('chat_room_members','chat_room_members.chat_room','chat_rooms.id')
            ->where('user',Auth::user()->id)
            ->where('chat_type','<>','3-Survey')
            ->orderBy('chat_rooms.updated_at','desc')
            ->get();
        }

        foreach ($chatRooms as $chatRoom) {
            # code...
            if ($chatRoom->chat_type == '1-Personal') {
                # code...
                $chatRoom->name = $this->castChatRoomName($chatRoom->name);
            }
        }

    	return response()->json($chatRooms);
    }

    public function getChatHistory($chatRoom = null){
        // DB::connection()->enableQueryLog();

        $chats = Chat::select(DB::raw('chats.id, chats.chat_text, chats.created_by, chats.created_at, users.name'))
            ->join('chat_room_members','chat_room_members.id','chats.chat_member')
            ->join('chat_rooms','chat_rooms.id','chat_room_members.chat_room')
            ->join('users','users.id','chats.created_by')
            ->where('chat_rooms.id',$chatRoom)
            ->whereRaw("chats.created_at like '".date('Y-m-d')."%' ")
            ->orderBy('chats.created_at', 'asc')
            ->get();
        // dd(DB::getQueryLog());
        return response()->json($chats);
    }

    public function readAllMessages(Request $request){
        $updated = DB::table('chat_room_members')
            ->where('id',$request->id)
            ->update(['unread_messages' => 0]);
        return response()->json($updated);
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
