<?php

require '../vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

use GuzzleHttp\Client;


if (!isset($_SESSION["userId"])) {
    header("Location: /login");
    die();
}

if (!isset($_SESSION["PaymentIntent"])) {
    header("Location: /");
    die();
}


$userId = $_SESSION["userId"];
$paymentIntent = $_SESSION["PaymentIntent"];
$id = $paymentIntent["id"];
$type = $paymentIntent["type"];
$price = $paymentIntent["price"];
$start_date = $paymentIntent["date_start"];
$end_date = $paymentIntent["date_end"];
$amount_people = $paymentIntent["amount_people"];


try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $test = [
        'userId' => $userId,
        'id' => $id,
        'type' => $type,
        'price' => $price,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'amount_people' => $amount_people
    ];

    $response = $client->post('/booking', [
        'json' => $test

    ]);

    $body = json_decode($response->getBody()->getContents(), true);

    if ($body['success'] == true) {
?>
        <script>
            alert("Votre réservation a bien été prise en compte. Vous allez être redirigé vers la page d'accueil.");
            window.location.replace("https://pcs-all.online/");
        </script>
<?
    } else {
        echo "Erreur lors de la réservation";
    }
} catch (Exception $e) {

    echo $e->getMessage();
    die();
}
?>