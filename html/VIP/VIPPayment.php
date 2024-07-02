<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';
require '../reservation/secrets.php';
use GuzzleHttp\Client;
session_start();
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}
$userToken = $_SESSION["token"];
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/usersbytoken/' . $userToken);
    $body = json_decode($response->getBody()->getContents(), true);
    $users = $body["users"];
} catch (Exception $e) {
    $users = [];
}

if ($users["grade"] == 2 && $_POST["plan"] == 1) {
    $_SESSION["error"] = "Vous êtes déjà abonné à ce plan";
    header('location: /VIP/VIP');
    die();

}
if ($users["grade"] == 3 && $_POST["plan"] == 1) {
    $_SESSION["error"] = "Vous êtes déjà abonné à un plan, veuillez attendre la date d'expiration de votre abonnement pour en choisir un autre";
    header('location: /VIP/VIP');
    die();

}
if ($users["grade"] == 2 && $_POST["plan"] == 2) {
    $_SESSION["error"] = "Vous êtes déjà abonné à un plan, veuillez attendre la date d'expiration de votre abonnement pour en choisir un autre";
    header('location: /VIP/VIP');
    die();

}
if ($users["grade"] == 3 && $_POST["plan"] == 2) {
    $_SESSION["error"] = "Vous êtes déjà abonné à ce plan";
    header('location: /VIP/VIP');
    die();
}

$_SESSION["PaymentIntent"] = $_POST;
if ($_POST['plan'] == 1) {
    $plan = 'Abonnement Back Packer';

}
if ($_POST['plan'] == 2) {
    $plan = 'Abonnement Explorateur';

}

\Stripe\Stripe::setApiKey($stripeSecretTest);
\Stripe\Stripe::setApiVersion("2024-04-10");

$price = $_POST['price'] * 100;

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $plan,
            ],
            'unit_amount' => $price,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'https://pcs-all.online/VIP/success',
    'cancel_url' => 'https://pcs-all.online/VIP/cancel',
]);
header ('Location: ' . $session->url);


