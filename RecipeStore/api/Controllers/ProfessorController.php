<?php
/**
 * Author: Derek Wright
 * Date: 5/24/2023
 * File: ProfessorController.php
 * Description: Define the ProfessorController class
 */

namespace MyCollegeAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use MyCollegeAPI\Models\Professor;
use MyCollegeAPI\Controllers\ControllerHelper as Helper;

class ProfessorController {
    //list all professors
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Professor::getProfessors();

        //Modify the image field to prepend the base url
        foreach ($results as $result) {
            $result["image"] = $this->getImageBaseUrl($request) . $result["image"];
        }

        return Helper::withJson($response, $results, code: 200);
    }

    //View a specific professor
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['id'];
        $results = Professor::getProfessorById($id);
        //modify the image field to prepend the base url
        $results['image'] = $this->getImageBaseUrl($request) . $results["image"];

        return Helper::withJson($response, $results, 200);
    }

    //View all classes taught by a professor
    public function viewClasses(Request $request, Response $response, array $args) : Response {
        $id = $args['id'];
        $results = Professor::getClassesByProfessor($id);
        return Helper::withJson($response, $results, 200);
    }

    // Get the path to image url. Images are stored inside public/images folder.
    private function getImageBaseUrl(Request $request): String {
        $uri = $request->getUri();
        $port = $uri->getPort() ? ":" . $uri->getPort() : "";
        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        return $uri->getScheme() . "://" . $uri->getHost() . $port  . $routeContext->getBasePath() . "/public/images/";
    }
}