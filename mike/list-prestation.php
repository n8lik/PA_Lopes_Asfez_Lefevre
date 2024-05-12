<?php
require 'includes/header.php';
$prestations = listPerformance();
?>

<link rel="stylesheet" href="css/prestation.css">

<div class="container mt-5">
    <h2>Liste des Prestations</h2>
    <?php
  if (isset($_SESSION['listOfErrorsRdv']) && is_array($_SESSION['listOfErrorsRdv'])) { ?>
    <div class="text-danger">
      <ul>
        <?php foreach ($_SESSION['listOfErrorsRdv'] as $error) : ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php
    // unset($_SESSION['listOfErrorsRdv']);
  }
  ?>
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
                        <form action="demande-prestation" method="POST" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($prestation['id']) ?>">
                            <button type="submit" class="btn btn-primary">Demander la prestation</button>
                        </form>
                        <?php if (isset($_SESSION['grade']) && $_SESSION['grade'] == '6'): ?>
                            <a href="delete-prestation.php?id=<?= $prestation['id'] ?>" class="btn btn-danger">Supprimer</a>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
