<?php

require_once 'Repository.php';

class ListRepository extends Repository
{
    public function getListsByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM get_lists WHERE LOWER(title) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByPriority(int $priority_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM get_lists
            WHERE priority_id=:id
        ');
        $stmt->bindParam(':id', $priority_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByType(int $type_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM get_lists WHERE type_id=:id
        ');
        $stmt->bindParam(':id', $type_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListsByCategory(int $category_id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id, title, type_name, category, priority, owner FROM get_lists
                                                      WHERE category_id=:id
        ');
        $stmt->bindParam(':id', $category_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeList(int $list_id){
        $stmt = $this->database->connect()->prepare('
          DELETE FROM lists WHERE id=:id   
        ');
        $stmt->bindParam(':id', $list_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addList(ListShop $shopList){
        $pdo = $this->database->connect();
        $lastInsertCategoryId = null;
        try {
            if($shopList?->getCategory()){
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

            $IdType = $shopList->getType()->getId();

            $date = new DateTime();

            $pdo->beginTransaction();
            $stmt = $this->database->connect()->prepare('
                INSERT INTO lists (owner_id, category_id, priority_id, title, type_id)
                VALUES (?, ?, ?, ?, ?)
            ');

            $date = new DateTime();

            $stmt->execute([
                $shopList->getOwnerId(),
                $lastInsertCategoryId,
                $shopList?->getPriority()?->getId(),
                $shopList->getTitle(),
                $IdType
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