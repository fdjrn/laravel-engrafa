<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Process extends Model
{
    protected $table = 'process';

    public static function getDataProcess() {

        $data = DB::table('process')->get();

        // dd($menu);

        return $data;

	}
}
