<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: /admin/login.php');
    exit();
}

if (!isset($_POST['deleteLang'])) {
    header('Location: /admin/support?choice=lang');
    echo "Form not submitted properly.";
    exit();
}


if (!isset($_POST['lang'])) {
    $_SESSION['delerror'] = "Veuillez sélectionner une langue.";
    header('Location: /admin/support?choice=lang');
    echo $_SESSION['error'];
    exit();
}

$language = $_POST['lang'];
$target_dir = "/var/www/html/includes/lang/";
$target_file = $target_dir . $language . ".json";

if (file_exists($target_file)) {
    unlink($target_file);
    $_SESSION['delsuccess'] = "La langue " . $language . " a été supprimée.";
} else {
    $_SESSION['delerror'] = "La langue " . $language . " n'existe pas.";
}

header('Location: /admin/support?choice=lang');
exit();

