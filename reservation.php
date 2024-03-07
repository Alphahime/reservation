<?php
require_once("config.php");

// Récupération des billets depuis la base de données
try {
    $stmt = $conn->query("SELECT * FROM billet");
    $billets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Traitement du formulaire d'achat, de modification ou de suppression
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['action']) && isset($_POST['billet_id'])) {
        $action = $_POST['action'];
        $billet_id = $_POST['billet_id'];
        
        if ($action == 'achat') {
            try {
                // Mettre à jour le statut du billet dans la base de données
                $stmt = $conn->prepare("UPDATE billet SET statut = 'Réservé' WHERE id_billet = :billet_id");
                $stmt->bindParam(':billet_id', $billet_id);
                $stmt->execute();
                // Rediriger l'utilisateur vers la page de confirmation de réservation
                header("Location: confirmation_reservation.php?billet_id=" . $billet_id);
                exit;
            } catch(PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } elseif ($action == 'modifier') {
            // Rediriger l'utilisateur vers une page de modification avec l'identifiant du billet en paramètre
            header("Location: edit.php?id_billet=" . $billet_id);
            exit;
        } elseif ($action == 'supprimer') {
            // Logique pour supprimer un billet
            try {
                // Exécuter la requête SQL pour supprimer le billet de la base de données
                $stmt = $conn->prepare("DELETE FROM billet WHERE id_billet = :billet_id");
                $stmt->bindParam(':billet_id', $billet_id);
                $stmt->execute();
                // Rediriger l'utilisateur vers une page de confirmation de suppression
                header("Location: confirmation_suppression.php");
                exit;
            } catch(PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
    } else {
        echo "Erreur : Action ou identifiant de billet non spécifié.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des billets disponibles</title>
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

<section class="billets">
    <h2>Billets disponibles</h2>
    <div class="billets-container">
        <?php foreach ($billets as $billet) : ?>
            <div class="billet-item">
                <?php echo $billet['destination'] . ' - ' . $billet['date'] . ' ' . $billet['heure'] . ' (' . $billet['prix'] . '€)'; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="billet_id" value="<?php echo $billet['id_billet']; ?>">
                    <button type="submit" name="action" value="achat">Réserver</button>
                    <button type="submit" name="action" value="modifier">Modifier</button>
                    <button type="submit" name="action" value="supprimer">Annuler</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<footer>
    <p>&copy; 2024 Somplon Travel </p>
</footer>
</body>
</html>
