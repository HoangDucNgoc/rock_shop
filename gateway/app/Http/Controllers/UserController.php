<?php

namespace App\Http\Controllers;

use App\Http\Curl\Facades\User as UserMicroservice;
use Illuminate\Http\Request;

class UserController extends Controller
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
    | Register for normal user
    |--------------------------------------------------------------------------
    |    email       | string (250)       | required
    |    password    | string             | required
     */
    public function register(Request $request)
    {
        $result = UserMicroservice::register(['json' => (array) json_decode($request->getContent())]);

        if ($result) {
            return response()->json($result->getBody(), $result->getStatusCode());
        }
        return response()->json("Error Server", 500);
    }

    //
}
