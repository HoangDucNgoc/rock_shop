<?php

namespace App\Http\Controllers;

use App\Enums\ErrorCode;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\ListCategoryRequest;
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

		$response->data = $response->newListCategory($groupItems, $categories);
		return $response->responseData();

	}

	/*
		    |--------------------------------------------------------------------------
		    | Greate Category
		    |--------------------------------------------------------------------------
		    | name       | String       | required
		    | group_item | integer       | required
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
			$response->data = $response->newCategoryWithModel($category);
			return $response->responseData();
		} else {
			$response->message = ErrorCode::SAVE_DATA_FAIL;
			$response->errorMessage = Lang::get('messages.create_category_fail');
			return $response->badRequest();
		}

	}
}
