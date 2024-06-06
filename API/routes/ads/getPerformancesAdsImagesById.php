<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsInfo.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$parameters = getParametersForRoute("/performanceAdsImages/:id");
$id = $parameters["id"];


$dispo = getAdsImages($id,"performance");

if ($dispo == null) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "No disponibility found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "disponibility" => $dispo
    ]));
}

?>