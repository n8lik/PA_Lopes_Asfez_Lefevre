<?php
include 'admin_header.php';
/*Recuperer le paramètre donné en GET*/
$id = $_GET['id'];
/*Si le paramètre est 0, afficher une zone de recherche incluant des filtres pour echercher un utilisateur*/
if ($id == 0) {
    echo '<div class="admin-content"><h3>Rechercher un utilisateur</h3>';
    echo '<form action="users.php?id=0" method="post">';
    echo '<input type="text" name="search" placeholder="Rechercher un utilisateur">';
    echo '<select name="role">';
    echo '<option value="0">Tous les rôles</option>';
    echo '<option value="1">Administrateur</option>';
    echo '<option value="2">Utilisateur</option>';
    echo '</select>';
    echo '<input type="submit" value="Rechercher">';
    echo '</form></div>';
    }if (isset($_POST['search'])) {
        /*Si le formulaire est soumis, afficher les résultats de la recherche*/
        $search = $_POST['search'];
        $role = $_POST['role'];
        /*Rechercher dans la base de données les utilisateurs correspondant aux critères de recherche*/
        /*Afficher les résultats*/
    }


/*Si le paramètre est 1, afficher une liste des utilisateurs en attente de validation*/


include 'admin_footer.php';
?>