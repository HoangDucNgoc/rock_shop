<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Enums\Status;

class CategoryRepository extends BaseRepository {

	/**
	* Get categories 
	* @param @group_item int
	* @return $result array
	*/
	public function getListCategory($group_item = null) {
		
		$sql = 'select id,name,group_item,description,parent_id from category where is_delete = :is_delete and is_active =:is_active';
		$parameter = array(
							'is_delete' => Status::UNDELETE ,
							'is_active' => Status::ACTIVE
					);

		if($group_item != null){
			$sql .= ' and group_item =:group_item';
			$parameter['group_item'] = $group_item;
		}

		$result= DB::select($sql,$parameter);
		return $result;

	}

	/**
	* Get category detail
	* @param @id int
	* @return $result array
	*/
	public function getCategoryById($id) {
		
		$sql = 'select id,name,group_item,description,parent_id from category where is_delete = :is_delete and is_active =:is_active and id =:id limit 1';
		$parameter = array(
							'is_delete' => Status::UNDELETE ,
							'is_active' => Status::ACTIVE,
							'id' => $id
					);

		$result= DB::select($sql,$parameter);
		
		if(count($result) == 0 ){
			return null;
		}

		return $result[0];

	}

}
