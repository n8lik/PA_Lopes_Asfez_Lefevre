<?php

require '../vendor/autoload.php';
require '../includes/header.php';

$id = $_GET['id'];

use GuzzleHttp\Client;

try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);

    $response = $client->get('/private-message/' . $id);

    $body = json_decode($response->getBody()->getContents(), true);

    if ($body['success'] == true) {
        $conversation = $body['conversation'];
    } else {
        echo $body['error'];
        die();
    }
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
