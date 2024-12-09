<?php
    session_start();
    if (!isset($_SESSION['logged_in'])) {
        die('Non authentifié');
    }

    // Fonction de transfert DANGEREUSE (sans protection CSRF)
    function transferMoney($amount, $recipient) {
        // Simulation de transfert
        file_put_contents('transferts.log',
            date('Y-m-d H:i:s') .
            " Transfert de {$_SESSION['username']} : $amount vers $recipient\n",
            FILE_APPEND
        );
    }

    // Réception de la demande de transfert
    if (isset($_GET['amount']) && isset($_GET['recipient']))
    {
        // Les informations du formulaire sont récupérées
        // Aucune vérification n'est effectuée

        $amount = floatval($_GET['amount']);
        $recipient = htmlspecialchars($_GET['recipient']);
        transferMoney($amount, $recipient);

        echo "Transfert effectué : $amount vers $recipient";
    }
?>