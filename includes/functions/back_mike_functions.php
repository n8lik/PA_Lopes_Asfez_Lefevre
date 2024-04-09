<?php
function connectToDB() {
    $host = 'localhost'; // Remplacez par votre serveur de base de données
    $dbname = 'nom_de_votre_base'; // Remplacez par le nom de votre base de données
    $username = 'votre_utilisateur'; // Remplacez par votre nom d'utilisateur de base de données
    $password = 'votre_mot_de_passe'; // Remplacez par votre mot de passe de base de données
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}


function getValidationsEnAttente() {
    try {
        $pdo = connectToDB(); 

        $sql = "SELECT * FROM validations WHERE statut = 'en_attente'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    } catch (Exception $e) {
        die("Erreur lors de la récupération des validations en attente : " . $e->getMessage());
    }
}
// Utilisation de la fonction pour obtenir les validations en attente
// $validationsEnAttente = getValidationsEnAttente();
// foreach ($validationsEnAttente as $validation) {
//     // Traitez chaque validation ici...
//     echo "ID de validation : " . $validation['id'] . "<br>"; // Exemple d'affichage de l'ID
// }

function validerDemande($idDemande) {
    try {
        $pdo = connectToDB();
        $sql = "UPDATE validations SET statut = 'valide' WHERE id = :idDemande";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idDemande', $idDemande, PDO::PARAM_INT);
        $stmt->execute();

        echo "La demande #$idDemande a été validée avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de la validation de la demande #$idDemande : " . $e->getMessage());
    }
}

function refuserDemande($idDemande) {
    try {
        $pdo = connectToDB();
        $sql = "UPDATE validations SET statut = 'refuse' WHERE id = :idDemande";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idDemande', $idDemande, PDO::PARAM_INT);
        $stmt->execute();

        echo "La demande #$idDemande a été refusée.";
    } catch (PDOException $e) {
        die("Erreur lors du refus de la demande #$idDemande : " . $e->getMessage());
    }
}

function mettreEnReVerification($idDemande) {
    try {
        $pdo = connectToDB();
        $sql = "UPDATE validations SET statut = 're vérification' WHERE id = :idDemande";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idDemande', $idDemande, PDO::PARAM_INT);
        $stmt->execute();

        echo "La demande #$idDemande a été mise en 're vérification'.";
    } catch (PDOException $e) {
        die("Erreur lors de la mise en 're vérification' de la demande #$idDemande : " . $e->getMessage());
    }
}

function modifierPrixDemande($idDemande, $nouveauPrix) {
    try {
        $pdo = connectToDB();
        $sql = "UPDATE validations SET nouveauprix = :nouveauPrix WHERE id = :idDemande";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idDemande', $idDemande, PDO::PARAM_INT);
        $stmt->bindParam(':nouveauPrix', $nouveauPrix, PDO::PARAM_STR); 
        $stmt->execute();

        echo "Le prix de la demande #$idDemande a été mis à jour avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour du prix pour la demande #$idDemande : " . $e->getMessage());
    }
}

function recupererToutesLesAnnonces() {
    try {
        $pdo = connectToDB(); 
        $sql = "SELECT * FROM annonces";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $annonces;
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des annonces : " . $e->getMessage());
    }
}

function rechercherAnnonces($termeDeRecherche) {
    $termeDeRecherche = "%{$termeDeRecherche}%"; // Préparation du terme de recherche pour la requête SQL avec des wildcards
    try {
        $pdo = connectToDB(); // Utilisez votre fonction existante pour se connecter à la DB
        $sql = "SELECT * FROM annonces WHERE titre LIKE :termeDeRecherche OR description LIKE :termeDeRecherche";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':termeDeRecherche', $termeDeRecherche, PDO::PARAM_STR);
        $stmt->execute();

        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    } catch (PDOException $e) {
        die("Erreur lors de la recherche : " . $e->getMessage());
    }
}

//exemple d'utilisation de la fonction rechercherAnnonces
// if (!empty($_GET['recherche'])) { // Vérifie si un terme de recherche a été fourni
//     $termeDeRecherche = $_GET['recherche'];
//     $annoncesTrouvees = rechercherAnnonces($termeDeRecherche);

