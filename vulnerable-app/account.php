<?php
session_start();
if (!$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

// Gestion de la déconnexion
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Détruire la session
    session_unset();
    session_destroy();

    // Rediriger vers la page de connexion
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Votre Compte</title>
    </head>
    <body>
        <h2>Votre Compte</h2>
        <p>Bonjour <?= $_SESSION['username'] ?>
            <a href="?action=logout" style="margin-left: 20px; color: red;">Déconnexion</a>
        </p>

        <h3>Nouveau Virement</h3>
        <!-- Formulaire de transfert d'argent -->
        <!-- Ce formulaire est vulnérable à une attaque CSRF -->
        <form action="transfert.php" method="GET">
            <input type="number" name="amount" placeholder="Montant" required>
            <input type="text" name="recipient" placeholder="Bénéficiaire" required>
            <button type="submit">Transférer</button>
        </form>
    </body>
</html>