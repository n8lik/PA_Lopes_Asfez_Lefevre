<?php
require 'includes/header.php';

$user_id = $_SESSION['userId'];
var_dump($user_id);

$RDV = getRdvByIdClientFini("26");
$prestations = getPerformanceById($RDV[0]['prestation_id']);



?>

<link rel="stylesheet" href="css/prestation.css">

<div class="container mt-5">
    <h2>Liste des Prestations fini</h2>
    <div class="row">

        <?php foreach ($prestations as $prestation) : ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title"><?= htmlspecialchars($prestation['title']) ?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Type de Prestation:</strong> <?= htmlspecialchars($prestation['performance_type']) ?></p>
                        <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($prestation['description']) ?></p>

                        <p class="card-text"><strong>Lieu de Rendez-vous:</strong> <?= htmlspecialchars($prestation['appointment_location']) ?></p>
                        <p class="card-text"><strong>Heure de début</strong> <?= date('H:i', strtotime($RDV[0]['heure_debut_rdv'])) ?></p>
                        <p class="card-text"><strong>Heure de fin</strong> <?= date('H:i', strtotime($RDV[0]['heure_fin_rdv']))  ?></p>

                    </div>


                    <div class="card-footer">
                        <p class="card-text"><strong>Prestation fini</strong></p>

                    </div>

                <?php endforeach; ?>
                </div>
            </div>
    </div>
</div>

    <?php include 'includes/footer.php'; ?>