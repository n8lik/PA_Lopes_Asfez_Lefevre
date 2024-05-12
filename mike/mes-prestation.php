<?php
require "includes/header.php";

$user_id = $_SESSION['userId'];
$prestations = getPerformanceByIdUser($user_id)

?>

<div class="container mt-5">
    <h2>Mes Prestations</h2>
    <div class="row">
        <?php foreach ($prestations as $prestation): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title"><?= htmlspecialchars($prestation['title']) ?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Type de Prestation:</strong> <?= htmlspecialchars($prestation['performance_type']) ?></p>
                        <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($prestation['description']) ?></p>
                        <p class="card-text"><strong>Prix:</strong> <?php
                            if ($prestation['km_cost'] != 0) {
                                echo htmlspecialchars($prestation['km_cost']) . ' €/Km';
                            } elseif ($prestation['hour_cost'] != 0) {
                                echo htmlspecialchars($prestation['hour_cost']) . ' €/H';
                            } else {
                                echo htmlspecialchars($prestation['price']) . ' €';
                            }
                        ?></p>
                        <p class="card-text"><strong>Lieu de Rendez-vous:</strong> <?= htmlspecialchars($prestation['appointment_location']) ?></p>
                        <p class="card-text"><strong>Disponibilité:</strong><br>
                            <?php
                            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                            $isAvailable = false;
                            foreach ($days as $day) {
                                $start_time = !empty($prestation[$day . '_start_time']) ? date('H:i', strtotime($prestation[$day . '_start_time'])) : null;
                                $end_time = !empty($prestation[$day . '_end_time']) ? date('H:i', strtotime($prestation[$day . '_end_time'])) : null;
                                if (!empty($start_time) && !empty($end_time)) {
                                    echo ucfirst($day) . ": " . $start_time . " - " . $end_time . "<br>";
                                    $isAvailable = true;
                                }
                            }
                            if (!$isAvailable) {
                                echo "Pas disponible";
                            }
                            ?>
                        </p>
                    </div>
                    
                    <div class="card-footer">
                        <a href="edit-prestation.php?id=<?= $prestation['id'] ?>" class="btn btn-primary">Modifier</a>
                        <a href="delete-prestation.php?id=<?= $prestation['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette prestation?');">Supprimer</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
