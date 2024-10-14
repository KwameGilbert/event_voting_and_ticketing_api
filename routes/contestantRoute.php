<?php
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../controllers/ContestantController.php';

return function (App $app){
    $contestantController = new ContestantController();

    $app->group('/contestants', function (RouteCollectorProxy $contestants) use ($contestantController) {

        $contestants->get('/event/{:id[0-9]+}', function (Request $request, Response $response, $args) use ($contestantController) {
            $eventId = $args['id'];
            $result = $contestantController->getAllContestantsByEvent($eventId);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $contestants->get('/{id:[0-9]+}', function (Request $request, Response $response, $args) use ($contestantController) {
            $id = $args['id'];
            $result = $contestantController->getSingleContestant($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $contestants->post('', function (Request $request, Response $response) use ($contestantController) {
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $contestantController->createContestant($data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $contestants->patch('/{id:[0-9]+}', function (Request $request, Response $response, $args) use ($contestantController) {
            $id = $args['id'];
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $contestantController->updateContestant($id, $data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        $contestants->delete('/{id:[0-9]+}', function (Request $request, Response $response, $args) use ($contestantController) {
            $id = $args['id'];
            $result = $contestantController->deleteContestant($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });
    });
};