<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Category.php';
require_once __DIR__.'/../repository/CategoryRepository.php';
require_once __DIR__.'/../repository/TypeRepository.php';
require_once __DIR__.'/../repository/PriorityRepository.php';
require_once __DIR__.'/../repository/ListRepository.php';
require_once __DIR__.'/../repository/ProductsRepository.php';

class ListController extends AppController{
    private CategoryRepository $categoryRepository;
    private TypeRepository $typeRepository;
    private PriorityRepository $priorityRepository;
    private ListRepository $listRepository;
    private ProductsRepository $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = new CategoryRepository();
        $this->typeRepository = new TypeRepository();
        $this->priorityRepository = new PriorityRepository();
        $this->listRepository = new ListRepository();
        $this->productRepository = new ProductsRepository();
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

    public function filter_category()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->listRepository->getListsByCategory($decoded['category_id']));
        }
    }

    public function filter_type()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->listRepository->getListsByType($decoded['type_id']));
        }
    }

    public function filter_priority()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->listRepository->getListsByPriority($decoded['priority_id']));
        }
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->listRepository->getListsByTitle($decoded['search']));
        }
    }

    public function list(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->productRepository->getProductsByListId(intval($decoded['list'])));
        }
    }
}