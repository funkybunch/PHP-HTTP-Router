<?php
/**
 * User: Mark Adkins
 * Date: 2/10/2019
 * Time: 12:34 AM
 */

namespace FunkyBunch\SimpleHTTPRouter;

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
        in_array($this->request->getPath(), $this->endpoints[$method]) && $method == $this->request->getMethod()) {
            return true;
        }
        return false;
    }

    private function constructRoute($path, $method, $callback) {
        if($this->request->isValidMethod()) {
            array_push($this->endpoints[$method], $path);
            if($this->validateRequest($path, $method)) {
                $callback();
                return true;
            } else {
                $this->setHTTPResponseCode(405);
            }
        } else {
            $this->setHTTPResponseCode(500);
        }
        http_response_code($this->responseCode);
        return false;
    }

    public function get($path, $callback) {
        $routeMethod = "GET";
        return $this->constructRoute($path, $routeMethod, $callback);
    }

    public function post($path, $callback) {
        $routeMethod = "POST";
        return $this->constructRoute($path, $routeMethod, $callback);
    }

    public function __destruct()
    {
        //echo json_encode($this->endpoints, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }
}