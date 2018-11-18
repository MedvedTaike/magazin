<?php

namespace app\controllers;

use app\models\User;
use app\models\Order;

class CabinetController extends AppController{
    public $layout = 'cabinet';
    
    public function actionIndex(){
        $id = $_SESSION['logged'];
        $user = new User;
        $current = $user->findOne($id);
        $order = new Order;
        $bonus = $order->getAllBonuses($id);
        $menuItem = $this->menu;
        $bonusAvail = $order->checkBonus($id);
        $lastOrder = $order->getOrder($id);
        $this->set(compact('menuItem', 'current', 'bonus', 'bonusAvail', 'lastOrder'));
    }
    public function actionArchive(){
        $id = $_SESSION['logged'];
        $order = new Order;
        $orders = $order->getOrders($id);
        $menuItem = $this->menu;
        $this->set(compact('menuItem','orders'));
    }
}