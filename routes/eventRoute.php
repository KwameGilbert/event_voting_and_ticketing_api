<?php
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../controllers/EventController.php';

return function (App $app) {
    $eventController = new EventController();

    $app->group('/events', function (RouteCollectorProxy $events) use ($eventController) {
        
        $events->get('', function (Request $request, Response $response) use ($eventController) {
            $result = $eventController->getAllEvents();
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to get a event by ID
        $events->get('/{id:[0-9]+}', function (Request $request, Response $response, $args) use ($eventController) {
            $id = $args['id'];
            $result = $eventController->getEventById($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to create a new event
        $events->post('', function (Request $request, Response $response) use ($eventController) {
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $eventController->createEvent($data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        // Route to update a event by ID
        $events->patch('/{id:[0-9]+}', function (Request $request, Response $response, $args) use ($eventController) {
            $id = $args['id'];
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $eventController->updateEvent($id, $data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $events->delete('/{id:[0-9]+}', function (Request $request, Response $response, $args) use ($eventController) {
            $id = $args['id'];
            $result = $eventController->deleteEvent($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });
};
