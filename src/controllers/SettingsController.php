<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SettingsController extends AppController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function account(){
        $this->render('portal/settings', ['messages' => [$_SESSION['user_name']]]);
    }

//    public function register()
//    {
//        if (!$this->isPost()) {
//            return $this->render('enter-page/register');
//        }
//
//        $email = $_POST['email'];
//        $password = $_POST['password'];
//        $confirmedPassword = $_POST['confirm-password'];
//        $name = $_POST['name'];
//        $surname = $_POST['surname'];
//
//        if ($password !== $confirmedPassword) {
//            return $this->render('enter-page/register', ['messages' => ['Please provide proper password']]);
//        }
//
//        $user = new User($email, password_hash($password, PASSWORD_BCRYPT), $name, $surname);
//
//        try{
//            $this->userRepository->addUser($user);
//        } catch (PDOException){
//            return $this->render('enter-page/register', ['messages' => ['Email: '.$email.' exist in database']]);
//        }
//        return $this->render('enter-page/login', ['messages' => ['You\'ve been succesfully registrated!']]);
//    }
//
//    public function logout(): void
//    {
//        // Unset all the session variables
//        $_SESSION = array();
//
//        // Destroy the session.
//        session_destroy();
//
//        header("Location: index");
//        die();
//    }
}