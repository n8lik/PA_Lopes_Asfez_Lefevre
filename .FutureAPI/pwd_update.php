<?php
require "../includes/functions/functions.php";
session_start();
if (!isset($_POST['submit'])){
    header("Location: ../index.php");
    exit; 
}
if($_POST["newPassword"]!=$_POST["confirmPassword"]){
    $_SESSION['passwordUpdateError'] = "Les mots de passe ne correspondent pas";
    header("Location: ../profile.php");
    exit;
}elseif(empty($_POST["newPassword"])|| empty($_POST["confirmPassword"])||empty($_POST["oldPassword"])){
    $_SESSION['passwordUpdateError'] = "Veuillez remplir tous les champs";
    header("Location: ../profile.php");
    exit;
}else{
    //Verification que l'ancien mdp est le bon
    $userInfo = getUserById($_SESSION['userId']);
    if(!password_verify($_POST["oldPassword"],$userInfo["password"])){
        $_SESSION['passwordUpdateError'] = "L'ancien mot de passe est incorrect";
        header("Location: ../profile.php");
        exit;
    }elseif($_POST["oldPassword"]==$_POST["newPassword"]){
        $_SESSION['passwordUpdateError'] = "Le nouveau mot de passe doit être différent de l'ancien";
        header("Location: ../profile.php");
        exit;
    }//Complexite du mdp
    elseif(strlen($_POST["newPassword"])<8 ){
        $_SESSION['passwordUpdateError'] = "Le mot de passe doit contenir au moins 8 caractères";
        header("Location: ../profile.php");
        exit;
    }else{
        //Mise à jour du mot de passe
        $password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
        $conn=connectDB();
        $req=$conn->prepare("UPDATE user SET password=:password WHERE id=:id");
        $req->execute([
            "password"=>$password,
            "id"=>$_SESSION["userID"]
        ]);
        $_SESSION['passwordUpdateOk'] = "Votre mot de passe a bien été mis à jour";
        header("Location: ../profile.php");
    }
}
