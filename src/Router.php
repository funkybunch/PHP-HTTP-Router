<?php
/**
 * User: Mark Adkins
 * Date: 2/10/2019
 * Time: 12:34 AM
 */

namespace FunkyBunch\SimpleHTTPRouter;

use phpDocumentor\Reflection\Types\Object_;

class Router
{
    private $endpoints;             // Array of allowed endpoints (constructed using get() and post() methods).
    private $request;               // The Request() object where HTTP request data is stored.
    private $responseCode = 404;    // The response code for the request.  Default set to 404 Not Found.
    private $validRoute = false;    // Prevents $responseCode from being overwritten if a valid route is found.


    /**
     * Router() constructor
     *
     * This creates a new Request() Object and initializes an array of arrays
     * in the $endpoints variable.  An array is created for each allowable HTTP
     * request type as defined in the Request Class.
     */
    public function __construct() {
        $this->request = new Request();
        $result = Array();
        foreach($this->request->getAllowedMethods() as $i) {
            $result[$i] = [];
        };
        $this->endpoints = $result;
    }

    /**
     * setHTTPResponseCode()
     *
     * Updates the HTTP code for the response.  This is set at the Object level
     * and is defaulted to 404 (NOT FOUND).
     *
     * @param int $HTTPCode
     */
    private function setHTTPResponseCode($HTTPCode) {
        $this->responseCode = $HTTPCode;
    }

    /**
     * validateRequest()
     *
     * Takes the $routePath and the $method and runs 3 checks on the
     * combination of path and method.
     *  1. Is the $routePath equal to the HTTP Request path?
     *  2. Is the $routePath in the allowed endpoints for the HTTP method used?
     *  3. Is the $method of the route equal to the method of the request?
     *
     * All 3 of these must be true in order for the request to be valid.
     *
     * Is the request valid? Yes[true]|No[false]
     *
     * @param String $routePath
     * @param String $method
     * @return bool
     */
    private function validateRequest($routePath, $method) {
        if($routePath == $this->request->getPath() &&
            in_array($this->request->getPath(), $this->endpoints[$method]) &&
            $method == $this->request->getMethod()) {

                return true;
        }
        return false;
    }

    /**
     * constructRoute()
     *
     * Calls Request()->isValidMethod() to check if the route method matches
     * the request method.  If so, it adds the $path to the Array() of
     * valid paths for that method.  Then it checks to see if the request
     * is valid by calling validateRequest() and executes the callback()
     * function if the defined route matches the request.  If the route and
     * request do not match, it sets the appropriate response code in the
     * event that no match is found.
     *
     * Was the route successfully constructed and $callback executed?
     * Yes[true]|No[false]
     *
     * @param String $path
     * @param String $method
     * @param String $callback Reference
     *
     * @return bool
     */
    private function constructRoute($path, $method, $callback) {
        if($this->request->isValidMethod()) {
            array_push($this->endpoints[$method], $path);
            if($this->validateRequest($path, $method)) {
                $callback();
                $this->setHTTPResponseCode(200); // SUCCESS
                $this->validRoute = true;
                return true;
            } else {
                // Don't overwrite response code if valid route match already found and executed.
                if(!$this->validRoute) {
                    $this->setHTTPResponseCode(405); // Method not allowed
                }
            }
        } else {
            // Don't overwrite response code if valid route match already found and executed.
            if(!$this->validRoute) {
                $this->setHTTPResponseCode(500); // Server Configuration Error
            }
        }
        return false;
    }

    /**
     * get()
     *
     * Defines a valid route and callback for a given $path for GET requests.
     * Was the route successfully constructed and $callback executed?
     * Yes[true]|No[false]
     *
     * @param String $path
     * @param String $callback
     *
     * @return bool
     */
    public function get($path, $callback) {
        $routeMethod = "GET";
        return $this->constructRoute($path, $routeMethod, $callback);
    }

    /**
     * post()
     *
     * Defines a valid route and callback for a given $path for POST requests.
     * Was the route successfully constructed and $callback executed?
     * Yes[true]|No[false]
     *
     * @param String $path
     * @param String $callback
     *
     * @return bool
     */
    public function post($path, $callback) {
        $routeMethod = "POST";
        return $this->constructRoute($path, $routeMethod, $callback);
    }

    /**
     * getRequest()
     *
     * Returns the HTTP request Object received from client.
     *
     * @return Object_ - HTTP REQUEST Object
     */
    public function getRequest() {
        return $this->request->getRequest();
    }

    /**
     * Router() destructor
     *
     * This sends the saved HTTP response code to the browser once all routes have been evaluated.
     */
    public function __destruct()
    {
        http_response_code($this->responseCode);
    }
}