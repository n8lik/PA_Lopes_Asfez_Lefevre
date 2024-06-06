<?php

require '../../vendor/autoload.php';
session_start();
use GuzzleHttp\Client;

//Si le formulaire est envoyé
if (isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    //On envoie le ticket
    try {
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $ticket = [
            'userId' => $_SESSION['userId'],
            'subject' => $subject,
            'message' => $message
        ];
        $response = $client->post('/addTicket', [
            'json' => $ticket
        ]);
        $body = json_decode($response->getBody()->getContents(), true);

        var_dump($body);


        if ($body['success']) {
            $_SESSION["ticketok"] = "Votre ticket a bien été envoyé";
            header('Location: /support.php?type=ticket');
        } else {
            $_SESSION["ticketerror"] = "Une erreur est survenue";
            header('Location: /support.php?type=ticket');
        }
    } catch (Exception $e) {
        $_SESSION["ticketerror"] = "Une erreur est survenue";
        header('Location: /support.php?type=ticket');
    }
}

//Si une réponse a un ticket est envoyée en get
if ($_GET['id'] == "answer") {
    //Verifier que la reponse n'est pas vide
    if (!empty($_POST['message'])) {
        $db = connectDB();
        $req = $db->prepare("INSERT INTO ticket(id_user,type,subject,content,status,answer_id) VALUES (:id_user,1,:subject,:content,0,:answer_id)");
        $req->execute(['id_user' => $_SESSION['userId'], 'subject' => $_POST['subject'], 'content' => $_POST['message'], 'answer_id' => $_POST['ticketId']]);
        $_SESSION["ticketok"] = "Votre réponse a bien été envoyée";
        header('Location: /myTicket.php?id=' . $_POST['ticketId']);
    } else {
        $_SESSION["ticketerror"] = "Veuillez remplir le message";
        //retour à la page précédente
        header('Location: /myTicket.php?id=' . $_POST['ticketId']);
    }
}

//Si on ferme un ticket
if ($_GET['id'] == "close") {
    $db = connectDB();
    $req = $db->prepare("UPDATE ticket SET status = 2 WHERE id = :id");
    $req->execute(['id' => $_POST['ticketId']]);
    $_SESSION["ticketok"] = "Le ticket a bien été fermé";
    header('Location: /myTicket.php?id=' . $_POST['ticketId']);
}
