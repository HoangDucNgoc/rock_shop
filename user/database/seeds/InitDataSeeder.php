<?php

use App\Enums\Status;
use Illuminate\Database\Seeder;

class InitDataSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('roles')->insert(
			[
				[
					'name' => 'super_admin',
					'description' => 'For administrator',
					'is_active' => Status::ACTIVE,
					'is_delete' => Status::UNDELETE,
				],
				[
					'name' => 'admin',
					'description' => 'For admin',
					'is_active' => Status::ACTIVE,
					'is_delete' => Status::UNDELETE,
				],
			]
		);

		DB::table('feature')->insert(
			[
				[
					'name' => 'admin/category',
					'description' => 'manage category',
					'is_active' => Status::ACTIVE,
					'is_delete' => Status::UNDELETE,
				],
				
			]
		);
	}
}
