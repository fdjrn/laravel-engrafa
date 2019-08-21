<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItGoal extends Model
{
    protected $table = 'it_goal';

    public static function dataItGoal() {

        $data = DB::table('it_goal')->get();

        // dd($menu);

        return $data;

	}

    public static function dataItGoalToProcess() {

        $data = DB::table('it_goal_to_process')->get();

        // dd($menu);

        return $data;

	}
}
