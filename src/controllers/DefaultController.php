<?php

require_once 'AppController.php';

class DefaultController extends AppController{
    public function index(){
        $this->render('portal/lists', ['messages' => [$_SESSION['user_name']]]);
    }

    public function dashboard(){
        $this->render('portal/lists', ['messages' => [$_SESSION['user_name']]]);
    }
}
