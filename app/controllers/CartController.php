<?php

namespace app\controllers;

class CartController extends AppController{
    public $layout = 'cart';
    
    public function actionIndex(){
        $menuItem = $this->menu;
        $this->set(compact('menuItem'));
    }
}