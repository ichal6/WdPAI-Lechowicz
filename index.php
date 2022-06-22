<?php

require_once 'Router.php';

$path = trim($_SERVER['REQUEST_URI'], '/');

$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('index', 'DefaultController');
Router::get('login', 'LoginController');
Router::get('register', 'RegisterController');
Router::get('dashboard', 'DefaultController');
Router::get('lists', 'ListController');
Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::get('logout', 'SecurityController');
Router::get('account', 'SettingsController');
Router::post('updateAccount', 'SettingsController');
Router::get('search', 'ListController');
Router::get('list', 'ListController');
Router::get('filter_priority', 'ListController');
Router::get('filter_category', 'ListController');
Router::get('filter_type', 'ListController');
Router::get('filter_type', 'ListController');
Router::delete('remove_product', 'ProductController');

Router::addUnSecurePage('login');
Router::addUnSecurePage('register');

Router::run($path);
