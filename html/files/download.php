<?php
require '../vendor/autoload.php';
session_start() ;
Use GuzzleHttp\Client;
$token = $_SESSION["token"];
$grade = $_SESSION["grade"];
$filename = $_GET['file'];
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $test = [
        'grade' => $grade,
        'token' => $token,
        'filename' => $filename
    ];
    $response = $client->post('/downloadFile', [
        'json' => $test

    ]);

    
    // récupérer les headers
    $headers = $response->getHeaders();
    // remplacer les headers par ceux de la réponse
    foreach ($headers as $name => $values) {
        foreach ($values as $value) {
            header($name . ': ' . $value);
        }
    }
    // afficher le contenu de la réponse
    echo $response->getBody();
    
} catch (Exception $e) {
    
    echo $e->getMessage();
}