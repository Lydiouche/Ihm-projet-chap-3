<!--permet supprimer produit a BD -->
<?php
include ("liaison_BD.php");
include ("inscription.php");
include ("session.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID du produit à supprimer
    $idProduit = $_POST['id_produit'];

    // Vérifier que l'ID est valide
    if (!empty($idProduit) && is_numeric($idProduit)) {
        // Préparer la requête SQL pour supprimer le produit
        $requete = $pdo->prepare("DELETE FROM Produit WHERE id = :id");
        $requete->bindParam(':id', $idProduit, PDO::PARAM_INT);

        // Exécuter la requête
        if ($requete->execute()) {
            // Rediriger vers la page admin_produit.php après suppression
            header("Location: admin_produit.php");
            exit;
        } else {
            $messageErreur = "Erreur lors de la suppression du produit.";
        }
    } else {
        $messageErreur = "Veuillez entrer un ID valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Produit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Supprimer un Produit</h1>
    </header>
    <main>
        <form method="POST" action="supprimer_produit.php">
            <label for="id_produit">ID du produit à supprimer :</label>
            <input type="number" id="id_produit" name="id_produit" required>
            <button type="submit">Valider</button>
        </form>
        <?php
        if (isset($messageErreur)) {
            echo "<p style='color: red;'>$messageErreur</p>";
        }
        ?>
    </main>
    <footer>
        <p>Nous contacter : cliquemangé@gmail.com</p>
        <p>Projet Gphy, CliqueMangé. Tous droits réservés.</p>
        <p>2025</p>
    </footer>
</body>
</html>