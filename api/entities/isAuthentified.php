<?php

function isAuthentified(string $role = "USER"): bool
{
    //On récupère les entêtes de la requête pour récupérer le jeton
    $headers = getallheaders();
    $authorizationHeader = $headers["Authorization"];
    $authorizationParts = explode(" ", $authorizationHeader);

    //Si le type d'authorisation n'est pas présent on renvoie une erreur
    if (!isset($authorizationParts[0])) {
        return false;
    }
    if (!isset($authorizationParts[1])) {
        return false;
    }

    //On récupère le type d'authorisation et le jeton
    $authorizationType = $authorizationParts[0];
    $bearerToken = $authorizationParts[1];
    if ($authorizationType !== "Bearer") {
        return false;
    }

    //On récupère la connexion à la base de données
    require_once __DIR__ . "/../database/connection.php";
    $pdo = getDatabaseConnection();
    //On prépare la requête
    $getUserQuery = $pdo = $pdo->prepare("SELECT role FROM users WHERE token = :token");
    //On exécute la requête
    $result = $getUserQuery->execute([
        "token" => $bearerToken
    ]);
    if (!$result) {
        return false;
    }
    //On récupère le résultat
    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);
    //Si l'utilisateur n'existe pas on renvoie une erreur
    if (!$user) {
        return false;
    }
    //Si l'utilisateur n'a pas le bon rôle on renvoie une erreur; c'est le cas si le rôle de l'utilisateur n'est pas égal au rôle passé en paramètre
    if ($user["role"] !== $role) {
        return false;
    }
    return true;
}
