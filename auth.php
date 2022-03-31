<?php

session_start();

if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    $password = $_POST["password"];

    if($password == "password"){
        $_SESSION["loggedIn"] = "true";
        header("Location: ./index.php");
    }else{
        header("Location: ./login.php");
    }
}

?>