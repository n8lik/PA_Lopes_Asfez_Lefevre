<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";
require_once __DIR__ . "/../../libraries/parameters.php";


$parameters = getParametersForRoute("/getAdminBySearch/:search");
if (!isset($parameters["search"])) {
    echo (jsonResponse(404, [], [
        "success" => false,
        "message" => "Missing parameters"
    ]));
    die();
}
$search = $parameters["search"];
$data = getAdminBySearch($search);


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


