<?php
//Jon Ross Richardson
//Routing file to route to the correct places

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
            });
            $group->group('/ingredient', function (RouteCollectorProxy $group) {
                $group->get('', 'Ingredient:index');
                $group->get('/{id}', 'Ingredient:view');
            });
            $group->group('/category', function (RouteCollectorProxy $group) {
                $group->get('', 'Category:index');
                $group->get('/{id}', 'Category:view');
            });
            $group->group('/dietaryInformation', function (RouteCollectorProxy $group) {
                $group->get('', 'DietaryInformation:index');
                $group->get('/{id}', 'DietaryInformation:view');
            });
            $group->group('/recipeDietary', function (RouteCollectorProxy $group) {
                $group->get('', 'RecipeDietary:index');
                $group->get('/{id}', 'RecipeDietary:view');
            });
            $group->group('/recipeCategory', function (RouteCollectorProxy $group) {
                $group->get('', 'RecipeCategory:index');
                $group->get('/{id}', 'RecipeCategory:view');
            });
            $group->group('/recipeIngredient', function (RouteCollectorProxy $group) {
                $group->get('', 'RecipeIngredient:index');
                $group->get('/{id}', 'RecipeIngredient:view');
            });
            $group->group('/recipeCuisine', function (RouteCollectorProxy $group) {
                $group->get('', 'RecipeCuisine:index');
                $group->get('/{id}', 'RecipeCuisine:view');
            });

        });

// Handle invalid routes
        $app->any('{route:.*}', function(Request $request, Response $response) {
            $response->getBody()->write("Page Not Found");
            return $response->withStatus(404);
        });
    };

};