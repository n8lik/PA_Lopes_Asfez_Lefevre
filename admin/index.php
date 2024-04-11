<?php
include 'admin_header.php';
?>

<div class="admin-content">
    <div class="admin-content-column">
        <h3>Utilisateurs</h3>
        <ul>
            <li><a href="users.php?=0">Liste des utilisateurs</a></li>
            <li><a href="users.php?=1">En attente de validation</a></li>
        </ul>
    </div>
    <div class="admin-content-column">
        <h3>Annonces</h3>
        <ul>
            <li><a href="ad.php?=0">Liste des annonces logements</a></li>
            <li><a href="ad.php?=1">Liste des annonces prestattions</a></li>
        </ul>
    </div>
</div>




<?php 
include 'admin_footer.php';
?>