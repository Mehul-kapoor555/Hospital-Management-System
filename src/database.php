<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "mehul2003";
    $db_name = "hospital";
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