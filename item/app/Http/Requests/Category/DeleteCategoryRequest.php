<?php

namespace App\Http\Requests\Category;

use Illuminate\Support\Facades\Lang;
use Validator;

class DeleteCategoryRequest
{

    private $request;
    private $user;
    private $errors; // array

    public function __construct($requestForm)
    {
        $this->request = $requestForm;
    }

    public function validation()
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validation */

        $validation = Validator::make(
            $this->request->all(),
            [
                'id' => 'required|integer',
            ],
            [
                'id.integer' => Lang::get('messages.id_must_integer'),
                'id.required' => Lang::get('messages.id_category_required'),
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
        return $this->request->input('id');
    }

}
