<?php

namespace app\controllers;

use app\models\Product;
use app\models\Category;
class ProductController extends AppController{
    public $layout = 'product';
    
    public function actionView(){
        $id = $this->routes['index'];
        $product = new Product;
        $category = new Category;
        $catName = $category->getName($id);
        $products = $product->getProducts($id);
        $menuItem = $this->menu;
        $this->set(compact('products','menuItem', 'catName'));
    }
    public function actionSearch(){
        $id = $this->routes['index'];
        $model = new Product;
        $product = $model->findOne($id);
        $menuItem = $this->menu;
        $this->set(compact('product','menuItem'));
    }
}