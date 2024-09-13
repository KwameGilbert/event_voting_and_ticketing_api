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

    // Get All Categories By Event with the count of contestants for each category
    public function getCategoriesOfEvent($id)
    {
        $query = "
        SELECT c.*, COUNT(ct.id) AS contestant_count
        FROM " . $this->table_name . " c
        LEFT JOIN contestants ct ON ct.category_id = c.id
        WHERE c.event_id = :event_id
        GROUP BY c.id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $id);
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all categories with contestant count
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
        }else{
            $error = $stmt->errorInfo();
            echo "Error updating category:" . $error[2];
            return false;
        }
    }

    public function deleteCategory($id){
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()){
            return true;
        }else{
            $error = $stmt->errorInfo();
            echo "Error deleting category: " . $error[2];
        }
    }
}



