<?php

namespace RecipeStore\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RecipeStore\Controllers\ControllerHelper as Helper;
use RecipeStore\Models\Ingredient;
use RecipeStore\Validation\Validator;

Class IngredientController {
    //Retrieve all the ingredients
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Ingredient::getIngredients($request);
        return Helper::withJson($response, $results, 200);
    }

    //View a specific class by section number
    public function view(Request $request, Response $response, array $args) : Response {
        $results = Ingredient::getIngredientByID($args['ingredient_id']);
        return Helper::withJson($response, $results, 200);
    }

    //Create an Ingredient
    public function create(Request $request, Response $response, array $args) : Response {
        //Validating the request
        $validation = Validator::validateIngredient($request);

        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        //create a new ingredient
        $ingredient = Ingredient::createIngredient($request);

        if (!$ingredient) {
            $results['status']= "Ingredient cannot be created.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Ingredient has been created.",
            'data' => $ingredient
        ];

        return Helper::withJson($response, $results, 200);
    }


}
