<!--Page Accueil-->
<?php
include ("liaison_BD.php");
include ("inscription.php");
include ("session.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
        <div class="gif-right">   
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
<div class="container_page">
    <div class="descriptif_page">
        <h2>DESCRIPTIF</h2>
        <div class="description">
        <p>CliquéMangé vous propose une large gamme de produits issu de cuisine végétarienne, cela passant par du sucré/salé, des boissoins mais aussi des formules.</p>
        <p>L'ensemble des produits du site sont proposé en livraison ou à emporter</p>
        <p>Bon Appétit!</p>
        </div>
    </div>

    <div class="bottom-container-page">
        <div class="formules">
            <h2>FORMULES</h2>
            <ul>
            <div class="buttons_link_formules">
                <li><a href="Formules.php">Pour ceux qui mangent bien à la cantine</a></li>
                <li><a href="Formules.php">Le classico-classique</a></li>
                <li><a href="Formules.php">Pour les gnomes</a></li>
                <li><a href="Formules.php">Pour les boursiers</a></li>
            </div>
            </ul>
        </div>

        <div class="suggestions">
        <h2>SUGGESTIONS</h2>
            <div class="buttons">
            <?php
            $query = "SELECT ID_Produit, Nom_Produit, Image, Suggestion FROM Produit WHERE Suggestion Like 'Nouveau Plat' or Suggestion Like 'Plat Vedette' or Suggestion Like 'Plat de la Semaine' or Suggestion Like 'Boisson Vedette'";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($suggestions as $suggestion): ?>
                    <div class="menu-item">
                        <a href="aliment.php?id=<?php echo htmlspecialchars($suggestion['ID_Produit']); ?>" class="item-link">
                            <div class="item-photo">
                                <img src="images/<?php echo htmlspecialchars($suggestion['Image']); ?>" 
                                alt="Photo de <?php echo htmlspecialchars($suggestion['Nom_Produit']); ?>" 
                                class="item-photo img">
                            </div>
                            <div class="item-info">
                                <p><?php echo htmlspecialchars($suggestion['Nom_Produit']); ?></p>
                                <p><b><?php echo htmlspecialchars($suggestion['Suggestion']); ?></b></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

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



