<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/JWTHandler.php'; // Include the JWTHandler class

class User
{
    private $conn;
    private $table_name = "users";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Create a new user
    public function createUser($data)
    {
        $query = "INSERT INTO " . $this->table_name . " (email, password, firstName, lastName, phone) 
                  VALUES (:email, :password, :firstName, :lastName, :phone)";

        $stmt = $this->conn->prepare($query);

        $data['password'] = $this->hash_password($data['password']);

        // Bind parameters
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':firstName', $data['firstName']);
        $stmt->bindParam(':lastName', $data['lastName']);
        $stmt->bindParam(':phone', $data['phone']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Read all users
    public function getAllUsers()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($users as &$user) {
            unset($user['password']);
        }

        return $users;
    }

    // Read a single user by ID
    public function getUserById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        unset($user['password']);

        return $user;
    }

    //Get all Events of a User
    public function getEventsByUserId($id)
    {
        $query = "SELECT * FROM events WHERE host = :host";
        $stmt = $this->conn->prepare($query);

        //Bind parameters
        $stmt->bindParam(':host', $id);
        $stmt->execute();

        $userEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $userEvents;
    }

    //Login a user
    public function login($email, $password)
    {
        // SQL query to fetch user by email
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        // Bind the email parameter to the query
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Fetch the user
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user is found and password matches, create a JWT
        if ($user && password_verify($password, $user['password'])) {
            // Remove password from the response
            unset($user['password']);

            // Create an instance of JWTHandler
            $jwtHandler = new JWTHandler();

            // Generate the token
            $jwt = $jwtHandler->generateToken($user);

            $data = [
                'token' => $jwt,
                'data' => $user
            ];
            // Return the token
            return $data;
        }

        // If login fails, return false
        return false;
    }

    // Update a user
    public function updateUser($id, $data)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET email = :email, password = :password, firstName = :firstName, lastName = :lastName, phone = :phone
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        // Bind parameters
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':firstName', $data['firstName']);
        $stmt->bindParam(':lastName', $data['lastName']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete a user
    public function deleteUser($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function hash_password($password): string
    {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        return $hashed_password;
    }
}
