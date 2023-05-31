<?php
/**
 *Author: Allyson West
 *Date: 5/31/23
 *File: Validator.php
 *Description: creating Validator class
 */

namespace RecipeStore\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

//creating the Validator class

class Validator
{
    private static array $errors = [];

    //return errors in array
    public static function getErrors(): array
    {
        return self::$errors;
    }

    // A generic validation method. it returns true on success or false on failed validation.
    public static function validate($request, array $rules): bool
    {
        foreach ($rules as $field => $rule) {
            //Retrieve parameters from URL or the request body
            $param = $request->getAttribute($field) ?? $request->getParsedBody()[$field];
            try {
                $rule->setName($field)->assert($param);
            } catch (NestedValidationException $ex) {
                self::$errors[$field] = $ex->getFullMessage();
            }
        }
        // Return true or false; "false" means a failed validation.
        return empty(self::$errors);
    }

    //Validate Recipe data.
    public static function validateRecipe($request) : bool {
        //Define all the validation rules
        $rules = [
            'id' => v::notEmpty()->alnum()->startsWith('s')->length(5, 5),
            'name' => v::alnum(' '),
            'email' => v::email(),
            'major' => v::alpha(' '),
            'gpa' => v::numericVal()
        ];

        return self::validate($request, $rules);
    }

    //Validate Ingredient data.
    public static function validateIngredient($request) : bool {
        //Define all the validation rules
        $rules = [
            'id' => v::notEmpty()->alnum()->startsWith('s')->length(5, 5),
            'name' => v::alnum(' '),
            'email' => v::email(),
            'major' => v::alpha(' '),
            'gpa' => v::numericVal()
        ];

        return self::validate($request, $rules);
    }
}