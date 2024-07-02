<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/updateUser.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$userId = $body["userId"];
$vip_status = $body["vip_status"];

$data = updateVIPUser($userId, $vip_status);

if (!$data){
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Erreur lors de la mise à jour de l'utilisateur"
        ]
    );
    die();
}

echo jsonResponse(
    200,
    [],
    [
        "success" => true,
        "message" => "Utilisateur mis à jour"
    ]
);