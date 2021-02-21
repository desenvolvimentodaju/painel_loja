<?php
    if (!isset($_SESSION)) session_start();
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    if(@$_SESSION['user_logado'] == 0 && !isset($_SESSION['nivel_acesso'])){
        echo "<script> window.location.href='index.php' </script>";
    }
    // session_start();
    /* include_once("conn/conn.php");
    date_default_timezone_set('America/Sao_Paulo');
    $data_login = $_SESSION['datetime_login_pv'];
    $id_user = $_SESSION['id_user'];
    $data_now = date("d-m-Y, g:i a");
    // $portal = 'Portal de vendas';
    $sql = "UPDATE `monitoramento` SET `user_out`='$data_now' WHERE user_id = $id_user";
    // $sql = "UPDATE `monitoramento` SET `user_out`='$data_now' WHERE user_id = $id_user, user_in = '$data_login'";
    echo $sql;
    $conexao = $conn -> prepare($sql);
    $conexao -> execute(array(
        ':id' => 'id',
        ':user_in' => $data_login,
        ':user_out' => $data_now,
        ':user_id' => $id_user,
        ':log_in' => ''
    )); 
    $conn_acesso = NULL;*/
    unset($_SESSION['user_logado']);
    echo "<script> window.location.href='index.php' </script>";
?>