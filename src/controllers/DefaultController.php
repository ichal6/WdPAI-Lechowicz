<?php

require_once 'AppController.php';

class DefaultController extends AppController{
    public function index(){
//        $this->render('portal/lists', ['messages' => [
//            'user' => $_SESSION['user'],
//        ]]);
        header("Location: lists");
    }

    public function dashboard(){
//        $this->render('portal/lists', ['messages' => [
//            'user' => $_SESSION['user'],
//        ]]);
        header("Location: lists");
    }
}
