<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController
{
    public function login(){
        $user = new User('snow@pk.edu.pl', 'admin', "John", "Snow");

        if (!$this->isPost()) {
            return $this->render("enter-page/login");
        }
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->getEmail() !== $email) {
            echo "Test";
            return $this->render("enter-page/login", ['messages' => ['User with this email not exist!']]);
        }

        if ($user->getPassword() !== $password) {
            echo "Test";
            return $this->render('enter-page/login', ['messages' => ['Wrong password!']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";

        header("Location: {$url}/dashboard");
    }
}