<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Notifications;
use App\Models\NotificationReceivers;
use App\Events\ReadNotification;

class NotificationController extends Controller
{
    //

    public function getNotifications(Request $request){
    	
    	$notifications = NotificationReceivers::
    		select(
    			'notifications.id as notif_id', 
    			'notifications.notification_text',
    			'notifications.modul',
    			'notifications.modul_id',
    			'notification_receivers.created_at',
    			'notification_receivers.is_read',
    			'notification_receivers.id as notif_receiver_id',
    			'users.name as notif_creator'
    		)
    		->join('notifications', 'notifications.id', 'notification_receivers.notification')
    		// ->join('users as notif_creator', 'notif_creator.id', 'notifications.created_by')
    		->join('users','users.id','notifications.created_by')
    		->whereRaw("notification_receivers.created_at < STR_TO_DATE('".$request->date."','%Y-%m-%d %H:%i:%S')" )
    		->where('notification_receivers.receiver',Auth::user()->id)
    		// ->where('notifications.modul','<>','1-Chat')
    		->orderBy('notification_receivers.created_at', 'desc')
    		->limit(20)
    		->get();

		return response()->json($notifications);
    }

    public function getUnreadNotifications(Request $request){
        
        $notifications = NotificationReceivers::
            where('receiver', Auth::user()->id)
            ->where('is_read','0')
            ->count();

        return response()->json($notifications);
    }

    public function read(Request $request){

    	$notificationReceiver = NotificationReceivers::find($request->id);
    	$notificationReceiver->is_read = 1;
    	$notificationReceiver->update();

        // broadcast('read',Auth::user());

    	return response()->json($notificationReceiver);
    }

    public function readAll(Request $request){
    	$update = DB::table('notification_receivers')
    		->where('receiver',Auth::user()->id)
    		->where('is_read','0')
    		->update(['is_read'=>'1']);

        broadcast(new ReadNotification('readAll',Auth::user()));

		return response()->json([
			'notification_readed' => $update 
		]);

    }
}
