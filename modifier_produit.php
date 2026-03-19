<!--permet modifier infos produit BD -->
<?php
include ("liaison_BD.php");
include ("inscription.php");
include ("session.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id_produit']) && is_numeric($_GET['id_produit'])) {
    $idProduit = $_GET['id_produit'];

    // Récupérer les informations du produit
    $requete = $pdo->prepare("SELECT * FROM Produit WHERE ID_Produit = :id");
    $requete->bindParam(':id', $idProduit, PDO::PARAM_INT);
    $requete->execute();
    $produit = $requete->fetch(PDO::FETCH_ASSOC);

    if ($produit) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom = $_POST['Nom_Produit'];
            $ingredients = $_POST['Ingredients']; // Correction ici
            $allergenes = $_POST['Allergenes'];
            $categorie = $_POST['Categorie'];
            $type = $_POST['Type'];
            $prix = $_POST['Prix'];
            $description = $_POST['Description'];
            $suggestion = $_POST['Suggestion'];

            try {
                // Préparer la requête de mise à jour
                $updateRequete = $pdo->prepare("
                    UPDATE Produit 
                    SET Nom_Produit = :nom, Ingredients = :ingredients, Allergenes = :allergenes, 
                        Categorie = :categorie, Type = :type, Prix = :prix, 
                        Description = :description, Suggestion = :suggestion 
                    WHERE ID_Produit = :id
                ");
                $updateRequete->bindParam(':nom', $nom);
                $updateRequete->bindParam(':ingredients', $ingredients); // Correction ici
                $updateRequete->bindParam(':allergenes', $allergenes);
                $updateRequete->bindParam(':categorie', $categorie);
                $updateRequete->bindParam(':type', $type);
                $updateRequete->bindParam(':prix', $prix);
                $updateRequete->bindParam(':description', $description);
                $updateRequete->bindParam(':suggestion', $suggestion);
                $updateRequete->bindParam(':id', $idProduit, PDO::PARAM_INT);

                // Exécuter la requête
                if ($updateRequete->execute()) {
                    // Redirection vers la page admin_produit.php après mise à jour réussie
                    header("Location: admin_produit.php?success=1");
                    exit;
                } else {
                    echo "<p>Erreur lors de la mise à jour du produit.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>Erreur SQL : " . $e->getMessage() . "</p>";
            }
        }
    } else {
        echo "<p>Produit introuvable.</p>";
        exit;
    }
} else {
    echo "<p>ID du produit invalide.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Modifier le Produit</h1>
    <?php if ($produit): ?>
        <form method="POST" action="">
    <label for="Nom_Produit">Nom :</label>
    <input type="text" id="Nom_Produit" name="Nom_Produit" value="<?= htmlspecialchars($produit['Nom_Produit']) ?>" required>

    <label for="Ingredients">Ingrédients :</label>
    <textarea id="Ingredients" name="Ingredients" required><?= htmlspecialchars($produit['Ingredients']) ?></textarea>

    <label for="Allergenes">Allergènes :</label>
    <textarea id="Allergenes" name="Allergenes" required><?= htmlspecialchars($produit['Allergenes']) ?></textarea>

    <label for="categorie"><b>Catégorie :</b></label>
    <div class="radio-container">
        <input type="radio" id="categorie1" name="Categorie" value="Entree" <?= $produit['Categorie'] === 'Entree' ? 'checked' : '' ?>>
        <label for="categorie1">Entrée</label>
    </div>
    <div class="radio-container">
        <input type="radio" id="categorie2" name="Categorie" value="Plat" <?= $produit['Categorie'] === 'Plat' ? 'checked' : '' ?>>
        <label for="categorie2">Plat</label>
    </div>
    <div class="radio-container">
        <input type="radio" id="categorie3" name="Categorie" value="Dessert" <?= $produit['Categorie'] === 'Dessert' ? 'checked' : '' ?>>
        <label for="categorie3">Dessert</label>
    </div>
    <div class="radio-container">
        <input type="radio" id="categorie4" name="Categorie" value="Boisson" <?= $produit['Categorie'] === 'Boisson' ? 'checked' : '' ?>>
        <label for="categorie4">Boisson</label>
    </div>

    <label for="type"><b>Type :</b></label>
    <div class="radio-container">
        <input type="radio" id="type1" name="Type" value="Chaud" <?= $produit['Type'] === 'Chaud' ? 'checked' : '' ?>>
        <label for="type1">Chaud</label>
    </div>
    <div class="radio-container">
        <input type="radio" id="type2" name="Type" value="Froid" <?= $produit['Type'] === 'Froid' ? 'checked' : '' ?>>
        <label for="type2">Froid</label>
    </div>

    <label for="Prix">Prix :</label>
    <input type="number" id="Prix" name="Prix" value="<?= htmlspecialchars($produit['Prix']) ?>" required>

    <label for="image"><b>Image :</b></label>
    <input type="file" id="image" name="image" accept="image/*"><br>

    <label for="Description">Description :</label>
    <textarea id="Description" name="Description" required><?= htmlspecialchars($produit['Description']) ?></textarea>

    <label for="suggestion"><b>Suggestion :</b></label><br>
    <div class="radio-container">
        <input type="radio" id="suggestion1" name="Suggestion" value="Nouveau Plat" <?= $produit['Suggestion'] === 'Nouveau Plat' ? 'checked' : '' ?>>
        <label for="suggestion1">Nouveau Plat</label>
    </div>
    <div class="radio-container">
        <input type="radio" id="suggestion2" name="Suggestion" value="Boisson Vedette" <?= $produit['Suggestion'] === 'Boisson Vedette' ? 'checked' : '' ?>>
        <label for="suggestion2">Boisson Vedette</label>
    </div>
    <div class="radio-container">
        <input type="radio" id="suggestion3" name="Suggestion" value="Plat de La Semaine" <?= $produit['Suggestion'] === 'Plat de La Semaine' ? 'checked' : '' ?>>
        <label for="suggestion3">Plat de La Semaine</label>
    </div>
    <div class="radio-container">
        <input type="radio" id="suggestion4" name="Suggestion" value="Plat Vedette" <?= $produit['Suggestion'] === 'Plat Vedette' ? 'checked' : '' ?>>
        <label for="suggestion4">Plat Vedette</label>
    </div>
    <div class="radio-container">
        <input type="radio" id="suggestion5" name="Suggestion" value="" <?= empty($produit['Suggestion']) ? 'checked' : '' ?>>
        <label for="suggestion5">Aucune suggestion</label>
    </div>

    <button type="submit">Enregistrer</button>
</form>
    <?php endif; ?>
</body>
</html>