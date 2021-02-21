<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);

    $host = "172.31.0.52";
    $user = "administrator";
    $pass = "Q!W@E#R$";
    $banco = "db_daju";//trocar no /****PDO*****/

    $mysqli = new mysqli($host, $user, $pass, $banco);

    if(mysqli_connect_errno()){
        printl("Não foi possivel conectar!", mysqli_connect_errno());
        exit();
    }
    try {
        // $conn = new PDO('mysql:host=172.31.0.52;dbname=db_daju', $user, $pass);
        $conn = new PDO('mysql:host='.$host.';dbname=db_daju', $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

?>