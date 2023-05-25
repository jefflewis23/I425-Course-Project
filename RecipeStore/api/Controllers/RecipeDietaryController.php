<?php

namespace RecipeStore\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RecipeStore\Controllers\ControllerHelper as Helper;
use RecipeStore\Models\RecipeDietary;

Class RecipeDietaryController{
    //Retrieve all the classes
    public function index(Request $request, Response $response, array $args) : Response {
        $results = RecipeDietary::getRecipeDietaries();
        return Helper::withJson($response, $results, 200);
    }

    //View a specific class by section number
    public function view(Request $request, Response $response, array $args) : Response {
        $results = RecipeDietary::getRecipeDietaryByID($args['recipe_dietary_id']);
        return Helper::withJson($response, $results, 200);
    }
}
