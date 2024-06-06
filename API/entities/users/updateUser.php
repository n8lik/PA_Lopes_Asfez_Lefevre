<?php

function updateUser(string $id, $columns): void
{
    //On se connecte à la base de données
    require_once __DIR__ . "/../../database/connection.php";

    //On vérifie que l'on a bien des colonnes à mettre à jour
    if (count($columns) === 0) {return;}

    //On initialise un tableau vide, on définit les colonnes qui seront modifiées et on définit un tableau contenant les informations de l'utilisateur
    $tab = [];
    $changeColumns = ["email", "password", "token"];
    $idToChar = ["id" => htmlspecialchars($id)];

    //On parcourt les colonnes à modifier
    foreach ($columns as $columnName => $columnValue) {
        //Si la colonne n'est pas autorisée on passe à la suivante
        if (!in_array($columnName, $changeColumns)) {continue;}

        //On ajoute la colonne à modifier dans le tableau
        $tab[] = "$columnName = :$columnName";

        //Si la colonne est le mot de passe on le hash
        if ($columnName === "password") {
            $idToChar[$columnName] = password_hash($columnValue, PASSWORD_BCRYPT);
        } else {
            $idToChar[$columnName] = htmlspecialchars($columnValue);
        }
    }

    //On prépare la requête
    $pdo = getDatabaseConnection();
    $query = "UPDATE users SET " . implode(", ", $tab) . " WHERE id = :id";
    $updateUser = $pdo->prepare($query);

    //On exécute la requête
    $updateUser->execute($idToChar);
}

