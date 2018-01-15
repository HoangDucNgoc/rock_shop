<?php

namespace App\Http\Requests\User;

use Validator;

class RegisterRequest
{

    public function validation($request)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validation */

        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Tasd.',
            ]
        );

        if ($validation->fails()) {
            return $validation->getMessageBag()->all();
        }
    }

}
