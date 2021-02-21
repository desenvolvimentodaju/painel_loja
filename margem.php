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
    <title>Margem</title>
    <!-- Semantic -->
    <link rel="stylesheet" href="https://semantic-ui.com/dist/semantic.min.css">
    <!--Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="bibliotecas/css/style.css">
</head>
<body class="w-100">
    <?php include_once('menu_up.php'); ?>
    <div class="d-flex flex-column w-5 mt-3">
        <!-- Filtro de datas -->
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <form method="post" action="">
                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-2">
                            <label for="inputP1Day">Período 1</label>
                            <div class="row">
                                <div class="col mt-2">
                                    <input type="date" class="form-control" id="inputP1Day" name="dataP1" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputP2Day">Período 2</label>
                            <div class="row">
                                <div class="col mt-2">
                                    <input type="date" class="form-control" id="inputP2Day" name="dataP2" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <button type="submit" class="btn btn-outline-info" name="filtrar">Filtrar datas</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Fim filtro de buscas -->

        <!-- Tabelas -->
        <div class="div-tabelas mt-3 w-100 d-flex flex-column align-items-center">
            <!-- Vendas -->
            <div class="div-vendas small w-75">
                <table class="ui selectable celled table pink text-center">
                    <thead>
                        <tr class="small">
                            <th colspan="8" class="small">
                                <div class="ui left floated small primary labeled icon button bck-azul-escuro-daju">
                                    <i class="shopping bag icon bck-azul-escuro-daju"></i>Margem
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Empresa</th>
                            <th><?php echo isset($_POST['dataP1'])? date('d/m/Y', strtotime($data_p1)) : "Data" ; ?></th>
                            <th>Contribuição Marginal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            /* Período 1 ou data ano passado */
                            if((isset($_POST['dataP1'])) && (strtotime($_POST['dataP1']) != strtotime('1969-31-12'))){
                                $data_p1 = $_POST['dataP1'];
                            }elseif(date('L') == 1){
                                $data_p1 = date('Y-m-d', strtotime('-'. 364 .' days', strtotime(date('Y-m-d'))));
                            }else{
                                $data_p1 = date('Y-m-d', strtotime('-'. 365 .' days', strtotime(date('Y-m-d'))));
                            }
                            /* Fim período 1 */

                            /* Início período 2 ou hoje*/
                            if(isset($_POST['dataP2']) && (strtotime($_POST['dataP2']) != strtotime('1969-31-12'))){
                                $data_p2 = $_POST['dataP2'];
                            }else{
                                $data_p2 = date('Y-m-d');
                            }

                            if(isset($_POST['dataP1']) || isset($_POST['dataP2'])){
                                $sql = "SELECT * FROM `base_margem` WHERE `data_base` BETWEEN '".$data_p1."' AND '".$data_p2."'";
                            }else{
                                $sql = "SELECT * FROM `base_margem`";
                            }


                            $conexaoLoja = $conn -> prepare($sql);
                            $conexaoLoja -> execute();
                            /******** Início definição dos valores por loja ********/
                            foreach($conexaoLoja AS $linha_consulta_loja){
                                echo "<tr>";
                                    echo "<td>".$linha_consulta_loja['cd_empresa']."</dh>";
                                    echo "<td>".date('d/m/Y', strtotime($linha_consulta_loja['dt_base']))."</dh>";
                                    echo "<td>".$linha_consulta_loja['contribuicao_marginal']."</dh>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include_once('modal.php'); ?>



    <!----------------------- Scripts ----------------------->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

</body>
</html>