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

    public function register(Request $request)
    {
        $result = UserMicroservice::register(['json' => (array) json_decode($request->getContent())]);
        
        //var_dump($result->getBody());
    }

    //
}
