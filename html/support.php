<?php require 'includes/header.php';
require 'vendor/autoload.php';

use GuzzleHttp\Client;


ini_set('display_errors', 'on');
error_reporting(E_ALL);

//stocker 2 tableau des messages en session
if (!isset($_SESSION["Usermessages"])) {
    $_SESSION["Usermessages"] = [];
}
if (!isset($_SESSION["Chatmessages"])) {
    $_SESSION["Chatmessages"] = [];
}

//si on a un retour du ticket, afficher
if (isset($_SESSION["ticketok"])) {
    echo '<div class="alert alert-success" role="alert" style="text-align:center !important">' . $_SESSION["ticketok"] . '</div>';
    unset($_SESSION["ticketok"]);
}
if (isset($_SESSION["ticketerror"])) {
    echo '<div class="alert alert-danger" role="alert" style="text-align:center !important">' . $_SESSION["ticketerror"] . '</div>';
    unset($_SESSION["ticketerror"]);
}

//si on a un retour POST du chatbot, l'ajouter au tableau des messages
if (isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    if (!empty($message)) {
        array_push($_SESSION["Usermessages"], $message);
    }
    $response = botResponse($message);
    array_push($_SESSION["Chatmessages"], $response);
}

//Switch pour ticket ou bot
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'ticket':
            if (!isset($_SESSION['userId'])) {
?>
                <div class="container" style="margin-top: 5%;">
                    <div class="alert alert-danger" role="alert" style="text-align: center;">
                        Vous devez être connecté pour accéder à cette page.
                    </div>
                    <div class="alert alert-info" role="alert" style="text-align: center;">
                        <a href="login.php">Se connecter</a>
                    </div>
                </div>
            <?php
            } else {
                $idUser = $_SESSION['userId'];
                try {
                    $client = new Client();
                    $response = $client->get('https://pcs-all.online:8000/users/' . $idUser);
                    $user = json_decode($response->getBody(), true)['users'];
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger" role="alert">Erreur lors de la récupération des informations</div>';
                }
            ?>
                <div class="support-container">
                    <h2>Créer un ticket</h2>
                    <form action="/includes/support/tickets" method="post" class="support-form">
                        <label for="email">Votre adresse mail</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
                        <label for="subject">Quel est le sujet de votre demande?</label>
                        <select name="subject" id="subject" class="form-control" required>
                            <option value="1">Problème de connexion</option>
                            <option value="2">Problème de paiement</option>
                            <option value="3">Problème de fonctionnalité</option>
                            <option value="4">Autre</option>
                        </select>

                        <label for="message">Entrez votre message</label>
                        <textarea name="message" id="message" class="form-control" required></textarea>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            <?php
            }
            break;
        case 'chatbot':
            ?>
            <link rel="stylesheet" href="/css/chatbot.css">
            <div class="chatbot-container">
                <div class="chatbot">
                    <div class="chatbot-header">
                        <h2>Chatbot</h2>
                    </div>
                    <div class="chatbot-body">
                        <div class="chatbot-message">
                            <p>Bonjour, je suis un chatbot, comment puis-je vous aider?</p>
                        </div>
                        <?php
                        //Afficher en quinconce les messages de l'utilisateur et du chatbot
                        for ($i = 0; $i < count($_SESSION["Usermessages"]); $i++) {
                        ?>
                            <div class="user-message">
                                <p><?php echo $_SESSION["Usermessages"][$i]; ?></p>
                            </div>
                            <div class="chatbot-message">
                                <p><?php echo $_SESSION["Chatmessages"][$i]; ?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <form action="" method="post">
                        <div class="chatbot-input">
                            <input type="text" placeholder="Votre message" name="message">
                            <button>Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
<?php

            break;
        default:
            header('Location: /');
            break;
    }
} else {
    require 'support_chatbot.php';
}
require 'includes/footer.php'; ?>