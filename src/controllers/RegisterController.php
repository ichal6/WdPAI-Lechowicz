<?php

require_once 'AppController.php';

class RegisterController extends AppController{
    public function register(){
        $this->render('enter-page/register');
    }
}
