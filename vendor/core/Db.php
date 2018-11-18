<?php

namespace vendor\core;

class Db{
    protected $pdo;
    protected static $instance;
    
    protected function __construct(){
        $db = require ROOT.'/config/db_config.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",
        ];
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['password'], $options);
    }
    
    public static function instance(){
        if(self::$instance === null ){
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function execute($sql,$params = []){
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    public function query($sql, $params = []){
        $stmt = $this->pdo->prepare($sql);
        $res =  $stmt->execute($params);
        if($res != null){
            return $stmt->fetchAll();
        }
        return [];
    }
}