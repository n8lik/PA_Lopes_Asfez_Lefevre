<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$data = getAllAdmins();

if (empty($data)) {
    echo (jsonResponse(400, [], [
        "success" => false,
        "message" => "No user found"
    ]));
} else {
    echo (jsonResponse(200, [], [
        "success" => true,
        "users" => $data
    ]));
}   

?>


