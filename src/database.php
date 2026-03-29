<?php
    $db_server = "localhost";
    $db_user = "username";
    $db_pass = "password";
    $db_name = "database_name";
    $conn = "";

    try{
        $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
    }
    catch(mysqli_sql_exception){
        echo "Couldn't connect.";
        header("Location: error.html");
        exit();
    }
?>
