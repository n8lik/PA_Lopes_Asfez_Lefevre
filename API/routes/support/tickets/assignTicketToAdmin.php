<?php
require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/support.php";


$body = getBody();
$ticketId = $body["ticketId"];
$adminId = $body["adminId"];

if (!isset($ticketId) || !isset($adminId)) {
    echo(jsonResponse(404, [], [
        "success" => false,
        "message" => "Missing parameters"
    ]));
}
$res = assignTicketToAdmin($ticketId, $adminId);

if ($res == "ok") {
    echo(jsonResponse(200, [], [
        "success" => true,
        "message" => "Ticket assigned to admin"
    ]));
} else {
    echo(jsonResponse(404, [], [
        "success" => false,
        "message" => "Error"
    ]));
}

?>