<?php
session_start();
require '../../includes/functions/functions.php';

$connect = connectDB();
$getType = $_GET["type"];



$id_user = $_SESSION['userId'];
$house = getHousingById($id);

if ($getType == "delete") {
    $id = $_GET["id"];
    deleteHousingById($id);
    header("Location : houses.php");
}

if ($getType == "add") {

    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $experienceType = $_POST['experienceType'];

        $propertyAddress = $_POST['propertyAddress'];
        $propertyCity = $_POST['propertyCity'];
        $propertyZip = $_POST['propertyZip'];
        $propertyCountry = $_POST['propertyCountry'];
        if ($_POST['propertyType'] == 'other') {
            $propertyType = $_POST['otherField'];
        } else {
            $propertyType = $_POST['propertyType'];
        }
        $rentalType = $_POST['rentalType'];
        $bedroomCount = $_POST['bedroomCount'];
        $guestCapacity = $_POST['guestCapacity'];
        $propertyArea = $_POST['propertyArea'];
        $price = $_POST['price'];
        $contactPhone = $_POST['contactPhone'];
        $timeSlot1 = isset($_POST['timeSlot1']) ? $_POST['timeSlot1'] : $_POST['timeSlot1_hidden'];
        $timeSlot2 = isset($_POST['timeSlot2']) ? $_POST['timeSlot2'] : $_POST['timeSlot2_hidden'];
        $timeSlot3 = isset($_POST['timeSlot3']) ? $_POST['timeSlot3'] : $_POST['timeSlot3_hidden'];

        $time = contactTime($timeSlot1, $timeSlot2, $timeSlot3);

        $errorMessage = '';


        // vérification que le formulaire est rempli avec de bonnes informations (regex)
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $title)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le titre doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $propertyAddress)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">L\'adresse doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $propertyCity)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La ville doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[0-9]{5}$/", $propertyZip)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le code postal doit contenir 5 chiffres.</div>';
        }
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $propertyCountry)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le pays doit contenir entre 3 et 50 caractères.</div>';
        }
        if (!preg_match("/^[0-9]{1,2}$/", $bedroomCount)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le nombre de chambres doit être compris entre 1 et 2 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{1,2}$/", $guestCapacity)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La capacité d\'accueil doit être comprise entre 1 et 2 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{1,4}$/", $propertyArea)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La surface doit être comprise entre 1 et 4 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{1,4}$/", $price)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le prix doit être compris entre 1 et 4 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{10}$/", $contactPhone)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le numéro de téléphone doit contenir 10 chiffres.</div>';
        }
        if (!isset($_POST['acceptation'])) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Vous devez accepter les conditions générales d\'utilisation.</div>';
        }
        if ($experienceType == '') {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Vous devez choisir un type de gestion.</div>';
        }


        if ($errorMessage === '') { // Si aucune erreur n'est présente, exécuter la fonction d'insertion
            insertHousing($title, $experienceType, $id_user, $propertyAddress, $propertyCity, $propertyZip, $propertyCountry, $propertyType, $rentalType, $bedroomCount, $guestCapacity, $propertyArea, $price, $contactPhone, $time);
            // envoyé une popup qui confirme l'envoi du formulaire et boutonpour revenir à l'accueil ou envoie d'un nouveau formulaire
            echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement.');</script>";
        } else {
            $_SESSION["errorAdd"] = $errorMessage;

            header("Location: addAHouse.php");
        }
    }
}

if ($getType == 'update') {
    $id = $_GET["id"];
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];

        $experienceType = $_POST['management_type'];
        $title = $_POST['title'];
        $typeLocation = $_POST['type_location'];
        $ammountRoom = $_POST['ammount_room'];
        $guestCapacity = $_POST['guest_capacity'];
        $propertyArea = $_POST['property_area'];
        $contactPhone =  $_POST['contact_phone'];
        $price = $_POST['price'];
        $timeSlot1 = isset($_POST['timeSlot1']) ? $_POST['timeSlot1'] : $_POST['timeSlot1_hidden'];
        $timeSlot2 = isset($_POST['timeSlot2']) ? $_POST['timeSlot2'] : $_POST['timeSlot2_hidden'];
        $timeSlot3 = isset($_POST['timeSlot3']) ? $_POST['timeSlot3'] : $_POST['timeSlot3_hidden'];

        $time = contactTime($timeSlot1, $timeSlot2, $timeSlot3);

        $errorMessage = '';


        // vérification que le formulaire est rempli avec de bonnes informations (regex)
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $title)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le titre doit contenir entre 3 et 50 caractères.</div>';
        }

        if (!preg_match("/^[0-9]{1,2}$/", $ammountRoom)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le nombre de chambres doit être compris entre 1 et 2 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{1,2}$/", $guestCapacity)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La capacité d\'accueil doit être comprise entre 1 et 2 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{1,4}$/", $propertyArea)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La surface doit être comprise entre 1 et 4 chiffres.</div>';
        }
        // regex prix compris entre 0.00 et 9999.99 
        if (!preg_match('/^(\d{1,4}(\.\d{1,2})?|9999(\.00)?)$/', $price)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le prix doit être compris entre 1 et 4 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{10}$/", $contactPhone)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le numéro de téléphone doit contenir 10 chiffres.</div>';
        }

        if ($experienceType == '') {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Vous devez choisir un type de gestion.</div>';
        }


        if ($errorMessage === '') { // Si aucune erreur n'est présente, exécuter la fonction d'insertion
            updateHousing($id, $title, $type_location, $ammountRoom, $experienceType, $guestCapacity, $propertyArea, $contactPhone, $time);
            echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement.');</script>";
            echo "<script> window.location.href='houses.php';</script>";

        } else {
            $_SESSION["errorModify"] = $errorMessage;

            header("Location: modifyAHouse.php?id=" . $id);
        }
    }
}

if ($getType == "addFiles") {
    $id = $_GET["id"];
    $user = getUserById($userId);
    $housing = getHousingById($id);



    if (isset($_POST['submit'])) {
        $errors = [];
        $type = $_POST['type'];
        $usertype = $_GET['usertype'];
        $target_dir = "/externalFiles/" . $usertype . "/";
        $originalFileName = $_FILES["file"]["name"];

        if ($id != '' && $user['id'] == $housing['id_user']) {
            $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            if ($extension != "pdf" && $extension != "jpg" && $extension != "jpeg" && $extension != "png") {
                $errors = '<div class="alert alert-danger" role="alert">Désolé, seuls les fichiers PDF, JPG, JPEG et PNG sont autorisés.</div>';
                
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
