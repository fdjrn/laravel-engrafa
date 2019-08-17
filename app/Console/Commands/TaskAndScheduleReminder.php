<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

use App\Models\Schedules;
use App\Models\Notifications;
use App\Models\NotificationReceivers;
use App\User;

use App\Events\NewNotification;

class TaskAndScheduleReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk notifikasi task dan schedule yang akan berlangsung dan sudah selesai';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $hourToSentDailyNotif = array("00:00");
        $hourDiffToSentHourlyNotif = array(1,2,3,4,5);

        $currendDate = Carbon::now()->format('Y-m-d');
        $currentHour = Carbon::now()->format('H');
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $notification = new Notifications;
        $user = New User;

        $taskId1 = "";
        $taskId2 = "";
        $taskId3 = "";

        $users = User::all();

        $tasks = DB::table("tasks")
            ->select(DB::raw("tasks.id as id, tasks.name as name, tasks.due_date as date_from, tasks.due_date as date_to, '' as location, tasks.detail as detail, tasks.color as color, tasks.created_by as created_by, tasks.updated_at as updated_at, tasks.created_at as created_at, 'task' as type, tasks.survey, task_participant.team_member"))
            ->join("task_participant","tasks.id","=","task_participant.task")
            ->whereDate('due_date','>=',$currendDate)
            ->orderBy('tasks.id')
            ->get();

        //notifikasi task
        foreach($tasks as $task){
            $dateFrom = new Carbon($task->date_from);
            $dayDifference = $dateFrom->diff(new Carbon($currendDate))->days;
            $hourDifference = $dateFrom->diffInHours(new Carbon($now));
            $minuteDifference = $dateFrom->diffInminutes(new Carbon($now));

            //notifikasi perhari
            if($dayDifference <= 3 && $dayDifference > 0 && in_array($currentHour.":00", $hourToSentDailyNotif)){

                if ($taskId1 <> $task->id) {
                    # code...
                    //simpan notifikasi
                    $notification = new Notifications;
                    $notification->notification_text = 'Task '.$task->name. ' is '.$dayDifference.' days remain';
                    $notification->modul = '5-Task';
                    $notification->modul_id = $task->survey;
                    $notification->created_by = $task->created_by;
                    $notification->save();

                    $taskId1 = $task->id; 

                    $user = User::find($task->created_by);
                }

                $notificationReceiver = new NotificationReceivers;
                $notificationReceiver->notification = $notification->id;
                $notificationReceiver->receiver = $task->team_member;
                $notificationReceiver->is_read = 0;
                $notificationReceiver->created_by = $task->created_by;
                $notificationReceiver->save();

                broadcast(new NewNotification($notification, $notificationReceiver, $user));

            }

            if($hourDifference <= 5 && $hourDifference > 0){

                if ($taskId2 <> $task->id) {
                    # code...
                    //simpan notifikasi
                    $notification = new Notifications;
                    $notification->notification_text = 'Task '.$task->name. ' is '.$hourDifference.' hours remain';
                    $notification->modul = '5-Task';
                    $notification->modul_id = $task->survey;
                    $notification->created_by = $task->created_by;
                    $notification->save();

                    $taskId2 = $task->id; 

                    $user = User::find($task->created_by);
                }

                $notificationReceiver = new NotificationReceivers;
                $notificationReceiver->notification = $notification->id;
                $notificationReceiver->receiver = $task->team_member;
                $notificationReceiver->is_read = 0;
                $notificationReceiver->created_by = $task->created_by;
                $notificationReceiver->save();

                broadcast(new NewNotification($notification, $notificationReceiver, $user));

            }

            //task berakhir
            if($minuteDifference <= 0){

                if ($taskId3 <> $task->id) {
                    # code...
                    //simpan notifikasi
                    $notification = new Notifications;
                    $notification->notification_text = 'Task '.$task->name. ' is over';
                    $notification->modul = '5-Task';
                    $notification->modul_id = $task->survey;
                    $notification->created_by = $task->created_by;
                    $notification->save();

                    $taskId3 = $task->id; 

                    $user = User::find($task->created_by);
                }

                $notificationReceiver = new NotificationReceivers;
                $notificationReceiver->notification = $notification->id;
                $notificationReceiver->receiver = $task->team_member;
                $notificationReceiver->is_read = 0;
                $notificationReceiver->created_by = $task->created_by;
                $notificationReceiver->save();

                broadcast(new NewNotification($notification, $notificationReceiver, $user));

            }
        }

        $schedules = DB::table("schedules")
            ->select(DB::raw("*, 'schedule' as type"))
            ->whereDate('date_from','>=',$now)
            ->orderBy('id')
            ->get();

        foreach($schedules as $schedule){
            $dateFrom = new Carbon($schedule->date_from);
            
            $dayFromDifference = $dateFrom->diff(new Carbon($currendDate))->days;
            $hourFromDifference = $dateFrom->diffInHours(new Carbon($now));
            $minuteFromDifference = $dateFrom->diffInminutes(new Carbon($now));

            // dd($schedule->id." ".$dateFrom." ".(new Carbon($now))." ".$minuteFromDifference);

            $notification1 = new Notifications;
            $notification2 = new Notifications;
            $notification3 = new Notifications;

            //notifikasi perhari
            if($dayFromDifference <= 3 && $dayFromDifference > 0 && in_array($currentHour.":00", $hourToSentDailyNotif)){
                //simpan notifikasi
                $notification1->notification_text = 'Event '.$schedule->name. ' is '.$dayFromDifference.' days will begin';
                $notification1->modul = '4-Schedule';
                $notification1->modul_id = $schedule->id;
                $notification1->created_by = $schedule->created_by;
                $notification1->save();
            }

            //notifikasi per jam
            if($hourFromDifference <= 5 && $hourFromDifference > 0){
                $notification2->notification_text = 'Event '.$schedule->name. ' is '.$hourFromDifference.' hours will begin';
                $notification2->modul = '4-Schedule';
                $notification2->modul_id = $schedule->id;
                $notification2->created_by = $schedule->created_by;
                $notification2->save();
            }

            //event dimulai
            if($minuteFromDifference <= 0){
                $notification3->notification_text = 'Event '.$schedule->name. ' is begin';
                $notification3->modul = '4-Schedule';
                $notification3->modul_id = $schedule->id;
                $notification3->created_by = $schedule->created_by;
                $notification3->save();
            }

            foreach ($users as $user) {
                //notifikasi perhari
                if($dayFromDifference <= 3 && $dayFromDifference > 3 && in_array($currentHour.":00", $hourToSentDailyNotif)){
                    $notificationReceiver = new NotificationReceivers;
                    $notificationReceiver->notification = $notification1->id;
                    $notificationReceiver->receiver = $user->id;
                    $notificationReceiver->is_read = 0;
                    $notificationReceiver->created_by = $notification1->created_by;
                    $notificationReceiver->save();

                    broadcast(new NewNotification($notification1, $notificationReceiver, $user));
                }
                
                //notifikasi perjam
                if($hourFromDifference <= 5 && $hourFromDifference > 0){
                    $notificationReceiver = new NotificationReceivers;
                    $notificationReceiver->notification = $notification2->id;
                    $notificationReceiver->receiver = $user->id;
                    $notificationReceiver->is_read = 0;
                    $notificationReceiver->created_by = $notification2->created_by;
                    $notificationReceiver->save();

                    broadcast(new NewNotification($notification2, $notificationReceiver, $user));
                }
                
                //event dimulai
                if($minuteFromDifference <= 0){
                    $notificationReceiver = new NotificationReceivers;
                    $notificationReceiver->notification = $notification3->id;
                    $notificationReceiver->receiver = $user->id;
                    $notificationReceiver->is_read = 0;
                    $notificationReceiver->created_by = $notification3->created_by;
                    $notificationReceiver->save();

                    broadcast(new NewNotification($notification3, $notificationReceiver, $user));
                }

            }
        }

        $schedules = DB::table("schedules")
            ->select(DB::raw("*, 'schedule' as type"))
            ->whereDate('date_from','<',$now)
            ->WhereDate('date_to','>=',$now)
            ->orderBy('id')
            ->get();

        // dd($schedules);

        foreach($schedules as $schedule){
            $dateTo = new Carbon($schedule->date_to);
            
            $dayToDifference = $dateTo->diff(new Carbon($currendDate))->days;
            $hourToDifference = $dateTo->diffInHours(new Carbon($now));
            $minuteToDifference = $dateTo->diffInminutes(new Carbon($now));

            // dd($schedule->id." ".$dateFrom." ".(new Carbon($now))." ".$hourToDifference);

            $notification1 = new Notifications;
            $notification2 = new Notifications;
            $notification3 = new Notifications;

            //notifikasi perhari
            if($dayToDifference <= 5 && $dayToDifference > 0 && in_array($currentHour.":00", $hourToSentDailyNotif)){
                //simpan notifikasi
                $notification1->notification_text = 'Event '.$schedule->name. ' in '.$dayToDifference.' days will over';
                $notification1->modul = '4-Schedule';
                $notification1->modul_id = $schedule->id;
                $notification1->created_by = $schedule->created_by;
                $notification1->save();
            }

            //notifikasi per jam
            if($hourToDifference >= 1 && $hourToDifference <= 5){
                $notification2->notification_text = 'Event '.$schedule->name. ' in '.$hourToDifference.' hours will over';
                $notification2->modul = '4-Schedule';
                $notification2->modul_id = $schedule->id;
                $notification2->created_by = $schedule->created_by;
                $notification2->save();
            }

            //event dimulai
            if($minuteToDifference <= 0){
                $notification3->notification_text = 'Event '.$schedule->name. ' in over';
                $notification3->modul = '4-Schedule';
                $notification3->modul_id = $schedule->id;
                $notification3->created_by = $schedule->created_by;
                $notification3->save();
            }

            foreach ($users as $user) {
                //notifikasi perhari
                if($dayToDifference <= 5 && $dayToDifference > 0 && in_array($currentHour.":00", $hourToSentDailyNotif)){
                    $notificationReceiver = new NotificationReceivers;
                    $notificationReceiver->notification = $notification1->id;
                    $notificationReceiver->receiver = $user->id;
                    $notificationReceiver->is_read = 0;
                    $notificationReceiver->created_by = $notification1->created_by;
                    $notificationReceiver->save();

                    broadcast(new NewNotification($notification1, $notificationReceiver, $user));
                }
                
                //notifikasi perjam
                if($hourToDifference >= 1 && $hourToDifference <= 5){
                    $notificationReceiver = new NotificationReceivers;
                    $notificationReceiver->notification = $notification2->id;
                    $notificationReceiver->receiver = $user->id;
                    $notificationReceiver->is_read = 0;
                    $notificationReceiver->created_by = $notification2->created_by;
                    $notificationReceiver->save();

                    broadcast(new NewNotification($notification2, $notificationReceiver, $user));
                }
                
                //event dimulai
                if($minuteToDifference <= 0){
                    $notificationReceiver = new NotificationReceivers;
                    $notificationReceiver->notification = $notification3->id;
                    $notificationReceiver->receiver = $user->id;
                    $notificationReceiver->is_read = 0;
                    $notificationReceiver->created_by = $notification3->created_by;
                    $notificationReceiver->save();

                    broadcast(new NewNotification($notification3, $notificationReceiver, $user));
                }

            }
        }

    }
}
