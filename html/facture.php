<?php
ob_start(); // Start output buffering


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'vendor/autoload.php';


use GuzzleHttp\Client;
use Dompdf\Dompdf;
if ($_SESSION["grade"] == 4) {
    $type = "housing";
} else if ($_SESSION["grade"] == 5) {
    $type = "performance";
} else {
    $_SESSION["error"] = "Vous n'avez pas les droits pour accéder à cette page";
    header("Location: index.php");
    exit();
}

try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $firstDay = date('Y-m-01');
    $lastDay = date('Y-m-t');
    $id = $_SESSION['userId'];
    $test = [
        'firstDay' => $firstDay,
        'lastDay' => $lastDay,
        'id' => $id
    ];
    $response = $client->get('/getBookingByDate', [
        'json' => $test
    ]);
    $data = json_decode($response->getBody()->getContents(), true);

} catch (Exception $e) {
    $data = [];
}

$bookingTitles = [];
$price = 0;
foreach ($data["bookings"] as $booking) {
    $price += $booking["price"];
    array_push($bookingTitles, $booking["title"]);
}
$dompdf = new Dompdf();

$details = '<div class="details">
    <h2>Voici vos informations</h2>';
if ($type == "housing") {
    $details .= '<p>Voici tous les logements que vous avez loués ce mois-ci pour un total de : ' . $price . ' €</p>';
} else if ($type == "performance") {
    $details .= '<p>Voici toutes les prestations que vous avez faites pour un prix total de : ' . $price . ' €</p>';
}
$details .= '<ul>';
foreach ($bookingTitles as $title) {
    $details .= '<li>' . $title . '</li>';
}
$details .= '</ul></div>';

$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Résumé des réservations de ' . date('F Y') . '</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            margin: 5px 0;
        }
        .details ul {
            list-style-type: none;
            padding: 0;
        }
        .details li {
            margin: 5px 0;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Résumé des réservations de ' . date('F Y') . '</h1>
        ' . $details . '
        <div class="footer">
            <p>Merci pour votre confiance.</p>
        </div>
    </div>
</body>
</html>';


// Load HTML into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Clear the output buffer
ob_end_clean();

$filename = "facture_du_mois_de". date("Y-M") ;
$dompdf->stream($filename , array("Attachment" => true));
unlink($filename . '.pdf');

?>