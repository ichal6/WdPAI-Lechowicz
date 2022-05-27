<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM ST.users u LEFT JOIN ST.users_details ud 
            ON u.id_user_details = ud.user_details_id WHERE email = :email
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
        $stmt = $this->database->connect()->prepare('
            INSERT INTO ST.users_details (name, surname)
            VALUES (?, ?)
        ');

        $stmt->execute([
            $user->getName(),
            $user->getSurname(),
        ]);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO ST.users (email, password, id_user_details, created_at)
            VALUES (?, ?, ?, ?)
        ');

        $date = new DateTime();
        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $this->getUserDetailsId($user),
            $date->format("Y-m-d")
        ]);
    }

    public function getUserDetailsId(User $user): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM ST.users_details WHERE name = :name AND surname = :surname
        ');
        $name = $user->getName();
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $surname = $user->getSurname();
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['user_details_id'];
    }
}