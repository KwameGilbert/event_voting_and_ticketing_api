<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__ . '/../controllers/UserController.php';

return function (App $app) {
    $userController = new UserController();

    $app->group('/users', function () use ($app, $userController) {

        // Route to get all users
        $app->get('', function (Request $request, Response $response) use ($userController) {
            $result = $userController->getAllUsers();
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to get a user by ID
        $app->get('/{id}', function (Request $request, Response $response, array $args) use ($userController) {
            $id = $args['id'];
            $result = $userController->getUserById($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to create a new user
        $app->post('', function (Request $request, Response $response) use ($userController) {
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $userController->createUser($data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route for login
        $app->post('/login', function (Request $request, Response $response) use ($userController) {
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $userController->login($data['email'], $data['password']);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to update a user by ID
        $app->patch('/{id}', function (Request $request, Response $response, array $args) use ($userController) {
            $id = $args['id'];
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $userController->updateUser($id, $data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to delete a user by ID
        $app->delete('/{id}', function (Request $request, Response $response, array $args) use ($userController) {
            $id = $args['id'];
            $result = $userController->deleteUser($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });
};
