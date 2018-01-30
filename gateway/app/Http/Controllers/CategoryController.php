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

       $result = ItemMicroservice::listCategory();
       var_dump($result);

        /*if ($result && $result->getStatusCode() != 500) {
            return response()->json($result->getBody(), $result->getStatusCode());
        }
        return response()->json("Error Server", 500);*/
        echo "string";
    }
   

}
