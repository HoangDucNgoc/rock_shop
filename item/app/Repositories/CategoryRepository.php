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
		
		$sql = 'select id,name,group_item,description from category where is_delete = :is_delete and is_active =:is_active';
		$parameter = array(
							'is_delete' => Status::UNDELETE ,
							'is_active' => Status::ACTIVE
					)


		$result= DB::select(, 
									[
										
									]
								);
		return $result;

	}

}
