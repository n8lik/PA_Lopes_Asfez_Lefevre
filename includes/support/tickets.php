<?php 
    include '../functions/functions.php';
    session_start();
//Si le formulaire est envoyé
if(isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])){
    $subject=htmlspecialchars($_POST['subject']);
    $message=htmlspecialchars($_POST['message']);

    //On vérifie que le message n'est pas vide
    if(!empty($message) && !empty($subject)){
        $db = connectDB();
        $req = $db->prepare("INSERT INTO ticket (id_user,type,subject,content) VALUES (:id_user,:type,:subject,:content)");
        $req->execute(['id_user' => $_SESSION['userId'], 'type' => 0, 'subject' => $subject, 'content' => $message]);
        $_SESSION["ticketok"] = "Votre ticket a bien été envoyé";
        header('Location: /support.php?type=ticket');
    }else{
        $_SESSION["ticketerror"] = "Veuillez remplir le message";
        //retour à la page précédente
        header('Location: /support.php?type=ticket');
    }
}

//Si une réponse a un ticket est envoyée en get
if($_GET['id'] == "answer"){
    //Verifier que la reponse n'est pas vide
    if(!empty($_POST['message'])){
        $db = connectDB();
        $req = $db->prepare("INSERT INTO ticket(id_user,type,subject,content,status,answer_id) VALUES (:id_user,1,:subject,:content,0,:answer_id)");
        $req->execute(['id_user' => $_SESSION['userId'], 'subject' => $_POST['subject'], 'content' => $_POST['message'], 'answer_id' => $_POST['ticketId']]);
        $_SESSION["ticketok"] = "Votre réponse a bien été envoyée";
        header('Location: /myTicket.php?id='.$_POST['ticketId']);
    }else{
        $_SESSION["ticketerror"] = "Veuillez remplir le message";
        //retour à la page précédente
        header('Location: /myTicket.php?id='.$_POST['ticketId']);
    }
}

//Si on ferme un ticket
if($_GET['id'] == "close"){
    $db = connectDB();
    $req = $db->prepare("UPDATE ticket SET status = 2 WHERE id = :id");
    $req->execute(['id' => $_POST['ticketId']]);
    $_SESSION["ticketok"] = "Le ticket a bien été fermé";
    header('Location: /myTicket.php?id='.$_POST['ticketId']);
}