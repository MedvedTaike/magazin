<?php

namespace app\models;

use vendor\core\base\Model;

class Product extends Model{
    public $table = 'product';
    
    public function getProducts($id){
        $sql = "SELECT * FROM product WHERE id_cat = ? AND status = ? ORDER BY sort ";
        $products = $this->findBySql($sql, [$id, 1]);
        return $products;
    }
    public function getSearchProducts($data){
        $out = '<div class="alert alert-warning" role="alert">Ничего не найдено!</div>';
        $result = $this->findLike($data, 'name');
        if(!empty($result)){
            $out = $this->formingProducts($result);
        }
        return $out;
    }
    protected function formingProducts($products){
        $out = '';
        foreach($products as $product){
            $out .= '<a href="/product/search/'.$product['id'].'" class="dropdown-item">'.$product['name'].'</a>';
        }
        return $out;
    }
    public function getOrderedProducts($ids){
        $sql = "SELECT * FROM product WHERE id IN($ids) AND status = '1' ORDER BY name";
        $out = $this->findBySql($sql);
        return $out;
    }
}