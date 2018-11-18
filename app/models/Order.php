<?php

namespace app\models;

use vendor\core\base\Model;

class Order extends Model{
    public $table = 'test_order';
    
    public function saveOrder($data, $mass){
        $id = $_SESSION['logged'];
        $out = '';
        $last = $this->lastOrder($id);
        if(empty($last)){
            $total = $this->getPrices($mass);
            $bonus = $this->getBonus($total['sell']);
            if($this->save($total,$bonus,$id,$data)){
                $out = 1;
            } else {
                $out = 2;
            }
        } else {
            $out = 0;
        }
        return $out;
    }
    protected function getPrices($mass){
        $result['buy'] = 0;
        $result['sell'] = 0;
        foreach($mass as $key => $count){
            $sql = "SELECT buy, sell, convert_t FROM product WHERE id = ? ";
            $total = $this->findBySql($sql, [$key]);
            $result['buy'] += ($total[0]['buy'] * $total[0]['convert_t']) * $count;
            $result['sell'] += ($total[0]['sell'] * $total[0]['convert_t']) * $count;
        }
        return $result;
    }
    protected function getBonus($total){
        $bonus = 0;
        if($total > 1000 AND $total < 3000 ){
            $bonus = 30;
        } elseif($total > 3000 AND $total < 5000 ){
            $bonus = 100;
        } elseif($total > 5000 AND $total < 10000 ){
            $bonus = 150;
        } elseif($total > 10000 ){
            $bonus = 300;
        } else {
            $bonus = 0;
        }
        return $bonus;
    }
    protected function save($total,$bonus,$id_user, $data){
        $sql = "INSERT INTO test_order(id_user,buy,sell,products,bonus,source) "
            ."VALUES (?, ?, ?, ?, ?, ?) ";
        if($this->query($sql, [$id_user, $total['buy'], $total['sell'], $data, $bonus, 1 ])){
            return true;
        } return false;
    }
    public function getAllBonuses($id){
        $sql = "SELECT SUM(bonus) AS bonus FROM test_order WHERE id_user = ? AND status = ? ";
        $result = $this->findBySql($sql, [$id, 1]);
        if($result[0]['bonus'] == null){
            return '0';
        } else {
            return $result[0]['bonus'];
        } 
    }
    public function lastOrder($id){
        $sql = "SELECT * FROM test_order WHERE id_user = ? AND status = ? ";
        $result = $this->findBySql($sql, [$id, 0]);
        return $result;
    }
    public function checkBonus($id){
        $sql = "SELECT COUNT(id) AS num FROM test_order WHERE id_user = ? AND bonus != ? AND status = ?  ";
        $result = $this->findBySql($sql,[$id, 0, 1]);
        $last_order = $this->lastOrder($id);
        if($result[0]['num'] >= 3 AND !empty($last_order)){
            return true;
        } else {
            return false;
        }
    }
    public function getOrder($id){
        $output = [];
        $result = $this->lastOrder($id);
        if(!empty($result)){
            $output = $this->getProducts($result);
        }
        return $output;
    }
    public function updateOrder($id, $data, $mass){
        $out = 0;
        $total = $this->getPrices($mass);
        $bonus = $this->getBonus($total['sell']);
        if($this->update($id,$data,$bonus,$total) == true){
            $out = 1;
            unset($_SESSION['update']);
        }
        return $out;
    }
    public function update($id, $data, $bonus, $total){
        $sql = "UPDATE test_order SET products = ?, bonus = ?, buy = ?, sell = ? WHERE id = ? ";
        $result = $this->query($sql, [$data, $bonus, $total['buy'], $total['sell'], $id]);
        return $result;
    }
    public function getProducts($result){
        $model = new Product;
        $products = json_decode($result[0]['products'], true);
        $keys = array_keys($products);
        $ids = implode(',',$keys);
        $final = $model->getOrderedProducts($ids);
        $i = 0;
        foreach($final as $id => $value ){
            $final[$i]['count'] = $products[$value['id']];
            $i++;
        }
        $result[0]['products'] = $final;
        return $result;
    }
    public function getOrders($id){
        $sql = "SELECT * FROM test_order WHERE id_user = ? AND status = ? ORDER BY date_on DESC LIMIT 10 ";
        $result = $this->findBySql($sql, [$id,1]);
        $orders = [];
        foreach($result as $id => $value){
            $out = $this->eachOrder($value['id']);
            $orders[$value['id']] = $this->getProducts($out);
        }
        return $orders;
    } 
    public function eachOrder($id){
        $sql = "SELECT * FROM test_order WHERE id = ? ";
        $result = $this->findBySql($sql, [$id]);
        return $result;
    }
    public function getBonusIds($id){
        $sql = "SELECT id FROM test_order WHERE id_user = ? AND bonus > ? AND status = ? ";
        $result = $this->findBySql($sql,[$id, 0, 1]);
        $final = [];
        foreach($result as $id => $key){
            $final[$id]= $key['id'];
        }
        return $final;
    }
    public function updateBonus($id){
        $lastOrder = $this->lastOrder($id);
        $idBonus = $this->getBonusIds($id);
        $idString = implode(',',$idBonus);
        $summ = $this->getAllBonuses($id);
        if($this->appointBonus($idString)){
            if($this->changeBonus($summ, $lastOrder[0]['id'])){
                return 1;
            }
        } return 0;
    }
    public function appointBonus($string){
        $sql = "UPDATE test_order SET bonus = ? WHERE id IN($string) ";
        $result = $this->query($sql,[0]);
        return $result;
    } 
    public function changeBonus($summ, $id){
        $sql = "UPDATE test_order SET get_bonus = ? WHERE id = ? ";
        $result = $this->query($sql,[$summ, $id]);
        return $result;
    } 
}