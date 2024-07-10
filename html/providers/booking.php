<?php
require "../includes/header.php";
require "../vendor/autoload.php";

use GuzzleHttp\Client;


//Si l'utilisateur n'est pas connecté

if (!isConnected()) {
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");

    die();
}
if ($_SESSION["userId"] != $_GET["id"]) {
    echo '<div class="alert alert-danger" >
<div class="row">
    <h2>Vous n\'êtes pas habilité à voir cette page</h2>
</div>
</div>';


    exit;
}

if (isset($_POST["submit"])) {
    $client = new Client();
    $test = [
        'booking_id' => $_POST["booking_id"],
        'comment' => $_POST["comment"],
        'user_id' => $_SESSION["userId"]
    ];
    $response = $client->post('https://pcs-all.online:8000/addCommentProvider', [
        'json' => $test
    ]);
    $comment = json_decode($response->getBody()->getContents(), true);

    if ($comment["success"] == true) {
        echo '<div class="alert alert-success" >
        <div class="row">
            <h2>' . $comment["message"] . '</h2>
        </div>
        </div>';
    } else {
        echo '<div class="alert alert-danger" >
        <div class="row">
            <h2>' . $comment["message"] . '</h2>
        </div>
        </div>';
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];



    $client = new Client();
    $test = [
        'adsType' => 'performance',
        'id' => $id
    ];
    $response = $client->get('https://pcs-all.online:8000/getAllBookingByOwnerId/', [
        'json' => $test
    ]);
    $booking = json_decode($response->getBody()->getContents(), true);
    if ($booking["success"] == true) {



        // Trier les réservations par date de début et mettre celles qui sont passées dans un autre tableau)


        $bookings = $booking["bookings"];
        $user =  [];
        $ads = [];

        $bookingsPassed = [];
        $bookingsFuture = [];

        foreach ($bookings as $booking) {
            $date = new DateTime($booking["start_date"]);
            $now = new DateTime();
            $response = $client->get('https://pcs-all.online:8000/users/' . $booking["user_id"]);
            $bookeduser = json_decode($response->getBody()->getContents(), true);
            $users = $bookeduser["users"];

            $response = $client->get('https://pcs-all.online:8000/getPerformanceAdsInfo/' . $booking["performance_id"]);
            $adsI = json_decode($response->getBody()->getContents(), true);
            $adsInfo = $adsI["adsInfo"];

            array_push($ads, $adsInfo);

            array_push($user, $users);
            if ($date < $now) {
                array_push($bookingsPassed, $booking);
            } else {

                array_push($bookingsFuture, $booking);
            }
        }
    } else {
        $bookingsPassed = [];
        $bookingsFuture = [];
    }
    // Afficher les réservations passées

?>
    <div class="container" style="margin-top: 1em;">
        <div class="row">
            <h2>Vos réservations</h2>
        </div>
    </div>

    <div class="container" style="margin-top: 2em;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button style="color:black !important" class="nav-link active" id="future-tab" data-bs-toggle="tab" data-bs-target="#future" type="button" role="tab" aria-controls="future" aria-selected="true">Futures</button>
            </li>
            <li class="nav-item" role="presentation">
                <button style="color:black !important" class="nav-link" id="passed-tab" data-bs-toggle="tab" data-bs-target="#passed" type="button" role="tab" aria-controls="passed" aria-selected="false">Passées</button>
            </li>
        </ul>


        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="future" role="tabpanel" aria-labelledby="future-tab">
                <div class="container" style="margin-top: 2em;">
                    <div class="row">
                        <?php if (empty($bookingsFuture)) { ?>
                            <div class="col-12">
                                <h2>Aucune réservation future trouvée</h2>
                            </div>
                        <?php } else { ?>
                            <?php foreach ($bookingsFuture as $key => $booking) {
                                $adsInfo = $ads[$key];
                                $traveler = $user[$key];

                            ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card" style="width: 100%; margin-bottom: 1em !important;">
                                            <div class="card-body d-flex flex-row align-items-center">
                                                <?php if ($booking["performance_id"] != null) {

                                                    $type = "housing";
                                                } else {
                                                    $type = "performances";
                                                }
                                                ?>
                                                <?php if (isset($booking["image"])) { ?>
                                                    <img src="<?= $booking["image"] ?>" class="img-fluid" alt="Photo de <?= $booking["title"] ?>" style="max-width: 20%; margin-right: 1em;">
                                                <?php } else {
                                                    echo '<img src="x" class="img-fluid" alt="Photo de ' . $booking["title"] . '" style="max-width: 20%; margin-right: 1em;">';
                                                } ?>
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title"><strong> <?= $booking["title"] ?></strong></h5>
                                                    <p class="card-text">Du
                                                        <?php
                                                        echo date("d/m/Y", strtotime($booking["start_date"]));
                                                        echo " à ";
                                                        $date = new DateTime($booking["start_date"]);
                                                        echo $date->format('H:i');
                                                        echo " au ";
                                                        echo date("d/m/Y", strtotime($booking["end_date"]));
                                                        echo " à ";
                                                        $date = new DateTime($booking["end_date"]);
                                                        echo $date->format('H:i');
                                                        ?>
                                                        <br>

                                                        <br>
                                                        Pseudo du locataire : <?php echo $traveler["pseudo"]; ?>
                                                        <br>
                                                        Nom du locataire : <?php echo $traveler["firstname"] . " " . $traveler["lastname"]; ?>

                                                        <br>
                                                        Prix : <?= $booking["price"] ?>€
                                                        <br>
                                                        Nombre de voyageurs : <?= $booking["amount_people"] ?>
                                                    </p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <?php
                                                    if ($booking["performance_id"] != null) {
                                                        // modale d'évaluation

                                                    ?> <a href="/privateMessage/addConversation?id=<?php echo $adsInfo['id']; ?>&type=performance&id_booking=<?php echo $booking[0] ?>" class="btn btn-primary mb-2">Contacter le locataire</a>

                                                    <?php
                                                        echo '<a href="/ads?id=' . $booking["performance_id"] . '&type=performance" class="btn btn-primary">Voir l\'annonce</a>';
                                                    } else {
                                                        echo '<a href="/ads?id=' . $booking["performance_id"] . '&type=performance" class="btn btn-primary">Voir l\'annonce</a>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="passed" role="tabpanel" aria-labelledby="passed-tab">
                <div class="container" style="margin-top: 2em;">
                    <div class="row">
                        <?php if (empty($bookingsPassed)) { ?>
                            <div class="col-12">
                                <h2>Aucune réservation passée trouvée</h2>
                            </div>
                        <?php } else { ?>
                            <?php foreach ($bookingsPassed as $key => $booking) {
                                $traveler = $user[$key];
                                $adsInfo = $ads[$key];
                            ?>

                                <!-- Modalle d'évaluation-->
                                <div class="modal fade" id="modalEvaluation" tabindex="-1" aria-labelledby="modalEvaluationLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEvaluationLabel">Évaluer le locataire</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body ">
                                                <form action="" method="post">
                                                    <div class="mb-3">
                                                        <label for="comment" class="form-label">Commentaire</label>
                                                        <textarea oninput="updateCounter()" class="form-control" name="comment" id="comment" rows="3" placeholder="Description du rendez-vous... Avis général... Réussite ou non du rendez-vous" required></textarea>
                                                        <p>Caractères : <span id="charCount">0</span></p>

                                                    </div>


                                                    <input type="hidden" name="booking_id" value="<?php echo $booking[0]; ?>">
                                                    <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card" style="width: 100%; margin-bottom: 1em !important;">
                                            <div class="card-body d-flex flex-row align-items-center">
                                                <?php if ($booking["performance_id"] != null) {

                                                    $type = "housing";
                                                } else {
                                                    $type = "performances";
                                                }
                                                ?>
                                                <?php if (isset($booking["image"])) { ?>
                                                    <img src="<?= $booking["image"] ?>" class="img-fluid" alt="Photo de <?= $booking["title"] ?>" style="max-width: 20%; margin-right: 1em;">
                                                <?php } else {
                                                    echo '<img src="x" class="img-fluid" alt="Photo de ' . $booking["title"] . '" style="max-width: 20%; margin-right: 1em;">';
                                                } ?>
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title"><strong> <?= $booking["title"] ?></strong></h5>
                                                    <p class="card-text">Du
                                                        <?php
                                                        echo date("d/m/Y", strtotime($booking["start_date"]));
                                                        echo " à ";
                                                        $date = new DateTime($booking["start_date"]);
                                                        echo $date->format('H:i');
                                                        echo " au ";
                                                        echo date("d/m/Y", strtotime($booking["end_date"]));
                                                        echo " à ";
                                                        $date = new DateTime($booking["end_date"]);
                                                        echo $date->format('H:i');
                                                        ?>
                                                        <br>

                                                        <br>
                                                        Pseudo du locataire : <?php echo $traveler["pseudo"]; ?>
                                                        <br>
                                                        Nom du locataire : <?php echo $traveler["firstname"] . " " . $traveler["lastname"]; ?>

                                                        <br>
                                                        Prix : <?= $booking["price"] ?>€
                                                        <br>
                                                        Nombre de voyageurs : <?= $booking["amount_people"] ?>
                                                    </p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="/privateMessage/addConversation?id=<?php echo $adsInfo['id']; ?>&type=performance&id_booking=<?php echo $booking[0] ?>" class="btn btn-primary mb-2">Contacter le locataire</a>
                                                    <?php
                                                    if ($booking["performance_id"] != null) {
                                                        echo '<button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalEvaluation">Évaluer le locataire</button>';

                                                        echo '<a href="/ads?id=' . $booking["housing_id"] . '&type=housing" class="btn btn-primary">Voir l\'annonce</a>';
                                                    } else {
                                                        echo '<a href="/ads?id=' . $booking["performance_id"] . '&type=performance" class="btn btn-primary">Voir l\'annonce</a>';
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCounter() {
            const textarea = document.getElementById('comment');
            const charCount = document.getElementById('charCount');
            charCount.textContent = textarea.value.length;
        }
    </script>
<?php
} else {
    echo '<div class="alert alert-danger" >
    <div class="row">
        <h2>Vous n\'êtes pas habilité à voir cette page</h2>
    </div>
    </div>';
}
include '../includes/footer.php';
