<?php
require "includes/header.php";
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
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
                <?php $user = getUserById($_SESSION['userId']);
                //On affiche le résultat si changement a eu lieu
                if (isset($_SESSION['profileUpdateOk'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['profileUpdateOk'] . '</div>';
                    unset($_SESSION['profileUpdateOk']);
                } elseif (isset($_SESSION['profileUpdateError'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['profileUpdateError'] . '</div>';
                    unset($_SESSION['profileUpdateError']);
                }
                ?>
                <form action=".FutureAPI/profile_update" method="post" class="support-form">
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

                    <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                </form>
            </center>
        </div>
        <div class="tab-pane fade" id="Security" role="tabpanel" aria-labelledby="Security-tab">
            <center>
                <h2>Connexion & sécurité</h2>
                <?php
                if (isset($_SESSION['passwordUpdateOk'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['passwordUpdateOk'] . '</div>';
                    unset($_SESSION['passwordUpdateOk']);
                } elseif (isset($_SESSION['passwordUpdateError'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['passwordUpdateError'] . '</div>';
                    unset($_SESSION['passwordUpdateError']);
                }
                ?>
                <form action=".FutureAPI/pwd_update" method="post" class="support-form">
                    <label for="oldPassword">Ancien mot de passe</label>
                    <input type="password" name="oldPassword" id="oldPassword" class="form-control" style="width: 80% !important; " required>
                    <label for="newPassword">Nouveau mot de passe</label>
                    <input type="password" name="newPassword" id="newPassword" class="form-control" style="width: 80% !important; " required>
                    <label for="confirmPassword">Confirmer le mot de passe</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" style="width: 80% !important; " required>
                    <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                </form>
            </center>
        </div>


        <div class="tab-pane fade" id="Payment" role="tabpanel" aria-labelledby="Payment-tab">
            <center>
                <h2>Moyen de paiement</h2>
            </center>
        </div>



        <div class="tab-pane fade" id="Notifications" role="tabpanel" aria-labelledby="Notifications-tab">
            <center>
                <h2>Notifications</h2>
            </center>
        </div>


        <div class="tab-pane fade" id="Tickets" role="tabpanel" aria-labelledby="Tickets-tab">
            <center>
                <h2>Mes tickets</h2>
                <table class="table table-hover">
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
                        $tickets = getTicketsByUserId($_SESSION['userId']);
                        foreach ($tickets as $ticket) {
                            echo '<tr>';
                            echo '<th scope="row">' . $ticket['id'] . '</th>';
                            echo '<td>' . getTicketSubject($ticket['subject']) . '</td>';
                            $date = new DateTime($ticket['creation_date']);
                            echo '<td>' . $date->format('d/m/y à H:i') . '</td>';
                            echo '<td>' . getTicketStatus($ticket['status']) . '</td>';
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