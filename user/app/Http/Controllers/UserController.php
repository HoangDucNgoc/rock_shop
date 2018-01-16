<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequest;
use App\Http\Responses\UserResponse;
use App\Enums\ErrorCode;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Lang;


class UserController extends Controller
{

    public function register( UserResponse $response,Request $request , UserRepository $userRepository )
    {
    	$registerRequest  = new RegisterRequest($request);

        if($registerRequest->validation()){
        	$response->message = ErrorCode::DATA_INVALID; 
        	$response->errorMessage = $registerRequest->getErrors();
        	return $response->badRequest();
        }

        $user = $registerRequest->getData();
        $user->setDefaultValue();

        $result = $userRepository->newUser($user);

        if($result > 0 ){
        	$user->id = $result;
        	$response->data = $response->newUserResponse($user);
	        $response->message = Lang::get('messages.register_success');
	        return $response->responseData();
        }
    }

}
