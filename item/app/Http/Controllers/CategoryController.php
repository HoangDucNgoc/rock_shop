<?php

namespace App\Http\Controllers;

use App\Enums\ErrorCode;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\DeleteCategoryRequest;
use App\Http\Requests\Category\ListCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Responses\CategoryResponse;
use App\Repositories\CategoryRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\GroupItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Category;

class CategoryController extends Controller {

	private $maxLevelMenu;
	private $categoryRepository;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(CategoryRepository $categoryRepository, ConfigRepository $configRepository) {
		$this->categoryRepository = $categoryRepository;

		$this->maxLevelMenu = $configRepository->getConfigByName('level_menu')->value;

	}

	/*
		    |--------------------------------------------------------------------------
		    | Get list Category
		    |--------------------------------------------------------------------------
		    |    ids       | int       |
	*/
	public function listCategory(GroupItemRepository $groupItemRepository, Request $request, CategoryResponse $response) {

		$listCategoryRequest = new ListCategoryRequest($request);
		$groupItem = $listCategoryRequest->getData();

		$groupItems = $groupItemRepository->listGroupItem($groupItem);
		$categories = $this->categoryRepository->getListCategory($groupItem);

		$response->message = '';
		$response->data =  $response->newListCategory($groupItems, $categories, $this->maxLevelMenu);
		return $response->responseData();

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
	public function createCategory( Request $request, CategoryResponse $response) {
		$createCategoryRequest = new CreateCategoryRequest($request);
		if ($createCategoryRequest->validation()) {
			$response->message = ErrorCode::DATA_INVALID;
			$response->errorMessage = $createCategoryRequest->getErrors();
			return $response->badRequest();
		}

		$category = $createCategoryRequest->getData();

		$result = $this->categoryRepository->createCategory($category);
		if ($result) {
			$response->message = Lang::get('messages.create_category_success');
			$response->data = $response->newCategoryWithModel($category);
			return $response->responseData();
		} else {
			$response->message = ErrorCode::SAVE_DATA_FAIL;
			$response->errorMessage = array(Lang::get('messages.create_category_fail'));
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
	public function updateCategory(Request $request, CategoryResponse $response) {
		$updateCategoryRequest = new UpdateCategoryRequest($request);
		if ($updateCategoryRequest->validation()) {
			$response->message = ErrorCode::DATA_INVALID;
			$response->errorMessage = $updateCategoryRequest->getErrors();
			return $response->badRequest();
		}

		$category = $updateCategoryRequest->getData();
		$result = $this->categoryRepository->updateCategory($category);
		$arrParrent = array($category->id);
		// update level for all child category of category update
		for ($i=1; $i <= $this->maxLevelMenu ; $i++) { 
			$categories = $this->categoryRepository->getListCategoryByParentIds($arrParrent);
			$arrParrent = array();
			if($categories == null) {
				break;
			}
			foreach ($categories as $key => $value) {

				$value->level = $value->level +  $updateCategoryRequest->levelRun;
				$this->categoryRepository->updateLevelCategory($value->id,$value->level);
				$arrParrent[] = $value->id;
			}
		}

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
	public function deleteCategory(Request $request, CategoryResponse $response) {
		$deleteCategoryRequest = new DeleteCategoryRequest($request);
		if ($deleteCategoryRequest->validation()) {
			$response->message = ErrorCode::DATA_INVALID;
			$response->errorMessage = $deleteCategoryRequest->getErrors();
			return $response->badRequest();
		}

		$id = $deleteCategoryRequest->getData();

		$category = $this->categoryRepository->getCategoryByField(array('parent_id' => $id));

		// can't delete category have child
		if($category) {
			$response->message = ErrorCode::DATA_INVALID;
			$response->errorMessage = array(Lang::get('messages.category_have_child_can_not_delete'));
			return $response->badRequest();
		}

		$result = $this->categoryRepository->deleteCategory($id);
		$response->message = Lang::get('messages.delete_category_success');
		$response->data = Lang::get('messages.delete_category_success');
		return $response->responseData();
	}
}
