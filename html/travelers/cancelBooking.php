<?php
session_start();
require '../vendor/autoload.php';
Use GuzzleHttp\Client;

$id = $_GET['id'];
$type = $_GET['type'];
$userId = $_SESSION['userId'];
try {
    $client = new Client();

    $response = $client->POST('https://pcs-all.online:8000/cancelBooking', [
        'json' => [
            'id' => $id,
            'type' => $type,
            'userId' => $userId
        ]
    ]);
    $data = json_decode($response->getBody()->getContents(), true);
    if ($data['success']) {
        $_SESSION["success"] = "La réservation a été annulée avec succès";
        
    } else {
        $_SESSION["error"] = "La réservation n'a pas pu être annulée";
    }
} catch (Exception $e) {
    echo "Error: $e";
}
header('Location: /travelers/catalogBookings.php');