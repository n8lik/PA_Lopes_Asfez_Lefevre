<?php
session_start();
require_once "functions/functions.php";
$conn = connectDB();

$action = "";
$id = "";
$firstname = "";
$lastname = "";
$email = "";
$pwd = "";
$pwdConfirm = "";
$phone_mobile = "";
$consent = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$action = $_POST['action'];

	$firstname = cleanFirstname($_POST['firstname']);
	$lastname = cleanLastname($_POST['lastname']);
	$email = cleanMail($_POST['email']);
	$phone_mobile = $_POST['phone_mobile'];

	if ($action == "update") {
		$user_type = $_POST['user_type'];
		$id = $_POST['id'];
		$consent = "1";
	} else {
		$user_type = 7;
		$pwd = $_POST['pwd'];
		$pwdConfirm = $_POST['pwdConfirm'];
		$consent = $_POST['consent'];
	}

	$listOfErrors = [];

	// --> Est-ce que le genre est cohérent

	// --> Nom plus de 2 caractères
	if (strlen($lastname) < 2) {
		$listOfErrors[] = "Le nom doit faire plus de 2 caractères";
	}
	if ($consent != "1") {
		$listOfErrors[] = "Le consentement à l'utilsation des données n'est pas accepté";
	}

	// --> Prénom plus de 2 caractères
	if (strlen($firstname) < 2) {
		$listOfErrors[] = "Le prénom doit faire plus de 2 caractères";
	}

	if ($action == "add") {
		// --> Format de l'email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$listOfErrors[] = "L'email est incorrect";
		} else {
			// --> Unicité de l'email (plus tard)

			$queryPrepared = $conn->prepare("SELECT * FROM ".DB_PREFIX."user WHERE email=:email");
			$queryPrepared->execute(["email" => $email]);

			$results = $queryPrepared->fetch();

			if (!empty($results)) {
				$listOfErrors[] = "L'email est déjà utilisé";
			}
		}

		// --> Complexité du pwd

		if (
			strlen($pwd) < 8
			|| !preg_match("#[a-z]#", $pwd)
			|| !preg_match("#[A-Z]#", $pwd)
			|| !preg_match("#[0-9]#", $pwd)
		) {
			$listOfErrors[] = "Le mot de passe doit faire au min 8 caractères avec des minuscules, des majuscules et des chiffres";
		}

		// --> Meme mot de passe de confirmation
		if ($pwd != $pwdConfirm) {
			$listOfErrors[] = "La confirmation du mot de passe ne correspond pas";
		}
	}

	//Si OK
	if (empty($listOfErrors)) {
		if ($action == "add") {
			//Insertion en BDD
			$queryPrepared = $conn->prepare("INSERT INTO ".DB_PREFIX."user
														(firstname, lastname, email, pwd, phone_mobile, user_type, created_at, consent)
														VALUES 
														(:firstname, :lastname, :email, :pwd, :phone_mobile, :user_type, NOW(), :consent)");

			$queryPrepared->execute([
				"firstname" => $firstname,
				"lastname" => $lastname,
				"email" => $email,
				"pwd" => password_hash($pwd, PASSWORD_DEFAULT),
				"phone_mobile" => $phone_mobile,
				"user_type" => $user_type,
				"consent" => $consent,
			]);


			//Redirection sur la page de connexion
			header('Location: ../login.php');
		} elseif ($action == "update") {
			$queryPrepared = $conn->prepare(
				"UPDATE users SET
					firstname=:firstname,
					lastname=:lastname,
					email=:email,
					phone_mobile=:phone_mobile,
					user_type=:user_type,
					updated_at=NOW()
					WHERE id=:id"
			);

			$queryPrepared->execute([
				"id" => $id,
				"firstname" => $firstname,
				"lastname" => $lastname,
				"email" => $email,
				"phone_mobile" => $phone_mobile,
				"user_type" => $user_type
			]);
			header('Location: ');
		}
	} else {

		//Si NOK
		//On stock les erreurs et la data
		$_SESSION['listOfErrors'] = $listOfErrors;
		unset($_POST["pwd"]);
		unset($_POST["pwdConfirm"]);
		$_SESSION['data'] = $_POST;
		//Redirection sur la page d'inscription
		if ($action == "add") {
			header('Location: register.php');
		} elseif ($action == "update") {
			//header('Location: ../pages/admin/user_managment.php');
		}
	}
}
//Nettoyage des données
$conn = null;
