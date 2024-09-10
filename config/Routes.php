<?php

use Slim\App;
use App\Controllers\UserController;

return function (App $app) {
    $userController = new UserController();

    $app->get('/users', [$userController, 'getAllUsers']);
    $app->get('/users/{id}', [$userController, 'getUserById']);
    $app->post('/users', [$userController, 'createUser']);
    $app->post('/users/login', [$userController, 'login']);
    $app->patch('/users/{id}', [$userController, 'updateUser']);
    $app->delete('/users/{id}', [$userController, 'deleteUser']);

    // Add more routes for other controllers as needed
};
