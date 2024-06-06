<?php 

function getAdsDisponibilitybyID($id, $type) {
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_housing = :id");
        $req->execute(['id' => $id]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_performance = :id");
        $req->execute(['id' => $id]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return null;
    }                                                                                                                                                      
}

function addAdsDisponibility($id, $type, $date) {
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == 'housing') {
        //Verifier que la date n'existe pas deja
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_housing = :id AND date = :date");
        $req->execute(['id' => $id, 'date' => $date]);
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            delAdsDisponibility($id, $type, $date);
            return null;
        }
        $req = $db->prepare("INSERT INTO disponibility (id_housing, date) VALUES (:id, :date)");
        $req->execute(['id' => $id, 'date' => $date]);
    } else if ($type == 'performance') {
        //Verifier que la date n'existe pas deja
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_performance = :id AND date = :date");
        $req->execute(['id' => $id, 'date' => $date]);
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            delAdsDisponibility($id, $type, $date);
            return null;
        }
        $req = $db->prepare("INSERT INTO disponibility (id_performance, date) VALUES (:id, :date)");
        $req->execute(['id' => $id, 'date' => $date]);
    } else {
        return null;
    }
}

function delAdsDisponibility($id, $type, $date) {
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == 'housing') {
        $req = $db->prepare("DELETE FROM disponibility WHERE id_housing = :id AND date = :date");
        $req->execute(['id' => $id, 'date' => $date]);
    } else if ($type == 'performance') {
        $req = $db->prepare("DELETE FROM disponibility WHERE id_performance = :id AND date = :date");
        $req->execute(['id' => $id, 'date' => $date]);
    } else {
        return null;
    }
}