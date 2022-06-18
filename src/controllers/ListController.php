<?php

require_once 'AppController.php';

class ListController extends AppController{
    public function lists(){
        $this->render('portal/lists', ['messages' => [
            'username' => $_SESSION['user_name']
        ]]);
    }
}