<?php
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

    //Create new Event
    public function createEvent($data)
    {
        $query = "INSERT INTO " . $this->table_name . " (
                event_name, 
                organization_name, 
                start_date, 
                end_date, 
                host, 
                description, 
                cost_per_vote, 
                created_at, 
                show_results, 
                status
              ) VALUES (
                :event_name, 
                :organization_name, 
                :start_date, 
                :end_date, 
                :host, 
                :description, 
                :cost_per_vote, 
                :created_at, 
                :show_results, 
                :status
              )";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':event_name', $data['event_name']);
        $stmt->bindParam(':organization_name', $data['organization_name']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':host', $data['host']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':cost_per_vote', $data['cost_per_vote']);
        $stmt->bindParam(':created_at', date('Y-m-d H:i:s'));
        $stmt->bindParam(':show_results', $data['show_results']);
        $stmt->bindParam(':status', $data['status']);

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

    //Update Event
    public function updateEvent($id, $data)
    {
        // Prepare the update query
        $query = "UPDATE " . $this->table_name . " 
              SET event_name = :event_name, 
                  organization_name = :organization_name, 
                  start_date = :start_date, 
                  end_date = :end_date, 
                  host = :host, 
                  description = :description, 
                  cost_per_vote = :cost_per_vote, 
                  show_results = :show_results, 
                  status = :status
              WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':event_name', $data['event_name']);
        $stmt->bindParam(':organization_name', $data['organization_name']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':host', $data['host']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':cost_per_vote', $data['cost_per_vote']);
        $stmt->bindParam(':show_results', $data['show_results']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
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
