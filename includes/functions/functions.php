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
include 'conf.inc.php';

// fonction connexion base de donnée 
function connectDB()
{

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
    }
    return false;
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

