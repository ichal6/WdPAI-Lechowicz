<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Currency.php';

class CurrencyRepository extends Repository
{
    public function getAllCurrencies(): bool|array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id, name FROM currencies
        ');

        $stmt->execute();
        $currenciesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $currenciesList = [];

        foreach($currenciesArray as $currencyArray){
            $currenciesList[] = new Currency(
                intval($currencyArray['id']),
                $currencyArray['name']
            );
        }
        return $currenciesList;
    }

    public function getCurrencyByName(string $name): ?Currency
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id, name FROM currencies WHERE name=:name
        ');

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $currencyArray = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Currency(
            intval($currencyArray['id']),
            $currencyArray['name']
        );
    }

    public function getCurrencyById(int $currency_id): ?Currency
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id, name FROM currencies WHERE id=:id
        ');

        $stmt->bindParam(':id', $currency_id, PDO::PARAM_STR);
        $stmt->execute();

        $currencyArray = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Currency(
            intval($currencyArray['id']),
            $currencyArray['name']
        );
    }
}