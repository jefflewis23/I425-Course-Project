<?php

namespace RecipeStore\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RecipeStore\Controllers\ControllerHelper as Helper;
use RecipeStore\Models\Recipe;

Class RecipeController{
    //Retrieve all the classes
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Recipe::getRecipes();
        return Helper::withJson($response, $results, 200);
    }

    //View a specific recipe by ID
    public function view(Request $request, Response $response, array $args) : Response {
        $results = Recipe::getRecipeByID($args['recipe_id']);
        return Helper::withJson($response, $results, 200);
    }

    //Create a recipe
    public function create(Request $request, Response $response, array $args) : Response {
        //Validating the request
        $validation = Validator::validateStudent($request);

        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        //create a new recipe
        $recipe = Recipe::createRecipe($request);

        if (!$recipe) {
            $results['status']= "Recipe cannot be created.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Recipe has been created.",
            'data' => $recipe
        ];

        return Helper::withJson($response, $results, 200);
    }




}
