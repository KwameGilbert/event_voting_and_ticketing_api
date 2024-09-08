<?php

use Slim\App;

require_once __DIR__ . '/../controllers/UserController.php';

return function (App $app) {
    $userController = new UserController();

    $app->group('/user', function () use ($app, $userController) {

        $app->get('', function () use ($userController) {
            return $userController->getAllUsers();
        });

        $app->get('/{id}', function ($args) use ($userController) {
            return $userController->getUserById($args['id']);
        });

        $app->post('', function () use ($userController) {
            $data = json_decode(file_get_contents('php://input'), true);
            return $userController->createUser($data);
        });

        $app->post('/login', function () use ($userController) {
            $data = json_decode(file_get_contents('php://input'), true);
            return $userController->login($data['email'], $data['password']);
        });

        $app->patch('/{id}', function ($args) use ($userController) {
            $data = json_decode(file_get_contents('php://input'), true);
            return $userController->updateUser($args['id'], $data);
        });

        $app->delete('/{id}', function ($args) use ($userController) {
            return $userController->deleteUser($args['id']);
        });
    });
};
