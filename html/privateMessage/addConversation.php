
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
            'type' => $type,
        ];

        $response = $client->post('/addConversation', [
            'json' => $test
        ]);

        $body = json_decode($response->getBody()->getContents(), true);


        if ($body['success'] == true) {
            header('Location: /privateMessage/conversation.php?id=' . $body['id']);
        } 
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
