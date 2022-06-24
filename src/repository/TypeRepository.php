<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Type.php';

class TypeRepository extends Repository
{
    public function getAllTypes(): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id, name FROM types
        ');
        $stmt->execute();

        $typesList = [];
        $typeArray = $stmt->fetch(PDO::FETCH_ASSOC);

        while($typeArray){
            array_push($typesList, new Type(
                intval($typeArray['id']),
                $typeArray['name'],
            ));
            $typeArray = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $typesList;
    }
}