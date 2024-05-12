<?php
require "../includes/header.php";

isConnected();

$prestation_id = $_POST['id'];
if (!isset($_POST['id'])) {
  header("Location: list-prestation.php");
  exit;
}

$prestation = getPerformanceById($prestation_id);


if (!$prestation) {
  header("Location: list-prestation.php");
  exit;
}



$user_id = $prestation[0]['id_user'];

$user_info = getUserById($user_id);

$cliuser_id = $_SESSION['userId'];

$conn = null;

?>



<div class="container mt-5">
  <h2>Demande de Prestation</h2>
 
  <div class="card">
    <div class="card-header">
      <h5 class="card-title"><?= $prestation[0]['title'] ?></h5>
    </div>
    <div class="card-body">
      <p class="card-text"><strong>Type de Prestation:</strong> <?= $prestation[0]['performance_type'] ?></p>
      <p class="card-text"><strong>Description:</strong> <?= $prestation[0]['description'] ?></p>
      <p class="card-text"><strong>Prix:</strong> <?php
                                                  if ($prestation[0]['km_cost'] != 0) {
                                                    echo $prestation[0]['km_cost'] . ' €/Km';
                                                  } elseif ($prestation[0]['hour_cost'] != 0) {
                                                    echo $prestation[0]['hour_cost'] . ' €/H';
                                                  } else {
                                                    echo $prestation[0]['price'] . ' €';
                                                  }
                                                  ?></p>
      <p class="card-text"><strong>Lieu de Rendez-vous:</strong> <?= $prestation[0]['appointment_location'] ?></p>
      <p class="card-text"><strong>Disponibilité:</strong><br>
        <?php
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $isAvailable = false;
        foreach ($days as $day) {
          $start_time = !empty($prestation[0][$day . '_start_time']) ? date('H:i', strtotime($prestation[0][$day . '_start_time'])) : null;
          $end_time = !empty($prestation[0][$day . '_end_time']) ? date('H:i', strtotime($prestation[0][$day . '_end_time'])) : null;
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
      <p class="card-text">Cette prestation est proposée par <?= $user_info['pseudo'] ?></p>
    </div>
  </div>
</div>



<div class="container mt-5">
  <form action="includes/ask_prestation" method="post">
    <input type="hidden" name="prestation_id" value="<?php echo $prestation[0]['id'] ?>">
    <input type="hidden" name="client_id" value="<?php echo $cliuser_id ?>">
    <input type="hidden" name="status" value="demande">

    <div class="form-group">
      <label for="lieu">Lieu du rendez-vous:</label>
      <input type="text" class="form-control" name="lieu" id="lieu">
    </div>

    <div class="form-group">
      <label for="date_rdv">Date du rendez-vous:</label>
      <input type="date" class="form-control" name="date_rdv" id="date_rdv">
    </div>

    <div class="form-group">
      <label for="heure_debut_rdv">Heure de début du rendez-vous:</label>
      <input type="time" class="form-control" name="heure_debut_rdv" id="heure_debut_rdv">
    </div>

    <div class="form-group">
      <label for="heure_fin_rdv">Heure de fin du rendez-vous:</label>
      <input type="time" class="form-control" name="heure_fin_rdv" id="heure_fin_rdv">
    </div>

    <button type="submit" class="btn btn-success" name="addsubmit">Demander la prestation</button>
    <button type="button" class="btn btn-primary">Envoyer un message</button>
  </form>
</div>

<?php include "includes/footer.php"; ?>