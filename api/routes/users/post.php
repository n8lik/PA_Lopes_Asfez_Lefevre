<?php
//On inclut les fichiers nécessaires    
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/login.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/createUser.php";
require_once __DIR__ . "/../../entities/users/getUserByEmail.php";

//On récupère le corps de la requête avec l'email et le mot de passe
$body = getBody();

//Si il manque l'email on renvoie une erreur
if (!isset($body["email"])) {
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Email not found"
    ]);

    die();
}

//Si il manque le mot de passe on renvoie une erreur
if (!isset($body["password"])) {
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Password not found"
    ]);

    die();
}

//Si le format de l'email est incorrect on renvoie une erreur
if (!filter_var($body["email"], FILTER_VALIDATE_EMAIL)) {
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Invalid email"
    ]);

    die();
}

//Si le mot de passe ne contient pas au moins 8 caractères on renvoie une erreur
if (strlen($body["password"]) < 8) {
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Password not strong enough"
    ]);

    die();
}

//Si l'email est déjà utilisé on renvoie une erreur
if (getUserByEmail($body["email"])) {
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Email already used"
    ]);

    die();
}

//On crée l'utilisateur
createUser($body["email"], $body["password"]);

echo jsonResponse(200, [], [
    "success" => true
    "message" => "Created"
]);
