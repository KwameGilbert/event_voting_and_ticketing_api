<?php 
//Contestant Model
require_once __DIR__ . '/../config/Database.php';

class Contestant {
    private $conn;
    private $table_name = 'contestants';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createContestant($data) {
        $query = 'INSERT INTO ' . $this->table_name . "
        (name, stage_name, category_id, image, status)
        VALUES(:name, :stage_name, :category_id, :image, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':stage_name', $data['stage_name']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':status', $data['status']);

        if($stmt->execute()) {
            return true;
        }else{
            $error = $stmt->errorInfo();
            echo "Error creating contestant:" . $error[2];
            return false;
    }
}

    public function getAllContestantsByEvent($eventId)
    {
        // SQL query to join contestants with their categories and filter by event ID
        $query = '
        SELECT c.*, cat.name as category_name
        FROM ' . $this->table_name . ' c
        JOIN categories cat ON c.category_id = cat.id
        WHERE c.event_id = :event_id
        ORDER BY cat.name';

        // Prepare and execute the query
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();

        // Fetch all the results grouped by categories
        $contestantsByEvent = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $contestantsByEvent;
    }


    public function getSingleContestant($contestantId) {
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE id = :id LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $contestantId);
        $stmt->execute();

        $contestant = $stmt->fetch(PDO::FETCH_ASSOC);
        return $contestant;
    }

    public function updateContestant($id, $data) {
        $query = 'UPDATE ' . $this->table_name . ' SET name = :name, stage_name = :stage_name, category_id = :category_id, image = :image, status = :status WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':stage_name', $data['stage_name']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()){
            return true;
        }else{
            // Get error information
            $error = $stmt->errorInfo();
            echo "Error updating contestant: " . $error[2];
            return false;
        }
    }

    public function deleteContestant($id){
        $query = 'DELETE FROM '. $this->table_name . 'WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()){
            return true;
        }else{
            // Get error information
            $error = $stmt->errorInfo();
            // Optionally log or display the error
            echo "Error executing query: " . $error[2];
            return false;
        }
    }
}
?>