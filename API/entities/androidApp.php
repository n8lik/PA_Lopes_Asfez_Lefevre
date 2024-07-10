<?php 
require_once __DIR__ . "/../database/connection.php";

function loginAndroid($email, $password) {
    $connection = connectDB();
    //rechercher les adresse email dans la base de données
    $query = $connection->prepare("SELECT * FROM user WHERE email = :email");
    $query->execute([
        "email" => $email
    ]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    //Verifier le mot de passe
    if (!$user) {
        return false;
    }

    $isPasswordValid = password_verify($password, $user["password"]);

    if (!$isPasswordValid) {
        return false;
    }

    return $user;
}