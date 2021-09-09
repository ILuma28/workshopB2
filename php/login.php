<?php

session_start();

include './dbSetup.php';

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "1") {
        session_destroy();
        unset($_SESSION);
    }
}

if (isset($_POST['mail'], $_POST['mdp'])) {
    $dsn = "mysql:host=$db_host;dbname=$db_database";

    $sql = "SELECT * from user where login_user='" . $_POST['mail'] . "'";
    $resultat = mysqli_query($conn, $sql);
    if ($resultat == FALSE) { // S'il y a une erreur dans la requête sql
        $table = array(
            'error'  => true,
            'message' => 'Erreur d\'execution de la requête',
        );
        $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
        echo $table_encode;
    } elseif (mysqli_num_rows($resultat) == 0) {
        $table = array(
            'error'  => true,
            'message' => 'Aucun compte n\'est lié à cet email',
        );

        $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
        echo $table_encode;
    } elseif (mysqli_num_rows($resultat) == 1) { // L'email existe dans la table user
        $pdo = new PDO($dsn, $db_user, $db_password);
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $mdp = $row['password_user'];
        if ($_POST['mdp'] == $mdp) {
            $sql = "SELECT * from user where login_user='" . $_POST['mail'] . "' and password_user='" . $mdp . "'"; // On regarde ds la base de donnés si le mdp correspond  bien avec l'email
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                $table = array(
                    'error'  => true,
                    'message' => 'Erreur d\'execution de la requête',
                );

                $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
                echo $table_encode;
            } elseif (mysqli_num_rows($resultat) == 1) {
                $row = mysqli_fetch_assoc($resultat);
                // On va initialiser les variables de la session
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['mail_user'] = $row['login_user'];
                

                $table = array(
                    'error' => false,
                    'message' => '../html/inGame.html',
                );
                $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
                echo $table_encode;
            }
        } else {
            $table = array(
                'error'  => true,
                'message' => 'Mot de passe incorect',
            );

            $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
            echo $table_encode;
        }
    }
}
