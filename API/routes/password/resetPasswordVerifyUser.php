<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/password.php";


$body = getBody();

if (!isset($body['email']) || !isset($body['token'])) {
    jsonResponse(400,  [], "Missing parameters");
    die();
}

$verif=resetPasswordVerifyUser($body['email'], $body['token']);

if (!$verif) {
    jsonResponse(404, [], "User not found");
    die();
}
echo jsonResponse(200, [], [
    "success" => true
]);