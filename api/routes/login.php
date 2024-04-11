<?php
//On inclut les fichiers nécessaires
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/login.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/connection.php";

//Necessaires pour le token
require_once __DIR__ . "/../../libraries/token.php";
require_once __DIR__ . "/../../entities/users/updateUser.php";

//On récupère le corps de la requête avec l'email et le mot de passe
$body = getBody();
//Si l'email ou le mot de passe est introuvabl dans le body on renvoie une erreur
if (!isset($body["email"]) || !isset($body["password"])) {
    echo jsonResponse(400, [], [
    "success" => false,
    "error" => "Bad email or password "
    ]);
    
    die();
}

//On récupère l'utilisateur avec l'email et le mot de passe
$id = login($body["email"], $body["password"]);

//Si l'utilisateur n'existe pas on renvoie une erreur
if (!$id) {
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Bad email or password"
    ]);

    die();
}


//Si la requête est bonne on génère un token
$token = getToken();

//On met à jour le token de l'utilisateur
updateUser($id, ["token" => $token]);

echo jsonResponse(200, [], [
    "success" => true,
    "token" => $token
]);
