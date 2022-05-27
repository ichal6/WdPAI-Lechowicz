<?php

require_once 'AppController.php';

class DefaultController extends AppController{
    public function index(){
        header("location: dashboard");
    }

    public function dashboard(){
        $this->render('portal/lists');
    }
}
