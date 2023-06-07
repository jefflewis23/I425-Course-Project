<?php
/**
 * Author: Derek Wright
 * Date: 6/7/2023
 * File: BasicAuthenticator.php
 * Description: Basic authenticator defining
 */
namespace RecipeStore\Authentication;

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use RecipeStore\Models\User;

class BasicAuthenticator {
    public function __invoke(Request $request, RequestHandler $handler) : Response {
        // If the header named "Authorization" does not exist, display an error
        if (!$request->hasHeader('Authorization')) {
            $results = ['Status' => 'Authorization header not found.'];
            return AuthenticationHelper::withJson($results, 401);
        }

        // If the Authorization header exists, retrieve its value. The value is an array with one single value.
        $auth = $request->getHeader('Authorization')[0];

        /* The value of the authorization header consists of "Basic" and a key, separated
         * by a space. The key is a base64 encoded string from "username:password".
         * An example: BasicKind user:password
         */
        // Remove 'Basic' from the string. Get everything after the space.
        list(, $apikey) = explode(" ", $auth, 2);

        // Get the username and password. The key needs to be decoded first.
        list($user, $password) = explode(':', base64_decode($apikey));

        // Authenticate the user
        if(!User::authenticateUser($user, $password)) {
            $results = array('status' => 'Authentication failed');
            $response = AuthenticationHelper::withJson($results, 403);
            return $response->withHeader('WWW-Authenticate',  'Basic realm="RecipeStore API"');
        }

        // Authentication succeeded
        return $handler->handle($request);
    }
}