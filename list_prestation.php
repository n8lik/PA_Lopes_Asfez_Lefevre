<?php 
include 'includes/header.php'; 

// Connexion à la base de données
$conn = connectDB();

// Requête SQL pour récupérer les informations des demandes de prestations
$demandsSql = "SELECT * FROM ".DB_PREFIX."demande_prestation";
$offersSql = "SELECT * FROM ".DB_PREFIX."offre_prestation";

try {
    $demandsStmt = $conn->prepare($demandsSql);
    $demandsStmt->execute();
    $demandsResult = $demandsStmt->fetchAll(PDO::FETCH_ASSOC);

    $offersStmt = $conn->prepare($offersSql);
    $offersStmt->execute();
    $offersResult = $offersStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
?>

<div class="container">
    <h1 class="mt-5">Gestion des Prestations</h1>
    <div class="btn-group mb-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary" onclick="showDemands()">Demandes de Prestation</button>
        <button type="button" class="btn btn-secondary" onclick="showOffers()">Offres de Prestation</button>
    </div>

    <input class="form-control mb-3" id="searchInput" type="text" placeholder="Rechercher une prestation..." onkeyup="searchTable()">


    <div id="demandsSection" class="table-responsive">
        <h2>Demandes de Prestations</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Date de Début</th>
                    <th scope="col">fin</th>
                    <th scope="col">Type de Prestation</th>
                    <th scope="col">Description</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Pays</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($demandsResult)) {
                    foreach ($demandsResult as $row) {
                        echo '<tr onclick="window.location.href=\'profile_user.php?id=' . htmlspecialchars($row["id"]) . '\';" style="cursor:pointer">';
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["date_debut"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["date_fin"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["performance_type"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["city"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["country"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Aucune demande trouvée.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="offersSection" class="table-responsive" style="display:none;">
        <h2>Offres de Prestations</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Type de Prestation</th>
                    <th scope="col">Description</th>
                    <th scope="col">Ville</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($offersResult)) {
                    foreach ($offersResult as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["performance_type"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["city"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Aucune offre trouvée.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function showDemands() {
    document.getElementById('demandsSection').style.display = '';
    document.getElementById('offersSection').style.display = 'none';
    resetSearch();
}

function showOffers() {
    document.getElementById('demandsSection').style.display = 'none';
    document.getElementById('offersSection').style.display = '';
    resetSearch();
}

function resetSearch() {
    var searchInput = document.getElementById('searchInput');
    searchInput.value = ''; // Réinitialise la barre de recherche
    searchTable(); // Met à jour l'affichage des tables selon le nouveau filtre (qui est vide dans ce cas)
}

function searchTable() {
    var input, filter, tables, trs, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    tables = document.querySelectorAll(".table-responsive:not([style*='display: none']) table"); // Recherche seulement dans la table visible

    tables.forEach(function(table) {
        trs = table.getElementsByTagName("tr");
        for (var i = 1; i < trs.length; i++) { // Commence à 1 pour ignorer la ligne d'en-tête
            txtValue = trs[i].textContent || trs[i].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                trs[i].style.display = "";
            } else {
                trs[i].style.display = "none";
            }
        }
    });
}

</script>

<?php include 'includes/footer.php'; ?>
