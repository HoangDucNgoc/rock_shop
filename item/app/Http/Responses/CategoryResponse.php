<?php

namespace App\Http\Responses;

class Category
{
    public $id;
    public $name;
    public $parentId;
    public $description;
}

class GroupItems
{
    public $id;
    public $name;
    public $categories; 
}

class CategoryResponse extends Response
{
	/**
     *  new category to response
     *
     * @param  Illuminate\Support\Facades\DB stdClass $groupItems
     * @param  Illuminate\Support\Facades\DB stdClass $categories
     * @return App\Http\Responses\Response
     */
    public function newListCategory($groupItems,$categories)
    {
        $data = array();
        foreach ($groupItems as $key => $item) {
            $groupItems = new GroupItems();
            $groupItems->id = $item->id;
            $groupItems->name = $item->name;
            $groupItems->categories = array();
            $data['group_' . $item->id] = $groupItems;
        }

        foreach ($categories as $key => $item) {
            $category = new Category();
            $category->id = $item->id;
            $category->name = $item->name;
            $category->parentId = $item->parent_id;
            $category->description = $item->description;
            $data['group_' . $item->id]->categories[] = $category;
        }

        return $data;
    }

}