<?php

function getPpByUserID($id)
{
    $images = [];
    $dir = __DIR__ . "/../../externalFiles/pp/";
    $files = scandir($dir);
    foreach ($files as $file) {
        if (strpos($file, $id) !== false) {
            $images[] = "https://pcs-all.online:8000/externalFiles/pp/" . $file;
        }
    }
    return $images;
}
?>