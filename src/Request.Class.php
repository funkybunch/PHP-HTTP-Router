<?php
/**
 * User: Mark Adkins
 * Date: 2/10/2019
 * Time: 12:39 AM
 */

namespace FunkyBunch\SimpleHTTPRouter;

class Request
{
    private $allowedMethods = Array("GET", "POST");
    private $method;
    private $request;
    private $path;

    public function __construct(){
        $this->path     = $_SERVER['REQUEST_URI'];
        $this->request  = $_REQUEST;
        $this->method   = $_SERVER['REQUEST_METHOD'];
    }

    public function getRequest() {
        return $this->request;
    }

    public function getAllowedMethods() {
        return $this->allowedMethods;
    }
    public function getPath() {
        return $this->path;
    }

    public function isValidMethod(){
        if(in_array($this->method, $this->getAllowedMethods())) {
            return true;
        }
        return false;
    }
}