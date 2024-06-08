<?php
require '../vendor/autoload.php';
require 'secrets.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$_SESSION["PaymentIntent"] = $_POST;

\Stripe\Stripe::setApiKey($stripeSecretTest);
\Stripe\Stripe::setApiVersion("2024-04-10");

$price = $_POST['price'] * 100;

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $_POST['title'],
            ],
            'unit_amount' => $price,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'https://pcs-all.online/reservation/success',
    'cancel_url' => 'https://pcs-all.online/reservation/cancel',
]);
header ('Location: ' . $session->url);

?>

