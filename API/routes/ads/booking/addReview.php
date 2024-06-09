<?php


require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/ads/booking.php";

$body= getBody();

$rate = $body["rate"];
$comment = $body["comment"];
$id = $body["id"];

$review = addReview($rate, $comment, $id);

if (empty($review)) {
    echo jsonResponse(400, [], [
        "success" => false,
        "message" => "Error while adding review"
    ]);
    die();
}else{
    echo jsonResponse(200, [], [
        "success" => true,
        "message" => "Review added"
    ]);
    die();
}

?>