<?PHP

session_start();
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}

$test = $_SESSION["PaymentIntent"];
$id = $test["id"];
$type = $test["type"];

$_SESSION["error"] = "Votre paiement a été annulé";


header("Location: /VIP/VIP");
