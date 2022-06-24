<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Unit.php';

class UnitRepository extends Repository
{
    public function getUnit(string $unitName): ?Unit{
        $stmt = $this->database->connect()->prepare('
          SELECT id, name FROM units WHERE name=:name   
        ');

        $stmt->bindParam(':name', $unitName, PDO::PARAM_STR);
        $stmt->execute();
        $unitArray = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($unitArray)){
            return new Unit($unitArray['id'], $unitArray['name']);
        } else{
            return null;
        }
    }

    public function addUnit(Unit $unit): int{
        $pdo = $this->database->connect();
        try {
            $pdo->beginTransaction();
            $stmt = $this->database->connect()->prepare('
                INSERT INTO units (name)
                VALUES (?)
            ');

            $stmt->execute([
                $unit?->getName()
            ]);
            $pdo->commit();
            $lastInsertId = $pdo->lastInsertId();
        } catch (PDOException $ex){
            $pdo->rollBack();
            throw $ex;
        }
        return $lastInsertId;
    }

    public function getUnitById(int $id): ?Unit
    {
        $stmt = $this->database->connect()->prepare('
          SELECT id, name FROM units WHERE id=:id   
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $unitArray = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($unitArray)){
            return new Unit($unitArray['id'], $unitArray['name']);
        } else{
            return null;
        }
    }

    public function getAllUnits(): Array
    {
        $stmt = $this->database->connect()->prepare('
          SELECT id, name FROM units  
        ');

        $stmt->execute();
        $unitsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $units = [];
        foreach ($unitsArray as $unitArray){
            $units[] = new Unit(intval($unitArray['id']), $unitArray['name']);
        }

        return $units;
    }
}
