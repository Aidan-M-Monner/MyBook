<?php
    // --------- Hosting Information --------- //
    $host = "localhost"; // Swapped out for host provider
    $username = "root"; //Can be changed in priveledges
    $password = "";
    $db = "mybook_db";

    // --------- Connecting to Database --------- //
    $connection = mysqli_connect($host, $username, $password, $db);

    // --------- Reading From a Database --------- //
    $query = "select * from users";
    $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($result)) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }