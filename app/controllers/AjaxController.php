<?php

namespace app\controllers;

use app\models\Order;
use app\models\Product;

class AjaxController extends AppController{
    public function actionCreateOrder(){
        if($this->isAjax()){
            $model = new Order;
            $data = json_encode($_POST['order']);
            $mass = $_POST['order'];
            $out = $model->saveOrder($data, $mass);
            echo $out;
        } die;
    }
    public function actionSetUpdate(){
        if($this->isAjax()){
            $data = $_POST['id'];
            $_SESSION['update'] = $data;
            echo $data;
        } die;
    }
    public function actionFindProduct(){
        if($this->isAjax()){
            $model = new Product;
            $data = $_POST['value'];
            $result = $model->getSearchProducts($data);
            echo $result;
        }die;
    }
    public function actionFindOrder(){
        if($this->isAjax()){
            $model = new Order;
            $data = $_POST['id'];
            $result = $model->getOrder($data);
            $result = json_encode($result);
            echo $result;
        } die;
    }
    public function actionUpdateOrder(){
        if($this->isAjax()){
            $data = json_encode($_POST['order']);
            $model = new Order;
            $mass = $_POST['order'];
            $id = $_SESSION['update'];
            $out = $model->updateOrder($id, $data, $mass);
            echo $out;
        } die;
    }
    public function actionGetBonus(){
        if($this->isAjax()){
            $id = $_SESSION['logged'];
            $order = new Order;
            $out = $order->updateBonus($id);
            echo $out;
        }die;
    }
}