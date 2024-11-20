<?php
    session_start();
    $users = [
        'alice' => 'password123',
        'bob' => 'securepwd'
    ];

    /*
     * Connexion
     */
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($users[$username]) && $users[$username] == $password)
        {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;

            // Redirection vers la page du compte
            header('Location: account.php');
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Site Vulnerable CSRF</title>
    </head>
    <body>
        <h2>Connexion</h2>
        <form method="POST">
            <input type="text" name="username" required>
            <input type="password" name="password" required>
            <button type="submit">Connexion</button>
        </form>
    </body>
</html>