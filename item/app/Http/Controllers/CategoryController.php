<?php

namespace App\Http\Controllers;

use App\Enums\ErrorCode;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Category\ListCategoryRequest;
use App\Http\Requests\Category\DeleteCategoryRequest;
use App\Http\Responses\CategoryResponse;
use App\Repositories\CategoryRepository;
use App\Repositories\GroupItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class CategoryController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/*
    |--------------------------------------------------------------------------
    | Get list Category
    |--------------------------------------------------------------------------
    |    ids       | int       |
	*/
	public function listCategory(CategoryRepository $categoryReppsitory, GroupItemRepository $groupItemRepository, Request $request, CategoryResponse $response) {
		$listCategoryRequest = new ListCategoryRequest($request);

		$groupItems = $groupItemRepository->listGroupItem($listCategoryRequest->getData());
		$categories = $categoryReppsitory->getListCategory();
		$data = array();
		for ($i=1; $i <= 4 ; $i++) { 

			foreach ($categories as $key => $value) {
				if($value->level== 1){
					$data['parent_' . $value->id] = $value;
					$value->child = 'child_' . $value->id;
					unset($categories[$key]);
				}else{
						if($value->level > $i) {
							break;
						}

						$data['child_'.$value->parent_id][] = $value;
						$value->child = 'child_' . $value->id;
						unset($categories[$key]);
				}


			}
			
		}
		var_dump($data);
		/*$response->message = '';
		$response->data = $response->newListCategory($groupItems, $categories);
		return $response->responseData();*/

	}

	/*
    |--------------------------------------------------------------------------
    | Greate Category
    |--------------------------------------------------------------------------
    | name       | String       | required
    | group_item | integer      | required
    | description| String       |
    | parent_id  | integer
	*/
	public function createCategory(CategoryRepository $categoryReppsitory, Request $request, CategoryResponse $response) {
		$createCategoryRequest = new CreateCategoryRequest($request);
		if ($createCategoryRequest->validation()) {
			$response->message = ErrorCode::DATA_INVALID;
			$response->errorMessage = $createCategoryRequest->getErrors();
			return $response->badRequest();
		}

		$category = $createCategoryRequest->getData();
		$result = $categoryReppsitory->createCategory($category);
		if ($result) {
			$response->message = Lang::get('messages.create_category_success');
			$response->data = $response->newCategoryWithModel($category);
			return $response->responseData();
		} else {
			$response->message = ErrorCode::SAVE_DATA_FAIL;
			$response->errorMessage = Lang::get('messages.create_category_fail');
			return $response->badRequest();
		}

	}

	/*
    |--------------------------------------------------------------------------
    | Update Category
    |--------------------------------------------------------------------------
    | id 		 | integer      | required
    | name       | String       | 
    | group_item | integer      | 
    | description| String       |
    | parent_id  | integer
	*/
	public function updateCategory(Request $request, CategoryResponse $response,CategoryRepository $categoryReppsitory){
		$updateCategoryRequest = new UpdateCategoryRequest($request);
		if ($updateCategoryRequest->validation()) {
			$response->message = ErrorCode::DATA_INVALID;
			$response->errorMessage = $updateCategoryRequest->getErrors();
			return $response->badRequest();
		}

		$category = $updateCategoryRequest->getData();
		$result = $categoryReppsitory->updateCategory($category);
		$response->message = Lang::get('messages.update_category_success');
		$response->data = $response->newCategoryWithModel($category); 
		return $response->responseData();

	}

	/*
    |--------------------------------------------------------------------------
    | Update Category
    |--------------------------------------------------------------------------
    | id 		 | integer      | required
	*/
	public function deleteCategory(Request $request, CategoryResponse $response,CategoryRepository $categoryReppsitory){
		$deleteCategoryRequest = new DeleteCategoryRequest($request);
		if ($deleteCategoryRequest->validation()) {
			$response->message = ErrorCode::DATA_INVALID;
			$response->errorMessage = $deleteCategoryRequest->getErrors();
			return $response->badRequest();
		}

		$id = $deleteCategoryRequest->getData();
		$result = $categoryReppsitory->deleteCategory($id);
		$response->message = Lang::get('messages.delete_category_success');
		$response->data = Lang::get('messages.delete_category_success');
		return $response->responseData();
	}
}
