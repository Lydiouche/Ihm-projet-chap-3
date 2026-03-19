<!--page A la carte-->
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
        <!-- LE FILTRE-->
        <div class="button-filtre">
            <button class="filtrer-button" onclick="document.getElementById('filter-modal-toggle').checked = true;">Filtrer</button>
        </div>

        <!-- Modal de filtre -->
        <input type="checkbox" id="filter-modal-toggle" class="modal-toggle">
        <div id="filter-modal" class="modal">
            <div class="modal-content">
                <label for="filter-modal-toggle" class="close-button">&times;</label>
                <h2>Filtrer</h2>
                <form>
                    <!-- Les champs du filtre -->
                    <label for="Prix-max"> Prix maximum:</label>
                    <input type="number" id="Prix-max" name="Prix-max" min="0" max="100" step="0.01" value="20">

                    <label>Quels sont vos allergènes ? :</label>
                    <div class="checkbox-group">                       
                        <input type="checkbox" id="gluten" name="Allergenes[]" value="gluten">
                        <label for="gluten">Gluten</label><br>  
                        <input type="checkbox" id="lactose" name="Allergenes[]" value="lactose">
                        <label for="lactose">Lactose</label><br> 
                        <input type="checkbox" id="malt" name="Allergenes[]" value="malt">
                        <label for="malt">Malt</label><br>  
                        <input type="checkbox" id="aucun" name="Allergenes[]" value="aucun">
                        <label for="aucun">Aucun</label><br>                        
                    </div>

                    <label>Types de plats:</label>
                    <div class="radio-group">                       
                        <input type="radio" id="plat-chaud" name="plat" value="chaud">
                        <label for="plat-chaud">Chaud</label><br>                         
                        <input type="radio" id="plat-froid" name="plat" value="froid">
                        <label for="plat-froid">Froid</label><br>                        
                    </div>
                    <br>

                    <button type="submit">Appliquer</button>
                    <!-- si pas de criteres, application = reinitialisation --> 
                    <br>
                </form>
            </div>
        </div>

        <!--Les composés de la page-->
        <section class="menu-section">
            <br>
            <h2>ENTREES</h2>
            <div class="menu-items"> <!--changer le nom en menu-container pour bien differencies?-->
            <div class="menu-items"> <!--le renommer en container pour differencier?-->
            <?php
                $query = "SELECT * FROM Produit WHERE Categorie='Entree'"; // Commencez avec une condition toujours vraie
                $params = [];
                //Filtre en php
                // Filtrer par prix maximum
                if (isset($_GET['Prix-max']) && is_numeric($_GET['Prix-max'])) {
                    $query .= " AND Prix <= ?";
                    $params[] = $_GET['Prix-max'];
                }

                // Filtrer par allergènes
                if (isset($_GET['Allergenes']) && is_array($_GET['Allergenes']) && !empty($_GET['Allergenes'])) {
                    $allergenes = $_GET['Allergenes'];
                    $conditions = [];
                    foreach ($allergenes as $allergene) {
                        $conditions[] = "NOT FIND_IN_SET(?, Allergenes)";
                        $params[] = trim($allergene);
                    }
                    if (!empty($conditions)) {
                        $query .= " AND " . implode(" AND ", $conditions);
                    }
                }

                // Filtrer par type de plat
                if (isset($_GET['plat'])) {
                    $query .= " AND Type = ?";
                    $params[] = $_GET['plat'];
                }

                // Préparer et exécuter la requête
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>  
            <!-- Les entrees -->
            <?php foreach ($produits as $produit): ?>
                    <div class="menu-item">
                    <a href="aliment.php?id=<?php echo htmlspecialchars($produit['ID_Produit']); ?>" class="item-link">
                        <div class="item-photo">
                            <img src="images/<?php echo htmlspecialchars($produit['Image']); ?>" 
                            alt="Photo de <?php echo htmlspecialchars($produit['Nom_Produit']); ?>" 
                            class="item-photo img">
                        </div>
                    </a>
                        <div class="item-info">
                            <p><?php echo $produit['Nom_Produit']; ?></p>
                            <p><?php echo $produit['Prix']; ?> €</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="menu-section">
            <h2>PLATS</h2>
            <div class="menu-items"> <!--le renommer en container pour differencier?-->
            <?php
                $query = "SELECT * FROM Produit WHERE Categorie='Plat'"; // Commencez avec une condition toujours vraie
                $params = [];

                // Filtrer par prix maximum
                if (isset($_GET['Prix-max']) && is_numeric($_GET['Prix-max'])) {
                    $query .= " AND Prix <= ?";
                    $params[] = $_GET['Prix-max'];
                }

                // Filtrer par allergènes
                if (isset($_GET['Allergenes']) && is_array($_GET['Allergenes']) && !empty($_GET['Allergenes'])) {
                    $allergenes = $_GET['Allergenes'];
                    $conditions = [];
                    foreach ($allergenes as $allergene) {
                        $conditions[] = "NOT FIND_IN_SET(?, Allergenes)";
                        $params[] = trim($allergene);
                    }
                    if (!empty($conditions)) {
                        $query .= " AND " . implode(" AND ", $conditions);
                    }
                }

                // Filtrer par type de plat
                if (isset($_GET['plat'])) {
                    $query .= " AND Type = ?";
                    $params[] = $_GET['plat'];
                }

                // Préparer et exécuter la requête
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>  
            <!-- Les plats -->
            <?php foreach ($produits as $produit): ?>
                    <div class="menu-item">
                    <a href="aliment.php?id=<?php echo htmlspecialchars($produit['ID_Produit']); ?>" class="item-link">
                        <div class="item-photo">
                            <img src="images/<?php echo htmlspecialchars($produit['Image']); ?>" 
                            alt="Photo de <?php echo htmlspecialchars($produit['Nom_Produit']); ?>" 
                            class="item-photo img">
                        </div>
                    </a>
                        <div class="item-info">
                            <p><?php echo $produit['Nom_Produit']; ?></p>
                            <p><?php echo $produit['Prix']; ?> €</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="menu-section">
            <h2>DESSERTS</h2>
            <div class="menu-items"> <!--le renommer en container pour differencier?-->
            <?php
                $query = "SELECT * FROM Produit WHERE Categorie='Dessert'"; // Commencez avec une condition toujours vraie
                $params = [];

                // Filtrer par prix maximum
                if (isset($_GET['Prix-max']) && is_numeric($_GET['Prix-max'])) {
                    $query .= " AND Prix <= ?";
                    $params[] = $_GET['Prix-max'];
                }

                // Filtrer par allergènes
                if (isset($_GET['Allergenes']) && is_array($_GET['Allergenes']) && !empty($_GET['Allergenes'])) {
                    $allergenes = $_GET['Allergenes'];
                    $conditions = [];
                    foreach ($allergenes as $allergene) {
                        $conditions[] = "NOT FIND_IN_SET(?, Allergenes)";
                        $params[] = trim($allergene);
                    }
                    if (!empty($conditions)) {
                        $query .= " AND " . implode(" AND ", $conditions);
                    }
                }

                // Filtrer par type de plat
                if (isset($_GET['plat'])) {
                    $query .= " AND Type = ?";
                    $params[] = $_GET['plat'];
                }

                // Préparer et exécuter la requête
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>    
            <!-- Les desserts -->
            <?php foreach ($produits as $produit): ?>
                    <div class="menu-item">
                    <a href="aliment.php?id=<?php echo htmlspecialchars($produit['ID_Produit']); ?>" class="item-link">
                        <div class="item-photo">
                            <img src="images/<?php echo htmlspecialchars($produit['Image']); ?>" 
                            alt="Photo de <?php echo htmlspecialchars($produit['Nom_Produit']); ?>" 
                            class="item-photo img">
                        </div>
                    </a>
                        <div class="item-info">
                            <p><?php echo $produit['Nom_Produit']; ?></p>
                            <p><?php echo $produit['Prix']; ?> €</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="menu-section">
            <h2>BOISSONS</h2>
            <div class="menu-items"> <!--le renommer en container pour differencier?-->
            <?php
                $query = "SELECT * FROM Produit WHERE Categorie='Boisson'"; // Commencez avec une condition toujours vraie
                $params = [];

                // Filtrer par prix maximum
                if (isset($_GET['Prix-max']) && is_numeric($_GET['Prix-max'])) {
                    $query .= " AND Prix <= ?";
                    $params[] = $_GET['Prix-max'];
                }

                // Filtrer par allergènes
                if (isset($_GET['Allergenes']) && is_array($_GET['Allergenes']) && !empty($_GET['Allergenes'])) {
                    $allergenes = $_GET['Allergenes'];
                    $conditions = [];
                    foreach ($allergenes as $allergene) {
                        $conditions[] = "NOT FIND_IN_SET(?, Allergenes)";
                        $params[] = trim($allergene);
                    }
                    if (!empty($conditions)) {
                        $query .= " AND " . implode(" AND ", $conditions);
                    }
                }

                // Filtrer par type de plat
                if (isset($_GET['plat'])) {
                    $query .= " AND Type = ?";
                    $params[] = $_GET['plat'];
                }

                // Préparer et exécuter la requête
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>     
            <!-- Les boissons -->
            <?php foreach ($produits as $produit): ?>
                    <div class="menu-item">
                    <a href="aliment.php?id=<?php echo htmlspecialchars($produit['ID_Produit']); ?>" class="item-link">
                        <div class="item-photo">
                            <img src="images/<?php echo htmlspecialchars($produit['Image']); ?>" 
                            alt="Photo de <?php echo htmlspecialchars($produit['Nom_Produit']); ?>" 
                            class="item-photo img">
                        </div>
                    </a>
                        <div class="item-info">
                            <p><?php echo $produit['Nom_Produit']; ?></p>
                            <p><?php echo $produit['Prix']; ?> €</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

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