<?php
require 'includes/header.php';
require 'vendor/autoload.php';

//Afficher les erreurs

use GuzzleHttp\Client;

if (isset($_GET['choice'])) {
    $choice = $_GET['choice'];
    switch ($choice) {
        case 'housing':
            if (isset($_POST['destination'])) {
                $destination = $_POST['destination'];
                $arrivalDate = $_POST['arrivalDate'];
                $departureDate = $_POST['departureDate'];
                $travelers = $_POST['travelers'];
                $content = getHousingCatalogBySearch($destination, $arrivalDate, $departureDate, $travelers);
                unset($_POST);
            } else {
                $client = new Client();
                $response = $client->request('GET', 'http://localhost:8000/getAllCatalogByChoice/' . $choice);
                $content = json_decode($response->getBody(), true)['catalog'];
            }
?>
            <link rel="stylesheet" href="css/catalog.css">
            <div class="container" style="margin-top: 1em;">
                <div class="row">
                    <h2> Où souhaitez-vous séjourner ?</h2>
                </div>
                <div class="row" style=" background-color: #34656D;border-radius:1em; padding:0.5em;">
                    <div class="col-12">
                        <form class="d-flex" action="catalog?choice=housing" method="POST">
                            <input name="destination" id="destinationInput" class="form-control me-2" type="text" placeholder="Destination" aria-label="Search" required>
                            <input name="arrivalDate" class="form-control me-2" type="date" placeholder="Date d'arrivée" aria-label="Search">
                            <input name="departureDate" class="form-control me-2" type="date" placeholder="Date de départ" aria-label="Search">
                            <input name="travelers" class="form-control me-2" type="number" placeholder="Nombre de voyageurs" aria-label="Search" min="1" max="10">
                            <button class="btn btn-outline-light" type="submit">Rechercher</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            if (isset($destination) && !empty($destination)) {
                echo '<center><div class="container" style="margin-top: 2em;">';
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<h2> Résultats pour ' . $destination . '</h2>';
                echo '</div>';
                echo '</div>';
                echo '</div></center>';
            }

            break;
        case 'performance':
            if (isset($_POST['activity'])) {
                $activity = $_POST['activity'];
                $date = $_POST['date'];
                $content = getPerformanceCatalogBySearch($activity, $date);
                unset($_POST);
            } else {
                $client = new Client();
                $response = $client->request('GET', 'http://localhost:8000/getAllCatalogByChoice/' . $choice);
                $content = json_decode($response->getBody(), true)['catalog'];
            }

            ?>
            <div class="container" style="margin-top: 1em;">
                <div class="row">
                    <h2> Quelle activité souhaitez-vous découvrir ?</h2>
                </div>
                <div class="row" style=" background-color: #34656D;border-radius:1em; padding:0.5em;">
                    <div class="col-12">
                        <form class="d-flex">
                            <input name="activity" class="form-control me-2" type="text" placeholder="Activité" aria-label="Search" required>
                            <input name="date" class="form-control me-2" type="date" placeholder="Date" aria-label="Search">
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
    if (isset($content) && !empty($content)) {
        echo '<center>';
        echo '<div class="container" style="margin: 2em;">';
        //Affichage du contenu sous forme de mosaique
        echo '<div class="row">';
        foreach ($content as $item) {
            echo '<div class="col-lg-3 col-md-6 col-12">';
            echo '<div class="card" style="width: 18rem; margin-bottom :1em !important;">
            <img src="/externalFiles/ads/' . $choice . '/' . $item['id'] . '_' . $item['id_user'] . '_1.jpg" class="card-img-top" alt="Image of ' . $item['title'] . '">
            <div class="card-body" >
                <h5 class="card-title">' . $item['title'] . '</h5>
                <p class="card-text">' . $item['description'] . '</p>
                <a href="/ads.php?id=' . $item['id'] . '&type=' . $choice . '" class="btn btn-primary">Voir plus</a>
            </div>
                </div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</center>';
    } else {
        echo '<center>';
        echo '<div class="container" style="margin: 2em;">';
        echo '<div class="row">';
        echo '<div class="col-12">';
        echo '<h2> Aucun résultat trouvé</h2>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</center>';
    }
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
            //Limites aux villes
            types: ['(cities)'],
        };
        new google.maps.places.Autocomplete(input, options);
    }
</script>