<?php

namespace App\Http\Controllers;

use App\Enums\ErrorCode;
use App\Http\Requests\User\CheckTokenRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Responses\UserResponse;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register for normal user
    |--------------------------------------------------------------------------
    |    email       | string (250)       | required
    |    password    | string             | required
     */

    public function register(UserResponse $response, Request $request, UserRepository $userRepository)
    {
        $registerRequest = new RegisterRequest($request);

        if ($registerRequest->validation()) {
            $response->message      = ErrorCode::DATA_INVALID;
            $response->errorMessage = $registerRequest->getErrors();
            return $response->badRequest();
        }

        $user = $registerRequest->getData();

        $result = $userRepository->newUser($user);

        if ($result > 0) {
            $user->id          = $result;
            $response->data    = $response->newUserResponse($user);
            $response->message = Lang::get('messages.register_success');
            return $response->responseData();
        } else {
            $response->message      = ErrorCode::DATA_ERROR;
            $response->errorMessage = array(Lang::get('messages.register_fail'));
            return $response->badRequest();
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    |    email       | string (250)       | required
    |    password    | string             | required
     */

    public function login(UserResponse $response, Request $request, UserRepository $userRepository)
    {
        $loginRequest = new LoginRequest($request);

        if ($loginRequest->validation()) {
            $response->message      = ErrorCode::DATA_INVALID;
            $response->errorMessage = $loginRequest->getErrors();
            return $response->badRequest();
        }

        $login = $loginRequest->getData();
        $user  = $userRepository->getUserByEmail($login->email);

        if ($user) {
            if ($user->password == crypt($login->password, $user->password)) {
                $user->token = base64_encode(Carbon::now()->toDateTimeString() . '_' . env('PRIVATE_KEY_TOKEN') . '_' . $user->email);
                if ($userRepository->updateUser($user)) {
                    $response->data    = $response->newUserResponse($user);
                    $response->message = Lang::get('messages.login_success');
                    return $response->responseData();
                }

            }
        }

        $response->message      = ErrorCode::lOGIC_PROCESS_FAIL;
        $response->errorMessage = array(Lang::get('messages.login_fail'));
        return $response->badRequest();

    }
    /*
    |--------------------------------------------------------------------------
    | Auth for other service
    |--------------------------------------------------------------------------
    |    token       | string      | required
     */

    public function checkToken(UserResponse $response, Request $request, UserRepository $userRepository)
    {

        $checkTokenRequest = new CheckTokenRequest($request);

        if ($checkTokenRequest->validation()) {
            $response->message      = ErrorCode::DATA_INVALID;
            $response->errorMessage = $checkTokenRequest->getErrors();
            return $response->badRequest();
        }

        $userToken = $checkTokenRequest->getData();
        $decode    = explode('_', base64_decode($userToken->token));
        if (isset($decode[1]) && $decode[1] == env('PRIVATE_KEY_TOKEN')) {

            $user = $userRepository->getUserByToken($userToken->token);
            if ($user) {
                $response->data    = $response->newUserResponse($user);
                $response->message = Lang::get('messages.check_token_success');
                return $response->responseData();
            }

        }

        $response->message      = ErrorCode::lOGIC_PROCESS_FAIL;
        $response->errorMessage = array(Lang::get('messages.check_token_fail'));
        return $response->badRequest();
    }

}
