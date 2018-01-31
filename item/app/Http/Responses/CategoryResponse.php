<?php

namespace App\Http\Responses;

class Category
{
    public $id;
    public $name;
    public $parentId;
    public $description;
}

class CategoryResponse extends Response
{
	/**
     *  new category to response
     *
     * @param  App\Models\User $user
     * @return App\Http\Responses\Response
     */
    public function newCategory($userModel)
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

}