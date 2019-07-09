<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Level extends Model
{
    protected $table = 'level';

    public static function dataLevel() {

        $data = DB::table('level')->get();

        // dd($menu);

        return $data;

	}
}
