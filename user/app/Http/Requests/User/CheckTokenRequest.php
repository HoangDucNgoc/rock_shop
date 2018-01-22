<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Validator;

class CheckTokenRequest
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
            $this->request->headers->all(),
            [
                'token' => 'required',
            ],
            [
                'token.required' => Lang::get('messages.token_required'),
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
        $this->user->token = $this->request->header('token');
        return $this->user;
    }

}
