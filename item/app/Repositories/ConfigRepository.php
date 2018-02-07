<?php

namespace App\Repositories;



class ConfigRepository extends BaseRepository {

	/**
	 * Get group item by id
	 * @param @group_item int
	 * @return $result stdClass
	 */
	public function getConfigByName($name) {
		
		return BaseRepository::getSignleData(
								'config',
								array('name','value'),
								array('name'=>$name)
							);
		
	}

}
