<?php
require '../includes/header.php';

$userId = $_SESSION['userId'];
$user = getUserById($userId);

if (!isConnected()) {
    header('Location: ../login.php');
}
if ($user['grade'] != 5) {
    header('Location: /');
}
?>


<link href="../../css/bailleur.css" rel="stylesheet">


<div class="container border-form mt-5">
    <center>
        <h2 class="mb-4 ">Je propose mon service !</h2>
    </center>
    <?php if ($_SESSION["errorAddP"] != '') { ?>
        <div><?php 
            echo $_SESSION["errorAddP"]; ?></div>
    <?php };
            $_SESSION["errorAddP"] = ""; ?>
    <form method="POST" action="action?type=add">

        <div class="form-group">
            <label for="Title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Titre de l'annonce" value="<?php if(isset($_SESSION['data']["title"])){echo $_SESSION['data']["title"];}?>" required>


        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"  placeholder="Description de l'annonce" value="<?php if(isset($_SESSION['data']["description"])){echo $_SESSION['data']["description"];}?>" required></textarea>
        </div>
        <div class="form-group">
            <label for="experienceType">Quel type de service proposez-vous ?</label>
            <select class="form-control" id="performance_type" name="performance_type" required>
                <option value="taxi">Taxi</option>
                <option value="cleaning">Ménage</option>
                <option value="plombier">Plomberie</option>
                <option value="menuisier">Menuisier</option>
                <option value="entretien">Travaux d'entretien</option>
                <option value="paysagiste">Paysagiste</option>
                <option value="electricien">Electricien</option>
                <option value="peintre">Peintre</option>
                <option value="chauffagiste">Chauffagiste</option>
                <option value="other">Autre : précisez</option>
            </select>
            <input type="text" id="otherField" name="otherField" class="form-control" style="display:none;" placeholder="Précisez le type de service" >
        </div>

            <label for="place-input">Lieu d'action</label>
            
            <?php include 'map.php'; ?>

        
            <br>

            <label for="propertyAddress">Adresse de facturation</label>
            <div class="form-row">


                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="address_appointment" name="address_appointment" placeholder="Adresse" value="<?php if(isset($_SESSION['data']["address_appointment"])){echo $_SESSION['data']["address_appointment"];}?>" required>
                </div>

                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="city_appointment" name="city_appointment" placeholder="Ville" value="<?php if(isset($_SESSION['data']["city_appointment"])){echo $_SESSION['data']["city_appointment"];}?>" required>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="zip_appointment" name="zip_appointment" placeholder="Code postal"  value="<?php if(isset($_SESSION['data']["zip_appointment"])){echo $_SESSION['data']["zip_appointment"];}?>" required>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control" id="country_appointment" name="country_appointment" required>

                        <option value="France">France</option>
                        <option value="Belgique">Belgique</option>
                        <option value="Suisse">Suisse</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Allemagne">Allemagne</option>
                        <option value="Royaume-Uni">Royaume-Uni</option>
                        <option value="Espagne">Espagne</option>
                        <option value="Italie">Italie</option>
                        <option value="Pays-Bas">Pays-Bas</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Autriche">Autriche</option>
                        <option value="Suède">Suède</option>
                        <option value="Danemark">Danemark</option>
                        <option value="Finlande">Finlande</option>
                        <option value="Norvège">Norvège</option>
                        <option value="Grèce">Grèce</option>
                        <option value="Irlande">Irlande</option>
                        <option value="Pologne">Pologne</option>
                        <option value="République tchèque">République tchèque</option>
                        <option value="Slovaquie">Slovaquie</option>
                        <option value="Hongrie">Hongrie</option>
                        <option value="Roumanie">Roumanie</option>
                        <option value="Bulgarie">Bulgarie</option>
                        <option value="Croatie">Croatie</option>
                        <option value="Slovénie">Slovénie</option>
                        <option value="Estonie">Estonie</option>
                        <option value="Lettonie">Lettonie</option>
                        <option value="Lituanie">Lituanie</option>
                        <option value="Malte">Malte</option>
                        <option value="Chypre">Chypre</option>
                    </select>
                </div>
            </div>

            <div class="form-groupe">
                <label for="price" class="form-label">Prix</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="<?php if(isset($_SESSION['data']["price"])){echo $_SESSION['data']["price"];}?>" required>
                <label for="price_type">Prix par</label>
                <select class="form-control" id="price_type" name="price_type" required>
                    <option value="" disabled selected>Sélectionnez une unité</option>

                    <option id="kmField" name="kmField" style="display:block;">km</option>
                    <option id="sqmField" name="sqmField" style="display:none;">m²</option>
                    <option id="chauffagisteField" name="chauffagisteField" style="display:none;">prestation</option>

                    <option id="entretienField" name="entretienField" style="display:none;">prestation</option>
                    <option id="plombierField" name="plombierField" style="display:none;">prestation</option>
                    <option id="peintreField" name="peintreField" style="display:none;">prestation</option>
                    <option id="menuisierField" name="menuisierField" style="display:none;">prestation</option>
                    <option id="paysagisteField" name="paysagisteField" style="display:none;">prestation</option>
                    <option id="cleaningField" name="cleaningField" style="display:none;">prestation</option>
                    <option id="wallField" name="wallField" style="display:none;">mur</option>



                    <option>heure</option>
                </select>
            </div>


            <div class="form-group">
                <input type="checkbox" name="acceptation" id="acceptation" required>
                <label for="acceptation">J'accepte la déclaration de confidentialité et les conditions générales d'utilisation</label>
            </div>


            <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>


    </form>
</div>
<script>
    var selectBox = document.getElementById('performance_type');

    function showOtherField($id, $id_showed) {

        var userInput = document.getElementById($id_showed);
        userInput.style.display = selectBox.value == $id ? 'block' : 'none';
    }


    selectBox.addEventListener('change', function() {
        showOtherField('other', 'otherField');
    });


    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";
        showOtherField('taxi', 'kmField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";

        showOtherField('cleaning', 'cleaningField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";

        showOtherField('plombier', 'plombierField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";

        showOtherField('menuisier', 'menuisierField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";
        showOtherField('entretien', 'entretienField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";
        showOtherField('paysagiste', 'paysagisteField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";
        showOtherField('electricien', 'electricienField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";
        showOtherField('peintre', 'peintreField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";
        showOtherField('peintre', 'wallField')
    });
    selectBox.addEventListener('change', function() {
        document.getElementById('price_type').value = "";
        showOtherField('chauffagiste', 'chauffagisteField')
    });
</script>

<?php



include '../includes/footer.php';
