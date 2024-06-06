<?php
require '../includes/header.php';

if (!isset($_SESSION['userId']) || ($_SESSION['grade'] != '1' && $_SESSION['grade'] != '2' && $_SESSION['grade'] != '3')) {

    header('Location: /');
    exit();
}

$likes = getLikesByUserId($_SESSION['userId']);
?>
<div class="container" style="margin-top: 1em;">
    <div class="row">
        <h2> Vos coups de coeur</h2>
    </div>
</div>
<?php
if (empty($likes)) {
    echo '<center>';
    echo '<div class="container" style="margin: 2em;">';
    echo '<div class="row">';
    echo '<div class="col-12">';
    echo '<h2> Aucun coup de coeur trouvé</h2>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</center>';
} else {
    //diférencier lique logement et prestation
    $housing_likes = [];
    $performance_likes = [];
    foreach ($likes as $like) {
        if ($like['id_housing'] != null) {
            $type = 'housing';
            $content = getHousingById($like['id_housing']);
            $housing_likes[] = $content;
        } elseif ($like['id_performance'] != null) {
            $type = 'performance';
            $content = getPerformanceById($like['id_performance'])[0];
            $performance_likes[] = $content;
        }
    }

    //Afficher avec la navbar javascript behavior de bootstrap
?>
    <div class="container" style="margin-top: 2em;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button style="color:black !important" class="nav-link active" id="housing-tab" data-bs-toggle="tab" data-bs-target="#housing" type="button" role="tab" aria-controls="housing" aria-selected="true">Logements</button>
            </li>
            <li class="nav-item" role="presentation">
                <button style="color:black !important" class="nav-link" id="performance-tab" data-bs-toggle="tab" data-bs-target="#performance" type="button" role="tab" aria-controls="performance" aria-selected="false">Prestations</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="housing" role="tabpanel" aria-labelledby="housing-tab">
                <div class="container" style="margin-top: 2em;">
                    <div class="row">
                        <?php
                        if (empty($housing_likes)) {
                            echo '<center>';
                            echo '<div class="container" style="margin: 2em;">';
                            echo '<div class="row">';
                            echo '<div class="col-12">';
                            echo '<h2> Aucun logement trouvé</h2>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</center>';
                        } else {
                            foreach ($housing_likes as $item) {
                                echo '<div class="col-lg-3 col-md-6 col-12">';
                                echo '<div class="card" style="width: 18rem; margin-bottom :1em !important;">
                        <img src="/externalFiles/ads/housing/' . $item['id'] . '_' . $item['id_user'] . '_1.jpg" class="card-img-top" alt="Image of ' . $item['title'] . '">
                        <div class="card-body" >
                            <h5 class="card-title">' . $item['title'] . '</h5>
                            <a href="/ads.php?id=' . $item['id'] . '&type=housing" class="btn btn-primary">Voir plus</a>
                            </div>
                        </div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="performance" role="tabpanel" aria-labelledby="performance-tab">
                <div class="container" style="margin-top: 2em;">
                    <div class="row">
                        <?php
                        if (empty($performance_likes)) {
                            echo '<center>';
                            echo '<div class="container" style="margin: 2em;">';
                            echo '<div class="row">';
                            echo '<div class="col-12">';
                            echo '<h2> Aucune prestation trouvée</h2>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</center>';
                        } else {
                            foreach ($performance_likes as $item) {
                                echo '<div class="col-lg-3 col-md-6 col-12">';
                                echo '<div class="card" style="width: 18rem; margin-bottom :1em !important;">
                                <img src="/externalFiles/ads/performance/' . $item['id'] . '_' . $item['id_user'] . '_1.jpg" class="card-img-top" alt="Image of ' . $item['title'] . '">
                                <div class="card-body" >
                                    <h5 class="card-title">' . $item['title'] . '</h5>
                                    <a href="/ads.php?id=' . $item['id'] . '&type=performance" class="btn btn-primary">Voir plus</a>
                                    </div>
                                </div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}

include "../includes/footer.php";
?>