<?php

namespace App\Http\Responses;

/**
 * Use for response to client
 */
class User
{
    public $id;
    public $userName;
    public $email;
    public $phone;
    public $firstName;
    public $lastName;
    public $address;
    public $token;
    public $birthday;
    public $role;
}

class UserResponse extends Response
{

    /**
     *  new user to response
     *
     * @param  App\Models\User $user
     * @return App\Http\Responses\Response
     */
    public function newUserResponse($userModel)
    {
        $user            = new User();
        $user->id        = $userModel->id;
        $user->userName  = $userModel->userName;
        $user->email     = $userModel->email;
        $user->phone     = $userModel->phone;
        $user->firstName = $userModel->firstName;
        $user->lastName  = $userModel->lastName;
        $user->address   = $userModel->address;
        $user->token     = $user->token;
        $user->birthday  = $userModel->birthday;
        return $user;
    }
}
