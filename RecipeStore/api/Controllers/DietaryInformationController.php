<?php

namespace RecipeStore\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RecipeStore\Controllers\ControllerHelper as Helper;
use RecipeStore\Models\DietaryInformation;

Class DietaryInformationController{
    //Retrieve all the classes
    public function index(Request $request, Response $response, array $args) : Response {
        $results = DietaryInformation::getDietaryInformations();
        return Helper::withJson($response, $results, 200);
    }

    //View a specific class by section number
    public function view(Request $request, Response $response, array $args) : Response {
        $results = DietaryInformation::getDietaryInformationByID($args['dietary_recipe_id']);
        return Helper::withJson($response, $results, 200);
    }
}
