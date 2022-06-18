<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Category.php';
require_once __DIR__.'/../repository/CategoryRepository.php';
require_once __DIR__.'/../repository/TypeRepository.php';
require_once __DIR__.'/../repository/PriorityRepository.php';

class ListController extends AppController{
    private CategoryRepository $categoryRepository;
    private TypeRepository $typeRepository;
    private PriorityRepository $priorityRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = new CategoryRepository();
        $this->typeRepository = new TypeRepository();
        $this->priorityRepository = new PriorityRepository();
    }

    public function lists(){
        $this->render('portal/lists', ['messages' => [
            'username' => $_SESSION['user_name'],
            'user' => $_SESSION['user'],
            'categories' => $this->categoryRepository->getAllCategories(),
            'types' => $this->typeRepository->getAllTypes(),
            'priorities' => $this->priorityRepository->getAllPriority()
        ]]);
    }
}