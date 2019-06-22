<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    //
    protected $table = 'roles';

    public static function data_roles() {

        $roles = DB::table('roles')->get();

        // dd($menu);

        return $roles;

	}
}
