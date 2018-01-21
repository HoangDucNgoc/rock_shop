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
        //var_dump($request->user());

        $result = UserMicroservice::register(['json' => (array) json_decode($request->getContent())]);

        if ($result && $result->getStatusCode() != 500) {
            return response()->json($result->getBody(), $result->getStatusCode());
        }
        return response()->json("Error Server", 500);
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    |    email       | string (250)       | required
    |    password    | string             | required
     */
    public function login(Request $request)
    {
        $result = UserMicroservice::login(['query' => $request->query()]);
        if ($result && $result->getStatusCode() != 500) {
            return response()->json($result->getBody(), $result->getStatusCode());
        }
        return response()->json("Error Server", 500);
    }

}
