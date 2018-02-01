<?php

namespace App\Http\Requests\Category;

use App\Enums\Status;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Validator;
use App\Repositories\CategoryRepository;

class CreateCategoryRequest
{

    private $request;
    private $category;
    private $errors; // array

    public function __construct($requestForm)
    {
        $this->request = $requestForm;
        $this->category    = new Category();
    }

    public function validation()
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validation */

        $validation = Validator::make(
            $this->request->all(),
            [
                'name'    => 'required|unique:category,name|max:240',
            ],
            [
                'name.unique'       => Lang::get('messages.name_category_unique'),
                'name.required'        => Lang::get('messages.name_category_required')
            ]
        );

        $validation->after(function ($validator) {
            $parentId = $this->request->input('parent_id');
            if($parentId ){
                $categoryRepository = new CategoryRepository();
                // not exist category parent
                if($categoryRepository->getCategoryById($parentId) == null){
                    $validator->getMessageBag()->add('parent_id', Lang::get('messages.parent_cateory_not_exist'));
                }
            }
            
        });


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
        $this->category->email    = $this->request->input('name');
        $this->category->userName = $this->request->input('description');
        $this->category->isActive = Status::ACTIVE;
        $this->category->isDelete = Status::UNDELETE;
        $this->category->parentId = ($this->request->input('parent_id') != null) ? $this->request->input('parent_id') : 0;
        return $this->category;
    }

}
