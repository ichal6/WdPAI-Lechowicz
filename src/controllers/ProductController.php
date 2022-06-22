<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/ProductsRepository.php';


class ProductController extends AppController
{
    private ProductsRepository $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductsRepository();
    }

    public function remove_product(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->productRepository->removeProduct(intval($decoded['id'])));
        }
    }

    public function bought_product(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->productRepository->setBoughtProduct(intval($decoded['id'])));
        }
    }
}