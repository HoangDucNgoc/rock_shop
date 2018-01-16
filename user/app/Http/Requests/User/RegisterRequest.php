<?php

namespace App\Http\Requests\User;

use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Lang;

class RegisterRequest
{

    private  $request;
    private  $user;
    private  $errors; // array

    public function __construct($requestForm)
    {
        $this->request = $requestForm;
        $this->user = new User();
    }

    public function validation()
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validation */

        $validation = Validator::make(
            $this->request->all(),
            [
                'email' => 'required|unique:users,email|email',
                'password' => 'required|confirmed:password_confirmation|min:8|regex:"^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d$@$!%*#?&]{8,}$"',
            ],
            [
                'email.unique' => Lang::get('messages.email_unique'),
                'email.email' => Lang::get('messages.email_invalid'),
                'email.required' => Lang::get('messages.email_required'),
                'password.confirmed' => Lang::get('messages.password_confirm_invalid'),
                'password.required' => Lang::get('messages.password_required'),
                'password.regex' => Lang::get('messages.password_regex'), 
            ]
        );

        if ($validation->fails()) {
            $this->errors = $validation->getMessageBag()->all();
            return true;
        }
    }

    public function getErrors(){
        return $this->errors;
    }

    public function getData(){
        $this->user->email = $this->request->input('email');
        $this->user->password = $this->request->input('password');
        return $this->user;
    }

}
