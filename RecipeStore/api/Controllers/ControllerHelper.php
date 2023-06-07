<?php
/**
 * Author: Derek Wright
 * Date: 5/24/2023
 * File: ControllerHelper.php
 * Description: Define the ControllerHelper Class. This class defines one single method called withJson.
 *  The withJson methods sends a response of data in JSON format along with a status code.
 */
namespace MyCollegeAPI\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

class ControllerHelper {
    // This method sends a response of data in JSON format along with a status code
    public static function withJson(Response $response, $data, int $code) : Response {
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}