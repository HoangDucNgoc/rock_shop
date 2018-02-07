<?php

namespace App\Http\Requests\Category;

use App\Enums\Status;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\GroupItemRepository;
use Illuminate\Support\Facades\Lang;
use Validator;

class CreateCategoryRequest {

	private $request;
	private $category;
	private $errors; // array
	private $level;

	public function __construct($requestForm) {
		$this->request = $requestForm;
		$this->category = new Category();
		$this->level = 0;
	}

	public function validation() {
		/** @var \Illuminate\Contracts\Validation\Validator $validation */

		$validation = Validator::make(
			$this->request->all(),
			[
				'name' => 'required|unique:category,name|max:240',
				'group_item' => 'required|integer',
			],
			[
				'name.unique' => Lang::get('messages.name_category_unique'),
				'name.required' => Lang::get('messages.name_category_required'),
				'group_item.integer' => Lang::get('messages.group_item_integer'),
				'group_item.required' => Lang::get('messages.group_item_required'),
			]
		);

		$validation->after(function ($validator) {

			$parentId = $this->request->input('parent_id');
			if ($parentId) {
				$categoryRepository = new CategoryRepository();
				// not exist category parent
				$category = $categoryRepository->getCategoryById($parentId);

				if ( $category == null) {
					$validator->getMessageBag()->add('parent_id', Lang::get('messages.parent_cateory_not_exist'));
				}else{
					$this->level = $category->level + 1;
				}
			}

			$groupItem = $this->request->input('group_item');
			if ($groupItem) {
				$groupItemRepository = new GroupItemRepository();
				if (count($groupItemRepository->getGroupItemById($groupItem)) == 0) {
					$validator->getMessageBag()->add('parent_id', Lang::get('messages.group_item_invalid'));
				}
			}

		});

		if ($validation->fails()) {
			$this->errors = $validation->getMessageBag()->all();
			return true;
		}
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getData() {
		$this->category->name = $this->request->input('name');
		$this->category->description = $this->request->input('description');
		$this->category->isActive = Status::ACTIVE;
		$this->category->isDelete = Status::UNDELETE;
		$this->category->groupItem = $this->request->input('group_item');
		$this->category->parentId = ($this->request->input('parent_id') != null) ? $this->request->input('parent_id') : 0;
		$this->category->level = $this->level;
		return $this->category;
	}

}
