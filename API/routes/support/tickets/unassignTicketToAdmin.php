<?php
require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/support.php";


$body = getBody();
$ticketId = $body["ticketId"];

if (!isset($ticketId)) {
    echo(jsonResponse(404, [], [
        "success" => false,
        "message" => "Missing parameters"
    ]));
}

$res = unassignTicketToAdmin($ticketId);

if ($res == "ok") {
    echo(jsonResponse(200, [], [
        "success" => true,
        "message" => "Ticket unassigned to admin"
    ]));
} else {
    echo(jsonResponse(404, [], [
        "success" => false,
        "message" => "Error"
    ]));
}
?>