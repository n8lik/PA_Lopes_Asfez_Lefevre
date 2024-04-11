<?php
//Pour ajouter un utilisateur dans la base de données
function createUser(string $email, string $password): void
{
    //On récupère la connexion à la base de données
    require_once __DIR__ . "/../../database/connection.php";
    //On prépare la requête
    $pdo = getDatabaseConnection();
    $query = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $statement = $pdo->prepare($query);
    //On exécute la requête
    $statement->execute([
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT)
    ]);
}