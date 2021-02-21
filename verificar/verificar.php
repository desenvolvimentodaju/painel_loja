<?php
    if (!isset($_SESSION)) session_start();
    ini_set('display_errors',1);//mostrar os erros
    ini_set('display_startup_erros',1);//mostrar os erros
    if(isset($_SESSION['user_logado']) && $_SESSION['user_logado'] == 1){
        echo "<script> window.location.href='../index.php' </script>";
    }
    date_default_timezone_set('America/Sao_Paulo');
    //verificação da sessão
    if(isset($_POST['login'])){
        if(!empty($_POST['user_name'])){
            if(!empty($_POST['pass'])){
                    try{
                        $usuario = $_POST['user_name'];
                        $senha  = md5($_POST['pass']);
                        $sql = "SELECT usuario FROM users WHERE usuario = '$usuario' AND senha = '$senha'";
                        include_once("../conn/conn.php");
                        //verificar se existe no banco
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam('usuario', $usuario, PDO::PARAM_STR);
                        $stmt->bindParam('senha', $senha, PDO::PARAM_STR);
                        $stmt->execute();
                        $count = $stmt->rowCount();
                        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
                        if($count == 1 && !empty($row)) {
                            //se existe pegar informações
                            $sql  = "SELECT * FROM `users` WHERE usuario = '$usuario'";
                            $conexao = $conn -> prepare($sql);
                            $conexao -> execute();
                            foreach($conexao AS $infos){
                                    $id_user = $infos['id_users'];//separado da session para inputar no monitoramento
                                    $nome_completo = $infos['nome_completo'];
                                    $usuario = $infos['usuario'];
                                    $_SESSION['nivel_acesso'] =  $infos['nivel_acesso'];
                                    $_SESSION['funcao'] =  $infos['funcao'];
                                    $_SESSION['troca_senha'] = $infos['troca_senha'];
                                    $_SESSION['id_user'] = $infos['id_users'];
                                    $_SESSION['nome_user'] = $infos['nome_completo'];
                                    $_SESSION['usuario'] = $infos['usuario'];
                                    $_SESSION['loja'] = $infos['empresa'];
                                    $_SESSION['user_logado'] = 1;
                                    // data e hora de login
                                    $data_now = date("d-m-Y, g:i a");
                                    $portal = 'Parciais de venda';
                                    $_SESSION['datetime_login_pp'] = $data_now;
                                    $conexao = $conn -> prepare("INSERT INTO `monitoramento`(`id`, `user_in`, `user_out`, `user_id`, `log_in`) VALUES (NULL,'$data_now',NULL,'$id_user','$portal')");
                                    $conexao -> execute(array(
                                        ':id' => NULL,
                                        ':user_in' => $data_now,
                                        ':user_out' => NULL,
                                        ':user_id' => $id_user,
                                        ':log_in' => $portal
                                    ));
                                    $conn_acesso = NULL;
                            }
                            echo "<script> window.location.href='../index.php' </script>";
                        }else{
                            echo"<script> alert('Nome de usuário ou senha não encontrados!') </script>";
                            echo "<script> window.location.href='../index.php' </script>";
                        }
                    }catch (PDOException $e){
                        echo"<script> alert('Nome de usuário ou senha não encontrados!') </script>";
                        echo "Error : ".$e->getMessage();
                    }
            }else{
                echo("<script> alert('Digite uma senha!!') </script>");
                echo "<script> window.location.href='../index.php' </script>";
            }
        }else{
            echo("<script> alert('Digite um login!!') </script>");
            echo "<script> window.location.href='../index.php' </script>";
        }
    }
?>