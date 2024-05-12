<?php
require "../includes/header.php";
isConnected();
?>

<div class="container mt-3">
    <h2>Ajouter une prestation</h2>
    <?php
    if (isset($_SESSION['listOfErrorsPresta']) && is_array($_SESSION['listOfErrorsPresta'])) { ?>
        <div class="text-danger">
            <ul>
                <?php foreach ($_SESSION['listOfErrorsPresta'] as $error) : ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php
        unset($_SESSION['listOfErrorsPresta']);
    }
    ?>
    <form action="includes/prestation_add" method="post">
        <div class="container mt-3">
            <div class="form-group">
                <label for="performance_type">Type de Prestation:</label>
                <select class="form-control" id="performance_type" name="performance_type" required>
                    <option value="">--Sélectionnez le type de prestation--</option>
                    <option value="Nettoyage du logement">Nettoyage du logement</option>
                    <option value="Changement des ampoules">Changement des ampoules</option>
                    <option value="Petits travaux de plomberie">Petits travaux de plomberie</option>
                    <option value="Réparation du mobilier">Réparation du mobilier</option>
                    <option value="Transport de et vers aéroport">Transport de et vers aéroport</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price_type">Type de Tarif:</label>
                <select class="form-control" id="price_type" name="price_type" required onchange="handlePriceTypeChange()">
                    <option value="">--Sélectionnez le type de tarif--</option>
                    <option value="km">Kilomètres</option>
                    <option value="hour">Heures</option>
                    <option value="fixed">Prix fixe</option>
                </select>
            </div>

            <div class="form-group" id="kmInput" style="display:none;">
                <label for="km_cost">Coût par kilomètre (€) :</label>
                <input type="text" class="form-control" id="km_cost" name="km_cost" placeholder="Coût par km" onblur="formatDecimal(this)">
            </div>

            <div class="form-group" id="hourInput" style="display:none;">
                <label for="hour_cost">Coût par heure (€) :</label>
                <input type="text" class="form-control" id="hour_cost" name="hour_cost" placeholder="Coût par heure" onblur="formatDecimal(this)">
            </div>

            <div class="form-group" id="fixedPriceInput" style="display:none;">
                <label for="price">Prix fixe :</label>
                <input type="text" class="form-control" step="1.00" id="price" name="price" placeholder="Entrez le prix" onblur="formatDecimal(this)">
            </div>



            <div class="form-group">
                <label for="title">Titre:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>




            <div class="form-group">
                <label for="city_appointment">Décrivez dans quels endroit vous acceptez les rendez-vous:</label>
                <input type="text" class="form-control" id="city_appointment" name="appointment_location" required>
            </div>
            <div class="form-group">
                <label>Disponibilités:</label>
                <?php
                $days = [
                    'monday' => 'Lundi', 'tuesday' => 'Mardi', 'wednesday' => 'Mercredi',
                    'thursday' => 'Jeudi', 'friday' => 'Vendredi', 'saturday' => 'Samedi', 'sunday' => 'Dimanche'
                ];
                foreach ($days as $key => $day) {
                ?>
                    <div class="row">
                        <div class="form-check">
                            <input type="hidden" name="availability[<?php echo $key ?>]" value="0">
                            <input class="form-check-input" type="checkbox" name="availability[<?php echo $key ?>]" id="<?php echo $key ?>" value="1" onchange="toggleDayHours(this)">
                            <label class="form-check-label" for="<?php echo $key ?>">
                                <?php echo $day ?>
                            </label>
                            <div class="input-group col-md-2" id="<?php echo $key ?>_hours" style="display:none;">
                                <label>Heures de disponibilité:</label>
                                
                                <input type="time" class="form-control col-md-6" style="width: 100% !important;" name="hours[<?php echo $key ?>][start]" id="hours_<?php echo $key ?>_start" placeholder="Heure de début" >
                                <input type="time" class="form-control col-md-6" style="width: 100% !important;" name="hours[<?php echo $key ?>][end]" id="hours_<?php echo $key ?>_end" placeholder="Heure de fin" >
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <button type="submit" class="btn btn-primary" name="addsubmit">Ajouter Prestation</button>
        </div>
    </form>
</div>

<script src="includes/js/prestation.js"></script>


<?php include 'includes/footer.php';
?>