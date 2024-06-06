<?php
require "functions/functions.php";
var_dump($_POST);
session_start();
if (!isset($_POST['action']) || !isset($_SESSION['userId'])) {
    header('Location: /');
    exit();
}
switch ($_POST['action']) {
    case 'addLike':
        if (!isset($_POST['id']) || !isset($_POST['type'])) {
            header('Location: /');
            exit();
        }
        $id = $_POST['id'];
        $type = $_POST['type'];
        $userId = $_SESSION['userId'];
        addLike($id, $type, $userId);
        break;
    case 'removeLike':
        if (!isset($_POST['id']) || !isset($_POST['type'])) {
            header('Location: /');
            exit();
        }
        $id = $_POST['id'];
        $type = $_POST['type'];
        $userId = $_SESSION['userId'];
        removeLike($id, $type, $userId);
        break;
}

//retourner à l'url précédente
header('Location: /ads?id=' . $_POST['id'] . '&type=' . $_POST['type']);
