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
        $user = $this->userRepository->getUser($_SESSION["email"]);
        $_SESSION['user'] = $user;
        $returnArray = [
            "email" => $_SESSION['email'],
            "name" => $user->getName(),
            "surname" => $user->getSurname(),
            'user' => $user,
            'username' => $_SESSION['user_name']
        ];

        $this->render('portal/settings', ['messages' => $returnArray]);
    }

    public function updateAccount(){
        if (!$this->isPost()) {
            return $this->render('portal/dashboard',
                ['messages' => [
                    'user' => $_SESSION['user']
                ]]);
        }

        $email = $_POST['email'];
        $oldPassword = $_POST['old-password'];
        $newPassword = $_POST['new-password'];
        $confirmedNewPassword = $_POST['new-password-confirm'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        if ($newPassword !== $confirmedNewPassword) {
            return $this->render('portal/settings', ['messages' => [
                'error' => 'Your new Passwords is not the same',
                'user' => $_SESSION['user']
            ]]);
        }

        $updateUser = new User($email, password_hash($newPassword, PASSWORD_BCRYPT), $name, $surname);

        if (!password_verify($oldPassword, $_SESSION["user"]->getPassword()) ) {
            return $this->render('portal/settings', ['messages' => [
                'error' => 'Wrong password!',
                'user' => $_SESSION['user']
            ]]);
        }

        try{
            $this->userRepository->editUser($_SESSION['user']->getEmail(), $updateUser);
        } catch (PDOException){
            return $this->render('portal/settings', ['messages' => [
                'error' => 'Email: '.$email.' exist in database',
                'user' => $_SESSION['user']
            ]]);
        }
        header("Location: logout");
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