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
    <title>Desempenho de loja</title>
    <!-- Semantic -->
    <link rel="stylesheet" type="text/css" href="bibliotecas/semantic/semantic.min.css">
    <script src="bibliotecas/semantic/semantic.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <!--Bootstrap -->
    <link rel="stylesheet" href="bibliotecas/bootstrap/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                            <label for="inputP1Day">Período Comparativo</label>
                            <div class="row">
                                <div class="col mt-2">
                                    <input type="date" class="form-control" id="inputP1Day" name="dataP1" value="<?php echo $data_p1; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputP2Day">Período Atual</label>
                            <div class="row">
                                <div class="col w-20">
                                    <div class="row">
                                        <div class="col mt-2">
                                            <input type="date" class="form-control" id="inputP2Day" name="dataP2" value="<?php echo $data_p2; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputP2Day">Horário</label>
                            <div class="row">
                                <div class="col mt-2">
                                    <input type="time" class="form-control" id="inputP2Day" name="horaInicio" value="<?php echo $hora_inicio; ?>">
                                </div>
                                <div class="col mt-2">
                                    <input type="time" class="form-control" id="inputP2Day" name="horaFim" value="<?php echo $hora_fim; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <button type="submit" class="btn btn-primary" name="filtrar">Filtrar datas</button>
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
                                    <i class="shopping bag icon bck-azul-escuro-daju"></i>Vendas
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Loja</th>
                            <th><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento<br><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?> X <?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th style="background-color:#00b0f0;">Hiper do Dia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AV</td>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA2') && defined('P1_VENDA_SOB_MEDIDA')? number_format((P1_VENDA_LOJA2+P1_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA2') && defined('P2_VENDA_SOB_MEDIDA')? number_format((P2_VENDA_LOJA2+ P2_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA2')? number_format(CRESCIMENTO_LOJA2,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_LOJA2')? number_format(HIPER_VENDAS_P2_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>BR</td>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA4')? number_format(P1_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA4')? number_format(P2_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA4')? number_format(CRESCIMENTO_LOJA4,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_LOJA4')? number_format(HIPER_VENDAS_P2_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>CB</td>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA5')? number_format(P1_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA5')? number_format(P2_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA5')? number_format(CRESCIMENTO_LOJA5,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_LOJA5')? number_format(HIPER_VENDAS_P2_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>SJP</td>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA6')? number_format(P1_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA6')? number_format(P2_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA6')? number_format(CRESCIMENTO_LOJA6,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_LOJA6')? number_format(HIPER_VENDAS_P2_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>AT</td>
                            <td>R$ <?php echo (defined('P1_VENDA_LOJA7') && date('Y',strtotime($data_p1)) != '2019')? number_format(P1_VENDA_LOJA7,2,',','.') : number_format(P1_VENDA_LOJA6,2,',','.') ; ?></td>
                            <td>R$ <?php echo (defined('P1_VENDA_LOJA7') && date('Y',strtotime($data_p2)) != '2019')? number_format(P2_VENDA_LOJA7,2,',','.') : number_format(P2_VENDA_LOJA6,2,',','.') ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA7')? number_format(CRESCIMENTO_LOJA7,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_LOJA7')? number_format(HIPER_VENDAS_P2_LOJA7,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Delivery</td>
                            <td>R$ <?php echo defined('P1_VENDA_DELIVERY')? number_format(P1_VENDA_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_DELIVERY')? number_format(P2_VENDA_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_DELIVERY')? number_format(CRESCIMENTO_DELIVERY,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_DELIVERY')? number_format(HIPER_VENDAS_P2_DELIVERY,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>E-commerce</td>
                            <td>R$ <?php echo defined('P1_VENDA_ECOMMERCE')? number_format(P1_VENDA_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_ECOMMERCE')? number_format(P2_VENDA_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ECOMMERCE')? number_format(CRESCIMENTO_ECOMMERCE,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_ECOMMERCE')? number_format(HIPER_VENDAS_P2_ECOMMERCE,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Marketplace</td>
                            <td>R$ <?php echo defined('P1_VENDA_MARKETPLACE')? number_format(P1_VENDA_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_MARKETPLACE')? number_format(P2_VENDA_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_MARKETPLACE')? number_format(CRESCIMENTO_MARKETPLACE,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_MARKETPLACE')? number_format(HIPER_VENDAS_P2_MARKETPLACE,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Regional(Lojas + Online)</td>
                            <td>R$ <?php echo defined('P1_VENDAS_REGIONAL1')? number_format((P1_VENDAS_REGIONAL1 + P1_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDAS_REGIONAL1')? number_format((P2_VENDAS_REGIONAL1 + P2_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_REGIONAL1')? number_format(CRESCIMENTO_REGIONAL1,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_REGIONAL1')? number_format(HIPER_VENDAS_P2_REGIONAL1,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Regional(AV,BR,CB,SJP)</td>
                            <td>R$ <?php echo defined('P1_VENDAS_REGIONAL2')? number_format((P1_VENDAS_REGIONAL2 + P1_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDAS_REGIONAL2')? number_format((P2_VENDAS_REGIONAL2 + P2_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_REGIONAL2')? number_format(CRESCIMENTO_REGIONAL2,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;">R$ <?php echo defined('HIPER_VENDAS_P2_REGIONAL2')? number_format(HIPER_VENDAS_P2_REGIONAL2,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim Vendas -->

            <!-- Tkm -->
            <div class="div-tkm mt-5 small w-75">
                <table class="ui selectable celled table pink text-center w-100">
                    <thead>
                        <tr class="small">
                            <th colspan="8" class="small">
                                <div class="ui teal button left floated small primary labeled icon bck-azul-escuro-daju">
                                    <i class="money bill alternate icon bck-azul-escuro-daju"></i> TKM
                                </div>
                            </th>
                        </tr>
                        <tr>
                        <th>Loja</th>
                            <th><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Hiper</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AV</td>
                            <td>R$ <?php echo defined('P1_TKM_LOJA2')? number_format(P1_TKM_LOJA2,2,',','.') : "-" ; ?></td>
                            <td style="background-color:<?php echo COR_TKM_LOJA2; ?>">R$ <?php echo defined('P2_TKM_LOJA2')? number_format(P2_TKM_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_LOJA2')? number_format(CRESCIMENTO_TKM_LOJA2,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_LOJA2')? "R$".number_format(HIPER_TKM_P2_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>BR</td>
                            <td>R$ <?php echo defined('P1_TKM_LOJA4')? number_format(P1_TKM_LOJA4,2,',','.') : "-" ; ?></td>
                            <td style="background-color:<?php echo COR_TKM_LOJA4; ?>">R$ <?php echo defined('P2_TKM_LOJA4')? number_format(P2_TKM_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_LOJA4')? number_format(CRESCIMENTO_TKM_LOJA4,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_LOJA4')? "R$".number_format(HIPER_TKM_P2_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>CB</td>
                            <td>R$ <?php echo defined('P1_TKM_LOJA5')? number_format(P1_TKM_LOJA5,2,',','.') : "-" ; ?></td>
                            <td style="background-color:<?php echo COR_TKM_LOJA5; ?>">R$ <?php echo defined('P2_TKM_LOJA5')? number_format(P2_TKM_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_LOJA5')? number_format(CRESCIMENTO_TKM_LOJA5,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_LOJA5')? "R$".number_format(HIPER_TKM_P2_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>SJP</td>
                            <td>R$ <?php echo defined('P1_TKM_LOJA6')? number_format(P1_TKM_LOJA6,2,',','.') : "-" ; ?></td>
                            <td style="background-color:<?php echo COR_TKM_LOJA6; ?>">R$ <?php echo defined('P2_TKM_LOJA6')? number_format(P2_TKM_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_LOJA6')? number_format(CRESCIMENTO_TKM_LOJA6,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_LOJA6')? "R$".number_format(HIPER_TKM_P2_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>AT</td>
                            <td>R$ <?php echo (defined('P1_TKM_LOJA7') && date('Y',strtotime($data_p1)) != '2019')? number_format(P1_TKM_LOJA7,2,',','.') : number_format(P1_TKM_LOJA6,2,',','.') ; ?></td>
                            <td style="background-color:<?php echo COR_TKM_LOJA7; ?>">R$ <?php echo (defined('P2_TKM_LOJA7') && date('Y',strtotime($data_p2)) != '2019')? number_format(P2_TKM_LOJA7,2,',','.') : number_format(P2_TKM_LOJA6,2,',','.') ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_LOJA7')? number_format(CRESCIMENTO_TKM_LOJA7,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_LOJA7')? "R$".number_format(HIPER_TKM_P2_LOJA7,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Delivery</td>
                            <td>R$ <?php echo defined('P1_TKM_DELIVERY')? number_format(P1_TKM_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_TKM_DELIVERY')? number_format(P2_TKM_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_DELIVERY')? number_format(CRESCIMENTO_TKM_DELIVERY,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_DELIVERY')? "R$".number_format(HIPER_TKM_P2_DELIVERY,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>E-commerce</td>
                            <td>R$ <?php echo defined('P1_TKM_ECOMMERCE')? number_format(P1_TKM_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_TKM_ECOMMERCE')? number_format(P2_TKM_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_ECOMMERCE')? number_format(CRESCIMENTO_TKM_ECOMMERCE,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_ECOMMERCE')? "R$".number_format(HIPER_TKM_P2_ECOMMERCE,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Marketplace</td>
                            <td>R$ <?php echo defined('P1_TKM_MARKETPLACE')? number_format(P1_TKM_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_TKM_MARKETPLACE')? number_format(P2_TKM_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_MARKETPLACE')? number_format(CRESCIMENTO_TKM_MARKETPLACE,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_MARKETPLACE')? "R$".number_format(HIPER_TKM_P2_MARKETPLACE,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Regional</td>
                            <td>R$ <?php echo defined('P1_TKM_REGIONAL2')? number_format(P1_TKM_REGIONAL2,2,',','.') : "-" ; ?></td>
                            <td style="background-color: <?php echo COR_TKM_REGIONAL2; ?>">R$ <?php echo defined('P2_TKM_REGIONAL2')? number_format(P2_TKM_REGIONAL2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TKM_REGIONAL2')? number_format(CRESCIMENTO_TKM_REGIONAL2,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0;"><?php echo defined('HIPER_TKM_P2_REGIONAL2')? "R$".number_format(HIPER_TKM_P2_REGIONAL2,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim TKM -->


            <!-- Atendimentos -->
            <div class="div-atendimentos mt-5 small w-75">
                <table class="ui selectable celled table pink text-center w-100">
                    <thead>
                        <tr class="small">
                            <th colspan="8" class="small">
                                <div class="ui left floated small primary labeled icon button bck-azul-escuro-daju">
                                    <i class="handshake icon bck-azul-escuro-daju"></i> Atendimentos
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Loja</th>
                            <th><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AV</td>
                            <td><?php echo defined('P1_ATENDIMENTO_LOJA2')? P1_ATENDIMENTO_LOJA2 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_LOJA2')? P2_ATENDIMENTO_LOJA2 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA2')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA2,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>BR</td>
                            <td><?php echo defined('P1_ATENDIMENTO_LOJA4')? P1_ATENDIMENTO_LOJA4 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_LOJA4')? P2_ATENDIMENTO_LOJA4 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA4')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA4,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>CB</td>
                            <td><?php echo defined('P1_ATENDIMENTO_LOJA5')? P1_ATENDIMENTO_LOJA5 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_LOJA5')? P2_ATENDIMENTO_LOJA5 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA5')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA5,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>SJP</td>
                            <td><?php echo defined('P1_ATENDIMENTO_LOJA6')? P1_ATENDIMENTO_LOJA6 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_LOJA6')? P2_ATENDIMENTO_LOJA6 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA6')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA6,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>AT</td>
                            <td><?php 
                                if(defined('P1_ATENDIMENTO_LOJA7') && date('Y',strtotime($data_p1))  != '2019'){
                                    echo P1_ATENDIMENTO_LOJA7;
                                }elseif(defined('P1_ATENDIMENTO_LOJA6')){
                                    echo P1_ATENDIMENTO_LOJA6;
                                }else{
                                    echo '-';
                                }
                            ?></td>
                            <td><?php echo (defined('P2_ATENDIMENTO_LOJA7') && date('Y',strtotime($data_p2)) != '2019')? P2_ATENDIMENTO_LOJA7: P2_ATENDIMENTO_LOJA6; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA7')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA7,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Delivery</td>
                            <td><?php echo defined('P1_ATENDIMENTO_DELIVERY')? P1_ATENDIMENTO_DELIVERY : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_DELIVERY')? P2_ATENDIMENTO_DELIVERY : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_DELIVERY')? number_format(CRESCIMENTO_ATENDIMENTO_DELIVERY,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>E-commerce</td>
                            <td><?php echo defined('P1_ATENDIMENTO_ECOMMERCE')? P1_ATENDIMENTO_ECOMMERCE : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_ECOMMERCE')? P2_ATENDIMENTO_ECOMMERCE : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_ECOMMERCE')? number_format(CRESCIMENTO_ATENDIMENTO_ECOMMERCE,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Marketplace</td>
                            <td><?php echo defined('P1_ATENDIMENTO_MARKETPLACE')? P1_ATENDIMENTO_MARKETPLACE : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_MARKETPLACE')? P2_ATENDIMENTO_MARKETPLACE : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_MARKETPLACE')? number_format(CRESCIMENTO_ATENDIMENTO_MARKETPLACE,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        </tr>
                        <tr>
                            <td>Regional</td>
                            <td><?php echo defined('P1_ATENDIMENTO_REGIONAL2')? P1_ATENDIMENTO_REGIONAL2 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_REGIONAL2')? P2_ATENDIMENTO_REGIONAL2 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ATENDIMENTO_REGIONAL2')? number_format(CRESCIMENTO_ATENDIMENTO_REGIONAL2,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim Atendimentos -->

            <!-- Fluxo de clientes -->
            <div class="div-atendimentos mt-5 small w-75">
                <table class="ui selectable celled table pink text-center w-100">
                    <thead>
                        <tr class="small">
                            <th colspan="8" class="small">
                                <div class="ui left floated small primary labeled icon button bck-azul-escuro-daju">
                                    <i class="retweet icon bck-azul-escuro-daju"></i>Fluxo de Clientes
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Loja</th>
                            <th><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AV</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_LOJA2')? P1_FLUXO_DE_CLIENTES_LOJA2 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_LOJA2')? P2_FLUXO_DE_CLIENTES_LOJA2 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA2')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>BR</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_LOJA4')? P1_FLUXO_DE_CLIENTES_LOJA4 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_LOJA4')? P2_FLUXO_DE_CLIENTES_LOJA4 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA4')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>CB</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_LOJA5')? P1_FLUXO_DE_CLIENTES_LOJA5 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_LOJA5')? P2_FLUXO_DE_CLIENTES_LOJA5 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA5')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>SJP</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_LOJA6')? P1_FLUXO_DE_CLIENTES_LOJA6 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_LOJA6')? P2_FLUXO_DE_CLIENTES_LOJA6 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA6')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>AT</td>
                            <td><?php 
                                if(defined('P1_FLUXO_DE_CLIENTES_LOJA7') && date('Y',strtotime($data_p1)) != '2019'){
                                    echo P1_FLUXO_DE_CLIENTES_LOJA7;
                                }elseif(defined('P1_FLUXO_DE_CLIENTES_LOJA6')){
                                    echo P1_FLUXO_DE_CLIENTES_LOJA6;
                                }else{
                                    echo '-';
                                }
                            ?></td>
                            <td><?php if(defined('P2_FLUXO_DE_CLIENTES_LOJA7') && date('Y',strtotime($data_p2))  != '2019'){
                                    echo P2_FLUXO_DE_CLIENTES_LOJA7;
                                }elseif(defined('P2_FLUXO_DE_CLIENTES_LOJA6') && date('Y',strtotime($data_p2))  != '2019'){
                                    echo P2_FLUXO_DE_CLIENTES_LOJA6;
                                }else{
                                    echo '-';
                                } ?></td>
                            <td><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA7')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA7,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Regional</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_REGIONAL2')? P1_FLUXO_DE_CLIENTES_REGIONAL2 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_REGIONAL2')? P2_FLUXO_DE_CLIENTES_REGIONAL2 : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL2')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL2,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim Fluxo de clientes -->

            <!-- Taxa de conversão -->
            <div class="div-atendimentos mt-5 small w-75">
                <table class="ui selectable celled table pink text-center w-100">
                    <thead>
                        <tr class="small">
                            <th colspan="8" class="small">
                                <div class="ui left floated small primary labeled icon button bck-azul-escuro-daju">
                                    <i class="sync icon bck-azul-escuro-daju"></i>Taxa de conversão
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Loja</th>
                            <th><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AV</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_LOJA2')? number_format(P1_TAXA_DE_CONVERSAO_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_LOJA2')? number_format(P2_TAXA_DE_CONVERSAO_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA2')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>BR</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_LOJA4')? number_format(P1_TAXA_DE_CONVERSAO_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_LOJA4')? number_format(P2_TAXA_DE_CONVERSAO_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA4')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>CB</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_LOJA5')? number_format(P1_TAXA_DE_CONVERSAO_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_LOJA5')? number_format(P2_TAXA_DE_CONVERSAO_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA5')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>SJP</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_LOJA6')? number_format(P1_TAXA_DE_CONVERSAO_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_LOJA6')? number_format(P2_TAXA_DE_CONVERSAO_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA6')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>AT</td>
                            <td><?php 
                                if(defined('P1_TAXA_DE_CONVERSAO_LOJA7') && date('Y',strtotime($data_p1))  != '2019'){
                                    echo number_format(P1_TAXA_DE_CONVERSAO_LOJA7,2,',','.');
                                }elseif(defined('P1_TAXA_DE_CONVERSAO_LOJA6')){
                                    echo number_format(P1_TAXA_DE_CONVERSAO_LOJA6,2,',','.');
                                }else{
                                    echo '-';
                                }
                            ?></td>
                            <td><?php echo (defined('P2_TAXA_DE_CONVERSAO_LOJA7') && date('Y',strtotime($data_p2)) != '2019')? number_format(P2_TAXA_DE_CONVERSAO_LOJA7,2,',','.'): number_format(P2_TAXA_DE_CONVERSAO_LOJA6,2,',','.'); ?></td>
                            <td><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA7')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA7,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Regional</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_REGIONAL')? number_format(P1_TAXA_DE_CONVERSAO_REGIONAL,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_REGIONAL')? number_format(P2_TAXA_DE_CONVERSAO_REGIONAL,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim Taxa de conversão -->


            <!-- Itens por venda -->
            <div class="div-itens-por-venda mt-5 small w-75">
                <table class="ui selectable celled table pink text-center w-100">
                    <thead>
                        <tr class="small">
                            <th colspan="4" class="small">
                                <div class="ui left floated small primary labeled icon button bck-azul-escuro-daju">
                                <i class="shopping cart icon bck-azul-escuro-daju"></i> Itens por venda
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Loja</th>
                            <th><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AV</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_LOJA2')? number_format(P1_ITENS_POR_VENDA_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_LOJA2')? number_format(P2_ITENS_POR_VENDA_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA2')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>BR</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_LOJA4')? number_format(P1_ITENS_POR_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_LOJA4')? number_format(P2_ITENS_POR_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA4')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>CB</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_LOJA5')? number_format(P1_ITENS_POR_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_LOJA5')? number_format(P2_ITENS_POR_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA5')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>SJP</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_LOJA6')? number_format(P1_ITENS_POR_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_LOJA6')? number_format(P2_ITENS_POR_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA6')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>AT</td>
                            <td><?php
                                if(defined('P1_ITENS_POR_VENDA_LOJA7') && date('Y',strtotime($data_p1))  != '2019'){
                                    echo number_format(P1_ITENS_POR_VENDA_LOJA7,2,',','.');
                                }elseif(defined('P1_ITENS_POR_VENDA_LOJA6')){
                                    echo number_format(P1_ITENS_POR_VENDA_LOJA6,2,',','.');
                                }else{
                                    echo '-';
                                }
                            ?></td>
                            <td><?php echo (defined('P2_ITENS_POR_VENDA_LOJA7') && date('Y',strtotime($data_p2)) != '2019')? number_format(P2_ITENS_POR_VENDA_LOJA7,2,',','.'): number_format(P2_ITENS_POR_VENDA_LOJA6,2,',','.'); ?></td>
                            <td><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA7')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA7,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Regional</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_REGIONAL')? number_format(P1_ITENS_POR_VENDA_REGIONAL,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_REGIONAL')? number_format(P2_ITENS_POR_VENDA_REGIONAL,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_REGIONAL')? number_format(CRESCIMENTO_ITENS_POR_VENDA_REGIONAL,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Preço médio produtos -->
            <div class="div-preco-medio-produto mt-5 small mb-5 w-75">
                <table class="ui selectable celled table pink text-center w-100">
                    <thead>
                        <tr class="small">
                            <th colspan="4" class="small">
                                <div class="ui left floated small primary labeled icon button bck-azul-escuro-daju">
                                <i class="dollar sign icon bck-azul-escuro-daju"></i>Preço Médio Produto
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Loja</th>
                            <th><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AV</td>
                            <td>R$ <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_LOJA2')? number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA2,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_LOJA2')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA2')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>BR</td>
                            <td>R$ <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_LOJA4')? number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA4,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_LOJA4')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA4')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>CB</td>
                            <td>R$ <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_LOJA5')? number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA5,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_LOJA5')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA5')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>SJP</td>
                            <td>R$ <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_LOJA6')? number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_LOJA6')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA6')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>AT</td>
                            <td>R$ <?php
                                if(defined('P1_PRECO_MEDIO_PRODUTOS_LOJA7') && date('Y',strtotime($data_p1))  != '2019'){
                                    echo number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA7,2,',','.');
                                }elseif(defined('P1_PRECO_MEDIO_PRODUTOS_LOJA6')){
                                    echo number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.');
                                }else{
                                    echo '-';
                                }
                            ?></td>
                            <td>R$ <?php echo (defined('P2_PRECO_MEDIO_PRODUTOS_LOJA7') && date('Y',strtotime($data_p2)) != '2019')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA7, 2,',','.'): number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA6, 2,',','.'); ?></td>
                            <td><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA7')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA7,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Regional</td>
                            <td>R$ <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_REGIONAL')? number_format(P1_PRECO_MEDIO_PRODUTOS_REGIONAL,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_REGIONAL')? number_format(P2_PRECO_MEDIO_PRODUTOS_REGIONAL,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- fim preço médio produtos -->

            <!-- Margem -->
            <div class="div-preco-medio-produto mt-5 small mb-5 w-75">
                <table class="ui selectable celled table pink text-center w-100">
                    <thead>
                        <tr class="small">
                            <th colspan="4" class="small">
                                <div class="ui left floated small primary labeled icon button bck-azul-escuro-daju">
                                <i class="percent icon bck-azul-escuro-daju"></i>Margem
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Loja</th>
                            <th><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento P.P%<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AV</td>
                            <td><?php echo defined('P1_MARGEM_LOJA2')? number_format(P1_MARGEM_LOJA2,2,',','.') : "-" ; ?></td>
                            <td style="background-color: <?php echo COR_MARGEM_LOJA2; ?>"><?php echo defined('P2_MARGEM_LOJA2')? number_format(P2_MARGEM_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_MARGEM_LOJA2')? number_format(CRESCIMENTO_MARGEM_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>BR</td>
                            <td><?php echo defined('P1_MARGEM_LOJA4')? number_format(P1_MARGEM_LOJA4,2,',','.') : "-" ; ?></td>
                            <td style="background-color: <?php echo COR_MARGEM_LOJA4; ?>"><?php echo defined('P2_MARGEM_LOJA4')? number_format(P2_MARGEM_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_MARGEM_LOJA4')? number_format(CRESCIMENTO_MARGEM_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>CB</td>
                            <td><?php echo defined('P1_MARGEM_LOJA5')? number_format(P1_MARGEM_LOJA5,2,',','.') : "-" ; ?></td>
                            <td style="background-color: <?php echo COR_MARGEM_LOJA5; ?>"><?php echo defined('P2_MARGEM_LOJA5')? number_format(P2_MARGEM_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_MARGEM_LOJA5')? number_format(CRESCIMENTO_MARGEM_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>SJP</td>
                            <td><?php echo defined('P1_MARGEM_LOJA6')? number_format(P1_MARGEM_LOJA6,2,',','.') : "-" ; ?></td>
                            <td style="background-color: <?php echo COR_MARGEM_LOJA6; ?>"><?php echo defined('P2_MARGEM_LOJA6')? number_format(P2_MARGEM_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_MARGEM_LOJA6')? number_format(CRESCIMENTO_MARGEM_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>AT</td>
                            <td><?php
                                if(defined('P1_MARGEM_LOJA7') && date('Y',strtotime($data_p1)) != '2019'){
                                    echo number_format(P1_MARGEM_LOJA7,2,',','.');
                                }elseif(defined('P1_MARGEM_LOJA6')){
                                    echo number_format(P1_MARGEM_LOJA6,2,',','.');
                                }else{
                                    echo '-';
                                }
                            ?></td>
                            <td style="background-color: <?php echo COR_MARGEM_LOJA7; ?>"><?php echo (defined('P2_MARGEM_LOJA7') && date('Y',strtotime($data_p2)) != '2019')? number_format(P2_MARGEM_LOJA7,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_MARGEM_LOJA7')? number_format(CRESCIMENTO_MARGEM_LOJA7,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Regional</td>
                            <td><?php echo defined('P1_MARGEM_REGIONAL')? number_format(P1_MARGEM_REGIONAL,2,',','.') : "-" ; ?></td>
                            <td style="background-color: <?php echo COR_MARGEM_REGIONAL; ?>"><?php echo defined('P2_MARGEM_REGIONAL')? number_format(P2_MARGEM_REGIONAL,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_MARGEM_REGIONAL')? number_format(CRESCIMENTO_MARGEM_REGIONAL,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- fim Margem -->
        </div>
    </div>

    <?php include_once('modal.php'); ?>
    <!----------------------- Scripts ----------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="bibliotecas/js/scripts.js"></script>
</body>
</html>