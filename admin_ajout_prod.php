<!--permet ajout produit a BD -->
<?php
include ("liaison_BD.php");
include ("inscription.php");
include ("session.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Récupérer les données du formulaire
        $Nom_Produit = $_POST['nom_produit'];
        $Ingredients = $_POST['ingredients'];
        $Allergenes = $_POST['allergenes'];
        $Categorie = $_POST['categorie'];
        $Type = $_POST['type'];
        $Prix = $_POST['prix'];
        $Description = $_POST['description'];
        $Suggestion = isset($_POST['suggestion']) ? $_POST['suggestion'] : null;

        // Gérer l'upload de l'image
        $Image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $Image = $target_file;
            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }

        // Préparer la requête SQL pour insérer les données
        $ajout = $pdo->prepare("INSERT INTO Produit (Nom_Produit, Ingredients, Allergenes, Categorie, Type, Prix, Image, Description, Suggestion) 
                                VALUES (:Nom_Produit, :Ingredients, :Allergenes, :Categorie, :Type, :Prix, :Image, :Description, :Suggestion)");

        $ajout->bindParam(':Nom_Produit', $Nom_Produit);
        $ajout->bindParam(':Ingredients', $Ingredients);
        $ajout->bindParam(':Allergenes', $Allergenes);
        $ajout->bindParam(':Categorie', $Categorie);
        $ajout->bindParam(':Type', $Type);
        $ajout->bindParam(':Prix', $Prix);
        $ajout->bindParam(':Image', $Image, PDO::PARAM_LOB);
        $ajout->bindParam(':Description', $Description);
        $ajout->bindParam(':Suggestion', $Suggestion);

        if ($ajout->execute()) {
            header('Location: admin_produit.php');
            exit;
        } else {
            echo "Une erreur est survenue lors de l'ajout";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1><b>Ajouter un Produit</b></h1>
    <form action="admin_ajout_prod.php" method="post" enctype="multipart/form-data">
        <label for="nom_produit"><b>Nom du Produit:</b></label>
        <input type="text" id="nom_produit" name="nom_produit" required><br>

        <label for="ingredients"><b>Ingredients:</b></label>
        <input type="text" id="ingredients" name="ingredients" required><br>

        <label for="allergenes"><b>Allergènes:</b></label>
        <input type="text" id="allergenes" name="allergenes" required><br>

        <label for="categorie"><b>Catégorie:</b></label>
        <div class="radio-container">
            <input type="radio" id="categorie1" name="categorie" value="Entree">
            <label for="categorie1">Entree</label>
        </div>
        <div class="radio-container">
            <input type="radio" id="categorie2" name="categorie" value="Plat">
            <label for="categorie2">Plat</label>
        </div>
        <div class="radio-container">
            <input type="radio" id="categorie3" name="categorie" value="Dessert">
            <label for="categorie3">Dessert</label>
        </div>
        <div class="radio-container">
            <input type="radio" id="categorie4" name="categorie" value="Boisson">
            <label for="categorie4">Boisson</label>
        </div>

        <label for="type"><b>Type:</b></label>
        <div class="radio-container">
            <input type="radio" id="type1" name="type" value="Chaud">
            <label for="type1">Chaud</label>
        </div>
        <div class="radio-container">
            <input type="radio" id="type2" name="type" value="Froid">
            <label for="type2">Froid</label>
        </div>

        <label for="prix"><b>Prix:</b></label>
        <input type="number" step="0.01" id="prix" name="prix" required><br>

        <label for="image"><b>Image:</b></label>
        <input type="file" id="image" name="image" accept="image/*"><br>

        <label for="description"><b>Description:</b></label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="suggestion"><b>Suggestion:</b></label><br>
        <div class="radio-container">
            <input type="radio" id="suggestion1" name="suggestion" value="Nouveau Plat">
            <label for="suggestion1">Nouveau Plat</label>
        </div>
        <div class="radio-container">
            <input type="radio" id="suggestion2" name="suggestion" value="Boisson Vedette">
            <label for="suggestion2">Boisson Vedette</label>
        </div>
        <div class="radio-container">
            <input type="radio" id="suggestion3" name="suggestion" value="Plat de La Semaine">
            <label for="suggestion3">Plat de La Semaine</label>
        </div>
        <div class="radio-container">
            <input type="radio" id="suggestion4" name="suggestion" value="Plat Vedette">
            <label for="suggestion4">Plat Vedette</label>
        </div>
        <p>(Critère non obligatoire)</p>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>