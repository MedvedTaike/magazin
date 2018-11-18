<?php

namespace vendor\core\base;

abstract class Controller{
    public $routes;
    public $layout = '';
    public $view ;
    public $vars = [];
    
    function __construct($routes){
        $this->routes = $routes;
        $this->view = $routes['action'];
    }
    
    function getView(){
        $obj = new View($this->routes, $this->view,$this->layout);
        $obj->render($this->vars);
    }
    function set($vars){
        $this->vars = $vars;
    }
}