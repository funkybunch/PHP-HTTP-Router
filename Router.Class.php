<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mark Adkins
 * Date: 2/10/2019
 * Time: 12:34 AM
 */

include_once "Request.Class.php";
include_once "HTTPErrors.Class.php";

class Router
{
    private $endpoints;
    private $request;
    private $responseCode = 200;

    public function __construct() {
        $this->request = new Request();
        $result = Array();
        foreach($this->request->getAllowedMethods() as $i) {
            $result[$i] = [];
        };
        $this->endpoints = $result;
    }

    private function setHTTPResponseCode($HTTPCode) {
        $this->responseCode = $HTTPCode;
    }

    private function validateRequest($routePath, $method) {
        if($routePath == $this->request->getPath() &&
        in_array($this->request->getPath(), $this->endpoints[$method])) {
            return true;
        }
        return false;
    }

    private function constructRoute($path, $method, $callback) {
        if($this->request->isValidMethod()) {
            array_push($this->endpoints[$method], $path);
            if($this->validateRequest($path, $method)) {
                return $callback();
            } else {
                $this->setHTTPResponseCode(405);
            }
        } else {
            $this->setHTTPResponseCode(500);
        }
        http_response_code($this->responseCode);
    }

    public function get($path, $callback) {
        $routeMethod = "GET";
        $this->constructRoute($path, $routeMethod, $callback);
    }

    public function post($path, $callback) {
        $routeMethod = "POST";
        $this->constructRoute($path, $routeMethod, $callback);
    }

    public function __destruct()
    {
        //echo json_encode($this->endpoints, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}