<?php
include "fun_admin.php";
session_start(); // Démarrer la session au début
if (isset($_POST['loginsubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];

    if (empty($email)) {
        $errors['email'] = 'Veuillez entrer votre email.';
        print("on a une erreur email  \n");
    }

    if (empty($password)) {
        $errors['password'] = 'Veuillez entrer votre mot de passe.';
        print("on a une erreur password  \n");
    }

    if (empty($errors)) {
        print("on juste avant connectDB \n");
        $pdo = connectDB();
        $stmt = $pdo->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $admin = $stmt->fetch();
        print("on juste après connectDB \n");
        print_r($admin);

        if ($password== $admin['password'] && $admin['is_admin'] == 1 && $admin['grade'] == 6) {
            //Comparaison des deux morts de passes
            $_SESSION['email'] = $admin['email'];
            $_SESSION['firstname'] = $admin['firstname'];
            $_SESSION['lastname'] = $admin['lastname'];
            $_SESSION['admin'] = True;
            header('Location:/admin/index.php');
            exit();
        } else {
            $errors['password'] = 'Email ou mot de passe incorrect.';
        }
    }

    // Stocker les erreurs dans la session pour les afficher sur la page de connexion
    $_SESSION['errors'] = $errors;
    header('Location:/admin/login.php'); // Rediriger vers la page de connexion en cas d'erreur
    exit();
}


if (isset($_POST['logout'])) {
    session_destroy();
    header('Location:/admin/login.php');
    exit();
}
?>
