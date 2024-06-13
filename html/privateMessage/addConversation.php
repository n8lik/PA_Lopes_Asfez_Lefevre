<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;

session_start();

$userId = $_SESSION['userId'];
$id = $_GET['id'];
$type = $_GET['type'];


try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $test = [
        'userId' => $userId,
        'id' => $id,
        'type' => $type
    ];

    $response = $client->post('/addConversation', [
        'json' => $test
    ]);

    $body = json_decode($response->getBody()->getContents());
    /* if ($body['success']) {
        $idConv = $body['idConv'];
        header("Location: conversation.php?id=$idConv");
    } */
   var_dump($body);
} catch (Exception $e) {

    echo $e->getMessage();
    die();
}
