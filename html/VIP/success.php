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


if (!isset($_SESSION["userId"])) {
    header("Location: /login");
    die();
}

if (!isset($_SESSION["PaymentIntent"])) {
    header("Location: /");
    die();
}
$plan = $_SESSION["PaymentIntent"]["plan"];
$price = $_SESSION["PaymentIntent"]["price"];
$token = $_SESSION["token"];

try {
    $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
    $response = $client->post('/VIPUser', [
        'json' => [
            'vip_status' => $plan,
            'userId' => $_SESSION["userId"]
        ]
    ]);
    $booking = json_decode($response->getBody()->getContents(), true);
   
   
    if ($booking["success"] == true) {

        unset($_SESSION["PaymentIntent"]);
        
        header('location: /VIP/sendmail?id='.$plan.'&user='.$token);
   
        

    } else {
        $_SESSION["error"] = "Une erreur est survenue lors de la création de votre abonnement";

        header('location: /VIP/VIP');
        unset($_SESSION["PaymentIntent"]);
        
    }

} catch (Exception $e) {
    echo $e->getMessage();
    die();
} 



