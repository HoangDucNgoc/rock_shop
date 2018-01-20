<?php

namespace App\Http\Requests\User;

use App\Enums\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Validator;

class RegisterRequest
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
                'email'    => 'required|unique:users,email|email|max:240',
                'password' => 'required|confirmed:password_confirmation|min:8|max:240|regex:"^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d$@$!%*#?&]{8,}$"',
            ],
            [
                'email.unique'       => Lang::get('messages.email_unique'),
                'email.email'        => Lang::get('messages.email_invalid'),
                'email.required'     => Lang::get('messages.email_required'),
                'password.confirmed' => Lang::get('messages.password_confirm_invalid'),
                'password.required'  => Lang::get('messages.password_required'),
                'password.regex'     => Lang::get('messages.password_regex'),
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
        $this->user->userName = $this->request->input('email');
        $this->user->password = Hash::make($this->request->input('password'));
        $this->user->isActive = Status::ACTIVE;
        $this->user->isDelete = Status::UNDELETE;
        $this->user->token    = base64_encode(Carbon::now() . '_' . env('PRIVATE_KEY_TOKEN'));
        return $this->user;
    }

}
