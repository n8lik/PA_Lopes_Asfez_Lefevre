
<?php

require_once __DIR__ . "/../../database/connection.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";


function getAllConversationWhereFromUserIdToUserIdAdsId($userId, $touser, $adsid, $type)
{
    $db = connectDB();

    $column = ($type == "performances") ? "performance_id" : "housing_id";

    $req = $db->prepare("SELECT * FROM private_message WHERE from_user_id = :from_user_id AND to_user_id = :to_user_id AND $column = :adsid");
    $req->execute(['from_user_id' => $userId, 'to_user_id' => $touser, 'adsid' => $adsid]);
    return $req->fetch();
}

function addConversation($userId, $type, $adsid)
{

    $to_user_id = getUserByAdsId($adsid, $type)['id_user'];

    $allconv = getAllConversationWhereFromUserIdToUserIdAdsId($userId, $to_user_id, $adsid, $type);

    if ($allconv) {
        $id = $allconv['id_conv'];
    } else {
        $id = bin2hex(random_bytes(32));

        $db = connectDB();

        if ($type == "performances") {
            $req = $db->prepare("INSERT INTO private_message (id_conv, from_user_id, to_user_id, performance_id) VALUES (:id, :from_user_id, :to_user_id, :adsid)");
        } elseif ($type == "housing") {
            $req = $db->prepare("INSERT INTO private_message (id_conv, from_user_id, to_user_id, housing_id) VALUES (:id, :from_user_id, :to_user_id, :adsid)");
        }

        $req->execute(['id' => $id, 'from_user_id' => $userId, 'to_user_id' => $to_user_id, 'adsid' => $adsid]);
    }

    return $id;
}

function getPrivateMessageById($id)
{
    $db = connectDB();
    // récupérer tous les messages de la conversation
    $req = $db->prepare("SELECT * FROM private_message WHERE id_conv = :id");
    $req->execute(['id' => $id]);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}


function getUserIdInConv($id, $userId)
{
    // trouver le deuxieme participant autre que userId

    $db = connectDB();
    $req = $db->prepare("SELECT * FROM private_message WHERE id_conv = :id");
    $req->execute(['id' => $id]);
    $result = $req->fetch();

    if ($result['from_user_id'] == $userId) {
        return $result['to_user_id'];
    } else {
        return $result['from_user_id'];
    }
}

function getPerfOrHousingIdById($id)
{
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM private_message WHERE id_conv = :id");
    $req->execute(['id' => $id]);
    $result = $req->fetch();

    if ($result['performance_id']) {
        return $result['performance_id'];
    } else {
        return $result['housing_id'];
    }
}

function getTypeById($id)
{
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM private_message WHERE id_conv = :id");
    $req->execute(['id' => $id]);
    $result = $req->fetch();

    if ($result['performance_id']) {
        return "performances";
    } else {
        return "housing";
    }
}

function addMessage($id, $content, $type, $userId, $touser, $adsid)
{

    $db = connectDB();
    if ($type == "performances") {
        $req = $db->prepare("INSERT INTO private_message (id_conv, content, from_user_id, to_user_id, performance_id) VALUES (:id, :content, :from_user_id, :to_user_id, :adsid)");
    } elseif ($type == "housing") {
        $req = $db->prepare("INSERT INTO private_message (id_conv, content, from_user_id, to_user_id, housing_id) VALUES (:id, :content, :from_user_id, :to_user_id, :adsid)");
    }
    $req->execute(['id' => $id, 'content' => $content, 'from_user_id' => $userId, 'to_user_id' => $touser, 'adsid' => $adsid]);
}
