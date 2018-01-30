<?php

namespace App\Http\Responses;

use App\Repositories\RoleRepository;
use App\Repositories\FeatureRepository;

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
    public $feature;
    public $groupItem;
}

/**
* Role
**/
class Role
{
    public $name;
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
        $user->token     = $userModel->token;
        $user->birthday  = $userModel->birthday;
        $user->groupItem = $userModel->groupItem;
        $user->role      = $this->getRole($userModel->roleId);
        $user->feature   = $this->getFeature($userModel->roleId);
        return $user;
    }

    private function getRole($roleId)
    {
        $roleRepository = new RoleRepository();
        $role = new Role();
        $result = $roleRepository->getRoleByid($roleId);
        if($result){
            $role->name = $result->name;
        }
        return $role;
    }

    private function getFeature($roleId) {
        $featureRepository = new FeatureRepository();
        return $featureRepository->getFeature($roleId);
    }

}
