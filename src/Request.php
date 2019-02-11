<?php
/**
 * User: Mark Adkins
 * Date: 2/10/2019
 * Time: 12:39 AM
 */

namespace FunkyBunch\SimpleHTTPRouter;

use phpDocumentor\Reflection\Types\Object_;

class Request
{
    private $allowedMethods = Array("GET", "POST"); // HTTP request methods permitted by the application.
    private $method;                                // HTTP method of this request.
    private $request;                               // Request Object from client.
    private $path;                                  // Path that the request originated from.

    /**
     * Request() constructor
     *
     * Sets the Request() $path, $method, and $request Object.
     */
    public function __construct(){
        $this->path     = $_SERVER['REQUEST_URI'];
        $this->request  = $_REQUEST;
        $this->method   = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * getRequest()
     *
     * Returns the HTTP request Object.
     *
     * @return Object_
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * getAllowedMethods()
     *
     * Returns the methods allowed by the application.
     *
     * @return array
     */
    public function getAllowedMethods() {
        return $this->allowedMethods;
    }

    /**
     * getPath()
     *
     * Returns the full path of the HTTP request.
     *
     * @return String
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * getMethod()
     *
     * Returns the method type of the HTTP request.
     *
     * @return String
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * isValidMethod()
     *
     * Determines if the method used by the HTTP request is permitted by
     * the application. Yes[true]|No[false]
     *
     * @return bool
     */
    public function isValidMethod(){
        if(in_array($this->method, $this->getAllowedMethods())) {
            return true;
        }
        return false;
    }
}