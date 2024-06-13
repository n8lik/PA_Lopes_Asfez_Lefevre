<?php

require "../../includes/header.php";
require "../../vendor/autoload.php";

use GuzzleHttp\Client;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Si l'utilisateur n'est pas connecté

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $client = new Client();
    $response = $client->get('https://pcs-all.online:8000/getAllBookingByOwnerId/'.$id);
    $booking = json_decode($response->getBody()->getContents(), true);

}

if ($booking["success"]== true){

    $booking = $booking["bookings"];
    foreach ($booking as $book){
        echo "<div class='card'>";
        echo "<div class='card-header'>";
        echo "<h2>Logement: ".$book["title"]."</h2>";
        echo "</div>";
        echo "<div class='card-body'>";
        echo "<p>Locataire: ".$book["tenant"]."</p>";
        echo "<p>Date de début: ".$book["start_date"]."</p>";
        echo "<p>Date de fin: ".$book["end_date"]."</p>";
        echo "<p>Montant: ".$book["amount"]."€</p>";
        echo "</div>";
        echo "</div>";
    }
}