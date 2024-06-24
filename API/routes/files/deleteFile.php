<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/files.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";

$body = getBody();

$token = $body["token"];
$file = $body["filename"];
$grade = $body["grade"];

if ($grade == 4){
    $grade = "landlord";
}
else{
    $grade = "provider";
}

$id = getUserByToken($token);
$userId = $id["id"];

if (!$id) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "error" => "User not found"
    ]));
    exit;
}

deleteFile($userId, $grade, $file);


echo (jsonResponse(200, [], [
    "success" => true,
    "message" => "Fichier supprimé"
]));