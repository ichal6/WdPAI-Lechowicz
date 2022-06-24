<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Status.php';

class StatusRepository extends Repository
{
    public function getToBuyStatus(): Status
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id, name FROM statuses WHERE name=:name
        ');

        $nameToBuy = 'to buy';
        $stmt->bindParam(':name', $nameToBuy, PDO::PARAM_STR);
        $stmt->execute();

        $status = $stmt->fetch(PDO::FETCH_ASSOC);

        if($status){
            return new Status($status['id'], $status['name']);
        } else{
            throw new PDOException('Status does not exist');
        }
    }
}