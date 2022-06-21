<?php

require_once 'Repository.php';

class ListRepository extends Repository
{
    public function getListsByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT lists.id, title, types.name as type_name FROM lists JOIN types ON lists.type_id = types.id WHERE LOWER(title) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByPriority(int $priority_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT lists.id, title, types.name as type_name, p.id as priority_id FROM lists JOIN types ON lists.type_id = types.id JOIN priorities p on lists.priority_id = p.id WHERE priority_id=:id
        ');
        $stmt->bindParam(':id', $priority_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByType(int $type_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT lists.id, title, types.name as type_name, type_id FROM lists JOIN types ON lists.type_id = types.id WHERE type_id=:id
        ');
        $stmt->bindParam(':id', $type_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByCategory(int $category_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT lists.id, title, types.name as type_name, p.id as priority_id, c.id as category_id FROM lists JOIN types ON lists.type_id = types.id JOIN priorities p on lists.priority_id = p.id JOIN categories c on c.id = lists.category_id WHERE category_id=:id
        ');
        $stmt->bindParam(':id', $category_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}