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

    // ****************************************************
    // Fonction de génération de token CSRF
    function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
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
        <pre>Regarder le code source pour voir le champ input hidden CSRF!</pre>

        <!-- Formulaire de transfert d'argent -->
        <form action="transfert.php" method="POST">
            <!-- Ajout du token CSRF -->
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">

            <!-- On type les champs -->
            <label>Montant :
                <input type="number" name="amount" step="0.01" min="0" required>
            </label>
            <label>Bénéficiaire :
                <input type="text" name="recipient" placeholder="Bénéficiaire" required>
            </label>

            <button type="submit">Transférer</button>
        </form>
    </body>
</html>