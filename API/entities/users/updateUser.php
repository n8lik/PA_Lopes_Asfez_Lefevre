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
    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $db = connectDB();
    $querypreprared = $db->prepare("UPDATE user SET password = :newPassword WHERE id = :userId");
    $querypreprared->execute([
        'newPassword' => $newPassword,
        'userId' => $userId
    ]);

    return 1;
    
    
}

function updateVIPuser($userId, $vip_status){
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($vip_status == 3){
        $grade = 1;
        $querypreprared = $db->prepare("UPDATE user SET vip_status = :vip_status WHERE id = :userId");
        $querypreprared->execute([
            'vip_status' => 2,
            'userId' => $userId
        ]);
        return 1;
    }
    {
    if ($vip_status == 1){
        $grade = 2;
    }
    if ($vip_status == 2){
        $grade = 3;
    }
    $querypreprared = $db->prepare("UPDATE user SET grade=:grade, vip_status = :vip_status, vip_date =:vip_date WHERE id = :userId");
    $querypreprared->execute([
        'grade' => $grade,
        'vip_status' => 1,
        'vip_date' => date('Y-m-d H:i:s'),
        'userId' => $userId
    ]);

    return 1;
}
}