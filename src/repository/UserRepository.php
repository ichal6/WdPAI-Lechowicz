<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT email, password, name, surname, u.id as user_id FROM users u LEFT JOIN user_details ud 
            ON u.id_user_details = ud.id WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        $returnUser = new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname']
        );

        $returnUser->setId($user['user_id']);

        return $returnUser;
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

    public function editUser(string $oldEmail, User $updateUser){
        $pdo = $this->database->connect();
        try {
            $stmt = $this->database->connect()->prepare('
            SELECT u.id, id_user_details, email, password, name, surname FROM users u LEFT JOIN user_details ud 
            ON u.id_user_details = ud.id WHERE email = :email
        ');
            $stmt->bindParam(':email', $oldEmail, PDO::PARAM_STR);
            $stmt->execute();

            $oldUser = $stmt->fetch(PDO::FETCH_ASSOC);

            $pdo->beginTransaction();
            $stmt = $pdo->prepare('
                UPDATE user_details SET
                name = :name, surname = :surname
                WHERE id=:id
            ');

            $stmt->execute([
                $updateUser->getName(),
                $updateUser->getSurname(),
                $oldUser['id_user_details']
            ]);

            $stmt = $this->database->connect()->prepare('
                                UPDATE users SET
                email = :email, password = :password
                WHERE id=:id
            ');
            $stmt->execute([
                $updateUser->getEmail(),
                $updateUser->getPassword(),
                $oldUser['id']
            ]);
            $pdo->commit();
        } catch (PDOException $ex){
            $pdo->rollBack();
            throw $ex;
        }
    }

    public function removeUser(string $email){
        $pdo = $this->database->connect();
        try {
            $pdo->beginTransaction();

            $stmt = $this->database->connect()->prepare('
                DELETE FROM users WHERE email=:email
            ');
            $stmt->execute([
                $email
            ]);
            $pdo->commit();
        } catch (PDOException $ex){
            $pdo->rollBack();
            throw $ex;
        }
    }

    public function disableUser(string $email){
        $pdo = $this->database->connect();
        try {
            $pdo->beginTransaction();

            $stmt = $this->database->connect()->prepare('
                                UPDATE users SET
                enabled = false
                WHERE email=:email
            ');
            $stmt->execute([
                $email
            ]);
            $pdo->commit();
        } catch (PDOException $ex){
            $pdo->rollBack();
            throw $ex;
        }
    }

    public function enabledUser(string $email){
        $pdo = $this->database->connect();
        try {
            $pdo->beginTransaction();

            $stmt = $this->database->connect()->prepare('
                                UPDATE users SET
                enabled = true
                WHERE email=:email
            ');
            $stmt->execute([
                $email
            ]);
            $pdo->commit();
        } catch (PDOException $ex){
            $pdo->rollBack();
            throw $ex;
        }
    }
}