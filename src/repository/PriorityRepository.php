<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Priority.php';

class PriorityRepository extends Repository
{
    public function getAllPriority(): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT p.id, p.name FROM priorities p
        ');
        $stmt->execute();

        $prioritiesList = [];
        $prioritiesArray = $stmt->fetch(PDO::FETCH_ASSOC);

        while($prioritiesArray){
            array_push($prioritiesList, new Priority(
                intval($prioritiesArray['id']),
                $prioritiesArray['name'],
            ));
            $prioritiesArray = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $prioritiesList;
    }
}