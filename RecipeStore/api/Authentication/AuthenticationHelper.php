<?php
/**
 * Author: Derek Wright
 * Date: 6/6/2023
 * File: AuthenticationHelper.php
 * Description:
 */
namespace RecipeStore\Authentication;

use Slim\Psr7\Response;

class AuthenticationHelper {
    public static function withJson($data, int $code) : Response {
        $response = new Response();
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}