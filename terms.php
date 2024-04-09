<?php include 'includes/header.php';
//on vérifie que le paramètre id est bien un entier
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    if ($id ==0) {
        //SI le paramètre id vaut 0 on affiche la rubrique qui sommes nous
        ?>
        <div class="terms-container">
            <div class="terms-content">
                <h2>Qui sommes nous?</h2>
                <p>PCS est une entreprise spécialisée dans le développement de logiciels. <br>
                Nous proposons des solutions innovantes pour les entreprises et les particuliers. Notre équipe est composée de développeurs expérimentés qui travaillent en collaboration avec nos clients pour répondre à leurs besoins.</p>
            </div>
        </div>


        <?php
    }else if ($id == 1) {
        //SI le paramètre id vaut 1 on affiche la rubrique nouvelles fonctionnalités
        ?>
        <div class="terms-container">
            <div class="terms-content">
                <h2>Nouvelles fonctionnalités</h2>
                <p>Nous travaillons constamment à l'amélioration de nos produits. <br>
                Vous trouverez ici les dernières fonctionnalités ajoutées à nos logiciels.</p>
            </div>
        </div>
        
        <?php
    }else if ($id == 2) {
        //SI le paramètre id vaut 2 on affiche la rubrique mentions légales
        ?>
        <div class="terms-container">
            <div class="terms-content">
                <h2>Mentions légales</h2>
                <p>Ce site est la propriété de PCS. <br>
                Il a été créé dans le cadre d'un projet scolaire et n'a pas vocation à être utilisé dans un contexte professionnel.</p>
            </div>
        </div>
        
        <?php
    }else if ($id == 3) {
        //SI le paramètre id vaut 3 on affiche la rubrique conditions générales
        ?>
        <div class="terms-container">
            <div class="terms-content">
                <h2>Conditions générales</h2>
                <p>En utilisant ce site, vous acceptez les conditions générales d'utilisation. <br>
                Vous pouvez consulter nos mentions légales pour plus d'informations.</p>
            </div>
        </div>
        
        <?php
    }else if ($id == 4) {
        //SI le paramètre id vaut 4 on affiche la rubrique avis de propriété intellectuelle
        ?>
        <div class="terms-container">
            <div class="terms-content">
                <h2>Avis de propriété intellectuelle</h2>
                <p>Les contenus de ce site sont protégés par le droit d'auteur. <br>
                Toute reproduction ou utilisation sans autorisation est interdite.</p>
            </div>
        </div>
        
        <?php
    }else{
        //SI le paramètre id ne correspond à aucune rubrique on affiche un message d'erreur
        ?>
        <div class="terms-container">
            <div class="terms-content">
                <h2>Erreur 404</h2>
                <p>La page demandée n'existe pas</p>
            </div>
        </div>
        <?php
    }
}else{
    //SI le paramètre id n'est pas présent on affiche un message d'erreur
    ?>
    <div class="terms-container">
        <div class="terms-content">
            <h2>Erreur 404</h2>
            <p>La page demandée n'existe pas</p>
        </div>
    </div>
    <?php
}
include 'includes/footer.php';
?>