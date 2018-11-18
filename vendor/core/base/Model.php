<?php

namespace vendor\core\base;

use vendor\core\Db;

abstract class Model{
    protected $pdo;
    protected $table;
    protected $pk = 'id';
    
    function __construct(){
        $this->pdo = Db::instance();
    }
    function query($sql, $params = []){
        return $this->pdo->execute($sql, $params);
    }
    function getAll(){
        $sql = "SELECT * FROM {$this->table} ";
        return $this->pdo->query($sql);
    }
    function findAll($id , $field = ''){
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? AND status = ? ORDER BY sort ";
        return $this->pdo->query($sql, [$id , 1]);
    }
    function findOne($id, $field = ''){
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
        return $this->pdo->query($sql, [$id]);
    }
    function findBySql($sql, $params = []){
        return $this->pdo->query($sql, $params);
    }
    function findLike($str, $field, $table = ''){
        $table = $table ?: $this->table;
        $sql = "SELECT id,name FROM $table WHERE $field LIKE ? ";
        return $this->pdo->query($sql, ['%'.$str.'%']);
    }
}