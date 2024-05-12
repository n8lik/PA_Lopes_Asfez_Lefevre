<?php
require 'functions/functions.php';
$conn = connectDB(); 

$sql = "SELECT * FROM rendez_vous"; 
$stmt = $conn->prepare($sql);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($events); 

$conn = null;
