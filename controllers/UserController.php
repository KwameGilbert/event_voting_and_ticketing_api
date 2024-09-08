<?php

require_once __DIR__. '/../models/User.php';
// require_once './helpers/Response.php';
session_start();

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    // Create User
    public function createUser($data)
    {
        if ($this->user->createUser($data)) {
            return json_encode([
                "message" => "User created successfully.",
                "data" => $data
            ], 201);
        } else {
            return json_encode([
                "message" => "Failed to create user."
            ], 500);
        }
    }

    // Get All Users
    public function getAllUsers()
    {
        $users = $this->user->getAllUsers();
        if ($users) {
            return json_encode(["users" => $users], 200);
        } else {
            return json_encode([
                "message" => "Failed to get all users."
            ], 500);
        }
    }

    // Get User by ID
    public function getUserById($id)
    {
        $user = $this->user->getUserById($id);
        if ($user) {
            return json_encode(["user" => $user], 200);
        } else {
            return json_encode([
                "message" => "User by Id not found."
            ], 404);
        }
    }

    // Login User
    public function login($email, $password)
    {
        $user = $this->user->login($email, $password);

        if ($user) {
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            return json_encode([
                "message" => "Login successful",
                "user" => $user
            ], 200);
        } else {
            return json_encode([
                "message" => "Invalid credentials"
            ], 401);
        }
    }

    // Update User
    public function updateUser($id, $data)
    {
        if ($this->user->updateUser($id, $data)) {
            return json_encode([
                "message" => "User updated successfully.",
                "user" => $data
            ], 200);
        } else {
            return json_encode([
                "message" => "Failed to update user."
            ], 500);
        }
    }

    // Delete User
    public function deleteUser($id)
    {
        if ($this->user->deleteUser($id)) {
            return json_encode([
                "message" => "User deleted successfully."
            ], 200);
        } else {
            return json_encode([
                "message" => "Failed to delete user."
            ], 500);
        }
    }

    // Logout User
    public function logout()
    {
        // Destroy the session to log the user out
        session_unset();  // Unset all session variables
        session_destroy();  // Destroy the session itself

        return json_encode([
            "message" => "Logout successful"
        ], 200);
    }
}
