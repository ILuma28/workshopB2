<?php

session_start();

include './dbSetup.php';

if (isset($_POST['mail'], $_POST['prenom'], $_POST['nom'], $_POST['mdp'])) { // On revérifie que tous les éléments sont bien envoyés
    $sql = "SELECT * from user where login_user='" . $_POST['mail'] . "'";
    $resultat = mysqli_query($conn, $sql);
    if ($resultat == FALSE) { // S'il y a une erreur dans la requête sql
        $table = array(
            'error'  => true,
            'message' => 'Erreur d\'execution de la requête',
        );
        $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
        echo $table_encode;
    } elseif (mysqli_num_rows($resultat) == 1) { // Si il y a déjà l'addresse mail dans la database --> le compte existe déjà
        $table = array(
            'error'  => true,
            'message' => 'Cette addresse mail est déjà utilisée',
        );
        $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
        echo $table_encode;
    } elseif (mysqli_num_rows($resultat) == 0) { //S'il n'y a pas la meme addresse mail dans la database

        //--------------------------------------------------------------------------------------------------------------------------------

        $sql = "SELECT * from user where login_user='" . $_POST['mail'] . "'";
        $resultat = mysqli_query($conn, $sql);
        if ($resultat == FALSE) { // S'il y a une erreur dans la requête sql
            $table = array(
                'error'  => true,
                'message' => 'Erreur d\'execution de la requête',
            );
            $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
            echo $table_encode;
        } elseif (mysqli_num_rows($resultat) == 1) { // Si il y a déjà l'addresse mail dans la database --> le compte existe déjà
            $table = array(
                'error'  => true,
                'message' => 'Cette addresse mail est déjà utilisée',
            );
            $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
            echo $table_encode;
        } elseif (mysqli_num_rows($resultat) == 0) { //S'il n'y a pas la meme addresse mail dans la database

                $nom = htmlspecialchars($_POST['nom']); // htmlspecialchars transforme toute la variable en string (pour éviter des injéctions sql quand on entre le mail dans le formulaire par exemple)
                $prenom = htmlspecialchars($_POST['prenom']);
                $mail = htmlspecialchars($_POST['mail']);
                $mdp = htmlspecialchars($_POST['mdp']);
                $sql = "INSERT INTO user (name_user, fname_user, login_user, password_user) values ('" . $nom . "', '" . $prenom . "', '" . $mail . "', '" . $mdp . "')"; //Creation du compte user
                $resultat = mysqli_query($conn, $sql);
                if ($resultat == FALSE) {
                    $table = array(
                        'error'  => true,
                        'message' => 'Erreur d\'execution de la requête',
                    );

                    $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
                    echo $table_encode;
                } else {
                    $table = array(
                        'error'  => false,
                        'message' => 'Inscription réussie, vous allez être redirigé vers notre site sans quelques instants',
                    );
                    $table_encode = json_encode($table, JSON_INVALID_UTF8_IGNORE);
                    echo $table_encode;
                }
            }
        }
    }

