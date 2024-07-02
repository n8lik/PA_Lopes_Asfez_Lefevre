<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsDisponibility.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$ad_id = $body["id"];
$ad_type = $body["type"];
$ad_date= $body["date"];


$dispo = addAdsDisponibility($ad_id,$ad_type,$ad_date);


if (!$dispo) {
    echo jsonResponse(200, [], [
        "success" => false,
        "error" => "Les identifiants sont incorrects"
    ]);

    die();
}



echo jsonResponse(200, [], [
    "success" => true,
    "dispo" => $dispo
]);


