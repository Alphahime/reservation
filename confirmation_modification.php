<?php
require_once("config.php");

// Vérifier si l'identifiant du billet est passé dans l'URL
if(isset($_GET['billet_id'])) {
    $billet_id = $_GET['billet_id'];

    // Récupérer les détails du billet à partir de la base de données
    try {
        $stmt = $conn->prepare("SELECT * FROM billet WHERE id_billet = :billet_id");
        $stmt->bindParam(':billet_id', $billet_id);
        $stmt->execute();
        $billet = $stmt->fetch(PDO::FETCH_ASSOC);

        // Afficher les détails du billet
        if($billet) {
            echo "Destination : " . $billet['destination'] . "<br>";
            echo "Date de réservation : " . $billet['date_réservation'] . "<br>";
            echo "Heure de réservation : " . $billet['heure_réservation'] . "<br>";
            echo "Prix : " . $billet['prix'] . "€<br>";
        } else {
            echo "Le billet avec l'identifiant $billet_id n'existe pas.";
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} 
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de modification</title>
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

<section class="confirmation">
    <h2>Confirmation de modification</h2>
    <p>Votre modification a été effectuée avec succès.</p>
    <a href="reservation.php">Retour à la page de réservation </a>
</section>

</body>
</html>