<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/ProductsRepository.php';
require_once __DIR__.'/../repository/StatusRepository.php';
require_once __DIR__.'/../repository/UnitRepository.php';
require_once __DIR__.'/../repository/CurrencyRepository.php';
require_once __DIR__.'/../repository/LastPriceRepository.php';
require_once __DIR__.'/../models/Product.php';
require_once __DIR__.'/../models/Price.php';
require_once __DIR__.'/../models/Status.php';
require_once __DIR__.'/../models/Unit.php';


class ProductController extends AppController
{
    private ProductsRepository $productRepository;
    private StatusRepository $statusRepository;
    private UnitRepository $unitRepository;
    private CurrencyRepository $currencyRepository;
    private LastPriceRepository $lastPriceRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductsRepository();
        $this->statusRepository = new StatusRepository();
        $this->unitRepository = new UnitRepository();
        $this->currencyRepository = new CurrencyRepository();
        $this->lastPriceRepository = new LastPriceRepository();
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
        $currency_id = $_POST['currency_id'];

        $unit = $this->unitRepository->getUnit($unitName);

        if($unit == null){
            $unit_id = $this->unitRepository->addUnit($unitName);
            $unit = $this->unitRepository->getUnitById($unit_id);
        }

        $status = $this->statusRepository->getToBuyStatus();

        $product = new Product(null, $name, null, $status, doubleval($quantity), $unit);

        if($price != ''){
            $currency = $this->currencyRepository->getCurrencyById($currency_id);
            if($currency){
                $idPrice = $this->lastPriceRepository->addPrice(doubleval($price), $currency_id);
                $price = $this->lastPriceRepository->getPriceById($idPrice);
                $product->setPrice($price);
            } else{
                throw new PDOException('Wrong Currency');
            }
        }

        try{
            $this->productRepository->addProduct(intval($id_list), $product);
        } catch (PDOException $ex){
            return $this->render('portal/lists', ['messages' => [
                'error' => 'Error insert to DB'.$ex->getMessage(),
                'user' => $_SESSION['user']
            ]]);
        }
        header("Location: lists");
    }
}