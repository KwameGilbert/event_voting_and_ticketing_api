<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController{
    private $category;

    public function __construct(){
        $this->category = new Category();
    }

    //Create new category
    public function createCategory($data){
        if($this->category->createCategory($data)){
            return json_encode([
                "message" => "Category created successfully",
                "data" => $data 
            ], 201);
        }else{
            return json_encode([
                "message" => "Failed to create user"
            ], 500);
        }
    }

    //Get all Categories
    public function getCategoriesOfEvent($id){
        $eventCategories = $this->category->getCategoriesOfEvent($id);
        if($eventCategories >= 0){
            return json_encode(["eventCategories" => $eventCategories], 200);
        }else{
            return json_encode(["message" => "Failed to fetch event categories"], 500);
        }
    }
    
    //Update Category
    public function updateCategory($id, $data){
        if($this->category->updateCategory($id, $data)){
            return json_encode(["message" => "Category updated succesfully",
            "category" => $data], 200);
        }else{
            return json_encode(["message" => "Failed to update category"], 500);
        }
    }

    //Delete category
    public function deleteCategory($id){
        if($this->category->deleteCategory($id)){
            return json_encode(["message" => "Category deleting succesfully"], 200);
        }else{
            return json_encode(["message"=> "Failed to delete category"], 500);
        }
    }
        
}

?>