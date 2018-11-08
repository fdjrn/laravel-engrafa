<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleMenu extends Model
{
    //
    protected $table = 'role_menu';


    public static function roleMenus($role_id){

    	$roleMenus = DB::table('menus')
    		->join('role_menus','role_menus.menu','=','menus.id')
    		->where('role_menus.role',$role_id)
    		->get();

    	return $roleMenus;
    }
}
