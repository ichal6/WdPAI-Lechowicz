<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/LoginController.php';
require_once 'src/controllers/RegisterController.php';

class Router {
    public static $routes;

    public static function get($url, $controller){
        self::$routes[$url] = $controller;
    }

    public static function run($url) {
        $urlParts = explode('/', $url);
        $action = $urlParts[0];

        if(!array_key_exists($action, self::$routes)) {
            header("Location: index");
            die();
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';
        $id = $urlParts[1] ?? ''; // ?? czy wartośc istnieje czy nie, jesli nie wstaw znak pusty
        echo $id;

        $object->$action($id);

    }
}
