<?php

require "../functions/functions.php";
session_start();
$conn = connectDB();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $RdvId = $_POST['id'];
    accepterPrestation($RdvId); 
    header("Location: ../demande-Rdv.php");
}
?>
