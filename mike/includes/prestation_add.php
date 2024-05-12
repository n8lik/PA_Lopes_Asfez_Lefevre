<?php
require "functions/functions.php";
session_start();
$conn = connectDB();

$id_user = $_SESSION['userId'] ?? '';
$performance_type = $_POST['performance_type'] ?? '';
$price_type = $_POST['price_type'] ?? '';
$km_cost = is_numeric($_POST['km_cost']) ? $_POST['km_cost'] : 0;
$hour_cost = is_numeric($_POST['hour_cost']) ? $_POST['hour_cost'] : 0;
$price = is_numeric($_POST['price']) ? $_POST['price'] : 0;
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$appointment_location = $_POST['appointment_location'] ?? '';
$created_at = date('Y-m-d H:i:s');

$availability = [
    'monday' => $_POST['availability']['monday'] ?? 0,
    'tuesday' => $_POST['availability']['tuesday'] ?? 0,
    'wednesday' => $_POST['availability']['wednesday'] ?? 0,
    'thursday' => $_POST['availability']['thursday'] ?? 0,
    'friday' => $_POST['availability']['friday'] ?? 0,
    'saturday' => $_POST['availability']['saturday'] ?? 0,
    'sunday' => $_POST['availability']['sunday'] ?? 0
];

$listOfErrors = [];

$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

$hours = [];
foreach ($days as $day) {
    if (!empty($_POST['availability'][$day])) {
        $hours[$day]['start'] = $_POST["hours"][$day]["start"] ?? null;
        $hours[$day]['end'] = $_POST["hours"][$day]["end"] ?? null;

        if ($hours[$day]['start'] >= $hours[$day]['end']) {
            $listOfErrors[] = ucfirst($day) . ": L'heure de début doit être avant l'heure de fin.";
        }
    } else {
        $hours[$day]['start'] = null;
        $hours[$day]['end'] = null;
    }
}



if (isset($_POST['addsubmit'])) {

    if ($performance_type == '') {
        $listOfErrors[] = "Veuillez sélectionner un type de prestation.";
    }
    if ($price_type == '') {
        $listOfErrors[] = "Veuillez sélectionner un type de tarif.";
    }
    if (strlen($title) < 5) {
        $listOfErrors[] = "Le titre doit comporter au moins 5 caractères.";
    }
    if($appointment_location == ''){
        $listOfErrors[] = "Veuillez renseigner un lieu de rendez-vous.";
    }
    if (array_sum($availability) == 0) {
        $listOfErrors[] = "Veuillez sélectionner au moins un jour de disponibilité.";
    }
    


    



    if (empty($listOfErrors)) {
        $sql = "INSERT INTO prestations (id_user, performance_type, price_type, km_cost, hour_cost, title, description, price, appointment_location, monday, monday_start_time, monday_end_time, tuesday, tuesday_start_time, tuesday_end_time, wednesday, wednesday_start_time, wednesday_end_time, thursday, thursday_start_time, thursday_end_time, friday, friday_start_time, friday_end_time, saturday, saturday_start_time, saturday_end_time, sunday, sunday_start_time, sunday_end_time, created_at) 
                VALUES (:id_user, :performance_type, :price_type, :km_cost, :hour_cost, :title, :description, :price, :appointment_location, :monday, :monday_start_time, :monday_end_time, :tuesday, :tuesday_start_time, :tuesday_end_time, :wednesday, :wednesday_start_time, :wednesday_end_time, :thursday, :thursday_start_time, :thursday_end_time, :friday, :friday_start_time, :friday_end_time, :saturday, :saturday_start_time, :saturday_end_time, :sunday, :sunday_start_time, :sunday_end_time, :created_at)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'id_user' => $id_user,
                'performance_type' => $performance_type,
                'price_type' => $price_type,
                'km_cost' => $km_cost,
                'hour_cost' => $hour_cost,
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'appointment_location' => $appointment_location,
                'monday' => $availability['monday'],
                'monday_start_time' => $hours['monday']['start'],
                'monday_end_time' => $hours['monday']['end'],
                'tuesday' => $availability['tuesday'],
                'tuesday_start_time' => $hours['tuesday']['start'],
                'tuesday_end_time' => $hours['tuesday']['end'],
                'wednesday' => $availability['wednesday'],
                'wednesday_start_time' => $hours['wednesday']['start'],
                'wednesday_end_time' => $hours['wednesday']['end'],
                'thursday' => $availability['thursday'],
                'thursday_start_time' => $hours['thursday']['start'],
                'thursday_end_time' => $hours['thursday']['end'],
                'friday' => $availability['friday'],
                'friday_start_time' => $hours['friday']['start'],
                'friday_end_time' => $hours['friday']['end'],
                'saturday' => $availability['saturday'],
                'saturday_start_time' => $hours['saturday']['start'],
                'saturday_end_time' => $hours['saturday']['end'],
                'sunday' => $availability['sunday'],
                'sunday_start_time' => $hours['sunday']['start'],
                'sunday_end_time' => $hours['sunday']['end'],
                'created_at' => $created_at
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'exécution de la requête : " . $e->getMessage());
            die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        }

        header('Location: ../mes-prestation.php');
        exit;
    } else {
        $_SESSION['listOfErrorsPresta'] = $listOfErrors;
        header('Location: ../prestation.php');
        exit;
    }
}

$conn = null;
?>






