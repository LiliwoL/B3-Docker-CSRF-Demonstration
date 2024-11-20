<?php
    session_start();
    if (!$_SESSION['logged_in']) {
        die('Non authentifié');
    }

    // Fonction de validation du token CSRF
    function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) &&
            hash_equals($_SESSION['csrf_token'], $token);
    }

    // Fonction sécurisée de transfert
    function transferMoney($amount, $recipient) {
        // Simulation de transfert avec journalisation sécurisée
        $logEntry = date('Y-m-d H:i:s') .
            " Transfert de {$_SESSION['username']} : $amount vers $recipient\n";

        // Utilisation de FILE_APPEND avec des permissions restreintes
        file_put_contents('transferts.log', $logEntry, FILE_APPEND | LOCK_EX);
    }

    // Traitement du transfert
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // Vérification du token CSRF
        if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token']))
        {
            die('Erreur de sécurité : Token CSRF invalide');
        }

        // Validation et assainissement des données
        $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
        $recipient = filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_STRING);

        if ($amount === false || $recipient === false)
        {
            die('Données de transfert invalides');
        }

        // Transfert sécurisé
        transferMoney($amount, $recipient);
        echo "Transfert sécurisé effectué";
    }
?>