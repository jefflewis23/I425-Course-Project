<?php

namespace RecipeStore\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RecipeStore\Controllers\ControllerHelper as Helper;
use RecipeStore\Models\Cuisine;

Class CuisineController{
    //Retrieve all the classes
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Cuisine::getCuisines();
        return Helper::withJson($response, $results, 200);
    }

    //View a specific class by section number
    public function view(Request $request, Response $response, array $args) : Response {
        $results = Cuisine::getCuisinesByID($args['cuisine_id']);
        return Helper::withJson($response, $results, 200);
    }
}
