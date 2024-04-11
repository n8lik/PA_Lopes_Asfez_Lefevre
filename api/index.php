<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

//On inclut les fichiers nécessaires
require_once __DIR__ . "/libraries/path.php";
require_once __DIR__ . "/libraries/method.php";
require_once __DIR__ . "/libraries/response.php";

//pour la route /login 
if (isPath("login")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/login.php";
        die();
    }
}

//pour la route /register
if (isPath("register")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/users/post.php";
        die();
    }
}

//pour la route /tasks
if (isPath("tasks")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/tasks/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/tasks/post.php";
        die();
    }
}

//pour la route /tasks/:task
if (isPath("tasks/:task")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/tasks/delete.php";
        die();
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/tasks/patch.php";
        die();
    }
}

echo jsonResponse(404, [], [
    "success" => false,
    "message" => "Route not found"
]);
