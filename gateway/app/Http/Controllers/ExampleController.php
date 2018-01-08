<?php

namespace App\Http\Controllers;
use App\Http\Curl\Facades\User as UserMicroservice;

class ExampleController extends Controller
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

      public function demo()
    {

        $result = UserMicroservice::checkToken();
        var_dump($result->getBody());
    }

    //
}
