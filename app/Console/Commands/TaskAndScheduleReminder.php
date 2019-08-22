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

    protected $minuteDiffToSendDailyNotif = array();

    protected $minuteDiffToSendHourlyNotif = array();

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

        $this->minuteDiffToSendDailyNotif = array(
            $this->daysToMinutes(1),
            $this->daysToMinutes(2),
            $this->daysToMinutes(3),
            $this->daysToMinutes(4),
            $this->daysToMinutes(5)
        );

        $this->minuteDiffToSendHourlyNotif = array(
            $this->hoursToMinutes(1),
            $this->hoursToMinutes(2),
            $this->hoursToMinutes(3),
            $this->hoursToMinutes(4),
            $this->hoursToMinutes(5)
        );

        $currentDate = Carbon::now();
        $testDate = new Carbon("2019-08-21 15:59:00");

        $this->sendScheduleNotifications($currentDate);

    }

    private function sendTaskNotifications($currentDate){
        $notification = new Notifications;
        $taskId = "";
        
        $tasks = DB::table("tasks")
            ->select(DB::raw("tasks.id as id, tasks.name as name, tasks.due_date, '' as location, tasks.detail as detail, tasks.color as color, tasks.created_by as created_by, tasks.updated_at as updated_at, tasks.created_at as created_at, 'task' as type, tasks.survey, task_participant.team_member"))
            ->join("task_participant","tasks.id","=","task_participant.task")
            ->whereRaw('DATE(due_date) >= DATE(?)',$currentDate)
            ->orderBy('tasks.id')
            ->get();

        foreach ($tasks as $task) {
            $minutesDiff = $currentDate->diffInminutes($task->due_date);
            $notificationText = "";
            $send = false;

            if (in_array($minutesDiff, $this->minuteDiffToSendDailyNotif)) {
                # pesan perhari
                $notificationText = 'Task '.$task->name. ' is '.$this->minutesToDays($minutesDiff).' days remain';
                $send = true;
            }elseif (in_array($minutesDiff, $this->minuteDiffToSendHourlyNotif)) {
                # pesan perjam
                $notificationText = 'Task '.$task->name. ' is '.$this->minutesToHours($minutesDiff).' hours remain';
                $send = true;
            }elseif ($minutesDiff == 0) {
                # code...
                $notificationText = 'Task '.$task->name. ' is over';
                $send = true;
            }

            if ($send) {
                # kirim notifikasi
                if ($taskId <> $task->id) {
                    # code...
                    //simpan notifikasi
                    $notification = new Notifications;
                    $notification->notification_text = $notificationText;
                    $notification->modul = '6-Task';
                    $notification->modul_id = $task->survey;
                    $notification->created_by = $task->created_by;
                    $notification->save();

                    $taskId = $task->id;

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
    }

    private function sendScheduleNotifications($currentDate){
        $dateComparisonColom = "";
        $users = User::all();

        //begin
        $schedules = DB::table("schedules")
            ->select(DB::raw("*, 'schedule' as type"))
            ->whereRaw('DATE(date_from) >= DATE(?)',$currentDate)
            ->orderBy('id')
            ->get();
        $this->sendScheduleNotification($schedules, "begin",$users, $currentDate);

        //over
        DB::enableQueryLog();
        $schedules = DB::table("schedules")
            ->select(DB::raw("*, 'schedule' as type"))
            ->whereRaw('DATE(date_from) <= DATE(?)',$currentDate->format("Y-m-d H:i:s"))
            ->whereRaw('DATE(date_to) >= DATE(?)',$currentDate->format("Y-m-d H:i:s"))
            ->orderBy('id')
            ->get();
        // dd(DB::getQueryLog());
        // dd($schedules);
        $this->sendScheduleNotification($schedules, "over",$users, $currentDate);
    }

    private function sendScheduleNotification($schedules, $type, $users, $currentDate){
        $notification = new Notifications;
        foreach ($schedules as $schedule) {
            $minutesDiff = 0;
            switch ($type) {
                case 'begin':
                    $minutesDiff = $currentDate->diffInminutes($schedule->date_from);
                    break;
                case 'over':
                    $minutesDiff = $currentDate->diffInminutes($schedule->date_to);
                    break;
            }

            $notificationText = "";
            $send = false;

            if (in_array($minutesDiff, $this->minuteDiffToSendDailyNotif)) {
                # pesan perhari
                $notificationText = 'Event '.$schedule->name. ' is '.$this->minutesToDays($minutesDiff).' days will '.$type;
                $send = true;
            }elseif (in_array($minutesDiff, $this->minuteDiffToSendHourlyNotif)) {
                # pesan perjam
                $notificationText = 'Event '.$schedule->name. ' is '.$this->minutesToHours($minutesDiff).' hours will '.$type;
                $send = true;
            }elseif ($minutesDiff == 0) {
                # code...
                $notificationText = 'Event '.$schedule->name. ' is '.$type;
                $send = true;
            }

            if ($send) {
                # kirim notifikasi
                //simpan notifikasi
                $notification = new Notifications;
                $notification->notification_text = $notificationText;
                $notification->modul = '4-Schedule';
                $notification->modul_id = $schedule->id;
                $notification->created_by = $schedule->created_by;
                $notification->save();

                foreach ($users as $user) {
                    # code...
                    $notificationReceiver = new NotificationReceivers;
                    $notificationReceiver->notification = $notification->id;
                    $notificationReceiver->receiver = $user->id;
                    $notificationReceiver->is_read = 0;
                    $notificationReceiver->created_by = $schedule->created_by;
                    $notificationReceiver->save();

                    broadcast(new NewNotification($notification, $notificationReceiver, $user));
                }
            }
            
        }
    }

    private function daysToMinutes($days){
        return (1440 * $days);
    }

    private function hoursToMinutes($hours){
        return (60 * $hours);
    }

    private function minutesToDays($minutes){
        return ($minutes / 60 / 24);
    }

    private function minutesToHours($minutes){
        return ($minutes / 60);
    }
}
