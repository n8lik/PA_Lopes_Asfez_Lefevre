<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/androidApp.php";
require_once __DIR__ . "/../../libraries/body.php";
$body = getBody();


if (!isset($body["email"]) || !isset($body["password"])) {
    echo jsonResponse(200, [], [
        "success" => false,
        "error" => "Les champs email et password sont obligatoires"
    ]);

    die();
}

$email = $body["email"];
$password = $body["password"];

$user = loginAndroid($email, $password);


if (!$user) {
    echo jsonResponse(200, [], [
        "success" => false,
        "error" => "Les identifiants sont incorrects"
    ]);

    die();
}else{
    echo jsonResponse(200, [], [
        "success" => true,
        "id" => $user["id"],
        "pseudo" => $user["pseudo"],
        "grade" => $user["grade"]
    ]);
}

?>
