<?php

require_once 'Repository.php';

class ListRepository extends Repository
{
    public function getListsByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM get_lists WHERE user_id=:id AND LOWER(title) LIKE :search
        ');
        $userId = $_SESSION['user']->getId();

        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByPriority(int $priority_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM get_lists
             WHERE user_id=:id AND priority_id=:id_priority
        ');

        $userId = $_SESSION['user']->getId();
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':id_priority', $priority_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByType(int $type_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM get_lists 
                      WHERE user_id=:id AND type_id=:id_type
        ');

        $userId = $_SESSION['user']->getId();
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':id_type', $type_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByCategory(int $category_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM get_lists
                   WHERE user_id=:id AND category_id=:id_category
        ');
        $userId = $_SESSION['user']->getId();
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':id_category', $category_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeList(int $list_id){
        $stmt = $this->database->connect()->prepare('
          DELETE FROM lists WHERE id=:id   
        ');

        $userId = $_SESSION['user']->getId();
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':id', $list_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addList(ListShop $shopList){
        $pdo = $this->database->connect();
        $lastInsertCategoryId = null;
        try {
            if($shopList?->getCategory()){
                $category_name = $shopList->getCategory()->getName();
                $stmt = $this->database->connect()->prepare('
                SELECT categories.id as c_id, user_id FROM categories INNER JOIN users u on categories.user_id = u.id
                                                          WHERE categories.name =:name
                ');
                $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
                $stmt->execute();

                $return = $stmt->fetch(PDO::FETCH_ASSOC);
                if($return){
                    $lastInsertCategoryId = $return['c_id'];
                } else{
                    $stmt = $pdo->prepare('
                    INSERT INTO categories (user_id, name)
                    VALUES (?, ?)
                    ');

                    $stmt->execute([
                        $shopList->getOwnerId(),
                        $shopList->getCategory()->getName()
                    ]);
                    $lastInsertCategoryId = $pdo->lastInsertId();
                }
            }

            $IdType = $shopList->getType()->getId();

            $pdo->beginTransaction();
            $stmt = $this->database->connect()->prepare('
                INSERT INTO lists (owner_id, category_id, priority_id, title, type_id, created_at)
                VALUES (?, ?, ?, ?, ?, ?)
            ');

            $date = new DateTime();

            $stmt->execute([
                $shopList->getOwnerId(),
                $lastInsertCategoryId,
                $shopList?->getPriority()?->getId(),
                $shopList->getTitle(),
                $IdType,
                $date->format("Y-m-d")
            ]);
            $pdo->commit();
        } catch (PDOException $ex){
            die($ex->getMessage());
            $pdo->rollBack();
            // TODO
            // Remove category
            throw $ex;
        }
    }
}