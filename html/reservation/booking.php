<?php


$pageTitle = "Réservation";
require '../includes/header.php';
require '../vendor/autoload.php';
session_start();

use GuzzleHttp\Client;

if (!isset($_SESSION["userId"])) {
    header("Location: /login");
    die();
}

if (!isset($_GET["id"]) || !isset($_GET["type"])) {
    header("Location: /");
    die();
}



$id = $_GET["id"];
$type = $_GET["type"];

$client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
$response = $client->get($type == 'housing' ? '/housingDisponibility/' . $id : '/performanceDisponibility/' . $id);
$disponibility = json_decode($response->getBody()->getContents(), true)['disponibility'];

$response = $client->get($type == 'housing' ? '/housingAdsImages/' . $id : '/performanceAdsImages/' . $id);
$images = json_decode($response->getBody()->getContents(), true)['images'];

$response = $client->get($type == 'housing' ? '/getHousingAdsInfo/' . $id : '/getPerformanceAdsInfo/' . $id);
$ad = json_decode($response->getBody()->getContents(), true)['adsInfo'];


?>
<div class="terms-container">
    <div class="container" style="margin-top: 1em;">
        <div class="row">
            <center>
                <h1><strong>Réservation</strong></h1>
                <hr>
            </center>
        </div>
        <?php if (isset($_SESSION["booking"])) {
            if ($_SESSION["booking"] == 0) {
        ?>
                <div class="alert alert-success" role="alert">
                    Votre réservation a été effectuée avec succès. Vous recevrez votre facture par mail sous peu.
                </div>
            <?php
                unset($_SESSION["booking"]);
            } else {
            ?>
                <div class="alert alert-danger" role="alert">
                    Une erreur est survenue lors de la réservation.
                </div>
        <?php
                unset($_SESSION["booking"]);
            }
        }
        if (!isset($disponibility)){
            echo '<div class="alert alert-danger" role="alert">Aucune disponibilité n\'est renseignée pour cette annonce.</div>';
        } else{
        ?>
        <div class="row" style="height: 40vh;">
            <div class="col-8" style="height: 100%;">
                <div class="row" style="height: 100%;">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="height: 100%;">
                        <div class="carousel-inner" style="height: 100%;">
                            <?php
                            if (isset($images)){
                            for ($i = 0; $i < count($images); $i++) {
                                $image = $images[$i];
                                echo '<div class="carousel-item' . ($i == 0 ? ' active' : '') . '" style="height: 100%;">';
                                echo '<img src="' . $image . '" class="d-block w-100" alt="Image ' . $i . '" style="height: 100%; object-fit: cover;">';
                                echo '</div>';
                            }
                        }
                            ?>
                        </div>
                        <a class="carousel-control-prev" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4" style="height: 100%;">
                <div id='calendar' style="height: 100%;"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <br>
                <h2><?php echo $ad['title']; ?></h2>
                <p><?php echo $ad['city']; ?>, <?php echo $ad['country']; ?> - L'adresse exacte vous sera communiquée après la réservation.</p>
            </div>
            <div class="col-4" style="text-align: right;">
                <p> Selectionnez les dates de votre séjour</p>
                <p><?php echo $ad['price']; ?> €/nuit</p>
            </div>
            <hr>
            <div class="row">
                <?php if ($type== 'housing'){ ?>
                <div class="col-8">
                    <?php echo $ad['guest_capacity']; ?> personnes - <?php echo $ad['property_area']; ?> m² - <?php echo $ad['amount_room']; ?> chambres
                    <br>
                    <p><strong>Description:</strong> <?php echo $ad['description']; ?></p>
                </div>
                <div class="col-4">
                    <p>Date de début: <strong id="start-date"></strong>
                        <br>
                        Date de fin: <strong id="end-date"></strong>
                        <br>
                        Total: <strong id="total-price"></strong>
                    </p>
                    <!-- Formulaire de paiement -->
                    <form id="payment-form" method="POST" action="payment">
                        <label for="amount_people">Nombre de personnes</label>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" required>
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <input type="number" name="amount_people">

                        <input type="hidden" id="s-date" name="s-date" value="">
                        <input type="hidden" id="e-date" name="e-date" value="">
                        <input type="hidden" id="price" name="price" value="">
                        <input type="hidden" name="title" value="<?php echo $ad['title'] ?>">
                        <div id="card-element"></div>

                        <div id="card-errors" role="alert"></div>
                        <button id="submit">Payer</button>
                    </form>
                </div>
                <?php } else { ?>
                <div class="col-8">
                    <p><strong>Description:</strong> <?php echo $ad['description']; ?></p>
                </div>
                <?php }} ?>
            </div>
        </div>
    </div>
</div>
<?php  

require '../includes/footer.php';
?>
<script src="https://js.stripe.com/v3/"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
<script>
    // Récupérer les disponibilités et créer les événements pour FullCalendar
    let disponibility = <?php echo json_encode($disponibility); ?>;
    let events = [];
    let availableDates = new Set();

    // Ajoutez des événements pour toutes les dates de disponibilité
    for (let i = 0; i < disponibility.length; i++) {
        let date = disponibility[i]['date'];
        let isBooked = disponibility[i]['is_booked'];
        if (!isBooked) {
            availableDates.add(date);
        }
        events.push({
            start: date,
            display: 'background',
            backgroundColor: isBooked ? 'lightgray' : 'green'
        });
    }

    //faire un console.log pour voir les dates
    console.log(availableDates);

    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: '100%', // Hauteur du container
        events: events,
        selectable: true,
        select: function(info) {
            let startDate = info.startStr;
            let endDate = info.endStr;
            let date = new Date(endDate);
            date.setDate(date.getDate() - 1);
            endDate = date.toISOString().split('T')[0];
            console.log(endDate);
            //si il n'y a qu'un jour de séléctionné, on indique une erreur
            if (startDate == endDate) {
                alert("Veuillez sélectionner au moins deux jours.");
                return;
            }

            if (availableDates.has(startDate) && availableDates.has(endDate)) {
                document.getElementById('start-date').textContent = startDate;
                document.getElementById('end-date').textContent = endDate;

                let totalPrice = calculateTotalPrice(startDate, endDate, <?php echo $ad['price']; ?>);
                document.getElementById('total-price').textContent = totalPrice + " €";
                document.getElementById('price').value = totalPrice;

                document.getElementById('s-date').value = startDate;
                document.getElementById('e-date').value = endDate;



            } else {
                alert("Veuillez sélectionner uniquement les dates disponibles.");
            }
        },
        dayCellDidMount: function(info) {
            if (availableDates.has(info.dateStr)) {
                info.el.style.backgroundColor = 'green';
            } else {
                info.el.style.backgroundColor = 'lightgray';
            }
        }
    });
    calendar.render();

    function calculateTotalPrice(startDate, endDate, pricePerNight) {
        let start = new Date(startDate);
        let end = new Date(endDate);
        let nights = (end - start) / (1000 * 60 * 60 * 24);
        return nights * pricePerNight;
    }


    // Gestion des flèches du carousel
    $('.carousel-control-prev').click(function() {
        $('#carouselExampleControls').carousel('prev');
    });

    $('.carousel-control-next').click(function() {
        $('#carouselExampleControls').carousel('next');
    });
</script>