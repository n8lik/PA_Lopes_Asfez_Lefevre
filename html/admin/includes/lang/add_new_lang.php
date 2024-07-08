<?php
session_start();
// afficher les erreurs


if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
    exit();
}

if (!isset($_POST['addLang'])) {
    header('Location: /admin/support?choice=lang');
    echo "Form not submitted properly.";
    exit();
}

if (!isset($_POST['lang']) || empty($_FILES['langFile']['name'])) {
    $_SESSION['error'] = "Veuillez sélectionner un fichier de langue.";
    header('Location: /admin/support?choice=lang');
    echo $_SESSION['error'];
    exit();
}

$language = $_POST['lang'];

// vérifier que le fichier a été téléchargé sans erreur
if (isset($_FILES['langFile']) && $_FILES['langFile']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "/var/www/html/includes/lang/";
    $target_file = $target_dir . basename($_FILES["langFile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // vérifier si le fichier existe déjà
    if (file_exists($target_file)) {
        $_SESSION['error'] = "Le fichier existe déjà.";
        $uploadOk = 0;
    }

    // vérifier la taille du fichier
    if ($_FILES["langFile"]["size"] > 500000) {
        $_SESSION['error'] = "Le fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // autoriser seulement les fichiers JSON
    if($fileType != "json") {
        $_SESSION['error'] = "Seuls les fichiers JSON sont autorisés.";
        $uploadOk = 0;
    }
    //Renommer le fichier en fonction de la langue
    $target_file = $target_dir . $language . ".json";

    //vérifier si $uploadOk est à 0 en cas d'erreur
    if ($uploadOk != 0) {
        if (move_uploaded_file($_FILES["langFile"]["tmp_name"], $target_file)) {
            $_SESSION['success'] = "Le fichier " . htmlspecialchars(basename($_FILES["langFile"]["name"])) . " a été téléchargé.";
        } else {
            $_SESSION['error'] = "Une erreur s'est produite lors du téléchargement du fichier.";
        }
    }
} else {
    $_SESSION['error'] = "Aucun fichier n'a été téléchargé ou une erreur s'est produite.";
}

header('Location: /admin/support?choice=lang');
exit();
?>
