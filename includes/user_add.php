<?php
session_start();
require "functions/functions.php";


// Connexion à la base de données avec gestion d'erreur
$conn = connectDB();


$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';
$pseudo = $_POST['pseudo'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['passwordConfirm'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
$extension = $_POST['extension'] ?? '';
$country = $_POST['country'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$postal_code = $_POST['postal_code'] ?? '';
$grade = $_POST['grade'] ?? '';
$consent = $_POST['consent'] ?? '';




if (isset($_POST['submit'])) {
    // Nettoyage et validation des données
    $listOfErrors = [];


    $firstname = cleanFirstname($firstname);
    $lastname = cleanLastname($lastname);
    $email = cleanMail($email);

    // Validation des entrées
    if (strlen($password) < 8 || !preg_match("#[a-z]#", $password) || !preg_match("#[A-Z]#", $password) || !preg_match("#[0-9]#", $password)) {
        $listOfErrors[] = "Password must be at least 8 characters with lowercase, uppercase, and digits.";
    }
    if ($password !== $passwordConfirm) {
        $listOfErrors[] = "Password confirmation does not match.";
    }
    if (!in_array($grade, [1, 4, 5])) {
        $listOfErrors[] = "Invalid grade selected.";
    }
    if (strlen($lastname) < 2) {
        $listOfErrors[] = "Last name must be more than 2 characters.";
    }
    if (strlen($firstname) < 2) {
        $listOfErrors[] = "First name must be more than 2 characters.";
    }
    if ($consent != "1") {
        $listOfErrors[] = "Consent to data usage not accepted.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $listOfErrors[] = "L'email est incorrect";
    } else {
        // --> Unicité de l'email (plus tard)

        $queryPrepared = $conn->prepare("SELECT * FROM user WHERE email=:email");
        $queryPrepared->execute(["email" => $email]);

        $results = $queryPrepared->fetch();

        if (!empty($results)) {
            $listOfErrors[] = "L'email est déjà utilisé";
        }
    }    

    // Si aucune erreur, procéder à l'insertion ou à la mise à jour
    if (empty($listOfErrors)) {

        if ($action === "add") {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (pseudo, firstname, lastname, email, phone_number, extension, password, country, address, city, postal_code, grade, consent, is_deleted, is_admin, vip_status, is_validated)
                    VALUES (:pseudo, :firstname, :lastname, :email, :phone_number, :extension, :password, :country, :address, :city, :postal_code, :grade, :consent, 0, 0, 0, 0)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'pseudo' => $pseudo,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'phone_number' => $phone_number,
                'extension' => $extension,
                'password' => $passwordHash,
                'country' => $country,
                'address' => $address,
                'city' => $city,
                'postal_code' => $postal_code,
                'grade' => $grade,
                'consent' => $consent
            ]);
            echo "Point de contrôle 2";

            header('Location: ../login.php');
            exit;
        } elseif ($action === "update") {
            $sql = "UPDATE user SET pseudo = :pseudo, firstname = :firstname, lastname = :lastname, email = :email, phone_number = :phone_number, extension = :extension, country = :country, address = :address, city = :city, postal_code = :postal_code, grade = :grade WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'pseudo' => $pseudo,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'phone_number' => $phone_number,
                'extension' => $extension,
                'country' => $country,
                'address' => $address,
                'city' => $city,
                'postal_code' => $postal_code,
                'grade' => $grade
            ]);
            header('Location: ../admin.php');
            exit;
        }
    } else {
        // Gestion des erreurs
        $_SESSION['listOfErrors'] = $listOfErrors;
        unset($_POST["password"]);
        unset($_POST["passwordConfirm"]);
        $_SESSION['data'] = $_POST;
        header('Location: ../register.php');
        exit;
    }
}
$conn = null;
?>
