<?php
use Slim\App;

require_once __DIR__ . '/../controllers/EventController.php';

return function (App $app) {
    $eventController = new EventController();

    $app->group('/events', function () use ($app,$eventController) {

        $app->get('', function () use ($eventController) {
            return $eventController->getAllEvents();
        });

        $app->get('/{id}', function ($args) use ($eventController) {
            return $eventController->getEventById($args['id']);
        });

        $app->post('', function () use ($eventController) {
            $data = json_decode(file_get_contents('php://input'), true);
            return $eventController->createEvent($data);
        });

        $app->patch('/{id}', function ($args) use ($eventController) {
            $data = json_decode(file_get_contents('php://input'), true);
            return $eventController->updateEvent($args['id'], $data);
        });

        $app->delete('/{id}', function ($args) use ($eventController) {
            return $eventController->deleteEvent($args['id']);
        });
    });
};
