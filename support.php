<?php  require 'includes/header.php'; 
session_start();
//si on a un retour du ticket, afficher
if (isset($_SESSION["ticketok"])) {
    echo '<div class="alert alert-success" role="alert" style="text-align:center !important">' . $_SESSION["ticketok"] . '</div>';
    unset($_SESSION["ticketok"]);
}
if (isset($_SESSION["ticketerror"])) {
    echo '<div class="alert alert-danger" role="alert" style="text-align:center !important">' . $_SESSION["ticketerror"] . '</div>';
    unset($_SESSION["ticketerror"]);
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
            require 'includes/support/tickets.php';
            $user=getUserById($_SESSION['userId']);
             ?>
             <div class="support-container">
                <h2>Créer un ticket</h2>
                <form action="/includes/support/tickets" method="post" class="support-form">
                        <label for="email" >Votre adresse mail</label> 
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
                        <label for="subject" >Quel est le sujet de votre demande?</label>
                        <select name="subject" id="subject" class="form-control" required>
                                <option value="1">Problème de connexion</option>
                                <option value="2">Problème de paiement</option>
                                <option value="3">Problème de fonctionnalité</option>
                                <option value="4">Autre</option>
                        </select>

                        <label for="message" >Entrez votre message</label>
                        <textarea name="message" id="message" class="form-control" required></textarea>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
            <?php
            }
            break;
        case 'chatbot':
            require 'support_chatbot.php';
            break;
        default:
            require 'support_chatbot.php';
            break;
    }
} else {
    require 'support_chatbot.php';
}
require 'includes/footer.php'; ?>
