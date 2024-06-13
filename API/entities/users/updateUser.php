<?php

function updateUser($pseudo, $firstname, $lastname, $phone, $extension, $userId)
{
    //On se connecte à la base de données
    require_once __DIR__ . "/../../database/connection.php";

    $db = connectDB();
    $querypreprared = $db->prepare("UPDATE user SET pseudo = :pseudo, firstname = :firstname, lastname = :lastname, phone_number = :phone, extension = :extension WHERE id = :userId");
    $querypreprared->execute([
        'pseudo' => $pseudo,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'phone' => $phone,
        'extension' => $extension,
        'userId' => $userId
    ]);
    
    return 1;
    
}

function updatePassword($userId, $newPassword)
{
    //On se connecte à la base de données
    require_once __DIR__ . "/../../database/connection.php";

    $db = connectDB();
    $querypreprared = $db->prepare("UPDATE user SET password = :newPassword WHERE id = :userId");
    $querypreprared->execute([
        'newPassword' => $newPassword,
        'userId' => $userId
    ]);

    return 1;
    
    
}