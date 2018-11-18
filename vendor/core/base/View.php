<?php

namespace vendor\core\base;

class View{
    public $route = [];
    public $layout = '';
    
    function __construct($route, $view, $layout){
        $this->route = $route;
        $this->view = $view;
        if($layout === false){
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        
    }
    function render($vars){
        extract($vars);
        $file_view = APP."/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if(is_file($file_view)){
            require($file_view);
        } else {
            echo "File ne naiden";
        }
        $content = ob_get_clean();
        
        if($this->layout !== false){
            $file_layout = APP."/views/layouts/{$this->layout}.php";
            if(is_file($file_layout)){
                require($file_layout);
            } else {
                echo "Layout ne naiden! ";
            }
        }
    }
}