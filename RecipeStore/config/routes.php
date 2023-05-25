<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;


return function (App $app) {
    return function (App $app) {
// Add an app route
        $app->group('/api/v1', function(RouteCollectorProxy $group) {

            $group->group('/recipe', function (RouteCollectorProxy $group) {
                $group->get('', 'Recipe:index');
                $group->get('/{id}', 'Recipe:view');
                $group->get('/{id}/classes', 'Student:viewStudentClasses');
            });
        });

// Handle invalid routes
        $app->any('{route:.*}', function(Request $request, Response $response) {
            $response->getBody()->write("Page Not Found");
            return $response->withStatus(404);
        });
    };

};