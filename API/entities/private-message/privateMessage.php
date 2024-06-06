
<?php

require_once __DIR__ . "/../../database/connection.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";


function getAllConversationWhereFromUserIdToUserIdAdsId($userId, $touser, $adsid, $type) {
    $db = connectDB();
    
    $column = ($type == "performances") ? "performance_id" : "housing_id";
    
    $req = $db->prepare("SELECT id FROM private_message WHERE from_user_id = :from_user_id AND to_user_id = :to_user_id AND $column = :adsid");
    $req->execute(['from_user_id' => $userId, 'to_user_id' => $touser, 'adsid' => $adsid]);
    return $req->fetch();
}

function addConversation($userId, $type, $adsid) {
    $to_user_data = getUserByAdsId($adsid, $type);
    $to_user_id = $to_user_data["id_user"];

    $allconv = getAllConversationWhereFromUserIdToUserIdAdsId($userId, $to_user_id, $adsid, $type);

    if ($allconv) {
        $id = $allconv['id'];
    } else {
        $id = bin2hex(random_bytes(32));
        $db = connectDB();

        if ($type == "performances") {
            $req = $db->prepare("INSERT INTO private_message (id, from_user_id, to_user_id, performance_id) VALUES (:id, :from_user_id, :to_user_id, :adsid)");
        } elseif ($type == "housing") {
            $req = $db->prepare("INSERT INTO private_message (id, from_user_id, to_user_id, housing_id) VALUES (:id, :from_user_id, :to_user_id, :adsid)");
        }

        $req->execute(['id' => $id, 'from_user_id' => $userId, 'to_user_id' => $to_user_id, 'adsid' => $adsid]);
    }

    return $id;
}

function getPrivateMessageById($id) {
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM private_message WHERE id = :id");
    $req->execute(['id' => $id]);
    return $req->fetch();
}