<!--visu des produits-->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include ("liaison_BD.php");
include ("inscription.php");
include ("session.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si le formulaire de suppression a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'])) {
    $idProduit = $_POST['id_produit'];

    // Vérifier que l'ID est valide
    if (!empty($idProduit) && is_numeric($idProduit)) {
        // Préparer la requête SQL pour supprimer le produit
        $requete = $pdo->prepare("DELETE FROM Produit WHERE ID_Produit = :id");
        $requete->bindParam(':id', $idProduit, PDO::PARAM_INT);

        // Exécuter la requête
        if ($requete->execute()) {
            $messageSuccess = "Produit supprimé avec succès.";
            // Rediriger pour fermer le pop-up et recharger la page
            header("Location: admin_produit.php?success=1");
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
    <title>CliqueMangé</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="gif-left">
                <img src="images/salade.png" width='150'>
            </div>
            <a href="home_page.php">
                <img src="images/logo.png" width='250'>
            </a> 
            <div class="giv-right">   
                <img src="images/salade.png" width='150'>
            </div>
        </div>
        <nav>
            <div class="nav-left">
                <a class="nav-button" href="Carte.php">A la carte</a>
                <a class="nav-button" href="Formules.php">Formules</a>
            </div>
            <div class="nav-right">
                <!--Permet savoir si session active (aide, enlever pour plus beau visuel)-->
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo "User ID: " . $_SESSION['user_id'] . "<br>";
                    echo "User Role: " . $_SESSION['user_role'] . "<br>";
                } else {
                    echo "Aucune session active.<br>";
                }
                ?>
                <!--Modifie le bouton MonCompte selon si admin ou pas-->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_id'] == 1): ?>
                        <a class="nav-button" href="Admin.php">Mon compte</a>
                    <?php else: ?>
                        <a class="nav-button" href="user.php?id=<?php echo $_SESSION['user_id']; ?>">Mon compte</a>
                    <?php endif; ?>
                <?php else: ?>
                    <button class="nav-button" onclick="document.getElementById('login-modal-toggle').checked = true;">Mon compte</button>
                <?php endif; ?>
                <a class="nav-button" href="panier.php">🛒</a>
            </div>
        </nav>
    </header>

    <main>
        <h1>Liste des Produits</h1>
        <div class="button-ajout-suppression-prod">
            <button class="btn" onclick="window.location.href='admin_ajout_prod.php'">Ajouter</button>
            <label for="delete-modal-toggle" class="btn">Supprimer</label>
            <label for="modify-modal-toggle" class="btn">Modifier</label>
        </div>

        <div class="Tabl_produit">
            <?php
            // Préparer la requête SQL pour récupérer les données de la table Produit
            $requete1 = $pdo->prepare("SELECT * FROM Produit");
            $requete1->execute();

            // Récupérer toutes les lignes de la table Produit
            $lignes = $requete1->fetchAll(PDO::FETCH_ASSOC);

            // Vérifier s'il y a des résultats
            if (count($lignes) > 0) {
                // Créer le tableau HTML
                echo "<table border='1' cellpadding='10' cellspacing='0'>
                        <tr>";

                // Afficher les en-têtes du tableau (noms des colonnes)
                foreach ($lignes[0] as $colonne => $valeur) {
                    echo "<th>" . htmlspecialchars($colonne) . "</th>";
                }
                echo "</tr>";
 
                // Afficher les données des produits
                foreach ($lignes as $ligne) {
                    echo "<tr>";
                    foreach ($ligne as $colonne => $valeur) {
                        if ($colonne == 'Image') {
                            // Afficher le chemin d'accès de l'image au lieu de l'image elle-même
                            echo "<td>" . htmlspecialchars($valeur) . "</td>";
                        } else {
                            echo "<td>" . htmlspecialchars($valeur) . "</td>";
                        }
                    }
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>Aucun produit trouvé dans la base de données.</p>";
            }
            ?>
        </div>

        <!-- Pop-up de suppression -->
        <input type="checkbox" id="delete-modal-toggle" class="modal-toggle">
        <div class="modal">
            <div class="modal-content">
                <h2>Supprimer un Produit</h2>
                <form method="POST" action="">
                    <label for="id_produit">ID du produit à supprimer :</label>
                    <input type="number" id="id_produit" name="id_produit" required>
                    <button type="submit">Valider</button>
                </form>
                <label for="delete-modal-toggle" class="close-button">Fermer</label>
                <?php
                if (isset($messageErreur)) {
                    echo "<p style='color: red;'>$messageErreur</p>";
                }
                ?>
            </div>
        </div>

        <!-- Pop-up de modification -->
        <input type="checkbox" id="modify-modal-toggle" class="modal-toggle">
        <div class="modal">
            <div class="modal-content">
                <h2>Modifier un Produit</h2>
                <form method="GET" action="modifier_produit.php">
                    <label for="id_produit_modif">ID du produit à modifier :</label>
                    <input type="number" id="id_produit_modif" name="id_produit" required>
                    <button type="submit">Valider</button>
                </form>
                <label for="modify-modal-toggle" class="close-button">Fermer</label>
            </div>
        </div>
    </main>
       <!-- ...connexion code... -->
       <input type="checkbox" id="login-modal-toggle" class="modal-toggle">
        <div id="login-modal" class="modal">
            <div class="modal-content">
                <label for="login-modal-toggle" class="close-button">&times;</label>
                <h2>Connexion</h2>
                <form class="formulaire" action="session.php" method="POST">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                    placeholder="Votre Email"required>
        
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" 
                    placeholder="Mot de passe"required>
        
                    <div class="Connexion">
                        <button type="submit">Valider</button>
                    </div>
                    <p>Inscrivez-vous <label for="signup-modal-toggle" class="signup-link">Créer un compte</label></p>
        
                </form>
            </div>
        </div>
        
        <!-- ...inscription... -->
        <input type="checkbox" id="signup-modal-toggle" class="modal-toggle">
        <div id="signup-modal" class="modal">
            <div class="modal-content">
                <label for="signup-modal-toggle" class="close-button">&times;</label>
                <h2>Création de compte</h2>
                <form class="formulaire" action="inscription.php" method="POST">
                    <label for="Nom">Nom :</label>
                    <input type="text" id="Nom" name="Nom" 
                    placeholder="votre nom complet"required>
                    <label for="Prenom">Prénom :</label>
                    <input type="text" id="Prenom" name="Prenom" 
                    placeholder="votre Prénom"required>
                    <label for="email-creation">Email :</label>
                    <input type="email" id="email-creation" name="email-creation" 
                    placeholder="Votre Email"required>
                    <label for="telephone">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" 
                    placeholder="votre numéro de téléphone"required>        
                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse" name="adresse" 
                    placeholder="votre Adresse complete"required>
                    <label for="password-creation">Mot de passe :</label>
                    <input type="password" id="password-creation" name="password-creation" required 
                    placeholder="Mot de passe"required>
                    <!-- Champ caché pour l'ID -->
                    <input type="hidden" id="ID" name="ID">
                    <div class="création">
                    <button type="submit">Créer un compte</button>
                    </div>     
                </form>
            </div>
        </div>

</main>
<footer>
    <p>Nous contacter : cliquemangé@gmail.com</p>
    <p>Projet Gphy, CliqueMangé. Tous droits réservés.</p>
    <p>2025</p>
</footer>
</body>
</html>


