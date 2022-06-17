<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users u LEFT JOIN user_details ud 
            ON u.id_user_details = ud.id WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname']
        );
    }

    public function addUser(User $user)
    {
        $pdo = $this->database->connect();
        $lastInsertId = null;
        try {
            $stmt = $pdo->prepare('
                INSERT INTO user_details (name, surname)
                VALUES (?, ?)
            ');
            
            $stmt->execute([
                $user->getName(),
                $user->getSurname(),
            ]);
            $lastInsertId = $pdo->lastInsertId();

            $pdo->beginTransaction();
            $stmt = $this->database->connect()->prepare('
                INSERT INTO users (email, password, id_user_details, created_at)
                VALUES (?, ?, ?, ?)
            ');

            $date = new DateTime();

            $stmt->execute([
                $user->getEmail(),
                $user->getPassword(),
                $lastInsertId,
                $date->format("Y-m-d")
            ]);
            $pdo->commit();
        } catch (PDOException $ex){
            $pdo->rollBack();
            $this->removeUserDetailsById($lastInsertId);
            throw $ex;
        }
    }

    private function removeUserDetailsById(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM user_details WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
    }
}