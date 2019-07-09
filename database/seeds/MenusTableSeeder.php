<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('menus')->insert([
        	[
        		'root' => '0',
        		'name' => 'Invite People',
        		'url' => 'dashboard',
        		'icon' => 'fa-dashboard',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'root' => '0',
        		'name' => 'Index',
        		'url' => 'index',
        		'icon' => 'fa-folder-open',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'root' => '0',
        		'name' => 'Survey',
        		'url' => 'survey',
        		'icon' => 'fa-files-o',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'root' => '0',
        		'name' => 'Create New Team',
        		'url' => 'team',
        		'icon' => 'fa-plus',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'root' => '0',
        		'name' => 'Calendar',
        		'url' => 'calendar',
        		'icon' => 'fa-calendar',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'root' => '0',
        		'name' => 'Setting',
        		'url' => 'setting',
        		'icon' => 'fa-gear',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        ]);
    }
}
