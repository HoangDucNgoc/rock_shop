<?php

use Illuminate\Database\Seeder;
use App\Enums\Status;

class InitDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
        	[
        		[
		            'name' => 'super_admin',
		            'description' => 'For administrator',
		            'is_active' => Status::ACTIVE,
		            'is_delete' => Status::UNDELETE
	        	],
		        [
		        	'name' => 'admin',
		            'description' => 'For admin',
		            'is_active' => Status::ACTIVE,
		            'is_delete' => Status::UNDELETE
		        ]
	    	]
    	);
    }
}
