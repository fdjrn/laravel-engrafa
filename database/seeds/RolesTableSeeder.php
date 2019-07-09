<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
        	[
        		'id'=>'1',
        		'name'=>'Super Admin',
        		'super_admin'=>'1',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'id'=>'2',
        		'name'=>'Admin',
        		'super_admin'=>'0',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'id'=>'3',
        		'name'=>'Creator',
        		'super_admin'=>'0',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'id'=>'4',
        		'name'=>'Editor',
        		'super_admin'=>'0',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'id'=>'5',
        		'name'=>'Contributor',
        		'super_admin'=>'0',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        	[
        		'id'=>'6',
        		'name'=>'Viewer',
        		'super_admin'=>'0',
        		'created_at' => date('y-m-d h:m:s'),
        		'updated_at' => date('y-m-d h:m:s'),
        	],
        ]);
    }
}
