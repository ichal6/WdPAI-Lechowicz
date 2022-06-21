<?php

require_once 'Repository.php';

class ProductsRepository  extends Repository
{
    public function getProductsByListId(int $id_list)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT p.id, p.name as name, p.quantity, s.name as status_name FROM products as p 
                JOIN statuses s ON p.status_id = s.id JOIN units u ON p.unit_id = u.id
                                                                           WHERE list_id=:list_id
        ');
        $stmt->bindParam(':list_id', $id_list, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}