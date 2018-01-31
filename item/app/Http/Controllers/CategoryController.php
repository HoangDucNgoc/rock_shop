<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;

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

    public function listCategory(CategoryRepository $categoryReppsitory)
    {
        return $categoryReppsitory->getListCategory();

    }
}
