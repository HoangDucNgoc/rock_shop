<?php

namespace App\Http\Controllers;

use App\Http\Curl\Facades\Item as ItemMicroservice;
use Illuminate\Http\Request;

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
     */
    public function listCategory(Request $request)
    {
        $result = ItemMicroservice::listCategory(['json' => array('ids'=>$request->user()->groupItem)]);
        if ($result && $result->getStatusCode() != 500) {
            return response()->json($result->getBody(), $result->getStatusCode());
        }
        return response()->json("Error Server", 500);
    }

    public function createCategory(Request $request){

        $result = ItemMicroservice::createCategory(['json' => (array) json_decode($request->getContent())]);
        if ($result && $result->getStatusCode() != 500) {
            return response()->json($result->getBody(), $result->getStatusCode());
        }
        return response()->json("Error Server", 500);
    }
   

}
