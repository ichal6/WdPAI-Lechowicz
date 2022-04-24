<?php

require_once 'AppController.php';

class DashboardController extends AppController{
    public function dashboard(){
        // TODO return and render display.html
        $this->render('dashboard', ['grettings', 'Hello world']);
    }
}