<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login(){

        if (!$this->isPost()) {
            return $this->render("enter-page/login");
        }
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $user = $this->userRepository->getUser($email);

        if(!$user){
            return $this->render("enter-page/login", ['messages' => ['User not exist!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render("enter-page/login", ['messages' => ['User with this email not exist!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('enter-page/login', ['messages' => ['Wrong password!']]);
        }

        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $email;
        $_SESSION['user_name'] = $user->getName().' '.$user->getSurname();

        $url = "http://$_SERVER[HTTP_HOST]";

//        header("Location: {$url}/dashboard");
        $this->render('portal/lists', ['messages' => [$_SESSION['user_name']]]);
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('enter-page/register');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirm-password'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        if ($password !== $confirmedPassword) {
            return $this->render('enter-page/register', ['messages' => ['Please provide proper password']]);
        }

        //TODO try to use better hash function
        $user = new User($email, md5($password), $name, $surname);

        $this->userRepository->addUser($user);

        return $this->render('enter-page/login', ['messages' => ['You\'ve been succesfully registrated!']]);
    }

    public function logout(): void
    {
        // Unset all the session variables
        $_SESSION = array();

        // Destroy the session.
        session_destroy();

        header("Location: index");
        die();
    }
}