//     foreach ($annoncesTrouvees as $annonce) {
//         echo "Titre: " . htmlspecialchars($annonce['titre']) . "<br>";
//         echo "Description: " . nl2br(htmlspecialchars($annonce['description'])) . "<br>";
//         echo "Prix: " . htmlspecialchars($annonce['prix']) . "€<br>";
//         echo "<hr>"; // Séparateur pour chaque annonce trouvée
//     }
// } else {
//     echo "Veuillez saisir un terme de recherche.";
// }

function rechercherAnnoncesAvecTri($termeDeRecherche, $ordreDeTri = 'ASC') {
    $termeDeRecherche = "%{$termeDeRecherche}%";
    $ordreDeTri = strtoupper($ordreDeTri) === 'ASC' ? 'ASC' : 'DESC'; // Validation de l'ordre de tri

    try {
        $pdo = connectToDB();
        // Attention: Ne pas injecter directement des variables non validées dans votre SQL. Ici, $ordreDeTri est contrôlé.
        $sql = "SELECT * FROM annonces WHERE titre LIKE :termeDeRecherche OR description LIKE :termeDeRecherche ORDER BY prix $ordreDeTri";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':termeDeRecherche', $termeDeRecherche, PDO::PARAM_STR);
        $stmt->execute();

        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    } catch (PDOException $e) {
        die("Erreur lors de la recherche : " . $e->getMessage());
    }
}
// ex d'utilisation de la fonction rechercherAnnoncesAvecTri
// $termeDeRecherche = ''; // Votre terme de recherche, peut être vide pour récupérer toutes les annonces
// $ordreDeTri = 'ASC'; // Utilisez 'DESC' pour trier du prix le plus élevé au plus bas

// $annonces = rechercherAnnoncesAvecTri($termeDeRecherche, $ordreDeTri);

// foreach ($annonces as $annonce) {
//     echo "Titre: " . htmlspecialchars($annonce['titre']) . "<br>";
//     echo "Description: " . nl2br(htmlspecialchars($annonce['description'])) . "<br>";
//     echo "Prix: " . htmlspecialchars($annonce['prix']) . "€<br>";
//     echo "<hr>"; // Séparateur pour chaque annonce
// }

function rechercherAnnoncesParNote($termeDeRecherche, $noteMinimale, $ordreDeTri = 'ASC') {
    $termeDeRecherche = "%{$termeDeRecherche}%";
    $ordreDeTri = strtoupper($ordreDeTri) === 'ASC' ? 'ASC' : 'DESC'; // Validation de l'ordre de tri
    
    try {
        $pdo = connectToDB();
        $sql = "SELECT * FROM annonces WHERE (titre LIKE :termeDeRecherche OR description LIKE :termeDeRecherche) AND note >= :noteMinimale ORDER BY prix $ordreDeTri";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':termeDeRecherche', $termeDeRecherche, PDO::PARAM_STR);
        $stmt->bindParam(':noteMinimale', $noteMinimale, PDO::PARAM_INT);
        $stmt->execute();

        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultats;
    } catch (PDOException $e) {
        die("Erreur lors de la recherche filtrée par note : " . $e->getMessage());
    }
}

// $termeDeRecherche = ''; // Votre terme de recherche, peut être vide
// $noteMinimale = 3; // Filtrer pour obtenir les annonces avec une note de 3 ou plus
// $ordreDeTri = 'DESC'; // Trier par prix décroissant, par exemple

// $annonces = rechercherAnnoncesParNote($termeDeRecherche, $noteMinimale, $ordreDeTri);

// foreach ($annonces as $annonce) {
//     echo "Titre: " . htmlspecialchars($annonce['titre']) . "<br>";
//     echo "Description: " . nl2br(htmlspecialchars($annonce['description'])) . "<br>";
//     echo "Note: " . htmlspecialchars($annonce['note']) . "/5<br>";
//     echo "Prix: " . htmlspecialchars($annonce['prix']) . "€<br>";
//     echo "<hr>"; // Séparateur pour chaque annonce
// }
function supprimerAnnonce($idAnnonce) {
    try {
        $pdo = connectToDB(); // Assurez-vous que cette fonction est bien définie et fonctionnelle
        $sql = "DELETE FROM annonces WHERE id = :idAnnonce";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idAnnonce', $idAnnonce, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "L'annonce #$idAnnonce a été supprimée avec succès.";
        } else {
            echo "Aucune annonce trouvée avec l'ID #$idAnnonce.";
        }
    } catch (PDOException $e) {
        die("Erreur lors de la suppression de l'annonce #$idAnnonce : " . $e->getMessage());
    }
}

