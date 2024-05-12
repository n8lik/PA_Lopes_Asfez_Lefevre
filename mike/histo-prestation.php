<?php
require 'includes/header.php';

if (!isConnected()){
    header("https://pcs-all.online/login");
}
$rendezVous = selectAppointmentHisto();
//var_dump($rendezVous); ?>


<div class="container mt-5">
    <h2>Historique des rendez-vous terminés</h2>
    <div class="row">
        <?php foreach ($rendezVous as $rdv):
            $prestations = getPerformanceById($rdv['prestation_id']);
            foreach ($prestations as $prestation):
                ?>
            
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            Rendez-vous le: <?= htmlspecialchars(date("d-m-Y", strtotime($rdv['date_rdv']))) ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($prestation['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($prestation['description']) ?></p>
                            <p class="card-text"><strong>Heure de début:</strong> <?= htmlspecialchars(date("H:i", strtotime($rdv['heure_debut_rdv']))) ?></p>
                            <p class="card-text"><strong>Heure de fin:</strong> <?= htmlspecialchars(date("H:i", strtotime($rdv['heure_fin_rdv']))) ?></p>
                            <p class="card-text"><strong>Statut:</strong> <?= htmlspecialchars($rdv['status']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>