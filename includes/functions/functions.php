<?php

require '/var/www/html/includes/conf.inc.php';

// fonction connexion base de donnée 
function connectDB()
{
    try {
        $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PWD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {
        echo "Erreur SQL " . $e->getMessage();
        exit;
    }
}

// vérification si l'utilisateur est connecté
function isConnected()
{
    if (isset($_SESSION['email'])) {
        return true;
    }else{
    return false;
        header("../../login.php");
    }

}


// fonction de nettoyage des données

function cleanLastName($name)
{
    $name = trim($name);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    $name = ucfirst($name);
    return $name;
}

function cleanMail($mail)
{
    $mail = trim($mail);
    $mail = strip_tags($mail);
    $mail = htmlspecialchars($mail);
    $mail = strtolower($mail);
    return $mail;
}
function cleanFirstName($name)
{
    $name = trim($name);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    $name = ucfirst($name);
    return $name;
}

// fonction pour calculer les prix 

function price_calcul($type){
    
}

// fonction insertion BDD form location

function insertHousing($title, $experienceType,$id_user, $propertyAddress, $propertyCity, $propertyZip, $propertyCountry, $propertyType, $rentalType, $bedroomCount, $guestCapacity, $propertyArea, $price, $contactPhone, $time){
    $db = connectDB();    

    $queryprepare = $db->prepare("INSERT INTO housing (title, id_user, management_type, address, city, postal_code, country, type_house, type_location, ammount_room, guest_capacity, property_area, price, contact_phone, contact_time) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    

    try {
        $queryprepare->execute([$title, $id_user, $experienceType, $propertyAddress, $propertyCity, $propertyZip, $propertyCountry, $propertyType, $rentalType, $bedroomCount, $guestCapacity, $propertyArea, $price, $contactPhone, $time]);
      
    } catch (PDOException $e) {
        print("Erreur lors de l'exécution de la requête : " . $e->getMessage());
    }
    

}

function contactTime($timeSlot1, $timeSlot2, $timeSlot3) {
    if ($timeSlot1==1 && $timeSlot2==0 && $timeSlot3==0){
        return "avant 13h"; 
    }   

    else if ($timeSlot1==0 && $timeSlot2==1 && $timeSlot3==0){
        return "entre 13h et 18h";    

    }
    else if ($timeSlot1==0 && $timeSlot2==0 && $timeSlot3==1){
        return " après 18h";
    }
    else if ($timeSlot1==1 && $timeSlot2==1 && $timeSlot3==0){
        return "avant 13h et max 18h"; 
    }
    else if ($timeSlot1==1 && $timeSlot2==0 && $timeSlot3==1){
        return "avant 13h et après 18h";
    }
    else if ($timeSlot1==0 && $timeSlot2==1 && $timeSlot3==1){
         return " à partir de 13h et après 18h";
    }
    else if ($timeSlot1==1 && $timeSlot2==1 && $timeSlot3==1){
        return "tout le temps"; 
    }
}

function getUserById($id){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE id = ?");
    $req->execute([$id]);
    return $req->fetch();
}