<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\GroupItemRepository;
use App\Http\Requests\Category\ListCategoryRequest;
use App\Http\Requests\Category\CreateCategoryRequest;
use Illuminate\Http\Request;
use App\Http\Responses\CategoryResponse;
use App\Enums\ErrorCode;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | Get list Category 
    |--------------------------------------------------------------------------
    |    ids       | int       | 
     */
    public function listCategory(CategoryRepository $categoryReppsitory, GroupItemRepository $groupItemRepository, Request $request,CategoryResponse $response)
    {
        $listCategoryRequest = new ListCategoryRequest($request);

        $groupItems =  $groupItemRepository->listGroupItem($listCategoryRequest->getData());
        $categories =  $categoryReppsitory->getListCategory();

        $response->data    = $response->newListCategory($groupItems,$categories);
        return $response->responseData();

    }

    /*
    |--------------------------------------------------------------------------
    | Greate Category 
    |--------------------------------------------------------------------------
    |    ids       | int       | 
     */
    public function createCategory(Request $request,CategoryResponse $response)
    {
        $createCategoryRequest = new CreateCategoryRequest($request);
        if ($createCategoryRequest->validation()) {
            $response->message      = ErrorCode::DATA_INVALID;
            $response->errorMessage = $createCategoryRequest->getErrors();
            return $response->badRequest();
        }
        return 'sdf';

    }
}
