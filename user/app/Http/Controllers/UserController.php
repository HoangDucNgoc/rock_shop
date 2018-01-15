<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequest;
use App\Http\Responses\UserResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function register(RegisterRequest $registerRequest, UserResponse $response,Request $request )
    {
        var_dump($registerRequest->validation($request));
        return $response->responseData();
    }

}
