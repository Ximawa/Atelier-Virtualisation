<?php
    $host = "container_postgres";
    $username = "admin";
    $password = "password";
    $db = "gestion_produits";

    // PostgreSQL connection string
    $conn_string = "host=$host dbname=$db user=$username password=$password";

    // Establish a connection with PostgreSQL
    $link = pg_connect($conn_string);

    // Check if the connection is successful
    if (!$link) {
        die("Erreur de connexion à la base de données.");
    }

    // Set the client encoding to UTF-8
    pg_set_client_encoding($link, "utf8");
?>