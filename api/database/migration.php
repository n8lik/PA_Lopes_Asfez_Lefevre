<?php

require_once __DIR__ . "/connection.php";

try {
    $databaseConnection = getDatabaseConnection();
    $databaseConnection->query("DROP TABLE IF EXISTS users;");
    $databaseConnection->query("DROP TABLE IF EXISTS tasks;");
    //Création de la table users
    $databaseConnection->query("CREATE TABLE users(id INTEGER PRIMARY KEY AUTO_INCREMENT, email VARCHAR(50) NOT NULL, password CHAR(60) NOT NULL, token CHAR(60) NULL, role VARCHAR(15);");

    //Création de la table tasks 
    $databaseConnection->query("CREATE TABLE tasks(id INTEGER PRIMARY KEY AUTO_INCREMENT, description TEXT NOT NULL");
    //On ajoute une ligne task pour les tests
    $databaseConnection->query("INSERT INTO tasks(description) VALUES('Faire les courses')");
    
    echo "Migration réussie" . PHP_EOL;
} catch (Exception $exception) {
    echo "Une erreur est survenue durant la migration des données" . PHP_EOL;
    echo $exception->getMessage();
}

