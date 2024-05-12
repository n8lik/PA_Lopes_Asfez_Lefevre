<?php
require 'includes/header.php';

$user_id = $_SESSION['userId'];

$RDV = getRdvByIdClientNotFiniAndEnCours($user_id);

?>

<link rel="stylesheet" href="css/prestation.css">

<div class="container mt-5">
    <h2>Liste des Prestations demandées</h2>
    <div class="row">
        <?php foreach ($RDV as $RDVs) : 
        ?>
            <?php
            $prestations = getPerformanceById($RDVs['prestation_id']); 
            foreach ($prestations as $prestation) : 
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title"><?= htmlspecialchars($prestation['title']) ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Type de Prestation:</strong> <?= htmlspecialchars($prestation['performance_type']) ?></p>
                            <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($prestation['description']) ?></p>
                            <p class="card-text"><strong>Lieu de Rendez-vous:</strong> <?= htmlspecialchars($prestation['appointment_location']) ?></p>
                            <p class="card-text"><strong>Heure de début:</strong> <?= date('H:i', strtotime($RDVs['heure_debut_rdv'])) ?></p>
                            <p class="card-text"><strong>Heure de fin:</strong> <?= date('H:i', strtotime($RDVs['heure_fin_rdv'])) ?></p>
                        </div>
                        <div class="card-footer">
                            <?php if ($RDVs['status'] == 'en cours') : ?>
                                <form action="includes/finir-prestation.php" method="POST" style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($RDVs['id_rdv']) ?>">
                                    <button type="submit" class="btn btn-primary">Cliquez ici si la prestation est finie</button>
                                </form>
                            <?php elseif ($RDVs['status'] == 'demande') : ?>
                                <p class="card-text"><strong>En attente de validation</strong></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>