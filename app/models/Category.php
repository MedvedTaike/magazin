<?php

namespace app\models;

use vendor\core\base\Model;

class Category extends Model{
    public function findMenu(){
        $sql = "SELECT * FROM category WHERE status = ? ";
        $menu = $this->findBySql($sql , [1]);
        return $menu;
    }
    public function getName($id){
        $sql = "SELECT name FROM category WHERE id = ?  ";
        $name = $this->findBySql($sql, [$id]);
        return $name[0]['name'];
    }
}