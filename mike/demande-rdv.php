<?php
require 'includes/header.php';

$user_id = $_SESSION['userId'];

$prestations = getPerformanceById($user_id);


$RDV = getRdvByIdNotFini($prestations[0]["id"]);
?>

<link rel="stylesheet" href="css/prestation.css">

<div class="container mt-5">
    <h2>Liste des Prestations</h2>
    <div class="row">

        <?php foreach ($prestations as $prestation) : ?>
            <?php if ($RDV[0]['status'] == 'demande') {  ?>
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
                            <form action="includes/accepte-prestation" method="POST" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($RDV[0]['id_rdv']) ?>">
                                <button type="submit" class="btn btn-primary">Accepter</button>
                            </form>
                            <form action="includes/refuse-prestation" method="POST" style="display: inline-block;" onclick="return confirm('Êtes-vous sûr de vouloir refuser cette prestation?');">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($RDV[0]['id_rdv']) ?>">
                                <button type="submit" class="btn btn-danger">refuser</button>
                            </form>
                        </div>
                    <?php } elseif ($RDV[0]['status'] == 'En cours') {  ?>
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
                                <p class="card-text"><strong>En cours</strong></p>

                                </div>
                            <?php  }; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>

                <?php include 'includes/footer.php'; ?>