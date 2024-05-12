<?php
require "functions/functions.php";
session_start();
$conn = connectDB();

$id_rdv = $_POST['id_rdv'] ?? '';
$prestation_id = $_POST['prestation_id'] ?? '';
$client_id = $_POST['client_id'] ?? '';
$lieu = $_POST['lieu'] ?? '';
$date_rdv = $_POST['date_rdv'] ?? '';
$heure_debut_rdv = $_POST['heure_debut_rdv'] ?? '';
$heure_fin_rdv = $_POST['heure_fin_rdv'] ?? '';
$status = $_POST['status'] ?? '';


$listOfErrorsRdv = [];
if (isset($_POST['addsubmit'])) {

    if (empty($lieu)) {
        $listOfErrors[] = "Le lieu est obligatoire.";
    }
    if (empty($date_rdv)) {
        $listOfErrors[] = "La date est obligatoire.";
    }
    if ($date_rdv <= date("Y-m-d")) {
        $listOfErrors[] = "La date doit être supérieure ou égale à la date d'aujourd'hui.";
    }
    if (empty($heure_debut_rdv)) {
        $listOfErrors[] = "L'heure de début est obligatoire.";
    }
    if (empty($heure_fin_rdv)) {
        $listOfErrors[] = "L'heure de fin est obligatoire.";
    }
    if (empty($status) or $status != "demande") {
        $listOfErrors[] = "Le status est obligatoire et doit êtres inchangé.";
    }

    if ($heure_fin_rdv < $heure_debut_rdv) {
        $listOfErrors[] = "L'heure de début doit être avant l'heure de fin.";
    }

    if (empty($listOfErrorsRdv)) {
        $sql = "INSERT INTO rendez_vous (client_id, prestation_id, lieu, date_rdv, heure_debut_rdv, heure_fin_rdv, status) 
                VALUES (:client_id, :prestation_id, :lieu, :date_rdv, :heure_debut_rdv, :heure_fin_rdv, :status)";
        try {
            $request = $conn->prepare($sql);
            $request->execute([
                'prestation_id' => $prestation_id,
                'client_id' => $client_id,
                'lieu' => $lieu,
                'date_rdv' => $date_rdv,
                'heure_debut_rdv' => $heure_debut_rdv,
                'heure_fin_rdv' => $heure_fin_rdv,
                'status' => $status
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'exécution de la requête : " . $e->getMessage());
            die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        }
    
         header('Location: ../client-prestation.php'); 
        exit;
    } else {
        $_SESSION['listOfErrorsRdv'] = $listOfErrorsRdv;
        header('Location: ../list-prestation.php'); 
        exit;
    }
    
    $conn = null;



















}
