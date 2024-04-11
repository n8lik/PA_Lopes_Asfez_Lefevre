<?php
//Si l'email  n'existe pas en base de données on renvoie une erreur
function connection($id): array
{
    require_once __DIR__ . "/../database/connection.php";

    $databaseConnection = getDatabaseConnection();
    $getUserQuery = $databaseConnection->prepare("SELECT * FROM users WHERE email = :email");
    $getUserQuery->execute(["id" => $id["email"]]);
    //On récupère le résultat dans une variable
    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);
    //Si l'email n'existe pas on renvoie false
    if (!$user) {
        return false;
    }
    //Si l'email existe on teste le mot de passe
    if (!password_verify($id["password"], $user["password"])) {
        return false;
    }
    //Si le mot de passe est bon on renvoie l'id de l'utilisateur
    return $user;
}

