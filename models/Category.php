<?php
require_once __DIR__ . '/../config/database.php';

class Category
{
    private $conn;
    private $table_name = "category";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    //Create a new collatory
    public function createCategory($data){
        $query = "INSERT INTO " . $this->table_name . "
        (name, description, image, event_id)
        VALUES(:name, :descrition, :image, :event_id)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':event_id', $data['event_id']);

        if ($stmt->execute()){
            return true;
        }else{
            $error =$stmt->errorInfo();

            echo "Error creating new category:" . $error[2];
            return false;
        }
    }


    //Get All Categories By Event
    public function getCategoriesOfEvent($id){
        $query = "SELECT * FROM " . $this->table_name . " WHERE event_id=:event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $id);
        $stmt->execute();
        
        $categories = $stmt->fetch(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function updateCategory($data){
        $query = "UPDATE " . $this->table_name . " 
        SET name=:name, description=:description, image=:image";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':image', $data['image']);
        
        if($stmt->execute()){
            return true;
        }
    }
}


