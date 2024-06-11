<?php

function uploadFile($type, $id_user, $id_ads, $file)
{
    $compteur = 0;

    if (isset($id_ads)) {
        $target_dir = "externalFiles/" . $type . "/" . $id_user . "/" . $id_ads . "/";
    } else {
        $target_dir = "externalFiles/" . $type . "/" . $id_user . "/";
    }
    $originalFileName = $file["name"];
    $uploadOk = 1;


    // Vérifier que le répertoire cible existe, sinon le créer
    if (!is_dir($target_dir)) {
        $test = mkdir($target_dir, 0777, true);
        
    }

    // Obtenir l'extension du fichier
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

    // Générer un nouveau nom de fichier
    while (file_exists($target_dir . $compteur . "." . $extension)) {
        $compteur++;
    }
    $newFileName = $compteur . "." . $extension;
    $target_file = $target_dir . $newFileName;
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $reponse = "Erreur de téléchargement du fichier : " . $file['error'];
        return $reponse;;
    }

    // Déplacer le fichier uploadé
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
$reponse = "Le fichier " . htmlspecialchars(basename($file["name"])) . " a été téléchargé.";
        
    } else {
        $reponse =  "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";

    }
    return $reponse;
}
