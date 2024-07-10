<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';

use GuzzleHttp\Client;

session_start();

$userId = $_SESSION['userId'];
$id = $_GET['id'];
$type = $_GET['type'];
if (isset($_GET["id_booking"])) {
    $id_booking = $_GET["id_booking"];
}else {
    $id_booking = "non";
}

echo $userId . " " . $id . " " . $type . " " . $id_booking;
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $test = [
        'userId' => $userId,
        'id' => $id,
        'type' => $type,
        'id_booking' => $id_booking
    ];

    $response = $client->post('/addConversation', [
        'json' => $test
    ]);

    $body = json_decode($response->getBody()->getContents(), true);
    
    if ($body["success"]== true){
        $idConv = $body["idConv"];
        header("Location: conversation.php?id=$idConv");
    }
     
} catch (Exception $e) {

    echo $e->getMessage();
    die();
}
