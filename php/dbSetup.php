<?php

//On définit les variables pour la connexion à la base de données

$db_host = "192.168.43.184";
$db_user = "root";
$db_password = "1234";
$db_database = "workshop";
$db_port = "3306";

?>

<?php

//Connexion :

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_database, $db_port); // Connexion à la base de données
if (!$conn) {
    $array = array(
        'error' => true,
        'message' => 'erreur de connexion à la base de données',

    );
}
?>