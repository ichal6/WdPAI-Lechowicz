<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Category.php';

class CategoryRepository extends Repository
{
    public function getAllCategories(): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT c.id, c.name FROM categories c JOIN users u ON c.user_id=u.id WHERE u.email = :email
        ');
        $email = $_SESSION['user']->getEmail();

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $categoriesList = [];
        $categoryArray = $stmt->fetch(PDO::FETCH_ASSOC);

        while($categoryArray){
            array_push($categoriesList, new Category(
                intval($categoryArray['id']),
                $categoryArray['name'],
            ));
            $categoryArray = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $categoriesList;
    }
}