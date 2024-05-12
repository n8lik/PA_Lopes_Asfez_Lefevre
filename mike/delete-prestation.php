<?php
require 'includes/header.php';
$user_id = $_SESSION['userId'];
$prestations = getPerformanceByIdUserAndIdPerf($user_id, $_GET['id']);


$conn = connectDB();


$id = $_GET['id'];
if ($_GET['id'] == $prestations['id']) {
    deletePerformanceById($id);
    header("Location: mes-prestation.php");
    exit;
}

if (isset($_SESSION['grade']) && $_SESSION['grade'] == '6') {
    deletePerformanceById($id);
    header("Location: list-prestation.php");
    exit;
}

?>





