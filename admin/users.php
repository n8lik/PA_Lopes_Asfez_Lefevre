<?php
require 'includes/admin_header.php';
require 'includes/fun_admin.php';
//Verifier la connexion
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}
//Si y'a un POST qui est envoyé (par rapport au formulaire)
if (isset($_POST['userForm'])) {
    updateUser($_POST['id'], $_POST['pseudo'], $_POST['lastname'], $_POST['firstname'], $_POST['email']);
    //Nettoyer les variables
    unset($_POST['userForm']);
    unset($_POST['id']);
    unset($_POST['pseudo']);
    unset($_POST['lastname']);
    unset($_POST['firstname']);
    unset($_POST['email']);
    unset($_POST['grade']);

}
    

//gerer la suppression d'un utilisateur
if (isset($_POST['deleteUser'])) {
    deleteUser($_POST['id']);
    //Nettoyer les variables
    unset($_POST['deleteUser']);
    unset($_POST['id']);
}

//Si un admin est ajouté
if (isset($_POST['addNewAdmin'])) {
    addNewAdmin($_POST['pseudo'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['pwd'], $_POST['pwdConfirm'], $_POST['grade']);
    //Nettoyer les variables
    unset($_POST['addAdmin']);
    unset($_POST['pseudo']);
    unset($_POST['lastname']);
    unset($_POST['firstname']);
    unset($_POST['email']);
    unset($_POST['pwd']);
    unset($_POST['pwdConfirm']);
    unset($_POST['grade']);
}

//si c'est le choix qui est donné en paramètre :*
if (isset($_GET['choice'])) {
    /*Recuperer le paramètre donné en GET*/
    $id = $_GET['choice'];
    //Switch pour les différents cas
    switch ($id) {
        case 'all':
            $users = getAllUsers(); ?>
            <div class="admin-content">
                <h1> Utilisateurs (<?php echo totalNbUsers();?>)</h1>
            <?php
            break;
        case 'travelers':
            $users = getUsersByGrade("users");
            ?>
            <div class="admin-content">
                <h1> Voyageurs (<?php echo nbUserByGrade(1)+nbUserByGrade(2)+nbUserByGrade(3);?>)</h1>
            <?php
            break;
        case 'landlords':
            $users = getUsersByGrade(4);
            ?>
            <div class="admin-content">
                <h1> Bailleurs (<?php echo nbUserByGrade(4);?>)</h1>
            <?php
            break;
        case 'providers':
            $users = getUsersByGrade(5);
            ?>
            <div class="admin-content">
                <h1> Prestataires (<?php echo nbUserByGrade(5);?>)</h1>
            <?php
            break;
        case 'admins':
            $users = getUsersByGrade(6);
            ?>
            <div class="admin-content">
                <h1> Administrateurs (<?php echo nbUserByGrade(6);?>)</h1>
                <!--Pour ajouter un bouton pour ajouter un admin; viaa une modale. Le traitement est effectué en POST sur ce meme fichier -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddAdmin">
                    Ajouter un administrateur
                </button>
                <div class="modal fade" id="modalAddAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter un administrateur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body ">
                                <form method="post" action="">
                                    <input type="hidden" name="grade" value="6">
                                    <div class="mb-3">
                                        <label for="pseudo" class="form-label">Pseudo</label>
                                        <input type="text" class="form-control" id="pseudo" name="pseudo">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pwd" class="form-label">Mot de passe</label>
                                        <input type="password" class="form-control" id="pwd" name="pwd">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pwdConfirm" class="form-label">Confirmez le mot de passe</label>
                                        <input type="password" class="form-control" id="pwdConfirm" name="pwdConfirm">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary" name="addNewAdmin">Ajouter</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            


            <?php
            break;
        default:

            break;
    }?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Pseudo</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Grade</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $user) {
                            ?>
                            <tr>

                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['pseudo']; ?></td>
                                <td><?php echo $user['lastname']; ?></td>
                                <td><?php echo $user['firstname']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                
                                <td><?php echo getGrade($user['grade']); ?></td>
                                <td><?php echo getUserStatus($user['id']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal<?php echo $user['id']; ?>">
                                        Voir
                                    </button>

                                    <div class="modal fade" id="modal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Informations de <?php echo $user['pseudo']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <!--Faire un formulaire pour afficher les informations de l'utilisateur, que l'on peut modifier-->
                                                <div class="modal-body
                                                ">
                                                    <form id="userForm<?php echo $user['id']; ?>" method="post" action="">
                                                    
                                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="pseudo" class="form-label">Pseudo</label>
                                                            <input type="text" class="form-control" id="pseudo" value="<?php echo $user['pseudo']; ?> " name="pseudo">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="lastname" class="form-label">Nom</label>
                                                            <input type="text" class="form-control" id="lastname" value="<?php echo $user['lastname']; ?>" name="lastname">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="firstname" class="form-label">Prénom</label>
                                                            <input type="text" class="form-control" id="firstname" value="<?php echo $user['firstname']; ?>" name="firstname">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email" value="<?php echo $user['email']; ?>" name="email">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="grade" class="form-label">Grade</label>
                                                            <select class="form-select" id="grade" name="grade">
                                                                <option value="1">Voyageur</option>
                                                                <option value="2">Voyageur VIP1</option>
                                                                <option value="3">Voyageur VIP2</option>
                                                                <option value="4">Bailleur</option>
                                                                <option value="5">Prestataire</option>
                                                                <option value="6">Administrateur</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" form="userForm<?php echo $user['id']; ?>" class="btn btn-info" name="userForm" >Enregistrer les changements</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--Si l'utilisateur est supprimé, on ne peut pas afficher le bouton de suppression-->
                                    <?php if (getUserStatus($user['id']) != "Supprimé") { ?>
                                        <!--Modale pour demander la confirmation de suppression-->
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDelete<?php echo $user['id']; ?>">
                                            Supprimer
                                        </button>
                                        <!--Modale pour demander la confirmation de suppression-->
                                        <div class="modal fade" id="modalDelete<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Supprimer <?php echo $user['pseudo']; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body
                                                    ">
                                                        <p>Êtes-vous sûr de vouloir supprimer <?php echo $user['pseudo']; ?> ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <form method="post" action="">
                                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                            <button type="submit" class="btn btn-danger" name="deleteUser">Supprimer</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
            
<?php
}





include 'includes/admin_footer.php';
?>