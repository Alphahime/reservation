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
