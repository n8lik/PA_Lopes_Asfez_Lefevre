<?php
include 'includes/header.php'; // Assurez-vous que ce fichier contient le lien Bootstrap

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();

    $title = htmlspecialchars($_POST['title']);
    $performanceType = htmlspecialchars($_POST['performance_type']);
    $description = htmlspecialchars($_POST['description']);
    $paymentType = htmlspecialchars($_POST['payment_type']);
    $km = isset($_POST['km']) ? htmlspecialchars($_POST['km']) : null;
    $hours = isset($_POST['hours']) ? htmlspecialchars($_POST['hours']) : null;
    $sqm = isset($_POST['sqm']) ? htmlspecialchars($_POST['sqm']) : null;
    $city = htmlspecialchars($_POST['city']);

    $query = "INSERT INTO " . DB_PREFIX . "offre_prestation (title, performance_type, description, payment_type, km, hours, sqm, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute([$title, $performanceType, $description, $paymentType, $km, $hours, $sqm, $city]);
        echo "<p class='alert alert-success'>Offre de prestation ajoutée avec succès.</p>";
    } catch (Exception $e) {
        echo "<p class='alert alert-danger'>Erreur lors de l'ajout de l'offre de prestation : " . $e->getMessage() . "</p>";
    }
}
?>
<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Optionnel : Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<div class="container mt-5">
    <h1 class="mb-3">Créer une Offre de Prestation</h1>
    <form method="post" action="">
        <div class="form-group">
            <label for="title">Titre de l'offre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="performance_type">Type de Prestation</label>
            <input type="text" class="form-control" id="performance_type" name="performance_type" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="payment_type">Type de Paiement</label>
            <select class="form-control" id="payment_type" name="payment_type" required>
                <option value="">Sélectionnez un type</option>
                <option value="km">Au Kilomètre</option>
                <option value="hour">À l'Heure</option>
                <option value="sqm">Au Mètre Carré</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city">Ville</label>
            <input class="form-control" id="city" name="city" required></input>
        </div>

        <button type="submit" class="btn btn-primary">Créer Offre</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
// Script pour gérer l'affichage conditionnel des champs km, heures, sqm
</script>
<?php include 'includes/footer.php'; ?>
