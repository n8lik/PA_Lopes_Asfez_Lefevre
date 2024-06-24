<?php
require "includes/header.php";
require "vendor/autoload.php";

use GuzzleHttp\Client;

if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
}
$idUser = $_SESSION['userId'];
//Réception des informations de l'utilisateur
try {
    $client = new Client();
    $response = $client->get('https://pcs-all.online:8000/users/' . $idUser);
    $user = json_decode($response->getBody(), true)['users'];
} catch (Exception $e) {
    echo '<div class="alert alert-danger" role="alert">Erreur lors de la récupération des informations</div>';
}

//Récéption de la photo de profil
try {
    $client = new Client();
    $response = $client->get('https://pcs-all.online:8000/getPpById/' . $idUser);
    $userpdp = json_decode($response->getBody(), true)["users"];
} catch (Exception $e) {
    echo '<div class="alert alert-danger" role="alert">Erreur lors de la récupération de la photo de profil</div>';
}

?>

<div class="p-background">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link p-nav active" id="InfosPerso-tab" data-bs-toggle="tab" href="#InfosPerso" role="tab" aria-controls="InfosPerso" aria-selected="true">Informations personnelles</a>
            <a class="nav-item nav-link p-nav" id="Security-tab" data-bs-toggle="tab" href="#Security" role="tab" aria-controls="Security" aria-selected="false">Connexion & sécurité</a>
            <a class="nav-item nav-link p-nav" id="Payment-tab" data-bs-toggle="tab" href="#Payment" role="tab" aria-controls="Payment" aria-selected="false">Moyens de paiement</a>
            <a class="nav-item nav-link p-nav" id="Notifications-tab" data-bs-toggle="tab" href="#Notifications" role="tab" aria-controls="Notifications" aria-selected="false">Notifications</a>
            <a class="nav-item nav-link p-nav" id="Tickets-tab" data-bs-toggle="tab" href="#Tickets" role="tab" aria-controls="Tickets" aria-selected="false">Tickets</a>

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="InfosPerso" role="tabpanel" aria-labelledby="InfosPerso-tab">.
            <center>
                <h2> Mes informations personnelles </h2>
                <?php
                //On affiche le résultat si changement a eu lieu
                if (isset($_SESSION['profileUpdateOk'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['profileUpdateOk'] . '</div>';
                    unset($_SESSION['profileUpdateOk']);
                } elseif (isset($_SESSION['profileUpdateError'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['profileUpdateError'] . '</div>';
                    unset($_SESSION['profileUpdateError']);
                }
                ?>
                <?php
                if (isset($_SESSION['passwordUpdateOk'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['passwordUpdateOk'] . '</div>';
                    unset($_SESSION['passwordUpdateOk']);
                } elseif (isset($_SESSION['passwordUpdateError'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['passwordUpdateError'] . '</div>';
                    unset($_SESSION['passwordUpdateError']);
                }
                ?>
                <img src="<?= $userpdp[0]; ?>" alt="Photo de profil" style="width: 200px; height: 200px; border-radius: 50%; margin-bottom: 20px;">
                <form action="includes/updateUser" method="post" class="support-form" enctype="multipart/form-data">
                    <label for="pp">Changer de photo de profil</label>
                    <input type="file" name="file" id="pp" class="form-control" style="width: 80% !important; ">
                    <label for="pseudo">Votre pseudo</label>
                    <input type="pseudo" name="pseudo" id="pseudo" class="form-control" value="<?php echo $user['pseudo'];  ?>" style="width: 80% !important; ">
                    <label for="email">Votre adresse mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" style="width: 80% !important; " readonly>
                    <label for="firstname">Votre prénom</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $user['firstname']; ?>" style="width: 80% !important; " required>
                    <label for="lastname">Votre nom</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $user['lastname']; ?>" style="width: 80% !important; " required>
                    <label for="phone">Votre numéro de téléphone</label>
                    <div style="width: 80% !important; display: flex;">
                        <select class="form-control" id="extension" name="extension" style="flex-grow: 1;">
                            <option value="+33">+33 France</option>
                            <option value="+1">+1 USA/Canada</option>
                            <option value="+44">+44 Royaume-Uni</option>
                            <option value="+49">+49 Allemagne</option>
                            <option value="+39">+39 Italie</option>
                            <option value="+91">+91 Inde</option>
                        </select>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $user['phone_number']; ?>" required style="flex-grow: 3; margin-left: 10px;">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary" style="margin-top:1em">Modifier</button>
                </form>
            </center>
        </div>
        <div class="tab-pane fade" id="Security" role="tabpanel" aria-labelledby="Security-tab" >
            <center >
                <h2 style="margin-top:1em">Connexion & sécurité</h2>

                <h3 style="margin-top:1em">Changer de mot de passe</h3>
                <form action="includes/updateUser" method="post" class="support-form">
                    <label for="oldPassword">Ancien mot de passe</label>
                    <input type="password" name="oldPassword" id="oldPassword" class="form-control" style="width: 80% !important; " required>
                    <label for="newPassword">Nouveau mot de passe</label>
                    <input type="password" name="newPassword" id="newPassword" class="form-control" style="width: 80% !important; " required>
                    <label for="confirmPassword">Confirmer le mot de passe</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" style="width: 80% !important; " required>
                    <button type="submit" name="submit-password" class="btn btn-primary" style="margin-top:1em">Modifier</button>
                </form>

                <hr>

                <h3 style="margin-top:1em">Supprimer le compte</h3>
                <p style="color:red" style="width: 80% !important;">Attention, cette action est irréversible.<br>
                    Suite à la suppression de votre compte, vous perdrez l'ensemble de vos données et ne pourrez plus accéder à votre compte.<br>
                    Votre compte sera supprimé dans un délai de 30 jours après la demande de suppression.
            </p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal" style="margin-top:1em">
                    Supprimer le compte
                </button>

                <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAccountModalLabel">Suppression du compte</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body
                            ">
                            <p>Êtes-vous sûr de vouloir supprimer votre compte ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <a href="includes/deleteUser" class="btn btn-danger">Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>


            </center>
        </div>


        <div class="tab-pane fade" id="Payment" role="tabpanel" aria-labelledby="Payment-tab">
            <center>
                <h2 style="margin-top:1em">Moyen de paiement</h2>
            </center>
        </div>



        <div class="tab-pane fade" id="Notifications" role="tabpanel" aria-labelledby="Notifications-tab">
            <center>
                <h2 style="margin-top:1em">Notifications & preférences</h2>
                <div class="theme-toggle">
                    <button id="theme-toggle-button">Changer de theme</button>
                </div>
            </center>
        </div>


        <div class="tab-pane fade" id="Tickets" role="tabpanel" aria-labelledby="Tickets-tab">
            <center>
                <h2 style="margin-top:1em">Mes tickets</h2>
                <table class="table table-hover" style="color:var(--text-color)!important;">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Sujet</th>
                            <th scope="col">Date</th>
                            <th scope="col">Statut</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Appel API pour récupérer les tickets
                        try {
                            $client = new Client();
                            $response = $client->get('https://pcs-all.online:8000/getTicketsByUserId/' . $idUser);
                            $tickets = json_decode($response->getBody(), true)['tickets'];
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger" role="alert">Erreur lors de la récupération des tickets</div>';
                        }
                        foreach ($tickets as $ticket) {
                            echo '<tr>';
                            echo '<th scope="row">' . $ticket['id'] . '</th>';
                            echo '<td>' . $ticket['subject'] . '</td>';
                            $date = new DateTime($ticket['creation_date']);
                            echo '<td>' . $date->format('d/m/y à H:i') . '</td>';
                            echo '<td>' . $ticket['status'] . '</td>';
                            echo '<td><a href="myTicket?id=' . $ticket['id'] . '" class="btn btn-outline-secondary">Voir</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </center>
        </div>
    </div>
</div>






<?php
include "includes/footer.php";
?>