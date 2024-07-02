<?PHP

session_start();



$_SESSION["error"] = "Une erreur est survenue pendant votre paiement, veuillez réessayer.";


header("Location: /VIP/VIP");
