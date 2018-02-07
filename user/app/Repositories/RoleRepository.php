<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository {

	public function getRoleByid($id) {
		$roleTable = DB::table('roles')
			->where('id', '=', $id)
			->first();

		if ($roleTable) {
			$role = new Role();
			$role->id = $roleTable->id;
			$role->description = $roleTable->description;
			$role->name = $roleTable->name;
			return $role;
		}
		return null;

	}

}
