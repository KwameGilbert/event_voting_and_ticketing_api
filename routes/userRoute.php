<?php

use Slim\App;

require_once __DIR__ . '/../controllers/UserController.php';

return function (App $app) {
    $userController = new UserController();

    $app->group('/users', function () use ($app, $userController) {

        $app->get('', function ($request, $response) use ($userController) {
            return $userController->getAllUsers();
        });

        $app->get('/{id}', function ($request, $response, $args) use ($userController) {
            return $userController->getUserById($args['id']);
        });

        $app->post('', function ($request, $response) use ($userController) {
            $data = $request->getParsedBody();  // Get JSON or form data from the request
            return $userController->createUser($data);
        });

        $app->post('/login', function ($request, $response) use ($userController) {
            $data = $request->getParsedBody();  // Get JSON or form data from the request
            return $userController->login($data['email'], $data['password']);
        });

        $app->patch('/{id}', function ($request, $response, $args) use ($userController) {
            $data = $request->getParsedBody();  // Get JSON or form data from the request
            return $userController->updateUser($args['id'], $data);
        });

        $app->delete('/{id}', function ($request, $response, $args) use ($userController) {
            return $userController->deleteUser($args['id']);
        });
    });
};
