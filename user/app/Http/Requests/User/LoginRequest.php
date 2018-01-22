<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Validator;

class LoginRequest
{

    private $request;
    private $user;
    private $errors; // array

    public function __construct($requestForm)
    {
        $this->request = $requestForm;
        $this->user    = new User();
    }

    public function validation()
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validation */

        $validation = Validator::make(
            $this->request->all(),
            [
                'email'    => 'required',
                'password' => 'required',
            ],
            [
                'email.required'    => Lang::get('messages.email_required'),
                'password.required' => Lang::get('messages.password_required'),
            ]
        );

        if ($validation->fails()) {
            $this->errors = $validation->getMessageBag()->all();
            return true;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getData()
    {
        $this->user->email    = $this->request->input('email');
        $this->user->password = $this->request->input('password');
        return $this->user;
    }

}
