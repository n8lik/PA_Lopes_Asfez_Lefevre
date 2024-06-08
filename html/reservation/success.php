<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require '../vendor/autoload.php';


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
$start_date = $paymentIntent["s-date"];
$end_date = $paymentIntent["e-date"];
$amount_people = $paymentIntent["amount_people"];
$title = $paymentIntent["title"];


try {
    $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
    $response = $client->post('/addBooking', [
        'json' => [
            'title' => $title,
            'id' => $id,
            'type' => $type,
            'price' => $price,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'amount_people' => $amount_people,
            'userId' => $userId
        ]
    ]);
    $booking = json_decode($response->getBody()->getContents(), true);
   
    if ($booking["success"]) {
        unset($_SESSION["PaymentIntent"]);
        $_SESSION["booking"] = 0;
    } else {
        unset($_SESSION["PaymentIntent"]);
        $_SESSION["booking"] = 1;
    }

} catch (Exception $e) {
    echo $e->getMessage();
    die();
} 
finally{
    header("Location: /reservation/booking?id=$id&type=$type");
    die();
}





var_dump($_SESSION["PaymentIntent"]);
?>