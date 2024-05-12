<?php
//Afficher tous les users grace a mon api REST, en get

$response= file_get_contents("https://pcs-all.online:8000/api/users");
$users = json_decode($response, true);

var_dump($users);

?>