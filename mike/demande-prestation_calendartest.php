<?php
require "includes/header.php";

isConnected();



$prestation_id = $_POST['prestation_id'];
// if (!isset($_POST['prestation_id'])) {
//     header("Location: list-prestation.php");
//     exit;
// }

var_dump($POST);
$prestation = getPerformanceById($prestation_id);



// if (!$prestation) {
//     header("Location: list-prestation.php");
//     exit;
// }

$user_id = $prestation['id_user'];
$user_info = getUserById($user_id);

$conn = null;

?>
<!-- LES LINKS POUR LE CALENDRIER TEST-->
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>


    <div class="container mt-5">
        <h2>Demande de Prestation</h2>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?echo $prestation['title'] ?></h5>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Type de Prestation:</strong> <?echo $prestation['performance_type'] ?></p>
                <p class="card-text"><strong>Description:</strong> <?echo $prestation['description'] ?></p>
                <p class="card-text"><strong>Prix:</strong> <?echo $prestation['price'] ?> €</p>
                <p class="card-text"><strong>Lieu de Rendez-vous:</strong> <?echo $prestation['appointment_location'] ?></p>
                <p class="card-text"><strong>Disponibilités:</strong> <br>
                    <?php // listez les jours et les heures de disponibilité ?>
                    
                </p>
            </div>
            <div class="card-footer">
                <p class="card-text">Cette prestation est proposée par <?echo $user_info['first_name'] ?> <?echo $user_info['last_name'] ?></p>
                <a href="#" class="btn btn-primary">Demander cette prestation</a>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="text-center">Calendrier</h2>
            <div id='calendar'></div>
        </div>
    </div>
</div>

<!--Modal APPOINTMENT-->
<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingModalLabel">Prendre un rendez-vous</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="bookingForm" action="" method="POST">

          <input type="hidden" name="prestation_id" id="prestation_id" value="<?echo htmlspecialchars($prestation['id']) ?>">
          <input type="hidden" name="client_id" value="<?echo htmlspecialchars($_SESSION['userId']) ?>">
          <input type="hidden" name="status" value="demande">

          <div class="form-group">
            <label for="booking-title">Titre</label>
            <input type="text" class="form-control" id="booking-title" name="title" required>
          </div>
          <div class="form-group">
            <label for="booking-description">Description</label>
            <textarea class="form-control" id="booking-description" name="description" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="start-time">Heure de début</label>
            <input type="datetime-local" class="form-control" id="start-time" name="start_time" step="60" required>
          </div>
          <div class="form-group">
            <label for="end-time">Heure de fin</label>
            <input type="datetime-local" class="form-control" id="end-time" name="end_time" step="60" required>
          </div>
          <button type="submit" class="btn btn-primary">Réserver</button>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
// $(document).ready(function() {
//     $('#calendar').fullCalendar({
//         header: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'agendaWeek,agendaDay'
//         },
//         defaultView: 'agendaWeek',
//         defaultDate: new Date(),
//         navLinks: true,
//         editable: false,
//         eventLimit: true,
//         selectable: true,
//         selectHelper: true,
//         events: 'includes/script_calendar.php',
//         select: function(start, end) {
//             var startDate = moment(start).format('YYYY-MM-DDTHH:mm');
//             var endDate = moment(end).format('YYYY-MM-DDTHH:mm');

//             $('#start-time').val(startDate);
//             $('#end-time').val(endDate);

//             $('#bookingModal').modal('show');

//             $('#calendar').fullCalendar('unselect');
//         }
//     });
// });
</script>



<?php include "includes/footer.php"; ?>
