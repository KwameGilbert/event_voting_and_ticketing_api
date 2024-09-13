<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__ . '/../controllers/CategoryController.php';

return function (App $app){
    $categoryController = new CategoryController();

    $app->group('/categories', function (RouteCollectorProxy $categories) use ($categoryController){

        //Route to get all event Categories
        $categories->get('/{id:[0-9]+}', function (Request $request, Response $response, array $args) use ($categoryController){
            $id = $args['id'];
            $result = $categoryController->getCategoriesOfEvent($id);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Route to create a new category
        $categories->post('', function (Request $request, Response $response) use ($categoryController){
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $categoryController->createCategory($data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'application/json');
        });

        //Route to Update a collatory
        $categories->patch('/{id:[0-9]+}', function (Request $request, Response $response, array $args) use ($categoryController){
            $id = $args['id'];
            $data = json_decode($request->getBody()->getContents(), true);
            $result = $categoryController->updateCategory($id, $data);
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type','application/json');
        });

        $categories->delete('/{id:[0-9]+}', function (Request $request, Response $response))

    });
}

?>