<?php
    if (isset($_POST['US_login']) and isset($_POST['US_password'])) {
        session_start();
        include 'connect.php';

        ini_set('display_errors', '1');

        $US_login = pg_escape_string($link,$_POST['US_login']);
        $US_password = pg_escape_string($link,$_POST['US_password']);

        $hashed_password = hash('sha256', $US_password);

        $query = "SELECT * FROM utilisateurs WHERE US_login = $1 AND US_password = $2";
        $result = pg_prepare($link, "login_query", $query);

        $res = pg_execute($link, "login_query", array($US_login, $hashed_password));
        if ($res != false) {
            if (pg_num_rows($res) > 0) {
                // Utilisateur trouvé dans la base
                $utilisateur = pg_fetch_assoc($res);
                $_SESSION['login'] = $utilisateur['us_login'];
                header("Location: home.php");
            } else {
                header("Location: index.php");
            }
        } else {
            header("Location: BADUSER.html");
        }
    }
?>