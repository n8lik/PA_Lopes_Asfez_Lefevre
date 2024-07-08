<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsInfo.php";
require_once __DIR__ . "/../../libraries/parameters.php";


$parameters = getParametersForRoute("/getPerformanceAdsInfo/:id");
$id = $parameters["id"];

$adsInfo = getAdsInfo($id, "performance");

if (empty($adsInfo)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "No ads found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "adsInfo" => $adsInfo
    ]));
}

?>
