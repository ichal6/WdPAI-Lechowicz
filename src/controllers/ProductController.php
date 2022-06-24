<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/ProductsRepository.php';
require_once __DIR__.'/../repository/StatusRepository.php';
require_once __DIR__.'/../repository/UnitRepository.php';
require_once __DIR__.'/../models/Product.php';
require_once __DIR__.'/../models/Price.php';
require_once __DIR__.'/../models/Status.php';
require_once __DIR__.'/../models/Unit.php';


class ProductController extends AppController
{
    private ProductsRepository $productRepository;
    private StatusRepository $statusRepository;
    private UnitRepository $unitRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductsRepository();
        $this->statusRepository = new StatusRepository();
        $this->unitRepository = new UnitRepository();
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

    public function add_product_to_list(){
        if (!$this->isPost()) {
            return $this->render('portal/dashboard');
        }

        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $unitName = $_POST['unit'];
        $id_list = $_POST['list-id'];

        $unit = $this->unitRepository->getUnit($unitName);

        if($unit == null){
            $unit_id = $this->unitRepository->addUnit($unitName);
            $unit = $this->unitRepository->getUnitById($unit_id);
        }

        $status = $this->statusRepository->getToBuyStatus();

        $product = new Product(null, $name, null, $status, doubleval($quantity), $unit);

        if($price != ''){
            $priceArray = explode(" ", $price);
            if(count($priceArray)) {
                $price = new Price( null, $priceArray[0], $priceArray[1]);
                $product->setPrice($price);
            }
        }

        try{
            $this->productRepository->addProduct($id_list, $product);
        } catch (PDOException){
            return $this->render('portal/lists', ['messages' => [
                'error' => 'Product: '.$product->getName().' exist in database',
                'user' => $_SESSION['user']
            ]]);
        }
        header("Location: lists");
    }
}