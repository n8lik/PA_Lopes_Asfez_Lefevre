<link rel="stylesheet" href="css/ads.css">
<?php
require 'includes/header.php';
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$userId = $_SESSION['userId'];

$id = $_GET['id'];
$type = $_GET['type'];


try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    if ($type == 'housing') {
        $response = $client->get('/getHousingAdsInfo/' . $id);
    } else {
        $response = $client->get('/getPerformanceAdsInfo/' . $id);
    }
    $content = json_decode($response->getBody()->getContents(), true)['adsInfo'];
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

// Ajouter les disponibilités
if (isset($_POST['new_disponibility']) && !empty($_POST['new_disponibility'])) {
    $disponibility = json_decode($_POST['new_disponibility'], true);
    foreach ($disponibility as $date) {
        try {
            $client = new Client([
                'base_uri' => 'https://pcs-all.online:8000'
            ]);
            $test = [
                'id' => $id,
                'type' => $type,
                'date' => $date
            ];

            $response = $client->post('/addAdsDisponibility', [
                'json' => $test
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
    unset($_POST['new_disponibility']);
}

// Récupérer les disponibilités
$client = new Client([
    'base_uri' => 'https://pcs-all.online:8000'
]);
if ($type == 'housing') {
    $response = $client->get('/housingDisponibility/' . $id);
} else {
    $response = $client->get('/performanceDisponibility/' . $id);
}
$disponibility = json_decode($response->getBody()->getContents(), true);

if ($disponibility['success'] == false && $_SESSION['grade'] != 4 && $_SESSION['userId'] != $content['id_user']) {
    header('Location:/');
    exit();
}

// Gestion message Like
if (isset($_SESSION['likeSuccess'])) {
    echo '<div class="alert alert-success" role="alert" style="text-align:center !important">' . $_SESSION['likeSuccess'] . '</div>';
    unset($_SESSION['likeSuccess']);
}
if (isset($_SESSION['likeError'])) {
    echo '<div class="alert alert-danger" role="alert" style="text-align:center !important">' . $_SESSION['likeError'] . '</div>';
    unset($_SESSION['likeError']);
}

// Récupérer la note moyenne
try {
    $client = new Client();
    $response = $client->post('https://pcs-all.online:8000/getAverageRate', [
        'json' => [
            'id' => $id,
            'type' => $type
        ]
    ]);
    $averageRate = json_decode($response->getBody()->getContents(), true)['average'];
    
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

// Récupérer les commentaires
try {
    $client = new Client();
    $response = $client->post('https://pcs-all.online:8000/getComments', [
        'json' => [
            'id' => $id,
            'type' => $type
        ]
    ]);

    $comments = json_decode($response->getBody()->getContents(), true);
    if ($comments['success'] == true){
        $comments = $comments['comments'];
    }
    else{
        $comments = null;
    }


} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
?>

<div class="container" style="margin-top: 2em; background-color:#FFFDF6; padding: 1em;">
    <div class="row">
        <div class="col-md-6">
            <div id="carrouselIndividualAds" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    try {
                        $client = new Client([
                            'base_uri' => 'https://pcs-all.online:8000'
                        ]);
                        if ($type == 'housing') {
                            $response = $client->get('/housingAdsImages/' . $id);
                        } else {
                            $response = $client->get('/performanceAdsImages/' . $id);
                        }
                        $data = json_decode($response->getBody()->getContents(), true);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        die();
                    }

                    if ($data['success']) {
                        $images = $data['images'];
                        $active = true;
                        foreach ($images as $image) {
                            echo '<div class="carousel-item';
                            if ($active) {
                                echo ' active';
                                $active = false;
                            }
                            echo '">';
                            echo '<img src="' . $image . '" class="d-block w-100" style="border-radius:1em;" alt="image de ' . htmlspecialchars($content['title'], ENT_QUOTES, 'UTF-8') . '">';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>Pas d'images</p>";
                    }
                    ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carrouselIndividualAds" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carrouselIndividualAds" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <hr>
            <div class="ads-description">
                <h3>Description</h3>
                <p><?php echo $content['description']; ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <h2><?php echo $content['title']; ?></h2>
            <?php if ($type == 'housing') { ?>
                <div class="ads-localisation"><?php echo $content['type_location'] . ' à ' . $content['city'] . ', ' . $content['country']; ?></div>
                <div class="ads-price"><?php echo $content['type_house'] . '  -  ' . $content['guest_capacity'] . ' voyageurs  -  ' . $content['amount_room'] . ' chambres '; ?></div>
                <hr>
                <p>Publié par : <b>
                        <?php
                        $client = new Client([
                            'base_uri' => 'https://pcs-all.online:8000'
                        ]);
                        $response = $client->get('/users/' . $content['id_user']);
                        $body = json_decode($response->getBody()->getContents(), true);
                        echo $body['users']['pseudo'];
                        ?>
                    </b>
                </p>
                <div>
                    <?php /* if (isset($averageRate)){ ?>
                    Note : <?php echo $averageRate;} ?>/5
                        
                    <br>
                    <?php */
                    if(isset($comments)){?>
                    <div id="carrouselComments" class="carousel slide carrouselComments" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $active = true;
                            
                            foreach ($comments as $comment) {
                                echo '<div class="carousel-item';
                                if ($active) {
                                    echo ' active';
                                    $active = false;
                                }
                                echo '">';
                                echo '<div class="comment-box">';
                                echo '<p><strong>' . $comment['pseudo'] . ' </strong><br>';
                                echo $comment['review'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }

                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carrouselComments" data-bs-slide="prev">
                            <span class="fa fa-chevron-left" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carrouselComments" data-bs-slide="next">
                            <span class="fa fa-chevron-right" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                        <?php } ?>
                </div>
                <br>
                <div class="ads-price">Prix par nuit : <b><?php echo $content['price']; ?> €</b></div>
                <br>
                <?php if ($_SESSION['grade'] == 4 && $_SESSION['userId'] == $content['id_user']) { ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
                        Modifier les disponibilités
                    </button>
                    <div class="modal fade" id="addAvailabilityModal" tabindex="-1" aria-labelledby="addAvailabilityModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addAvailabilityModalLabel">Affichage des disponibilités</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="calendar"></div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="submitForm()">Confirmer les modifications</button>
                                    <form id="disponibilityForm" method="POST" action="">
                                        <input type="hidden" name="new_disponibility" id="newDisponibility" value="">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-12 button-container">
                            <form action="/reservation/booking" method="POST" class="d-flex w-100">
                                <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <a href="https://pcs-all.online/reservation/booking?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" class="btn btn-primary w-50 me-1">Réserver</a>
                                <a href="/privateMessage/addConversation?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" class="btn btn-secondary w-50">Contacter le propriétaire</a>
                            </form>
                        </div>
                    </div>
                <?php } ?>
                <br>
            <?php } elseif ($type == 'performance') { ?>
                <div class="ads-localisation"><?php echo $content['performance_type'] . ' à ' . $content['city_appointment'] . ', ' . $content['country_appointment']; ?></div>
                <hr>
                <div>
                    <?php /* if (isset($averageRate)){ ?>
                    Note : <?php echo $averageRate;} ?>/5
                    <?php  */
                    
                    if(isset($comments)){?>
                    <div id="carrouselComments" class="carousel slide carrouselComments" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $active = true;
                            foreach ($comments as $comment) {
                                echo '<div class="carousel-item';
                                if ($active) {
                                    echo ' active';
                                    $active = false;
                                }


                                echo '">';
                                echo '<div class="comment-box">';
                                echo '<p>' . $comment['review'] . '</p>';
                                echo '<p>Publié par : ' . $comment['pseudo'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carrouselComments" data-bs-slide="prev">
                            <span class="fa fa-chevron-left" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carrouselComments" data-bs-slide="next">
                            <span class="fa fa-chevron-right" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <?php } ?>
                </div>
                <p>Publié par : <b><?php
                                    $client = new Client([
                                        'base_uri' => 'https://pcs-all.online:8000'
                                    ]);
                                    $response = $client->get('/users/' . $content['id_user']);
                                    $body = json_decode($response->getBody()->getContents(), true);
                                    echo $body['users']['pseudo'];
                                    ?></b></p>
                <p>Description : <?php echo $content['description']; ?></p>
                <div class="ads-price">Prix : <b><?php echo $content['price']; ?> €</b></div>
                <br>
                <form action="/reservation/booking" method="POST">
                    <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                    <a href="https://pcs-all.online/reservation/booking?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" class="btn btn-primary">Réserver</a>
                    <a href="/privateMessage/addConversation?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" class="btn btn-secondary">Contacter le propriétaire</a>
                </form>
                <br>
            <?php } ?>
            <div class="row">
                <div class="col-md-6">
                    <?php if (isset($_SESSION['userId']) && $_SESSION['grade'] != 4 && $_SESSION['grade'] != 5) {
                        $client = new Client([
                            'base_uri' => 'https://pcs-all.online:8000'
                        ]);
                        $response = $client->post('/isLiked', [
                            'json' => [
                                'id' => $content['id'],
                                'type' => $type,
                                'userId' => $_SESSION['userId']
                            ]
                        ]);
                        $body = json_decode($response->getBody()->getContents(), true)['favorites'];
                        if ($body != null) { ?>
                            <form action="/includes/like" method="POST">
                                <input type="hidden" name="action" value="removeLike">
                                <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <button type="submit" class="btn btn-outline-secondary"> ♡ Retirer des favoris</button>
                            </form>
                        <?php } else { ?>
                            <form action="/includes/like" method="POST">
                                <input type="hidden" name="action" value="addLike">
                                <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <button type="submit" class="btn btn-outline-secondary"> ♡ Ajouter aux favoris</button>
                            </form>
                    <?php }
                    } ?>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn">Partager</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
<script>
    var disponibility = <?php echo json_encode($disponibility['disponibility']); ?>;
    var events = [];
    var newDisponibility = [];

    disponibility.forEach(element => {
        if (element.is_booked == 1) {
            events.push({
                start: element.date,
                end: element.date,
                display: 'background',
                classNames: ['booked-date']
            });
        } else {
            events.push({
                start: element.date,
                end: element.date,
                display: 'background',
                classNames: ['available-date']
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
            dayCellClassNames: function(date) {
                return ['unavailable-date', 'date-text'];
            },
            dateClick: function(info) {
                var index = newDisponibility.indexOf(info.dateStr);
                if (index === -1) {
                    newDisponibility.push(info.dateStr);
                    info.dayEl.classList.remove('unavailable-date');
                    info.dayEl.classList.add('available-date');
                } else {
                    newDisponibility.splice(index, 1);
                    info.dayEl.classList.remove('available-date');
                    info.dayEl.classList.add('unavailable-date');
                }
            }
        });
        calendar.render();
    });

    function submitForm() {
        document.getElementById('newDisponibility').value = JSON.stringify(newDisponibility);
        document.getElementById('disponibilityForm').submit();
    }
</script>