<?php

use App\Enums\Status;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config')->insert(
			[
				[
					'name' => 'level_menu',
					'value' => '5',
					'is_active' => Status::ACTIVE,
					'is_delete' => Status::UNDELETE,  
				],
			]
		);
    }
}
