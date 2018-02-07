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
		
		$groupItems = array();
		if ($group_item != null) {
			$groupItems['group_item'] = $group_item;
		}

		return BaseRepository::getMultiData(
								'category', // table
								array('id','name','group_item','description','parent_id','level'), // select
								$groupItems , // query
								array('order_by' => 'order by level') // option
							);

	}

	/**
	 * Get list category by parent ids
	 * @param @ids array
	 * @return $result array
	 */
	public function getListCategoryByParentIds($ids) {

		return BaseRepository::getMultiData(
								'category', // table
								array('id','name','group_item','description','parent_id','level'), // select
								array() , // query
								array('in' => array('parent_id' => implode(',', $ids))) // option
							);

	}



	/**
	 * Get category detail
	 * @param @id int
	 * @return $result array
	 */
	public function getCategoryById($id) {


		return BaseRepository::getSignleData(
								'category',
								array('id','name','group_item','description','parent_id','level'), // select
								array('id' => $id)
							);
	}

	/**
	 * Get category child
	 * @param @parentId int
	 * @return $result array
	 */
	public function getCategoryChild($parentId) {

		return BaseRepository::getMultiData(
								'category', // table
								array('id','name','group_item','description','parent_id','level'), // select
								array('parent_id' => $parentId)  // query
							);

	}

	/**
	 * Get category detail by field
	 * @param @field array  Ex : ['name' => "name"]
	 * @return $result array
	 */
	public function getCategoryByField($field,$query  = null) {


		return BaseRepository::getSignleData(
								'category',
								array('id','name','group_item','description','parent_id','level'), // select
								$field, // query
								$query
							);
	}

	/**
	 * new category
	 * @param $category /App/Models/Category.php
	 * @return $result array
	 */
	public function createCategory($category) {

		return DB::insert('insert into category (name , parent_id, group_item , description, is_active , is_delete, level) values (?, ?, ?, ?, ?, ?, ?)', [
			$category->name,
			$category->parentId,
			$category->groupItem,
			$category->description,
			$category->isActive,
			$category->isDelete,
			$category->level
		]
		);
	}

	/**
	 * new category
	 * @param $category /App/Models/Category.php
	 * @return integer
	 */
	public function updateCategory($category) {
		return DB::update('update category set name = ? , parent_id = ?, group_item = ?, description = ?, level = ? where id = ?', [
			$category->name,
			$category->parentId,
			$category->groupItem,
			$category->description,
			$category->level,
			$category->id,
		]
		);
	}

	/**
	 * update level category
	 * @param $category /App/Models/Category.php
	 * @return integer
	 */
	public function updateLevelCategory($id, $level) {
		return DB::update('update category set level = ? where id = ?', [
			$level,
			$id,
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
