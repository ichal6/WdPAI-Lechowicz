<?php

require_once 'AppController.php';

class LoginController extends AppController{
    public function login(){
        $this->render('enter-page/login');
    }
}
