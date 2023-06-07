<?php
/**
 * Author: Derek Wright
 * Date: 5/29/2023
 * File: Validator.php
 * Description: The Validator class defines methods that validate data of models.
 */

namespace MyCollegeAPI\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {
    private static array $errors = [];

    // A generic validation method. It returns true on success or false on failed validation.
    public static function validate($request, array $rules) : bool {
        foreach ($rules as $field => $rule) {
            //Retrieve parameters from URL or the request body
            $param = $request->getAttribute($field) ?? $request->getParsedBody()[$field];
            try{
                $rule->setName($field)->assert($param);
            } catch (NestedValidationException $ex) {
                self::$errors[$field] = $ex->getFullMessage();
            }
        }
        // Return true or false; "false" means a failed validation.
        return empty(self::$errors);
    }

    //Validate student data.
    public static function validateStudent($request) : bool {
        //Define all the validation rules. Be sure you upgrade PhpStorm to the latest version 2021.3 or above.
        $rules = [
            'id' => v::notEmpty()->alnum()->startsWith('s')->length(5, 5),
            'name' => v::alnum(' '),
            'email' => v::email(),
            'major' => v::alpha(' '),
            'gpa' => v::numericVal()
        ];

        return self::validate($request, $rules);
    }

    //Return the errors in an array
    public static function getErrors() : array {
        return self::$errors;
    }
}