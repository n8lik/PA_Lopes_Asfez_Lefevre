<?PHP

session_start();


$test = $_SESSION["PaymentIntent"];
$id = $test["id"];
$type = $test["type"];

$_SESSION["booking"] = 1;


header("Location: /reservation/booking?id=$id&type=$type");
