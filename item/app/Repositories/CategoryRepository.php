<?php

namespace App\Repositories;

use App\Enums\Status;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository {

	/**
	 * Get categories
	 * @param @group_item int
	 * @return $result array
	 */
	public function getListCategory($group_item = null) {

		$sql = 'select id,name,group_item,description,parent_id, level from category where is_delete = :is_delete and is_active =:is_active order by level';
		$parameter = array(
			'is_delete' => Status::UNDELETE,
			'is_active' => Status::ACTIVE,
		);

		if ($group_item != null) {
			$sql .= ' and group_item =:group_item';
			$parameter['group_item'] = $group_item;
		}

		$result = DB::select($sql, $parameter);
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
			'is_delete' => Status::UNDELETE,
			'is_active' => Status::ACTIVE,
			'id' => $id,
		);

		$result = DB::select($sql, $parameter);

		if (count($result) == 0) {
			return null;
		}

		return $result[0];

	}

	/**
	 * Get category detail by field
	 * @param @field array  Ex : ['name' => "name"]
	 * @return $result array
	 */
	public function getCategoryByField($field,$query  = null) {

		$sql = 'select id,name,group_item,description,parent_id from category where is_delete = :is_delete and is_active =:is_active ';
		$parameter = array(
			'is_delete' => Status::UNDELETE,
			'is_active' => Status::ACTIVE,
		);

		foreach ($field as $key => $value) {
			$sql .= " and $key =:$key";
			$parameter[$key] = $value;
		}

		$sql .= " and $query " .  ' limit 1';

		$result = DB::select($sql, $parameter);

		if (count($result) == 0) {
			return null;
		}

		return $result[0];

	}

	/**
	 * new category
	 * @param $category /App/Models/Category.php
	 * @return $result array
	 */
	public function createCategory($category) {

		return DB::insert('insert into category (name , parent_id, group_item , description, is_active , is_delete) values (?, ?, ?, ?, ?, ?)', [
			$category->name,
			$category->parentId,
			$category->groupItem,
			$category->description,
			$category->isActive,
			$category->isDelete,
		]
		);
	}

	/**
	 * new category
	 * @param $category /App/Models/Category.php
	 * @return integer
	 */
	public function updateCategory($category) {
		return DB::update('update category set name = ? , parent_id = ?, group_item = ?, description = ? where id = ?', [
			$category->name,
			$category->parentId,
			$category->groupItem,
			$category->description,
			$category->id,
		]
		);
	}

	/**
	 * delete category
	 * @param $category /App/Models/Category.php
	 * @return integer
	 */
	public function deleteCategory($id) {
		return DB::update('update category set is_delete = ? where id = ?', [
			Status::DELETE,
			$id
		]
		);
	}

}
