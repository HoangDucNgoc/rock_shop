<?php

namespace App\Models;

use App\Enums\Status;
use Carbon\Carbon;

class User 
{
	public $id;
	public $userName;
	public $email;
	public $password;
	public $phone;
	public $firstName;
	public $lastName;
	public $address;
	public $token;
	public $birthday;
	public $isActive;
	public $isDelete;
	public $roleId;
	public $createdAt;
	public $updatedAt;

	public function setDefaultValue(){
		$this->isActive = Status::ACTIVE;
		$this->isDelete = Status::UNDELETE;
		$this->createdAt = Carbon::now()->timestamp;
	}

	
}
