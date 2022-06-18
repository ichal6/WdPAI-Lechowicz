<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Type.php';

class TypeRepository extends Repository
{
    public function getAllTypes(): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT t.id, t.name FROM types t JOIN users u ON t.user_id=u.id WHERE u.email = :email
        ');
        $email = $_SESSION['user']->getEmail();

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
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