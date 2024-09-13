<?php
//Events Model
require_once __DIR__ . '/../config/database.php';

class Event
{
    private $conn;
    private $table_name = "events";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Create a new event
    public function createEvent($data)
    {
        $query = "INSERT INTO " . $this->table_name . " 
        (name, image, description, organization_name,sender_id, response_message, organizer_share, admin_share , cost_per_vote, host, show_results, event_start, event_end) 
        VALUES (:name, :image, :description, :organization_name, :sender_id, :response_message, :organizer_share, :admin_share, :cost_per_vote, :host, :showresults, :event_start, :event_end)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':organization_name', $data['organization_name']);
        $stmt->bindParam(':sender_id', $data['sender_id']);
        $stmt->bindParam(':response_message', $data['response_message']);
        $stmt->bindParam(':organizer_share', $data['organizer_share']);
        $stmt->bindParam(':admin_share', $data['admin_share']);
        $stmt->bindParam(':cost_per_vote', $data['cost_per_vote']);
        $stmt->bindParam(':host', $data['host']);
        $stmt->bindParam(':showresults', $data['showresults']);
        $stmt->bindParam(':event_start', $data['event_start']);
        $stmt->bindParam(':event_end', $data['event_end']);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            // Get error information
            $error = $stmt->errorInfo();
            // Optionally log or display the error
            echo "Error executing query: " . $error[2];
            return false;
        }
    }

    //Get All Events
    public function getAllEvents()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $events;
    }

    // Read a single event by ID
    public function getEventById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        return $event;
    }

    
    // Update event
    public function updateEvent($id, $data)
    {
        // Prepare the update query
        $query = "UPDATE " . $this->table_name . " 
        SET name = :name, 
        image = :image, 
        description = :description, 
        organization_name = :organization_name, 
        sender_id = :sender_id, 
        response_message = :response_message, 
        organizer_share = :organizer_share, 
        admin_share = :admin_share, 
        cost_per_vote = :cost_per_vote, 
        host = :host, 
        show_results = :show_results, 
        event_start = :event_start, 
        event_end = :event_end
        WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':organization_name', $data['organization_name']);
        $stmt->bindParam(':sender_id', $data['sender_id']);
        $stmt->bindParam(':response_message', $data['response_message']);
        $stmt->bindParam(':organizer_share', $data['organizer_share']);
        $stmt->bindParam(':admin_share', $data['admin_share']);
        $stmt->bindParam(':cost_per_vote', $data['cost_per_vote']);
        $stmt->bindParam(':host', $data['host']);
        $stmt->bindParam(':show_results', $data['show_results']); 
        $stmt->bindParam(':event_start', $data['event_start']);
        $stmt->bindParam(':event_end', $data['event_end']);
        $stmt->bindParam(':id', $id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            // Get error information
            $error = $stmt->errorInfo();
            // Optionally log or display the error
            echo "Error executing query: " . $error[2];
            return false;
        }
    }


    //Delete event
    public function deleteEvent($id)
    {
        // Prepare the delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
