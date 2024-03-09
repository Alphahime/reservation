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
     
    <h1>Votre billet a été annuler avec succées</h1>

<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['billet_id'])) {
    $billet_id = $_POST['billet_id'];

    try {
        // La requête SQL pour supprimer le billet de la base de données
        $stmt = $conn->prepare("DELETE FROM billet WHERE id_billet = :billet_id");
        $stmt->bindParam(':billet_id', $billet_id);
        $stmt->execute();
      
        echo "Le billet a été supprimé avec succès.";
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>