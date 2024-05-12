<?php
require 'includes/header.php';
$user_id = $_SESSION['userId'];
$prestations = getPerformanceByIdUserAndIdPerf($user_id, $_GET['id']);



if ($_GET['id'] != $prestations['id']) {
    header("Location: mes-prestation.php");
}
?>
<div class="container mt-3">
    <h2>Modifier une prestation</h2>
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
    <form action="includes/prestation_edit" method="post">
        <input type="hidden" name="id_perf" value="<?php echo $prestations['id'] ?>">
            <div class="form-group">
                <label for="performance_type">Type de Prestation:</label>
                <select class="form-control" id="performance_type" name="performance_type" required>
                    <option value="">--Sélectionnez le type de prestation--</option>
                    <option value="Nettoyage du logement" <?php if ($prestations['performance_type'] === 'Nettoyage du logement') echo 'selected'; ?>>Nettoyage du logement</option>
                    <option value="Changement des ampoules" <?php if ($prestations['performance_type'] === 'Changement des ampoules') echo 'selected'; ?>>Changement des ampoules</option>
                    <option value="Petits travaux de plomberie" <?php if ($prestations['performance_type'] === 'Petits travaux de plomberie') echo 'selected'; ?>>Petits travaux de plomberie</option>
                    <option value="Réparation du mobilier" <?php if ($prestations['performance_type'] === 'Réparation du mobilier') echo 'selected'; ?>>Réparation du mobilier</option>
                    <option value="Transport de et vers aéroport" <?php if ($prestations['performance_type'] === 'Transport de et vers aéroport') echo 'selected'; ?>>Transport de et vers aéroport</option>
                </select>
            </div>

        <div class="form-group">
            <label for="price_type">Type de Tarif:</label>
            <select class="form-control" id="price_type" name="price_type" required onchange="handlePriceTypeChange()">
                <option value="">--Sélectionnez le type de tarif--</option>
                <option value="km" <?php if ($prestations['price_type'] === 'km') echo 'selected'; ?>>Kilomètres</option>
                <option value="hour" <?php if ($prestations['price_type'] === 'hour') echo 'selected'; ?>>Heures</option>
                <option value="fixed" <?php if ($prestations['price_type'] === 'fixed') echo 'selected'; ?>>Prix fixe</option>
            </select>
        </div>

        <div class="form-group" id="kmInput" style="display:<?php echo ($prestations['price_type'] === 'km') ? 'block' : 'none';?>" >
            <label for="km_cost">Coût par kilomètre (€) :</label>
            <input type="text" class="form-control" id="km_cost" name="km_cost" placeholder="Coût par km" onblur="formatDecimal(this)" value="<?php echo htmlspecialchars($prestations["km_cost"])?>">
        </div>
       

        <div class="form-group" id="hourInput" style="display:<?php echo ($prestations['price_type'] === 'hour') ? 'block' : 'none';?>" >
            <label for="hour_cost">Coût par heure (€) :</label>
            <input type="text" class="form-control" id="hour_cost" name="hour_cost" placeholder="Coût par heure" onblur="formatDecimal(this)" value="<?php echo htmlspecialchars($prestations["hour_cost"])?>">
        </div>


        <div class="form-group" id="fixedPriceInput" style="display:<?php echo ($prestations['price_type'] === 'fixed') ? 'block' : 'none';?>" >
            <label for="price">Prix fixe :</label>
            <input type="text" class="form-control" step="1.00" id="price" name="price" placeholder="Entrez le prix" onblur="formatDecimal(this)" value="<?php echo htmlspecialchars($prestations["price"])?>">
        </div>



        <div class="form-group">
            <label for="title">Titre:</label>
            <input type="text" class="form-control" value="<?php echo $prestations["title"]?>" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($prestations['description']);?></textarea>
        </div>




        <div class="form-group">
            <label for="city_appointment">Décrivez dans quels endroit vous acceptez les rendez-vous:</label>
            <input type="text" class="form-control" id="city_appointment" name="appointment_location" required value="<?php echo htmlspecialchars($prestations["appointment_location"])?>">
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
                        <input class="form-check-input" type="checkbox" name="availability[<?php echo $key ?>]" id="<?php echo $key ?>" value="1" onchange="toggleDayHours(this)" <?php if ($prestations[$key] == '1') echo 'checked'; ?>>
                        <label class="form-check-label" for="<?php echo $key ?>">
                            <?php echo $day ?>
                        </label>
                        <div class="input-group col-md-2" id="<?php echo $key ?>_hours" style="display:none;">
                            <label>Heures de disponibilité:</label>

                            <input type="time" class="form-control col-md-6" style="width: 100% !important;" name="hours[<?php echo $key ?>][start]" id="hours_<?php echo $key ?>_start" placeholder="Heure de début" value="<?php echo htmlspecialchars($prestations[$key."_start_time"])?>">
                            <input type="time" class="form-control col-md-6" style="width: 100% !important;" name="hours[<?php echo $key ?>][end]" id="hours_<?php echo $key ?>_end" placeholder="Heure de fin" value="<?php echo htmlspecialchars($prestations[$key."_end_time"])?>">
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





<?php include 'includes/footer.php'; ?>