function supprimerCommentaire($idCommentaire) {
    try {
        $pdo = connectToDB();
        $sql = "DELETE FROM commentaires WHERE id = :idCommentaire";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCommentaire', $idCommentaire, PDO::PARAM_INT);
        $stmt->execute();

    } catch (PDOException $e) {
        die("Erreur lors de la suppression du commentaire : " . $e->getMessage());
    }
}


function modifierCommentaire($idCommentaire, $nouveauContenu) {
    try {
        $pdo = connectToDB();
        $sql = "UPDATE commentaires SET contenu = :nouveauContenu WHERE id = :idCommentaire";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nouveauContenu', $nouveauContenu, PDO::PARAM_STR);
        $stmt->bindParam(':idCommentaire', $idCommentaire, PDO::PARAM_INT);
        $stmt->execute();

    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour du commentaire : " . $e->getMessage());
    }
}

function ajouterSignalement($idCommentaire, $raison) {
    try {
        $pdo = connectToDB();
        $sql = "INSERT INTO signalements (idCommentaire, raison) VALUES (:idCommentaire, :raison)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCommentaire', $idCommentaire, PDO::PARAM_INT);
        $stmt->bindParam(':raison', $raison, PDO::PARAM_STR);
        $stmt->execute();

    } catch (PDOException $e) {
        die("Erreur lors de l'ajout du signalement : " . $e->getMessage());
    }
}

function ajouterCommentaire($idUtilisateur, $idArticle, $contenu) {
    try {
        $pdo = connectToDB();
        $sql = "INSERT INTO commentaires (idUtilisateur, idArticle, contenu, datePublication) VALUES (:idUtilisateur, :idArticle, :contenu, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':idArticle', $idArticle, PDO::PARAM_INT);
        $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        $stmt->execute();

        echo "Le commentaire a été ajouté avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout du commentaire : " . $e->getMessage());
    }
}

function recupererTickets() {
    try {
        $pdo = connectToDB();
        $sql = "SELECT t.*, u.nom AS nomUtilisateur, t.statut FROM tickets t JOIN utilisateurs u ON t.idUtilisateur = u.id ORDER BY t.dateCreation DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tickets;
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des tickets : " . $e->getMessage());
    }
}



function passerTicketEnCours($idTicket) {
    try {
        $pdo = connectToDB();
        $sql = "UPDATE tickets SET statut = 'en cours' WHERE id = :idTicket";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Le ticket #$idTicket a été passé à 'en cours' avec succès.";
        } else {
            echo "Aucun ticket trouvé avec l'ID #$idTicket, ou le ticket est déjà 'en cours'.";
        }
    } catch (PDOException $e) {
        die("Erreur lors du changement du statut du ticket : " . $e->getMessage());
    }
}

function cloreTicket($idTicket) {
    try {
        $pdo = connectToDB();
        $sql = "UPDATE tickets SET statut = 'clos' WHERE id = :idTicket";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Le ticket #$idTicket a été clos avec succès.";
        } else {
            echo "Aucun ticket trouvé avec l'ID #$idTicket, ou le ticket est déjà 'clos'.";
        }
    } catch (PDOException $e) {
        die("Erreur lors de la fermeture du ticket : " . $e->getMessage());
    }
}


