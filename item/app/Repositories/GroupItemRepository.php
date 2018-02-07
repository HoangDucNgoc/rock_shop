<?php

namespace App\Repositories;

use App\Enums\Status;
use Illuminate\Support\Facades\DB;

class GroupItemRepository extends BaseRepository {

	/**
	 * Get group item by id
	 * @param @group_item int
	 * @return $result stdClass
	 */
	public function getGroupItemById($id) {

		$sql = 'select  id,name,description from group_items where is_delete = :is_delete and is_active =:is_active and id =:id limit 1';
		$parameter = array(
			'is_delete' => Status::UNDELETE,
			'is_active' => Status::ACTIVE,
			'id' => $id,
		);

		$result = DB::select($sql, $parameter);
		return $result;

	}

	/**
	 * Get categories
	 * @param @ids integer
	 * @return $result array
	 */
	public function listGroupItem($ids = null) {

		$query = DB::table('group_items')
			->where('is_delete', '=', Status::UNDELETE)
			->where('is_active', '=', Status::ACTIVE);
		if ($ids) {
			$query->where('id', '=', $ids);
		}
		return $query->get();
	}

}
