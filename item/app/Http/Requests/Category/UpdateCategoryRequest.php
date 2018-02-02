<?php

namespace App\Http\Requests\Category;

use App\Enums\Status;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\GroupItemRepository;
use Illuminate\Support\Facades\Lang;
use Validator;

class UpdateCategoryRequest {

	private $request;
	private $category;
	private $errors; // array
	private $categoryModel;

	public function __construct($requestForm) {
		$this->request = $requestForm;
		$this->category = new Category();
	}

	public function validation() {
		/** @var \Illuminate\Contracts\Validation\Validator $validation */

		$validation = Validator::make(
			$this->request->all(),
			[
				'id' => 'required|integer',
				'name' => 'max:240',
				'group_item' => 'integer',
			],
			[
				'id.integer' => Lang::get('messages.id_must_integer'),
				'group_item.integer' => Lang::get('messages.group_item_integer'),
			]
		);

		$validation->after(function ($validator) {

			$id = $this->request->input('id');
			$categoryRepository = new CategoryRepository();
			$this->categoryModel = $categoryRepository->getCategoryById($id);
			if ( $this->categoryModel == null) {
				$validator->getMessageBag()->add('id', Lang::get('messages.category_not_exist'));
			}else{
				// name update unique
				if($categoryRepository->getCategoryByField( array('name' => $this->request->input('name')),"id != $id")){
					$validator->getMessageBag()->add('name', Lang::get('messages.name_category_unique'));
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
		$this->category->id = $this->request->input('id');
		$this->category->name = ($this->request->input('name') != null) ? $this->request->input('name') : $this->categoryModel->name; 
		$this->category->description = ($this->request->input('description') != null) ? $this->request->input('description') : $this->categoryModel->description;
		$this->category->groupItem = ($this->request->input('group_item') != null) ? $this->request->input('group_item') : $this->categoryModel->group_item;
		$this->category->parentId = ($this->request->input('parent_id') != null) ? $this->request->input('parent_id') : $this->categoryModel->parent_id;
		return $this->category;
	}

}
