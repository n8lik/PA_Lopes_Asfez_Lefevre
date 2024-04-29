<?php

require 'includes/header.php';


if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $experienceType = $_POST['experienceType'];
    $propertyAddress = $_POST['propertyAddress'];
    $propertyCity = $_POST['propertyCity'];
    $propertyZip = $_POST['propertyZip'];
    $propertyCountry = $_POST['propertyCountry'];
    $propertyType = $_POST['propertyType'];
    $rentalType = $_POST['rentalType'];
    $bedroomCount = $_POST['bedroomCount'];
    $guestCapacity = $_POST['guestCapacity'];
    $propertyArea = $_POST['propertyArea'];
    $price = $_POST['price'];
    $contactPhone = $_POST['contactPhone'];
    $userId = $_SESSION['id'];
    $timeSlot1 = isset($_POST['timeSlot1']) ? $_POST['timeSlot1'] : $_POST['timeSlot1_hidden'];
    $timeSlot2 = isset($_POST['timeSlot2']) ? $_POST['timeSlot2'] : $_POST['timeSlot2_hidden'];
    $timeSlot3 = isset($_POST['timeSlot3']) ? $_POST['timeSlot3'] : $_POST['timeSlot3_hidden'];

    $time = contactTime($timeSlot1, $timeSlot2, $timeSlot3);

    $errorMessage='';
    

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
    
    

    if ($errorMessage === '') { // Si aucune erreur n'est présente, exécuter la fonction d'insertion
    
    insertHousing($title, $userId, $experienceType, $propertyAddress, $propertyCity, $propertyZip, $propertyCountry, $propertyType, $rentalType, $bedroomCount, $guestCapacity, $propertyArea, $price, $contactPhone, $time);
    // envoyé une popup qui confirme l'envoi du formulaire et boutonpour revenir à l'accueil ou envoie d'un nouveau formulaire
    echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement.');</script>";
    echo "<script>window.location.href='index.php';</script>";

    }
    
}
?>


<link href="css/bailleur.css" rel="stylesheet">


<div class="container border-form mt-5">
    <h2 class="mb-4 ">Je fais une demande de simulation personnalisée</h2>
    <?php if ($errorMessage != ''){?>
        <div><?php echo $errorMessage; ?></div>
    <?php }; ?>
    <form method="POST" action="">

        <div class="form-group">
            <label for="Title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Titre de l'annonce" required>


        </div>
        <div class="form-group">
            <label for="experienceType">Quel type d'expérience souhaitez-vous ?</label>
            <select class="form-control" id="experienceType" name="experienceType" required>
                <option>Gestion de A à Z</option>
                <option>Yield Management</option>
                <option>Autre</option>
            </select>
        </div>

        <label for="propertyAddress">Adresse complète de votre propriété en location courte durée</label>
        <div class="form-row">


            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="propertyAddress" name="propertyAddress" placeholder="Adresse" required>
            </div>

            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="propertyCity" name="propertyCity" placeholder="Ville" required>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="propertyZip" name="propertyZip" placeholder="Code postal" required>
            </div>
        </div>



        <div class="form-group">
            <label for="propertyCountry">Pays de votre propriété en location courte durée</label>
            <input type="text" class="form-control" id="propertyCountry" name="propertyCountry" placeholder="Pays" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="propertyType">Type de bien</label>
                <select class="form-control" name="propertyType" id="propertyType" required>
                    <option>Appartement</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="rentalType">Type de location</label>
                <select class="form-control" name="rentalType " id="rentalType" required>
                    <option>Logement complet</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="bedroomCount">Nombre de chambres</label>
                <input type="number" class="form-control" name="bedroomCount" id="bedroomCount" required>
            </div>
            <div class="form-group col-md-6">
                <label for="guestCapacity">Capacité d'accueil</label>
                <input type="number" class="form-control" name="guestCapacity" id="guestCapacity" required>
            </div>
        </div>

        <div class="form-group">
            <label for="propertyArea">Surface en m²</label>
            <input type="number" class="form-control" name="propertyArea" id="propertyArea" required>
        </div>
        <div class="form-group">
            <label for="price">Prix à la nuit (en €)</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <div class="form-group">
            <label for="contactPhone">Téléphone</label>
            <input type="tel" class="form-control" id="contactPhone" name="contactPhone" required>
        </div>

        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" value="1" name="timeSlot1" id="timeSlot1">
            <input type="hidden" name="timeSlot1_hidden" value="0">
            <label class="form-check-label" for="timeSlot1">Avant 13h00</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" value="1" name="timeSlot2" id="timeSlot2">
            <input type="hidden" name="timeSlot2_hidden" value="0">
            <label class="form-check-label" for="timeSlot2">13h00 - 18h00</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" value="1" name="timeSlot3" id="timeSlot3">
            <input type="hidden" name="timeSlot3_hidden" value="0">
            <label class="form-check-label" for="timeSlot3">Après 18h00</label>
        </div>



        <div class="form-group">
            <input type="checkbox" name="acceptation" id="acceptation" required>
            <label for="acceptation">J'accepte la déclaration de confidentialité et les conditions générales d'utilisation</label>
        </div>


        <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
    </form>
</div>
<?php



require 'includes/footer.php';
