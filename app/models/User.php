<?php

namespace app\models;

use vendor\core\base\Model;

class User extends Model{
    
    public $table = 'user';

    function addVisit(){
        if(isset($_SESSION['logged'])){
            $sess_id = session_id();
            $status = 1;
            $hash = $this->generateCode();
            $_SESSION['hash'] = $hash;
            $user_id = $_SESSION['logged'];
            $sql = "INSERT INTO visits(id_user, hash, sess_id, status) VALUES(? , ?, ?, ?) ";
            $this->query($sql, [$user_id, $hash, $sess_id, $status]);
            $this->clearVisit($user_id);
        }
    } 
    function checkUser(){
        if(isset($_SESSION['logged'])){
            $sess_id = session_id();
            $hash = $_SESSION['hash'];
            $id = $_SESSION['logged'];
            $sql = "SELECT hash FROM visits WHERE id_user = ? AND status = ? AND hash = ? AND sess_id = ? ";
            $code = $this->findBySql($sql, [$id, 1, $hash, $sess_id]);
            if($code){
                return true;
            } return false;
        }
    }
    protected function generateCode($length=30) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;  
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];  
        }
        return $code;
    }
    public function userLogged(){
        if(!$this->checkUser()){
            header("Location:/");
        } 
    }
    public function deleteVisit(){
        if(isset($_SESSION['logged'])){
            $sess_id = session_id();
            $id_user = $_SESSION['logged'];
            $sql = "UPDATE visits SET status = ? WHERE hash = ? AND sess_id = ? ";
            $this->query($sql, [ 0, $_SESSION['hash'], $sess_id]);
        }
    }
    public function clearVisit($id){
        $sql = "SELECT id FROM visits WHERE id_user = ? AND status = ? ";
        $result = $this->findBySql($sql, [$id, 1 ]);
        if(count($result) > 1){
            $id_update = array_shift($result);
            $sql = "UPDATE visits SET status = ? WHERE id = ? ";
            $this->query($sql, [ 0, $id_update['id']]);
        } 
    }
    public function findUser(){
        $id = $_SESSION['logged'];
        $user = $this->findOne($id);
        return $user;
    }
}
