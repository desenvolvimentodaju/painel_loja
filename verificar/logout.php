<?php
    if (!isset($_SESSION)) session_start();
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    if(@$_SESSION['user_logado'] == 0){
        echo "<script> window.location.href='index.php' </script>";
    }else{
        if (!isset($_SESSION)) session_start();
        include_once("../conn/conn.php");
        date_default_timezone_set('America/Sao_Paulo');
        if(isset($_SESSION['datetime_login_pp'])){
            $data_login = date('d-m-Y, g:i a', strtotime($_SESSION['datetime_login_pp']));
            $id_user = $_SESSION['id_user'];
            $data_now = date("d-m-Y, g:i a");
            $portal = 'Parciais de venda';
            $sql = "UPDATE `monitoramento` SET `user_out`='$data_now' WHERE `user_id` = '$id_user' AND `user_in` = '$data_login'";
        }else{
            $id_user = $_SESSION['usuario'];
            $data_now = date("d-m-Y, g:i a");
            $portal = 'Parciais de venda';
            $sql = "INSERT INTO `monitoramento`(`id`, `user_in`, `user_out`, `user_id`, `log_in`) VALUES (0,'N/A','$data_now','$id_user','$portal')";
        }
        $conexao = $conn -> prepare($sql);
        $conexao -> execute();
        $conn = NULL;
        session_unset();
        echo "<script> window.location.href='index.php'</script>";
    }
?>