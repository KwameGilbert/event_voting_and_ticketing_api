<?php
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../controllers/UserController.php';

return function (App $app) {
    $userController = new UserController();

    $app->group('/users', function (RouteCollectorProxy $users) use ($userController) {

        // Route to get all users
        $users->get('', function (Request $request, Response $response) use ($userController) {
            $result = $userController->getAllUsers();
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to get a user by ID
        $users->get('/{id:[0-9]+}', function (Request $request, Response $response, array $args) use ($userController) {
            $id = $args['id'];
            $result = $userController->getUserById($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Get all user Events
        $users->get('/{id:[0-9]+}/events', function (Request $request, Response $response, array $args) use ($userController) {
            $id = $args['id'];
            $result = $userController->getEventsByUserId($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route for login
        $users->post('/login', function (Request $request, Response $response) use ($userController) {
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $userController->login($data['email'], $data['password']);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to create a new user
        $users->post('', function (Request $request, Response $response) use ($userController) {
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $userController->createUser($data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to update a user by ID
        $users->patch('/{id}', function (Request $request, Response $response, array $args) use ($userController) {
            $id = $args['id'];
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $userController->updateUser($id, $data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to delete a user by ID
        $users->delete('/{id}', function (Request $request, Response $response, array $args) use ($userController) {
            $id = $args['id'];
            $result = $userController->deleteUser($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });
};
