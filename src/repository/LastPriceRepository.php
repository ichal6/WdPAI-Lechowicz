<?php
require_once 'Repository.php';
require_once __DIR__.'/../models/Price.php';


class LastPriceRepository extends Repository
{
    public function addPrice(float $value, int $id_currency): ?int
    {
        $pdo = $this->database->connect();
        $stmt = $pdo->prepare('
          INSERT INTO last_prices (currency_id, value) 
          VALUES (?,?)   
        ');

        $stmt->execute([
            $id_currency,
            $value
        ]);

        return $pdo->lastInsertId();
    }

    public function getPriceById(int $id){
        $stmt = $this->database->connect()->prepare('
            SELECT id, currency_id, value FROM last_prices WHERE id=:id;
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $priceArray = $stmt->fetch();

        $stmt = $this->database->connect()->prepare('
            SELECT id, name FROM currencies WHERE id=:id;
        ');

        $id_currency = intval($priceArray['currency_id']);
        $stmt->bindParam(':id', $id_currency, PDO::PARAM_INT);
        $stmt->execute();
        $currencyArray = $stmt->fetch();
        $currency = new Currency(intval($currencyArray['id']), $currencyArray['name']);

        return new Price($priceArray['id'], doubleval($priceArray['value']), $currency);
    }
}