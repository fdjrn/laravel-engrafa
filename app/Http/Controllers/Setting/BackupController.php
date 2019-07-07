<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Alert;
use Artisan;
use Log;
use Storage;

class BackupController extends Controller
{
    public function index()
    {
        // $disk = Storage::disk(config('laravel-backup.backup.destination.disks')[0]);
        // $files = $disk->files(config('laravel-backup.backup.name'));
        $files = Storage::disk('backup_folder')->files();
        $backups = [];

        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            // if (substr($f, -4) == '.zip') {
            if (substr($f, -4) == '.sql') {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace(config('laravel-backup.backup.name') . '/', '', $f),
                    'file_size' => $this->humanFilesize(Storage::disk('backup_folder')->size($f)),
                    'last_modified' => Storage::disk('backup_folder')->lastModified($f),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);

        return view('setting.backuprestore')->with(compact('backups'));
    }

    public function create()
    {
        $path_file_name     = "";
        $command            = "";
        $output             = NULL;
        $returnVar          = NULL;

        // $path_file_name = "\app\Tata-Kelola-IT\mysql_db_engrafa_".date("Y")."_".date("m")."_".date("d")."_".date("H")."_".date("i")."_".date("s").".sql 2>&1";
        $path_file_name = "/app/Tata-Kelola-IT/mysql_db_engrafa_".date("Y").date("m").date("d").date("H").date("i").date("s").".sql 2>&1";

        $command = "C:/xampp/mysql/bin/mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . storage_path() . $path_file_name; 

        ini_set('max_execution_time', '9000');
        exec($command, $output, $returnVar);

        // echo($command);
        // echo("<br />----------------<br />");
        // var_dump($output);
        // echo("<br />----------------<br />");
        // echo($returnVar);
        // echo("<br />----------------<br />");

        if ($returnVar != 0) {
            // error occurred
            // echo("eror");
            Alert::success('Backup database file error', 'Create Backup')->autoclose(4000);
            return redirect()->back();
        }else{
            // success
            // echo("sukses");
            Alert::success('Backup database file has been created', 'Create Backup')->autoclose(4000);
            return redirect()->back();
        }

        
        // try {
        //     // start the backup process
        //     // Artisan::call('backup:run');
        //     Artisan::call('backup:run', ['--only-db' => true]);
        //     $output = Artisan::output();
        //     // log the results
        //     Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
        //     // return the results as a response to the ajax call
        //     Alert::success('Backup database file has been created', 'Create Backup')->autoclose(4000);
        //     return redirect()->back();
        // } catch (Exception $e) {
        //     Flash::error($e->getMessage());
        //     return redirect()->back();
        // }
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($file_name)
    {
        $file = Storage::disk('backup_folder')->getAdapter()->getPathPrefix().$file_name;
        return response()->download(storage_path("app/Tata-Kelola-IT/".$file_name));
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $exists = Storage::disk('backup_folder')->exists($file_name);

        if($exists){
            //Storage::delete($file_name);
            unlink(storage_path('app/Tata-Kelola-IT/'.$file_name));
            Alert::success('Backup database file has been deleted', 'Delete Backup')->autoclose(4000);
            return redirect()->back();
        }else{
            abort(404, "The backup database file doesn't exist.");
        }
    }

    public function humanFilesize($size, $precision = 2) {
        $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $step = 1024;
        $i = 0;

        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        
        return round($size, $precision).$units[$i];
    }

    /**
     * Restore database from backup file.
     */
    public function restore($file_name)
    {
        $path_file_name     = "";
        $command            = "";
        $output             = NULL;
        $returnVar          = NULL;

        $path_file_name     = "/app/Tata-Kelola-IT/".$file_name." 2>&1";

        // echo($file_name);
        // die;

        // $command = "zcat " . storage_path() . "/" . $backupFilename[1] . " | mysql --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "";

        //unzip -p dbdump.sql.zip | mysql -u root -p dbname
        
        //$command = "unzip -p ".storage_path()."/app/Tata-Kelola-IT/"."$file_name | mysql -u ".env('DB_USERNAME')." -p ".env('DB_DATABASE');

        // $command = "mysql --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " < " . storage_path() . "/app/Tata-Kelola-IT/mysql-db_dev_engrafa.sql";

        $command = "C:/xampp/mysql/bin/mysql --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " < " . storage_path() . $path_file_name;

        //$eksekusi = exec($command, $output, $returnVar);
        // $eksekusi = exec($command, $output);
        
        ini_set('max_execution_time', '9000');
        //$eksekusi = shell_exec($command);
        exec($command, $output, $returnVar);

        // echo($command);
        // echo("<br />----------------<br />");
        // var_dump($output);
        // echo("<br />----------------<br />");
        // echo($returnVar);
        // echo("<br />----------------<br />");

        if ($returnVar != 0) {
            // error occurred
            // echo("error");
            Alert::success('Restore database error', 'Restore')->autoclose(4000);
            return redirect()->back();
        }else{
            // success
            // echo("sukses");
            Alert::success('Restore database success', 'Restore')->autoclose(4000);
            return redirect()->back();
        }

        // $last_line = system($command, $returnVar);

        // echo '
        //         </pre>
        //         <hr />command: ' . $command . '
        //         <hr />Last line of the output: ' . $last_line . '
        //         <hr />Return value: ' . $returnVar;

        // $mysql = shell_exec("sudo which mysql");
        // $cmd = "$mysql --host=$host --user=$user --password=$pass -D $dbname -e 'source $base_sql_file'";
        // exec($cmd, $output, $retvar);

        // echo($command);
        // echo("<br />----------------<br />");
        // var_dump($output);
        // echo("<br />----------------<br />");
        // echo($returnVar);
        // echo("<br />----------------<br />");

        // print_r($command);
        // echo("<br />----------------<br />");
        // print_r($output);
        // echo("<br />----------------<br />");
        // print_r($returnVar);
        // echo("<br />----------------<br />");
        // die;

        // if(!$returnVar){
        //     //$this->info('Database Restored');
        //     //Alert::success('Database has been restored', 'Restore')->autoclose(4000);
        //     print_r('sukses');
        // }else{
        //     //$this->error($returnVar);
        //     // Alert::error('Database failed to restored', 'Restore')->autoclose(4000);
        //     print_r('gagal');
        // }

        // $exists = Storage::disk('backup_folder')->exists($file_name);

        
        // if($exists){
        //     print_r('asup true');
        //     //Storage::delete($file_name);
        //     unlink(storage_path('app/Tata-Kelola-IT/'.$file_name));
        //     Alert::success('Backup file has been deleted', 'Delete Backup')->autoclose(4000);
        //     return redirect()->back();
        // }else{
        //     print_r('asup false');
        //     abort(404, "The backup file doesn't exist.");
        // }
    }
}