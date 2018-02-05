<?php

namespace App\Http\Responses;

class Category {
	public $id;
	public $name;
	public $parentId;
	public $description;
}

class GroupItems {
	public $id;
	public $name;
	public $categories;
}

class CategoryResponse extends Response {
	/**
	 *  new category to response
	 *
	 * @param  Illuminate\Support\Facades\DB stdClass $groupItems
	 * @param  Illuminate\Support\Facades\DB stdClass $categories
	 * @return App\Http\Responses\Response
	 */
	public function newListCategory($groupItems, $categories) {
		$data = array();
		for ($i = 1; $i <= 4; $i++) {

			foreach ($categories as $key => $value) {
				if ($value->level == 1) {
					$data['parent_' . $value->id] = $value;
					$value->child = 'child_' . $value->id;
					unset($categories[$key]);
				} else {
					if ($value->level > $i) {
						break;
					}

					$data['child_' . $value->parent_id][] = $value;
					$value->child = 'child_' . $value->id;
					unset($categories[$key]);
				}

			}

		}
		return $data;
	}

	public function newCategoryWithModel($categoryModel) {
		$category = new Category();
		$category->id = $categoryModel->id;
		$category->name = $categoryModel->name;
		$category->parentId = $categoryModel->parentId;
		$category->description = $categoryModel->description;
		return $category;
	}

}