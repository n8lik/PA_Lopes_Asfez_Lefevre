<?php

function getDatabaseConnection(): PDO
{
    return $databaseConnection = new PDO("mysql:host=localhost;dbname=esgi", "root","");
}
