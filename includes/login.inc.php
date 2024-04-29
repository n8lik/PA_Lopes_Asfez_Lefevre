<?php

require 'functions/functions.php'; // Assurez-vous que le chemin vers vos fonctions est correct.

if (isset($_POST['loginsubmit'])) {
    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email'] = $email;

    if (empty($email) || empty($password)) {
        header("Location: ../login.php?error=emptyfields");
        exit();
    } else {
        try {
            $conn = connectDB();
            $stmt = $conn->prepare("SELECT * FROM ".DB_PREFIX."user WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['pwd'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'];
                    header("Location: ../index.php");
                    exit();
                } 
            } else {
                // Utilisateur non trouvé
                $_SESSION['ERRORS']['nouser'] = 'Email ou Mot de passe incorrect';
                header("Location: ../login.php");
                    exit();
            }
        } catch (Exception $e) {
            // Gérer l'erreur
            header("Location: ../login.php?error=exception");
            exit();
        }
    }
} else {
    // Accès non autorisé à ce fichier sans passer par le formulaire
    header("Location: ../login.php");
    exit();
}
?>
