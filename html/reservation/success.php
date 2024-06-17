<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require '../vendor/autoload.php';


session_start();

use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if (!isset($_SESSION["userId"])) {
    header("Location: /login");
    die();
}

if (!isset($_SESSION["PaymentIntent"])) {
    header("Location: /");
    die();
}
$token = $_SESSION["token"];
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
            's_date' => $start_date,
            'e_date' => $end_date,
            'amount_people' => $amount_people,
            'userId' => $userId
        ]
    ]);
    $booking = json_decode($response->getBody()->getContents(), true);
    $idresa = $booking["id"];
   
    if ($booking["success"]) {
        unset($_SESSION["PaymentIntent"]);
        $_SESSION["booking"] = 0;
        header('location: /pdf/sendmail?id='.$idresa.'&user='.$token);
   
        

    } else {
        unset($_SESSION["PaymentIntent"]);
        $_SESSION["booking"] = 1;
    }

} catch (Exception $e) {
    echo $e->getMessage();
    die();
} 




?>