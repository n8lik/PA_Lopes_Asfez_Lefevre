<?php
include 'includes/header.php'; // Include the header

// Connexion à la base de données
$conn = connectDB();

// Check if 'id' is present in the URL
if (isset($_GET['id'])) {
    $userId = htmlspecialchars($_GET['id']); // Sanitize the input

    // Prepare the SQL statement to fetch user data
    $sql = "SELECT * FROM ".DB_PREFIX."user WHERE id = :userId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // User found, display information
            echo "<div class='container'>";
            echo "<h1>Profile de l'Utilisateur</h1>";
            echo "<p><strong>Nom:</strong> " . htmlspecialchars($user['nom']) . "</p>";
            echo "<p><strong>Prénom:</strong> " . htmlspecialchars($user['prenom']) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
            echo "<p><strong>Téléphone:</strong> " . htmlspecialchars($user['telephone']) . "</p>";
            echo "</div>";
        } else {
            // No user found with this ID
            echo "<p>Aucun utilisateur trouvé.</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // No ID provided in the URL
    echo "<p>Identifiant d'utilisateur manquant.</p>";
}

include 'includes/footer.php'; // Include the footer
?>
