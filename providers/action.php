<?php
session_start();
require '../includes/functions/functions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connect = connectDB();
$getType = $_GET["type"];



$userId = $_SESSION['userId'];
echo $userId;

if ($getType == "delete") {
    $id = $_GET["id"];
    deletePerformance($id);
    header("Location : performances.php");
}

if ($getType == "add") {
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $address_appointment = $_POST['address_appointment'];
        $city_appointment = $_POST['city_appointment'];
        $zip_appointment = $_POST['zip_appointment'];
        $country_appointment = $_POST['country_appointment'];
        $price = $_POST['price'];
        $price_type = $_POST['price_type'];
        $fee = $price * 0.20;
        $place = $_POST['place'];
        $radius = $_POST['radiusSlider'];
        $performance_type = $_POST['performance_type'];
        if ($performance_type == 'other') {
            $performance_type = $_POST['otherField'];
        }
        $errorMessage = '';

        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $title)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le titre doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $address_appointment)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">L\'adresse doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $city_appointment)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La ville doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[0-9]{5}$/", $zip_appointment)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le code postal doit contenir 5 chiffres.</div>';
        }
        if ($radius < 1 || $radius > 50) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le rayon de déplacement doit être compris entre 1 et 50 km.</div>';
        }
        if ($errorMessage === '') {

            insertPerformance($title, $description, $performance_type, $address_appointment, $city_appointment, $zip_appointment, $country_appointment, $price, $price_type, $userId, $fee, $place, $radius);
            echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement.');</script>";
            echo "<script>window.location.href='/';</script>";
        } else {

            $_SESSION['data'] = $_POST;
            $_SESSION["errorAddP"] = $errorMessage;
            header("Location: addAPerformance.php");
        }
    }
}

if ($getType == 'update') {
    $id = $_GET["id"];
    $userId = $_SESSION['userId'];
    $performance = getPerformanceById($id);
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $address_appointment = $_POST['address_appointment'];
        $city_appointment = $_POST['city_appointment'];
        $zip_appointment = $_POST['zip_appointment'];
        $country_appointment = $_POST['country_appointment'];
        $price = $_POST['price'];
        $price_type = $_POST['price_type'];
        $fee = $price * 0.20;
        $place = $_POST['place'];
        $radius = $_POST['radiusSlider'];
        $errorMessage = '';

        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $title)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le titre doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $address_appointment)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">L\'adresse doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $city_appointment)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La ville doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[0-9]{5}$/", $zip_appointment)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le code postal doit contenir 5 chiffres.</div>';
        }
        if ($radius < 1 || $radius > 50) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le rayon de déplacement doit être compris entre 1 et 50 km.</div>';
        }
        if ($errorMessage === '') {
            updatePerformance($id, $title, $description, $address_appointment, $city_appointment, $zip_appointment, $country_appointment, $price, $price_type, $userId, $fee, $place, $radius);
            echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement.');</script>";
            echo "<script>window.location.href='/';</script>";
        } else {
            $_SESSION['data'] = $_POST;
            $_SESSION["errorUpdateP"] = $errorMessage;
            header("Location: modifyAPerformance.php?id=" . $id);
        }
    }
}

if ($getType == "addFiles") {
    $id = $_GET["id"];
    $user = getUserById($userId);
    $performance = getPerformanceById($id);



    if (isset($_POST['submit'])) {
        $errors = [];
        $type = $_POST['type'];
        $usertype = $_GET['usertype'];
        $target_dir = "/externalFiles/" . $usertype . "/";
        $originalFileName = $_FILES["file"]["name"];

        if ($id != '' && $user['id'] == $performance['id_user']) {
            $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            if ($extension != "pdf" && $extension != "jpg" && $extension != "jpeg" && $extension != "png") {
                $errors .= '<div class="alert alert-danger" role="alert">Désolé, seuls les fichiers PDF, JPG, JPEG et PNG sont autorisés.</div>';
            }
            $newFileName = $type . "_" . $user["id"] . "_" . $id . "." . $extension;

            $target_file = $target_dir . $newFileName;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement.');</script>";
                echo "<script> window.location.href='../filesAdd.php?id=" . $id . "';</script>";
            } else {
                $errors = '<div class="alert alert-danger" role="alert">Désolé, il y a eu une erreur lors du téléchargement de votre fichier.</div>';
                $_SESSION['errorFile'] = $errors;
                header("Location: ../filesAdd.php?id=" . $id);
            }
        } else {
            header("Location: houses.php");
        }
    }
}
