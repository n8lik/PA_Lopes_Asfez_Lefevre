<?php
require 'includes/header.php';
session_start();

if (isset($_GET['choice'])) {
    $choice = $_GET['choice'];
    switch ($choice) {
        case 'housing':
            $content = getCatalogByType($choice, 'all');
?>
            <link rel="stylesheet" href="css/catalog.css">
            <div class="container" style="margin-top: 1em;">
                <div class="row">
                    <h2> Où souhaitez-vous séjourner ?</h2>
                </div>
                <div class="row" style=" background-color: #34656D;border-radius:1em; padding:0.5em;">
                    <div class="col-12">
                        <form class="d-flex">
                            <input id="destinationInput" class="form-control me-2" type="text" placeholder="Destination" aria-label="Search" required> <input class="form-control me-2" type="date" placeholder="Date d'arrivée" aria-label="Search" required>
                            <input class="form-control me-2" type="date" placeholder="Date de départ" aria-label="Search" required>
                            <input class="form-control me-2" type="number" placeholder="Nombre de voyageurs" aria-label="Search" min="1" max="10" required>
                            <button class="btn btn-outline-light" type="submit">Rechercher</button>
                        </form>
                    </div>
                </div>
            </div>

        <?php
            break;
        case 'performance':
            $content = getCatalogByType($choice, 'all');

        ?>
            <div class="container" style="margin-top: 1em;">
                <div class="row">
                    <h2> Quelle activité souhaitez-vous découvrir ?</h2>
                </div>
                <div class="row" style=" background-color: #34656D;border-radius:1em; padding:0.5em;">
                    <div class="col-12">
                        <form class="d-flex">
                            <input class="form-control me-2" type="text" placeholder="Activité" aria-label="Search" required>
                            <input class="form-control me-2" type="date" placeholder="Date" aria-label="Search" required>
                            <button class="btn btn-outline-light" type="submit">Rechercher</button>
                        </form>
                    </div>
                </div>
            </div>
<?php
            break;
        default:
            header('Location: /index.php');
            break;
    }
    echo '<center>';
    echo '<div class="container" style="margin: 2em;">'; // Début du container
    //Affichage du contenu sous forme de mosaique
    echo '<div class="row">'; // Début de la rangée
    foreach ($content as $item) {
        echo '<div class="col-lg-3 col-md-6 col-12">'; // Colonne avec gestion responsive
        echo '<div class="card" style="width: 18rem;">
            <img src="/externalFiles/ads/' . $choice . '/' . $item['id'] . '_' . $item['id_user'] . '_1.jpg" class="card-img-top" alt="Image of ' . $item['title'] . '">
            <div class="card-body">
                <h5 class="card-title">' . $item['title'] . '</h5>
                <p class="card-text">' . $item['description'] . '</p>
                <a href="#" class="btn btn-primary">Voir plus</a>
            </div>
        </div>';
        echo '</div>'; // Fin de la colonne
    }

    echo '</div>'; // Fin de la rangée
    echo '</div>'; // Fin du container
    echo '</center>';
} else {
    header('Location: /index.php');
}
include 'includes/footer.php';
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfTvwEttd84Lx7xTxVqNk85d6z3CaDYrE&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    function initAutocomplete() {
        var input = document.getElementById('destinationInput');
        var options = {
            types: ['(cities)'], // Limite la recherche aux villes uniquement
        };
        new google.maps.places.Autocomplete(input, options);
    }
</script>