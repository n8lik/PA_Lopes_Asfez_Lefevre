<?php

function ajouterOuMettreAJourNote($idUtilisateur, $idObjet, $nouvelleNote) {
    try {
        $pdo = connectToDB(); 
        
        $sqlVerif = "SELECT id FROM notes WHERE idUtilisateur = :idUtilisateur AND idObjet = :idObjet";
        $stmtVerif = $pdo->prepare($sqlVerif);
        $stmtVerif->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmtVerif->bindParam(':idObjet', $idObjet, PDO::PARAM_INT);
        $stmtVerif->execute();
        $noteExistante = $stmtVerif->fetch(PDO::FETCH_ASSOC);
        
        if ($noteExistante) {
            // Mise à jour de la note existante
            $sqlUpdate = "UPDATE notes SET note = :note, dateNote = NOW() WHERE id = :id";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':note', $nouvelleNote, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':id', $noteExistante['id'], PDO::PARAM_INT);
            $stmtUpdate->execute();
        } else {
            // Insertion d'une nouvelle note
            $sqlInsert = "INSERT INTO notes (idUtilisateur, idObjet, note, dateNote) VALUES (:idUtilisateur, :idObjet, :note, NOW())";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
            $stmtInsert->bindParam(':idObjet', $idObjet, PDO::PARAM_INT);
            $stmtInsert->bindParam(':note', $nouvelleNote, PDO::PARAM_INT);
            $stmtInsert->execute();
        }

        echo "La note a été correctement mise à jour.";
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout ou de la mise à jour de la note : " . $e->getMessage());
    }
}


function ajouterReservation($idUtilisateur, $idObjetReserve, $dateDebut, $dateFin, $statut = 'en attente') {
    try {
        $pdo = connectToDB(); 
        
        $sql = "INSERT INTO reservations (idUtilisateur, idObjetReserve, dateDebut, dateFin, statut) 
                VALUES (:idUtilisateur, :idObjetReserve, :dateDebut, :dateFin, :statut)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':idObjetReserve', $idObjetReserve, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $dateDebut);
        $stmt->bindParam(':dateFin', $dateFin);
        $stmt->bindParam(':statut', $statut);
        $stmt->execute();

        echo "La réservation a été ajoutée avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout de la réservation : " . $e->getMessage());
    }
}

function verifierDisponibiliteLogement($idLogement, $dateDebut, $dateFin) {
    try {
        $pdo = connectToDB(); 
        
        // Préparation de la requête SQL pour trouver des réservations chevauchantes
        $sql = "SELECT COUNT(*) FROM reservations 
                WHERE idLogement = :idLogement 
                AND NOT (dateFin <= :dateDebut OR dateDebut >= :dateFin)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idLogement', $idLogement, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $dateDebut);
        $stmt->bindParam(':dateFin', $dateFin);
        $stmt->execute();

        // Vérification si des réservations chevauchantes existent
        $nombreReservations = $stmt->fetchColumn();

        if ($nombreReservations > 0) {
            // Des réservations chevauchantes ont été trouvées
            return false; // Le logement n'est pas disponible
        } else {
            // Aucune réservation chevauchante n'a été trouvée
            return true; // Le logement est disponible
        }
    } catch (PDOException $e) {
        die("Erreur lors de la vérification de la disponibilité : " . $e->getMessage());
    }
}

function reserverPrestataire($idPrestataire, $idClient, $dateDebut, $dateFin) {
    try {
        $pdo = connectToDB();
        
        $sqlVerif = "SELECT grade FROM utilisateurs WHERE id = :idPrestataire";
        $stmtVerif = $pdo->prepare($sqlVerif);
        $stmtVerif->bindParam(':idPrestataire', $idPrestataire, PDO::PARAM_INT);
        $stmtVerif->execute();
        $grade = $stmtVerif->fetch(PDO::FETCH_ASSOC)['grade'];
        
        if ($grade !== 'prestataire') {
            echo "L'utilisateur sélectionné n'est pas un prestataire.";
            return;
        }
        
        $sql = "INSERT INTO reservations_prestataires (idPrestataire, idClient, dateDebut, dateFin, statut) 
                VALUES (:idPrestataire, :idClient, :dateDebut, :dateFin, 'en attente')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrestataire', $idPrestataire, PDO::PARAM_INT);
        $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $dateDebut);
        $stmt->bindParam(':dateFin', $dateFin);
        $stmt->execute();

        echo "La réservation du prestataire a été effectuée avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de la réservation du prestataire : " . $e->getMessage());
    }
}

function verifierDisponibilitePrestataire($idPrestataire, $dateDebut, $dateFin) {
    try {
        $pdo = connectToDB();
        
        // Préparation de la requête SQL pour trouver des réservations chevauchantes
        $sql = "SELECT COUNT(*) FROM reservations_prestataires 
                WHERE idPrestataire = :idPrestataire 
                AND ((dateDebut < :dateFin AND dateFin > :dateDebut))";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPrestataire', $idPrestataire, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $dateDebut);
        $stmt->bindParam(':dateFin', $dateFin);
        $stmt->execute();

        // Vérification si des réservations chevauchantes existent
        $nombreReservations = $stmt->fetchColumn();

        if ($nombreReservations > 0) {
            // Des réservations chevauchantes ont été trouvées
            return false; // Le prestataire n'est pas disponible
        } else {
            // Aucune réservation chevauchante n'a été trouvée
            return true; // Le prestataire est disponible
        }
    } catch (PDOException $e) {
        die("Erreur lors de la vérification de la disponibilité du prestataire : " . $e->getMessage());
    }
}
