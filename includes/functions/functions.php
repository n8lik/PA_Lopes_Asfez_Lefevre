<?php

/*
base de donnée prestataire : 
id
performance_type
title
description
comment 
disponibility
price_type
price
postal_code
city
address
country
is_validated

*/
//récupération des DB_HOST, DB_DATABASE, DB_USER, DB_PWD, DB_PORT

define("DB_PREFIX","pcsall_");
define("DB_DATABASE","pcsall_bdd");
define("DB_USER","root");
define("DB_PWD","");
define("DB_PORT","3306");
define("DB_HOST","localhost");



// fonction connexion base de donnée 
function connectDB(){

    try {
        $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . ";port=" . DB_PORT, DB_USER, DB_PWD);
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



function ajouterPrestation($performance_type, $title, $description, $date_debut, $date_fin, $zip_code, $price, $city, $address, $country) {
    $conn = connectDB();
    $sql = "INSERT INTO " . DB_PREFIX . "prestation (performance_type, title, description, date_deb, date_fin, zip_code, price, city, address, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$performance_type, $title, $description, $date_debut, $date_fin, $zip_code, $price, $city, $address, $country]);
        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de la prestation : " . $e->getMessage();
        return false;
    }
}
