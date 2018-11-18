<?php

namespace vendor\core;

class Router{

    protected static $routes = [];
    protected static $route = [];
    
    static function add($regExp, $route = []){
        self::$routes[$regExp] = $route;
    }
    protected static function match($url){
        foreach(self::$routes as $pattern => $route){
            if(preg_match("~$pattern~i", $url, $matches)){
                foreach($matches as $key => $value){
                    if(is_string($key)){
                        $route[$key] = $value;
                    }
                }
                if(!isset($route['action'])){
                    $route['action'] = 'index';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
    static function dispatch($url){
        $url = self::removeQueryString($url);
        if(self::match($url)){
            $controller = 'app\controllers\\'.self::$route['controller'].'Controller';
            if(class_exists($controller)){
                $obj = new $controller(self::$route);
                $action = 'action'.self::lowerCamelCase(self::$route['action']);
                if(method_exists($obj , $action)){
                    $obj->$action();
                    $obj->getView();
                } else {
                    header("Location: /");
                }
            } else {
                header("Location: /");
            }
        } else {
            header("Location: /");
        }  
    }
    protected static function upperCamelCase($name){
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }    
    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));
    }
    protected static function removeQueryString($url){
        if($url){
            $params = explode('&', $url);
            if(false === strpos($params[0], '=')){
                return $params[0];
            } else {
                return '';
            }
        }
    }
}