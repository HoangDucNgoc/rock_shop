<?php

namespace App\Http\Controllers;

use App\Http\Curl\Facades\Item as ItemMicroservice;
use Illuminate\Http\Request;

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
    |$array = json_decode(json_encode($booking), true);
	*/
	public function listCategory(Request $request) {
		$result = ItemMicroservice::listCategory(['json' => array('ids' => $request->user()->groupItem)]);

		if ($result && $result->getStatusCode() != 500) {
			return response()->json($result->getBody(), $result->getStatusCode());
		}
		return response()->json("Error Server", 500);
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
	public function createCategory(Request $request) {

		$result = ItemMicroservice::createCategory(['json' => (array) json_decode($request->getContent())]);
		if ($result && $result->getStatusCode() != 500) {
			return response()->json($result->getBody(), $result->getStatusCode());
		}
		return response()->json("Error Server", 500);
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
	public function updateCategory(Request $request) {

		$result = ItemMicroservice::updateCategory(['json' => (array) json_decode($request->getContent())]);
		if ($result && $result->getStatusCode() != 500) {
			return response()->json($result->getBody(), $result->getStatusCode());
		}
		return response()->json("Error Server", 500);
	}

	/*
    |--------------------------------------------------------------------------
    | Delete Category
    |--------------------------------------------------------------------------
    | id 		 | integer      | required
	*/
	public function deleteCategory(Request $request) {

		$result = ItemMicroservice::deleteCategory(['query' => $request->query()]);
		if ($result && $result->getStatusCode() != 500) {
			return response()->json($result->getBody(), $result->getStatusCode());
		}
		return response()->json("Error Server", 500);
	}

}
