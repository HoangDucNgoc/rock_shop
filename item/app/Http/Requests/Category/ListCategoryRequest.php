<?php

namespace App\Http\Requests\Category;

use Illuminate\Support\Facades\Lang;
use Validator;

class ListCategoryRequest
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

        $validation = Validator::make();

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
        $ids = $this->request->input('ids');
        if($ids == null || $ids == 0 ){
            return ;
        }

        return $ids;
    }

}
