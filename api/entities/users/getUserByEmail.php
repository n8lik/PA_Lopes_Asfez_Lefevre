<?php
//Fonction pour récupérer un utilisateur par son email
function getUserByEmail(string $email): array
{
    //On récupère la connexion à la base de données
    require_once __DIR__ . "/../../database/connection.php";
    //On prépare la requête
    $pdo= getDatabaseConnection();
    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $pdo->prepare($query);
    //On exécute la requête
    $statement->execute(["email" => $email]);
    
    //on récupère le résultat dans une variable
    $result = $statement->fetch();

    //Si le résultat est vide on renvoie false
    if (!$result) {
        return false;
    }

    //On renvoie vrai s'il y a un résultat
    return true;
}