function afficherUtilisateurs() {
    try {
        $pdo = connectToDB(); 
        $sql = "SELECT id, nom, email, categorie FROM utilisateurs ORDER BY nom";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($utilisateurs)) {
            echo "<ul>";
            foreach ($utilisateurs as $utilisateur) {
                echo "<li>ID: " . htmlspecialchars($utilisateur['id']) . 
                     ", Nom: " . htmlspecialchars($utilisateur['nom']) .
                     ", Email: " . htmlspecialchars($utilisateur['email']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Aucun utilisateur trouvé.";
        }
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
    }
}

function rechercherUtilisateursAvecNote($termeDeRecherche, $noteMinimale) {
    try {
        $pdo = connectToDB();
        // Modification de la requête pour inclure un filtre sur la note
        $sql = "SELECT id, nom, email, categorie, note FROM utilisateurs 
                WHERE (nom LIKE :termeDeRecherche OR email LIKE :termeDeRecherche) 
                AND note >= :noteMinimale 
                ORDER BY nom";
        $stmt = $pdo->prepare($sql);
        $termeDeRecherche = "%" . $termeDeRecherche . "%";
        $stmt->bindParam(':termeDeRecherche', $termeDeRecherche, PDO::PARAM_STR);
        $stmt->bindParam(':noteMinimale', $noteMinimale, PDO::PARAM_INT);
        $stmt->execute();

        $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($utilisateurs)) {
            echo "<ul>";
            foreach ($utilisateurs as $utilisateur) {
                echo "<li>ID: " . htmlspecialchars($utilisateur['id']) . 
                     ", Nom: " . htmlspecialchars($utilisateur['nom']) .
                     ", Email: " . htmlspecialchars($utilisateur['email']) .
                     ", Catégorie: " . htmlspecialchars($utilisateur['categorie']) .
                     ", Note: " . htmlspecialchars($utilisateur['note']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Aucun utilisateur trouvé correspondant aux critères de recherche.";
        }
    } catch (PDOException $e) {
        die("Erreur lors de la recherche des utilisateurs : " . $e->getMessage());
    }
}
// exemple d'utilisation de la fonction rechercherUtilisateursAvecNote
// $termeDeRecherche = "john"; // Le terme de recherche
// $noteMinimale = 4; // Filtrer les utilisateurs avec une note de 4 ou plus
// rechercherUtilisateursAvecNote($termeDeRecherche, $noteMinimale);

function recupererInfosUtilisateur($idUtilisateur) {
    try {
        $pdo = connectToDB();

        // Récupérer la note moyenne de l'utilisateur
        $sqlNote = "SELECT AVG(valeur) AS noteMoyenne FROM notes WHERE idUtilisateur = :idUtilisateur";
        $stmtNote = $pdo->prepare($sqlNote);
        $stmtNote->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmtNote->execute();
        $noteMoyenne = $stmtNote->fetch(PDO::FETCH_ASSOC)['noteMoyenne'];

        // Récupérer les commentaires de l'utilisateur
        $sqlCommentaires = "SELECT contenu FROM commentaires WHERE idUtilisateur = :idUtilisateur";
        $stmtCommentaires = $pdo->prepare($sqlCommentaires);
        $stmtCommentaires->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmtCommentaires->execute();
        $commentaires = $stmtCommentaires->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer l'abonnement de l'utilisateur
        $sqlAbonnement = "SELECT type FROM abonnements WHERE idUtilisateur = :idUtilisateur";
        $stmtAbonnement = $pdo->prepare($sqlAbonnement);
        $stmtAbonnement->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmtAbonnement->execute();
        $abonnement = $stmtAbonnement->fetch(PDO::FETCH_ASSOC)['type'];

        // Affichage des résultats
        echo "Note moyenne de l'utilisateur : " . htmlspecialchars($noteMoyenne) . "<br>";
        echo "Commentaires de l'utilisateur :<ul>";
        foreach ($commentaires as $commentaire) {
            echo "<li>" . htmlspecialchars($commentaire['contenu']) . "</li>";
        }
        echo "</ul>";
        echo "Type d'abonnement de l'utilisateur : " . htmlspecialchars($abonnement);

    } catch (PDOException $e) {
        die("Erreur lors de la récupération des informations de l'utilisateur : " . $e->getMessage());
    }
}

function supprimerUtilisateur($idUtilisateur) {
    try {
        $pdo = connectToDB();
        $sql = "DELETE FROM utilisateurs WHERE id = :idUtilisateur";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();

        echo "L'utilisateur a été supprimé avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['idUtilisateur'])) {
    $idUtilisateur = $_POST['idUtilisateur'];
    supprimerUtilisateur($idUtilisateur);
    // Redirection ou autre logique après suppression
} else {
    echo "Aucun utilisateur spécifié pour la suppression.";
}


// Exemple d'un bouton de suppression pour l'utilisateur avec l'ID 1 
// <form method="POST" action="supprimerUtilisateur.php" onsubmit="return confirmerSuppression();">
//     <input type="hidden" name="idUtilisateur" value="1">
//     <input type="submit" value="Supprimer l'utilisateur">
// </form>

// <script>
// function confirmerSuppression() {
//     return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.');
// }
// </script>

