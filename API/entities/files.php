<?php

function uploadFile($type, $id_user, $id_ads, $file)
{
    $compteur = 0;

    $originalFileName = $file["name"];

    $uploadOk = 1;
    if (isset($id_ads)) {
        $target_dir = "externalFiles/" . $type . "/" . $id_user . "/" . $id_ads . "/";
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
    } else {
        $target_dir = "externalFiles/" . $type . "/";

        // Vérifier que le répertoire cible existe, sinon le créer
        if (!is_dir($target_dir)) {
            $test = mkdir($target_dir, 0777, true);
        }

        // Obtenir l'extension du fichier
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        // supprimer le fichier de nom $id_user

        $files = glob($target_dir . $id_user . ".*");
        
        unlink($files[0]);
        
        $newFileName = $id_user . "." . $extension;
        $target_file = $target_dir . $newFileName;
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $reponse = "Erreur de téléchargement du fichier : " . $file['error'];
            return $reponse;;
        }
    }




    // Déplacer le fichier uploadé
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $reponse = "Le fichier " . htmlspecialchars(basename($file["name"])) . " a été téléchargé.";
    } else {
        $reponse =  "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
    }
    return $reponse;
}

function getAllFilesByUserProviderId($id){
    $directoryPath = "externalFiles/provider/".$id."/";

    $fileData = [];

    if (file_exists($directoryPath) && is_dir($directoryPath)) {
        // Récupérer la liste des fichiers
        $files = scandir($directoryPath);

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $directoryPath . $file;

                // Récupérer les informations sur le fichier
                $fileInfo = [
                    'name' => $file,
                    'type' => mime_content_type($filePath),
                    'size' => filesize($filePath),
                    'path' => $filePath,
                    'userId' => $id
                ];

                // Ajouter les informations du fichier au tableau $fileData
                $fileData[] = $fileInfo;
            }
        }
    }

    return $fileData;
}


function getAllFilesByUserId($id,$type){
    $basePath = 'externalFiles/';
    $userPath = '';
    if ($type === 'landlord') {
        $userPath = "landlord/{$id}/";
    } elseif ($type === 'provider') {
        $userPath = "providers/{$id}/";
    }
    $userDirectory = $basePath . $userPath;
    $filesData = array();
    $files = scandir($userDirectory);

    // Filtrer les fichiers pour enlever '.' et '..'
    $files = array_diff($files, array('.', '..'));
    // Lire le contenu de chaque fichier et l'ajouter au tableau de données
    foreach ($files as $file) {
        $filePath = $userDirectory . $file;
        if (is_file($filePath)) {
            $fileContent = file_get_contents($filePath);
            $filesData[$file] = $fileContent;
        }
    }
    return $filesData;
}

function deleteFile($id, $type, $fileName)
{
    $basePath = 'externalFiles/';
    $userPath = '';
    if ($type === 'landlord') {
        $userPath = "landlord/{$id}/";
    } elseif ($type === 'provider') {
        $userPath = "providers/{$id}/";
    }
    $filePath = $basePath . $userPath . $fileName;
    if (file_exists($filePath)) {
        unlink($filePath);
        
    }
    
}