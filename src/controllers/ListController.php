<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Category.php';
require_once __DIR__.'/../repository/CategoryRepository.php';

class ListController extends AppController{
    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = new CategoryRepository();
    }

    public function lists(){
        $this->render('portal/lists', ['messages' => [
            'username' => $_SESSION['user_name'],
            'user' => $_SESSION['user'],
            'categories' => $this->categoryRepository->getAllCategories()
        ]]);
    }
}