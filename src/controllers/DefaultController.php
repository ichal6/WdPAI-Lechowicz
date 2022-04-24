<?php

require 'AppController.php';

class DefaultController extends AppController{
    public function index(){
        // TODO display login.html
        $this->render('enter-page/login'); 
    }

    public function projects($id = null) {
        // TODO display projects.html
        if($id) {
            return $this->render('project', ['id' => $id]);
        }

        $projects= [
            'WdPAI', 'WDSI'
        ];

        return $this->render('projects', ['projects' => $projects]);
    }
}
