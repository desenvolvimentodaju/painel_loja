<?php
    if (!isset($_SESSION)) session_start();
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    if(@$_SESSION['user_logado'] == 1){
        include_once('calculos.php');
    }else{
        echo "<script> window.location.href='verificar' </script>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Metas Diárias</title>
    <!-- Semantic -->
    <link rel="stylesheet" href="https://semantic-ui.com/dist/semantic.min.css">
    <!--Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="bibliotecas/css/style.css">
</head>
<body class="w-100">
    <?php include_once('menu_up.php'); ?>
    <div class="d-flex flex-column w-5 mt-3">
        <!-- Tabelas -->
        <div class="div-tabelas mt-3 w-100 d-flex flex-column align-items-center">
            <!-- Vendas -->
            <div class="div-vendas small w-75">
                <table class="ui selectable celled table pink text-center">
                    <thead>
                        <tr class="small">
                            <th colspan="9" class="small">
                                <div class="ui left floated small primary labeled icon button bck-azul-escuro-daju" type="button" data-toggle="modal" data-target="#exampleModal">
                                    <i class="shopping clock icon bck-azul-escuro-daju"></i>Horário de funcionamento
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Empresa</th>
                            <th>Horário de abertura</th>
                            <th>Horário de fechamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM db_nome_empresa";
                            $conexaoLoja = $conn -> prepare($sql);
                            $conexaoLoja -> execute();
                            /******** Início definição dos valores por loja ********/
                            foreach($conexaoLoja AS $linha_consulta_loja){
                                echo "<tr>";
                                    echo "<td>".$linha_consulta_loja['ds_loja']."</dh>";
                                    echo "<td>".$linha_consulta_loja['hora_inicio']."</dh>";
                                    echo "<td> ".$linha_consulta_loja['hora_fim']." </dh>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="hora_inicio">Horário</label>
                        <input type="time" class="form-control w-25 mb-3" id="hora_inicio" name="hora_inicio" value="<?php echo $linha_consulta_loja['hora_inicio']; ?>">
                        <input type="time" class="form-control w-25" id="hora_fim" name="hora_fim" value="<?php echo $linha_consulta_loja['hora_fim']; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="salvar" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php
        include_once('modal.php');
    ?>
    
    
    <!----------------------- Scripts ----------------------->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>
<?php
    if(isset($_POST['salvar'])){
        if((isset($_POST['hora_inicio'])) && (strtotime($_POST['hora_inicio']) != strtotime('00:00:00'))){
            $hora_inicio = date('H:i:s', strtotime($_POST['hora_inicio']));
        }
        if((isset($_POST['hora_fim'])) && (strtotime($_POST['hora_fim']) != strtotime('00:00:00'))){
            $hora_fim = date('H:i:s', strtotime($_POST['hora_fim']));
        }
        $sql_verificacao = "UPDATE `db_nome_empresa` SET `hora_inicio`= '$hora_inicio' ,`hora_fim`= '$hora_fim'";
        if($mysqli->query($sql_verificacao)){
            echo "<script> alert('Alteração concluída com sucesso') </script>";
            echo "<script> window.open(document.referrer,'_self'); </script>";
        }else{
            echo "<script> alert('Algo deu errado, informe a TI') </script>";
            echo "<script> window.open(document.referrer,'_self'); </script>";
        }
    }
?>