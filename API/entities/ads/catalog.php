<?php

function getAllCatalogByChoice($type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    switch ($type) {
        case 'housing':
            $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 1");
            $req->execute();
            return $req->fetchAll();
            break;
        case 'performance':
            $req = $db->prepare("SELECT * FROM performances WHERE is_validated = 1");
            $req->execute();
            return $req->fetchAll();
            break;
    }
}


function getHousingCatalogByType($type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 1 AND type = :type");
    $req->execute(['type' => $type]);
    return $req->fetchAll();
}

function getPerformanceCatalogByType($type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM performances WHERE is_validated = 1 AND type = :type");
    $req->execute(['type' => $type]);
    return $req->fetchAll();
}

function getHousingCatalogBySearch($destination, $arrivalDate, $departureDate, $travelers)
{
    require_once __DIR__ . "/../../database/connection.php";
    if ($destination != null) {
        $destination = explode(",", $destination);
        $destination = $destination[0];
        $db = connectDB();
        $req = $db->prepare("SELECT * FROM housing WHERE city = :destination AND is_validated = 1");
        $req->execute(['destination' => $destination]);
        return $req->fetchAll();
    }

    return [];
}

function getPerformanceCatalogBySearch($date, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM performances WHERE date = :date AND type = :type AND is_validated = 1");
    $req->execute(['date' => $date, 'type' => $type]);
    return $req->fetchAll();
}


######Favorites####

function addLike($id, $type, $userId)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("INSERT INTO likes (id_housing, id_user) VALUES (:id, :userId)");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return "ok";
    } else if ($type == 'performance') {
        $req = $db->prepare("INSERT INTO likes (id_performance, id_user) VALUES (:id, :userId)");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return "ok";
    }
}

function removeLike($id, $type, $userId)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("DELETE FROM likes WHERE id_housing = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return "ok";
    } else if ($type == 'performance') {
        $req = $db->prepare("DELETE FROM likes WHERE id_performance = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return "ok";
    }
}

function isLiked($id, $type, $userId)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("SELECT * FROM likes WHERE id_housing = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return $req->fetch();
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT * FROM likes WHERE id_performance = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return $req->fetch();
    }
}

function getLikesByUserId($userId)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM likes WHERE id_user = :userId");
    $req->execute(['userId' => $userId]);
    return $req->fetchAll();
}
