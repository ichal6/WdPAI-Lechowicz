<?php

require 'AppController.php';

class DefaultController extends AppController{
    public function index(){
        $this->render('enter-page/login'); 
    }
}
