<?php

namespace app\controllers;

use vendor\core\base\Controller;

use app\models\User;

use app\models\Category;

class AppController extends Controller{
    public $menu = [];
    public $id = '';
    public $user = [];
    
    public function __construct($routes){
        parent::__construct($routes);
        $model = new User;
        $model->userLogged();
        $category = new Category;
        $this->menu = $category->findMenu();
    }
    public function isAjax(){
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            return true;
        } return false;    
    }
}