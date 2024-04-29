<?php
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();

    // Vérifiez si l'utilisateur est connecté et récupérez l'ID de l'utilisateur
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!$userId) {
        echo "<p class='alert alert-danger'>Vous devez être connecté pour effectuer cette action.</p>";
        include 'includes/footer.php';
        exit; // Arrêt du script si l'utilisateur n'est pas connecté
    }

    $performanceType = htmlspecialchars($_POST['performance_type']);
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $startDate = htmlspecialchars(str_replace("T", " ", $_POST['date_debut']) . ":00");
    $endDate = htmlspecialchars(str_replace("T", " ", $_POST['date_fin']) . ":00");
    $zipCode = htmlspecialchars($_POST['zip_code']);
    $price = htmlspecialchars($_POST['price']);
    $city = htmlspecialchars($_POST['city']);
    $address = htmlspecialchars($_POST['address']);
    $country = htmlspecialchars($_POST['country']);

    // Vérifiez si les dates sont correctes
    if (strtotime($startDate) >= strtotime($endDate)) {
        $error = "La date de début doit être antérieure à la date de fin.";
    } else {
        // Préparez la requête SQL pour insérer les données dans la base de données
        $query = "INSERT INTO " . DB_PREFIX . "demande_prestation (user_id, performance_type, title, description, date_debut, date_fin, zip_code, price, city, address, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute([$userId, $performanceType, $title, $description, $startDate, $endDate, $zipCode, $price, $city, $address, $country]);
            echo "<p class='alert alert-success'>Prestation ajoutée avec succès.</p>";
        } catch (Exception $e) {
            echo "<p class='alert alert-danger'>Erreur lors de l'ajout de la prestation : " . $e->getMessage() . "</p>";
        }
    }
}
?>
<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Optionnel : Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<div class="container mt-5">
    <h1 class="mb-3">Demander une Prestation</h1>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <form method="post" action="">
        <!-- Form fields with Bootstrap styling -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="performance_type">Type de Performance</label>
                <input type="text" class="form-control" id="performance_type" name="performance_type" required>
            </div>
            <div class="form-group col-md-6">
                <label for="title">Titre</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group col-md-6">
                <label for="payment_type">Type de Rémunération</label>
                <select class="form-control" id="payment_type" name="payment_type" required onchange="handlePaymentTypeChange()">
                    <option value="">Sélectionnez un type</option>
                    <option value="km">Au Kilomètre</option>
                    <option value="hour">À l'Heure</option>
                    <option value="sqm">Au Mètre Carré</option>
                </select>
            </div>
            <div class="form-group col-md-6" id="km_input" style="display:none;">
                <label for="km">Kilomètres</label>
                <input type="number" class="form-control" id="km" name="km">
            </div>
            <div class="form-group col-md-6" id="hours_input" style="display:none;">
                <label for="hours">Heures</label>
                <input type="number" class="form-control" id="hours" name="hours">
            </div>
            <div class="form-group col-md-6" id="sqm_input" style="display:none;">
                <label for="sqm">Mètres Carrés</label>
                <input type="number" class="form-control" id="sqm" name="sqm">
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="date_debut">Date de Début (date et heure)</label>
                <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" required>
            </div>
            <div class="form-group col-md-6">
                <label for="date_fin">Date de Fin (date et heure)</label>
                <input type="datetime-local" class="form-control" id="date_fin" name="date_fin" required>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="zip_code">Code Postal</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
            </div>
            <div class="form-group col-md-4">
                <label for="price">Prix</label>
                <input type="number" class="form-control" id="price" name="price" required readonly>
            </div>

            <div class="form-group col-md-4">
                <label for="city">Ville</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
        </div>
        <div class="form-group">
            <label for="address">Adresse</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="country">Pays</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">Ajouter</button>
    </form>
</div>
<script>
function handlePaymentTypeChange() {
    var paymentType = document.getElementById('payment_type').value;
    var kmInput = document.getElementById('km_input');
    var hoursInput = document.getElementById('hours_input');
    var sqmInput = document.getElementById('sqm_input');

    // Initially hide all inputs
    kmInput.style.display = 'none';
    hoursInput.style.display = 'none';
    sqmInput.style.display = 'none';

    // Show and hide inputs based on selected payment type
    if (paymentType === 'km') {
        kmInput.style.display = 'block';
        calculatePrice();  // Recalculate price as soon as the type changes
    } else if (paymentType === 'hour') {
        hoursInput.style.display = 'none';
        calculateHours();  // Recalculate hours and price
        calculatePrice();
    } else if (paymentType === 'sqm') {
        sqmInput.style.display = 'block';
        calculatePrice();  // Recalculate price as soon as the type changes
    }
}

function calculateHours() {
    var startDate = new Date(document.getElementById('date_debut').value);
    var endDate = new Date(document.getElementById('date_fin').value);
    var diff = endDate - startDate;
    var hours = diff / 36e5; // Convert milliseconds to hours
    document.getElementById('hours').value = hours.toFixed(2);
    calculatePrice();  // Recalculate price after updating hours
}

function calculatePrice() {
    var paymentType = document.getElementById('payment_type').value;
    var priceInput = document.getElementById('price');
    var km = document.getElementById('km').value || 0;  // Use 0 as default value
    var hours = document.getElementById('hours').value || 0;  // Use 0 as default value
    var sqm = document.getElementById('sqm').value || 0;  // Use 0 as default value

    if (paymentType === 'km') {
        priceInput.value = (km * 2).toFixed(2);
    } else if (paymentType === 'hour') {
        priceInput.value = (hours * 12).toFixed(2);
    } else if (paymentType === 'sqm') {
        priceInput.value = (sqm * 5).toFixed(2);
    }
}

document.getElementById('payment_type').addEventListener('change', handlePaymentTypeChange);
document.getElementById('km').addEventListener('input', calculatePrice);
document.getElementById('hours').addEventListener('input', calculatePrice);
document.getElementById('sqm').addEventListener('input', calculatePrice);
document.getElementById('date_debut').addEventListener('change', calculateHours);
document.getElementById('date_fin').addEventListener('change', calculateHours);
</script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php include 'includes/footer.php'; ?>