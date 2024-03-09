<?php
require_once("config.php");
if(isset($_GET['id_billet'])) {
    $billet_id = $_GET['id_billet'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM billet WHERE id_billet = :billet_id");
        $stmt->bindParam(':billet_id', $billet_id);
        $stmt->execute();
        $billet = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($billet) {
            $destination = $billet['destination'];
            $date_reservation = $billet['date_réservation'];
            $heure_reservation = $billet['heure_réservation'];
            $prix = $billet['prix'];
        } else {
            echo "Billet non trouvé.";
            exit; 
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
  
    echo "Identifiant du billet non spécifié.";
    exit; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_destination = $_POST['destination'];
    $new_date_reservation = isset($_POST['date_réservation']) ? $_POST['date_réservation'] : date('Y-m-d');
    $new_heure_reservation = $_POST['heure_reservation'];
    $new_prix = $_POST['prix'];
    
    try {
        $stmt = $conn->prepare("UPDATE billet SET destination = :destination, date_réservation = :date_reservation, heure_réservation = :heure_reservation, prix = :prix WHERE id_billet = :billet_id");
        $stmt->bindParam(':destination', $new_destination);
        $stmt->bindParam(':date_reservation', $new_date_reservation);
        $stmt->bindParam(':heure_reservation', $new_heure_reservation);
        $stmt->bindParam(':prix', $new_prix);
        $stmt->bindParam(':billet_id', $billet_id);
        $stmt->execute();
        header("Location: confirmation_modification.php?id_billet=$billet_id");
        exit;
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Billet</title>
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
    
    <section class="edit-billet">
        <h2>Modification</h2>
        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_billet=' . $billet_id; ?>" method="post">
            <label for="destination">Destination :</label>
            <input type="text" id="destination" name="destination" value="<?php echo $destination; ?>" required><br>
            <label for="date_reservation">Date de réservation :</label>
            <input type="date" id="date_reservation" name="date_reservation" value="<?php echo $date_reservation; ?>" required><br>
            <label for="heure_reservation">Heure de réservation :</label>
            <input type="time" id="heure_reservation" name="heure_reservation" value="<?php echo $heure_reservation; ?>" required><br>
            <label for="prix">Prix :</label>
            <input type="number"  id="prix" name="prix" value="<?php echo $prix; ?>" required><br>
            <button type="submit" name="submit">Modifier</button>
        </form>
    </section>
</body>
</html>
