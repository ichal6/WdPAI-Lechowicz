<?php

require_once 'Router.php';

$path = trim($_SERVER['REQUEST_URI'], '/');

// var_dump($path);
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('index', 'DefaultController');
Router::get('projects', 'DefaultController');
Router::get("project", 'DefaultController');
Router::get('dashboard', 'DashboardController');
Router::run($path);
