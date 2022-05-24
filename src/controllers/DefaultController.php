<?php

require_once 'AppController.php';

class DefaultController extends AppController{
    public function index(){
        $this->render('enter-page/login'); 
    }

    public function dashboard(){
        $this->render('portal/lists');
    }
}
