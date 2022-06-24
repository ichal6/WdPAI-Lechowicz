<?php

require_once 'Repository.php';

class ProductsRepository  extends Repository
{
    public function getProductsByListId(int $id_list)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT p.id, p.name as name, p.quantity, s.name as status_name, u.name as unit_name,
                   lp.value as price, c.name as currency
            FROM products as p 
                JOIN statuses s ON p.status_id = s.id 
                JOIN units u ON p.unit_id = u.id
                LEFT OUTER JOIN last_prices lp on lp.id = p.last_price_id
                LEFT OUTER JOIN currencies c on lp.currency_id = c.id
                                                                           WHERE list_id=:list_id
        ');
        $stmt->bindParam(':list_id', $id_list, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeProduct(int $id){
        $stmt = $this->database->connect()->prepare('
          DELETE FROM products WHERE id=:id   
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setBoughtProduct(int $id_product){
        $stmt = $this->database->connect()->prepare('
          SELECT status_id FROM products WHERE id=:id   
        ');

        $stmt->bindParam(':id', $id_product, PDO::PARAM_INT);
        $stmt->execute();
        $possibleID = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_status = 0;

        if(in_array('1', $possibleID)){
            $id_status = 2;
        } else{
            $id_status = 1;
        }

        $stmt = $this->database->connect()->prepare('
          UPDATE products SET status_id =:status_id WHERE id=:id   
        ');
        $stmt->bindParam(':id', $id_product, PDO::PARAM_INT);
        $stmt->bindParam(':status_id', $id_status, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct(int $id_list, Product $product)
    {
         $stmt = $this->database->connect()->prepare('
          INSERT INTO products (list_id, name, last_price_id, quantity, unit_id, status_id) 
          VALUES (?,?,?,?,?,?)   
        ');

        $stmt->execute([
            $id_list,
            $product->getName(),
            $product?->getPrice()?->getId(),
            $product->getQuantity(),
            $product->getUnit()->getId(),
            $product->getStatus()->getId()
        ]);
    }
}