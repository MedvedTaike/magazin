<?php

namespace app\controllers;

use app\models\User;
use vendor\core\base\Controller;

class SiteController extends Controller{
    public $layout = 'enter';
    
    public function actionIndex()
    { 
        $data = $_POST;
        $errors = [];
        $model = new User;
        if(isset($data['do_login'])){
            $user = $model->findOne($data['phone'], 'phone');
            if($user){
                if(password_verify($data['password'], $user[0]['password'])){
                    $_SESSION['logged'] = $user[0]['id'];
                    $_SESSION['name'] = $user[0]['name'];
                    $model->addVisit();
                    header("Location: product/1");
                } else {
                    $errors['pass'] = 'Неверно введен пароль !';
                }
            } else {
                $errors['phone'] = 'Пользователь не найден !';
            }
        }
        $this->set(compact('errors', 'data'));
    }
    public function actionLogout(){
        $model = new User;
        if(isset($_SESSION['logged'])){
            $model->deleteVisit();
            unset($_SESSION['logged']);
            unset($_SESSION['hash']);
            header("Location: /");
        }
    }
}
