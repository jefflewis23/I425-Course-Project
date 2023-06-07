<?php
/**
 * Author: Derek Wright
 * Date: 5/29/2023
 * File: ClassController.php
 * Description: Define the ClassController class.  This class defines methods to interact with the MyClass model class.
 */
namespace MyCollegeAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MyCollegeAPI\Models\MyClass;
use MyCollegeAPI\Controllers\ControllerHelper as Helper;

class ClassController {
    //Retrieve all the classes
    public function index(Request $request, Response $response, array $args) : Response {
        $results = MyClass::getClasses();
        return Helper::withJson($response, $results, 200);
    }

    //View a specific class by section number
    public function view(Request $request, Response $response, array $args) : Response {
        $results = MyClass::getClassBySection($args['section']);
        return Helper::withJson($response, $results, 200);
    }

    //View students enrolled in a class section
    public function viewStudents(Request $request, Response $response, array $args) : Response {
        $results = MyClass::getStudentBySection($args['section']);
        return Helper::withJson($response, $results, 200);
    }
}