<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/LoginController.php';
require_once 'src/controllers/RegisterController.php';
require_once 'src/controllers/ListController.php';
require_once 'src/controllers/SecurityController.php';

class Router {
    public static $routes;
    public static $publicURL = array();

    public static function addUnSecurePage($url): void
    {
        array_push(self::$publicURL, $url);
    }


    public static function get($url, $controller){
        self::$routes[$url] = $controller;
    }

    public static function post($url, $controller){
        self::$routes[$url] = $controller;
    }

    public static function run($url) {
        session_start();
        if(!isset($_SESSION['first_run'])) {
            $_SESSION['first_run'] = 1;
        }

        $urlParts = explode('/', $url);
        $action = $urlParts[0];

        if(!in_array($action, self::$publicURL)){
            if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                header("location: login");
                exit;
            }
        } else{
            if(isset($_SESSION["loggedin"])){
                header("location: dashboard");
                exit;
            }
        }

        if(!array_key_exists($action, self::$routes)) {
            header("Location: index");
            die();
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';
        $id = $urlParts[1] ?? ''; // ?? czy wartośc istnieje czy nie, jesli nie wstaw znak pusty

        $object->$action($id);

    }
}
