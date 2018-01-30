<?php

use App\Enums\Status;
use Illuminate\Database\Seeder;

class GroupItemsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('group_items')->insert(
			[
				[
					'name' => 'cafe',
					'description' => 'Mặt hàng cafe',
					'is_active' => Status::ACTIVE,
					'is_delete' => Status::UNDELETE,  
				],
			]
		);
	}
}
