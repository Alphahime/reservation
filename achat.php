<?php  
if ($action == 'achat') {
    try {
        // Vérifier si le billet est déjà acheté (statut différent de "Disponible")
        $stmt = $conn->prepare("SELECT statut FROM billet WHERE id_billet = :billet_id");
        $stmt->bindParam(':billet_id', $billet_id);
        $stmt->execute();
        $billet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($billet['statut'] == 'Disponible') {
            // Mettre à jour le statut du billet pour marquer comme acheté
            $stmt = $conn->prepare("UPDATE billet SET statut = 'Achete' WHERE id_billet = :billet_id");
            $stmt->bindParam(':billet_id', $billet_id);
            $stmt->execute();
            // Redirection vers une page de confirmation ou une autre page
            header("Location: confirmation.php");
            exit;
        } else {
            echo "Ce billet n'est plus disponible.";
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}



?>