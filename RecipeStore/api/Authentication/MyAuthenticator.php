<?php
/**
 * Author: Derek Wright
 * Date: 6/6/2023
 * File: MyAuthenticator.php
 * Description:
 */
namespace RecipeStore\Authentication;

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use RecipeStore\Models\User;

class MyAuthenticator {
    /*
    * Use the __invoke method so the object can be used as a callable.
    * This method gets called automatically when the object is treated as a callable.
    */
    public function __invoke(Request $request, RequestHandler $handler) : Response {
        //Username and password are stored in a header called "RecipeStore-Authorization".
        if(!$request->hasHeader('RecipeStore-Authorization')) {
            $results = ['Status' => 'RecipeStore-Authorization header not found.'];
            return AuthenticationHelper::withJson($results, 401);
        }

        //If the header exists, retrieve its value.
        $auth = $request->getHeader('RecipeStore-Authorization');

        // The header value is an array with one single element. Retrieve the value.
        $apikey = $auth[0];

        //The header value is formatted as username:password.
        //Separate username and password and store them in variables.
        list($username, $password) = explode(':', $apikey);

        //Validate the username and password
        if(!User::authenticateUser($username, $password)) {
            $results = ['Status' => 'Authentication failed.'];
            return AuthenticationHelper::withJson($results, 403);
        }

        //A user has been authenticated
        return $handler->handle($request);
    }
}