<?php

function getAdsImages($id, $type)
{
    $images = [];
    $dir = __DIR__ . "/../../externalFiles/ads/" . $type;
    $files = scandir($dir);
    foreach ($files as $file) {
        if (strpos($file, $id) !== false) {
            $images[] = "https://pcs-all.online:8000/externalFiles/ads/" . $type . "/" . $file;
        }
    }
    return $images;
}

function getAdsInfo ($id, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == 'housing') {
        $req = $db->prepare("SELECT * FROM housing WHERE id = :id");
        $req->execute(['id' => $id]);
        return $req->fetch();
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT * FROM performances WHERE id = :id");
        $req->execute(['id' => $id]);
        return $req->fetch();
    } else {
        return null;
    }
}

?>
