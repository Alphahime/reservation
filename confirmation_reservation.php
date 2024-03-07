<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Réservation de billets de voyage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="contain_logo"></div>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="reservation.php">Réservation</a></li>
            
            </ul>
        </nav>
    </header>

<?php
require_once("config.php");

// Récupérer l'identifiant du billet réservé à partir de l'URL
$billet_id = $_GET['billet_id'];

try {
    // Récupérer les informations du billet réservé
    $stmt = $conn->prepare("SELECT * FROM billet WHERE id_billet = :billet_id");
    $stmt->bindParam(':billet_id', $billet_id);
    $stmt->execute();
    $billet = $stmt->fetch(PDO::FETCH_ASSOC);

    // Afficher les détails du billet réservé
    echo "<h2>Confirmation de Réservation</h2>";
    echo "<p>Merci pour votre réservation !</p>";
    echo "<p>Vous avez réservé le billet numéro $billet_id pour la destination {$billet['destination']}.</p>";
    echo "<p>Statut du billet: {$billet['statut']}</p>";
    echo "<h3>Détails du billet réservé :</h3>";
    echo "<p>Date de réservation: {$billet['date_réservation']}</p>";
    echo "<p>Heure de réservation: {$billet['heure_réservation']}</p>";
    echo "<p>Prix: {$billet['prix']}</p>";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
   
</body>
</html>


