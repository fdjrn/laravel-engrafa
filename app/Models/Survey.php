<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Survey extends Model
{
    protected $table = 'surveys';

    public static function mnsurvey() {

        $mnsurvey = DB::table('surveys')
			->where('created_by',Auth::user()->id)
			->get();

        // dd($menu);

        return $mnsurvey;

	}
}
