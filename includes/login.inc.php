<?php
session_start(); // Démarrage de la session

// Inclure le fichier où se trouve la fonction connectDB()
require 'functions/functions.php'; // Assure-toi de changer le chemin vers ton fichier de connexion.

// Vérification de la soumission du formulaire
if (isset($_POST['loginsubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: ../login.php?error=emptyfields");
        exit();
    } else {
        try {
            $conn = connectDB();
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // Vérification du mot de passe
                if (password_verify($password, $row['pwd'])) {
                    // Mot de passe correct, démarrage de la session
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    header("Location: ../index.php");
                    exit();
                } else {
                    header("Location: ../login.php");
                    exit();
                }
            } else {
                header("Location: ../login.php");
                exit();
            }
        } catch (Exception $e) {
            // Gérer l'erreur
            header("Location: ../login.php");
            exit();
        }
    }
} else {
    // Redirection si l'utilisateur accède à ce fichier d'une autre manière que par le formulaire de connexion
    header("Location: ../login.php");
    exit();
}
?>
