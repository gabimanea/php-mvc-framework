<?php namespace System;

class RouteCollection
{
    protected $routes = [];
    
    public function createRoute($method, $pattern, $call, $name = null)
    {
       $this->routes[] = [
           'method'   => $method,
           'pattern' => $pattern,
           'call' => $call,
           'name'     => $name,
       ]; 
    }
    
    public function getRoutes()
    {
        return $this->routes;
    }
}
