<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    //
    protected $table = 'menus';

    public function parent(){
    	return $this->hasOne('App\Models\Menu','id','root');
    }

    public function children(){
    	$instance = $this->hasMany('App\Models\Menu','root','id');
        return $instance;
    }

    public static function tree($roleId) {

        $menu = static::with(implode('.', array_fill(0, 100, 'children')))
			->join('role_menus','role_menus.menu','menus.id')
			->where('root', '=', '0')
			->where('role_menus.role',$roleId)
			->get();

        // dd($menu);

        return $menu;

	}
}
