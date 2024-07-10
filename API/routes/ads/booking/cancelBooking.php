<?php
require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/ads/booking.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

$body = getBody();

$id = $body["id"];
$type = $body["type"];
$userId = $body["userId"];


if (!isset($id) || !isset($type)) {
    echo jsonResponse(400, [], [
        "success" => false,
        "message" => "Missing parameters"
    ]);
    die();
}

$bookinguserid =  getBookingById($id)['user_id'];

if ($bookinguserid != $userId) {
    echo jsonResponse(200, [], [
        "success" => false,
        "message" => "You are not the owner of this booking"
    ]);
    die();
}

$booking = cancelBooking($id, $type);

if (!$booking) {
    echo jsonResponse(200, [], [
        "success" => false,
        "message" => "Booking not canceled"
    ]);
    die();
}

echo jsonResponse(200, [], [
    "success" => true,
    "message" => "Booking canceled"
]);