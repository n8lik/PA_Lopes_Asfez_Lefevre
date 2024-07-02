<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';
session_start();
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}
use GuzzleHttp\Client;


try {
    $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
    $response = $client->post('/VIPUser', [
        'json' => [
            'vip_status' => 3,
            'userId' => $_SESSION["userId"]
        ]
    ]);
    $booking = json_decode($response->getBody()->getContents(), true);
    if ($booking["success"] == true) {
        $_SESSION["success"] = "Votre abonnement a bien été supprimé";
        header('location: /VIP/VIP');
    } else {
        $_SESSION["error"] = "Une erreur est survenue lors de la suppression de votre abonnement";
        header('location: /VIP/VIP');
    }

} catch (Exception $e) {
    echo $e->getMessage();
    die();
} 

