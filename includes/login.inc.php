<?php
require 'functions/functions.php';
session_start(); 

if (isset($_POST['loginsubmit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email'] = $email;

    if (empty($email) || empty($password)) {
        $_SESSION['ERRORS']['emptyfields'] = 'Veuillez remplir tous les champs';
        header("Location: ../login.php");
    } else {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION["userId"] = $user["id"];
                $_SESSION["grade"] = $user["grade"];
                header("Location: ../index.php");
            } else {
                $_SESSION['ERRORS']['nouser'] = 'Email ou mot de passe incorrect';
                header("Location: ../login.php");
            }
        } else {
            $_SESSION['ERRORS']['nouser'] = 'Email ou mot de passe incorrect';
            header("Location: ../login.php");
        }
    }
}
?>
