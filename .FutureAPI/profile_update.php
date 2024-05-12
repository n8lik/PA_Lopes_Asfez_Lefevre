<?php
require "../includes/functions/functions.php";
session_start();
$conn = connectDB();
$userInfo = getUserById($_SESSION['userId']);
//On vérifie qu'il y ait des infos différentes
if ($userInfo['pseudo'] == $_POST['pseudo'] && $userInfo['firstname'] == $_POST['firstname'] && $userInfo['lastname'] == $_POST['lastname'] && $userInfo['phone_number'] == $_POST['phone']) {
    $_SESSION["profileUpdateError"] = "Aucune information n'a changé";
    header('Location:../profile.php');
} elseif (empty($_POST['pseudo']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['phone'])) {
    $_SESSION["profileUpdateError"] = "Veuillez remplir tous les champs";
    header('Location:../profile.php');
} else {
    //Verifier que le pseudo choisi ne soit pas deja utilisé
    $req = $conn->prepare("SELECT * FROM user WHERE pseudo=:pseudo AND id!=:id");
    $req->execute([
        "pseudo" => $_POST['pseudo'],
        "id" => $_SESSION['userId']
    ]);
    $user = $req->fetch();
    if ($user) {
        $_SESSION["profileUpdateError"] = "Ce pseudo est déjà utilisé";
        header('Location:../profile.php');
    } else {
        $req = $conn->prepare("UPDATE user SET pseudo=:pseudo, firstname=:firstname, lastname=:lastname, phone_number=:phone WHERE id=:id");
        $req->execute([
            "pseudo" => $_POST['pseudo'],
            "firstname" => $_POST['firstname'],
            "lastname" => $_POST['lastname'],
            "phone" => $_POST['phone'],
            "id" => $_SESSION['userId']
        ]);
        $_SESSION["profileUpdateOk"] = "Vos informations ont bien été mises à jour";
        header('Location:../profile.php');
    }
}
