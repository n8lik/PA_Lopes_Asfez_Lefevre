<?php 
include 'header.php';

include 'functions.php';

//connexion à la base de donnée
$connection = connectDB();

?>
<!-- formulaire de création de prestatire -->

<form>
    <!--base de donnée prestataire : 
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
is_validated-->
<!--pour peformance type un choix multiple entre taxi, ménage et autre-->
    <label for="performance_type">Type de prestation</label>
    <select name="performance_type" id="performance_type">
        <option value="taxi">Taxi</option>
        <option value="ménage">Ménage</option>
        <option value="autre">Autre</option>
    </select>

    <br>
    <label for="title">Titre</label>
    <input type="text" name="title" id="title" required>
    <br>
    <label for="description">Description</label>
    <input type="text" name="description" id="description" required>
    <br>
    
    <label for="disponibility">Disponibilité</label>
    <input type="text" name="disponibility" id="disponibility" required>
    <br>
    <label for="postal_code">Code postal</label>
    <input type="text" name="postal_code" id="postal_code" required>
    <br>
    <label for="city">Ville</label>
    <input type="text" name="city" id="city" required>
    <br>
    <label for="address">Adresse</label>
    <input type="text" name="address" id="address" required>
    <br>
    <label for="country">Pays</label>
    <input type="text" name="country" id="country" required>
    <br>
    <label for="is_validated">Validation</label>
    <input type="text" name="is_validated" id="is_validated" required>
    <br>
    <input type="submit" value="Créer">
    
</form>
w


<?php

//traitement du formulaire
if (!empty($_POST)) {
    $performance_type = $_POST['performance_type'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $disponibility = $_POST['disponibility'];
    $postal_code = $_POST['postal_code'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $is_validated = $_POST['is_validated'];

    //préparation de la requête
    $query = $connection->prepare("INSERT INTO prestataire (performance_type, title, description, disponibility, postal_code, city, address, country, is_validated) VALUES (:performance_type, :title, :description, :disponibility, :postal_code, :city, :address, :country, :is_validated)");

    //execution de la requête
    $query->execute([
        'performance_type' => $performance_type,
        'title' => $title,
        'description' => $description,
        'disponibility' => $disponibility,
        'postal_code' => $postal_code,
        'city' => $city,
        'address' => $address,
        'country' => $country,
        'is_validated' => $is_validated
    ]);

    echo "Prestataire créé";

}


	include 'footer.php';
    ?>