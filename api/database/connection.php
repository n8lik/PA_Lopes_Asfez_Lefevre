<?php

function getDatabaseConnection(): PDO
{
    return $databaseConnection = new PDO("mysql:host=localhost;dbname=PCSALL_BDD", "root","");
}
