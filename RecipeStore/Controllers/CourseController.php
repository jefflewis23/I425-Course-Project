<?php
/**
 * Author: Derek Wright
 * Date: 5/24/2023
 * File: CourseController.php
 * Description: This defines the CourseController Class
 */
namespace MyCollegeAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MyCollegeAPI\Models\Course;
use MyCollegeAPI\Controllers\ControllerHelper as Helper;

class CourseController {
    //Retrieve all courses
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Course::getCourses($request);
        return Helper::withJson($response, $results, 200);
    }

    //view a course
    public function view(Request $request, Response $response, array $args) : Response {
        $number = $args['number'];
        $results = Course::getCourseByNumber($number);
        return Helper::withJson($response, $results, 200);
    }

    //view classes of a course
    public function viewClasses(Request $request, Response $response, array $args) : Response {
        $results = Course::getClassesByCourse($args['number']);
        return Helper::withJson($response, $results, 200);
    }
}