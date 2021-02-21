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
    <link rel="stylesheet" href="https://semantic-ui.com/dist/semantic.min.css">
    <!--Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="bibliotecas/css/style.css">
</head>
<body class="w-100">
    <?php include_once('menu_up.php'); ?>
    <div class="d-flex flex-column <!-- w-5 --> mt-3">
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
                        <button type="submit" class="btn btn-primary bck-azul-claro-daju border-color-azul-claro-daju" name="filtrar">Filtrar datas</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Fim filtro de buscas -->

        <!-- Tabelas -->
        <div class="div-tabelas mt-3 w-100 d-flex flex-column align-items-center fs-3">
            <!-- Vendas -->
            <div class="div-vendas small w-95">
                <table class="ui table pink text-center font-weight-bold table-striped">
                    <thead>
                        <tr class="small text-left">
                            <th colspan="8" class="small">
                                <div class="ui small labeled icon button bck-rosa-daju">
                                    <i class="shopping bag icon bck-rosa-daju"></i>VENDAS
                                </div>
                            </th>
                        </tr>
                        <tr style="font-size: 1rem;">
                            <th class="bck-rosa-daju w-20">LOJA</th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th class="bck-rosa-daju">Crescimento<br><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?> X <?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th style="background-color:#00b0f0;">Hiper Parcial</th>
                            <th style="background-color:#00b0f0;">Hiper do Dia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Água Verde</td>
                            <td> <?php echo defined('P1_VENDA_LOJA2') && defined('P1_VENDA_SOB_MEDIDA')? number_format((P1_VENDA_LOJA2+P1_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></tdss=>
                            <td> <?php echo defined('P2_VENDA_LOJA2') && defined('P2_VENDA_SOB_MEDIDA')? number_format((P2_VENDA_LOJA2+ P2_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></tds=>
                            <td style="<?php echo COR_CRESCIMENTO_LOJA2; ?>"><?php echo defined('CRESCIMENTO_LOJA2')? number_format(CRESCIMENTO_LOJA2,2,',','.')."%" : "-" ; ?></tdlass=>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_LOJA2')? number_format(HIPER_PARCIAL_VENDAS_P2_LOJA2,2,',','.') : "-" ; ?></tdass=>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_LOJA2')? number_format(HIPER_VENDAS_P2_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Barigui</td>
                            <td> <?php echo defined('P1_VENDA_LOJA4')? number_format(P1_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_VENDA_LOJA4')? number_format(P2_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_LOJA4; ?>"><?php echo defined('CRESCIMENTO_LOJA4')? number_format(CRESCIMENTO_LOJA4,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_LOJA4')? number_format(HIPER_PARCIAL_VENDAS_P2_LOJA4,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_LOJA4')? number_format(HIPER_VENDAS_P2_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Cabral</td>
                            <td> <?php echo defined('P1_VENDA_LOJA5')? number_format(P1_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_VENDA_LOJA5')? number_format(P2_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_LOJA5; ?>"><?php echo defined('CRESCIMENTO_LOJA5')? number_format(CRESCIMENTO_LOJA5,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_LOJA5')? number_format(HIPER_PARCIAL_VENDAS_P2_LOJA5,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_LOJA5')? number_format(HIPER_VENDAS_P2_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">São José dos Pinhais</td>
                            <td> <?php echo defined('P1_VENDA_LOJA6')? number_format(P1_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_VENDA_LOJA6')? number_format(P2_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_LOJA6 ?>"><?php echo defined('CRESCIMENTO_LOJA6')? number_format(CRESCIMENTO_LOJA6,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_LOJA6')? number_format(HIPER_PARCIAL_VENDAS_P2_LOJA6,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_LOJA6')? number_format(HIPER_VENDAS_P2_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Atuba</td>
                            <td> <?php
                                    if(defined('P1_VENDA_LOJA7') && date('Y',strtotime($data_p1)) > '2019'){
                                        echo  number_format(P1_VENDA_LOJA7,2,',','.');
                                    }elseif(defined('P1_VENDA_LOJA6')){
                                        echo  number_format(P1_VENDA_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td> <?php
                                    if(defined('P2_VENDA_LOJA7') && date('Y',strtotime($data_p2)) > '2019'){
                                        echo  number_format(P2_VENDA_LOJA7,2,',','.');
                                    }elseif(defined('P2_VENDA_LOJA6')){
                                        echo  number_format(P2_VENDA_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td style="<?php echo COR_CRESCIMENTO_LOJA7; ?>"><?php echo defined('CRESCIMENTO_LOJA7')? number_format(CRESCIMENTO_LOJA7,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_LOJA7')? number_format(HIPER_PARCIAL_VENDAS_P2_LOJA7,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_LOJA7')? number_format(HIPER_VENDAS_P2_LOJA7,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Delivery</td>
                            <td> <?php echo defined('P1_VENDA_DELIVERY')? number_format(P1_VENDA_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_VENDA_DELIVERY')? number_format(P2_VENDA_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_DELIVERY; ?>"><?php echo defined('CRESCIMENTO_DELIVERY')? number_format(CRESCIMENTO_DELIVERY,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_DELIVERY')? number_format(HIPER_PARCIAL_VENDAS_P2_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_DELIVERY')? number_format(HIPER_VENDAS_P2_DELIVERY,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">E-commerce</td>
                            <td> <?php echo defined('P1_VENDA_ECOMMERCE')? number_format(P1_VENDA_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_VENDA_ECOMMERCE')? number_format(P2_VENDA_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ECOMMERCE; ?>"><?php echo defined('CRESCIMENTO_ECOMMERCE')? number_format(CRESCIMENTO_ECOMMERCE,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_ECOMMERCE')? number_format(HIPER_PARCIAL_VENDAS_P2_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_ECOMMERCE')? number_format(HIPER_VENDAS_P2_ECOMMERCE,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Marketplace</td>
                            <td> <?php echo defined('P1_VENDA_MARKETPLACE')? number_format(P1_VENDA_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_VENDA_MARKETPLACE')? number_format(P2_VENDA_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_MARKETPLACE; ?>"><?php echo defined('CRESCIMENTO_MARKETPLACE')? number_format(CRESCIMENTO_MARKETPLACE,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_MARKETPLACE')? number_format(HIPER_PARCIAL_VENDAS_P2_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_MARKETPLACE')? number_format(HIPER_VENDAS_P2_MARKETPLACE,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional(LOJAs + Online)</td>
                            <td> <?php echo defined('P1_VENDAS_REGIONAL1')? number_format((P1_VENDAS_REGIONAL1 + P1_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_VENDAS_REGIONAL1')? number_format((P2_VENDAS_REGIONAL1 + P2_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_REGIONAL1; ?>"><?php echo defined('CRESCIMENTO_REGIONAL1')? number_format(CRESCIMENTO_REGIONAL1,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_REGIONAL1')? number_format(HIPER_PARCIAL_VENDAS_P2_REGIONAL1,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_REGIONAL1')? number_format(HIPER_VENDAS_P2_REGIONAL1,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional(AV,BR,CB,SJP)</td>
                            <td> <?php echo defined('P1_VENDAS_REGIONAL2')? number_format((P1_VENDAS_REGIONAL2 + P1_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_VENDAS_REGIONAL2')? number_format((P2_VENDAS_REGIONAL2 + P2_VENDA_SOB_MEDIDA),2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_REGIONAL2; ?>"><?php echo defined('CRESCIMENTO_REGIONAL2')? number_format(CRESCIMENTO_REGIONAL2,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_PARCIAL_VENDAS_P2_REGIONAL2')? number_format(HIPER_PARCIAL_VENDAS_P2_REGIONAL2,2,',','.') : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"> <?php echo defined('HIPER_VENDAS_P2_REGIONAL2')? number_format(HIPER_VENDAS_P2_REGIONAL2,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim Vendas -->

            <!-- Tkm -->
            <div class="div-tkm mt-5 small w-95">
                <table class="ui table-striped table pink text-center font-weight-bold">
                    <thead>
                        <tr class="small text-left">
                            <th colspan="8" class="small">
                                <div class="ui button small labeled icon bck-rosa-daju">
                                    <i class="money bill alternate icon bck-rosa-daju"></i> TKM
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="bck-rosa-daju w-20">LOJA</th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th class="bck-rosa-daju">Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th style="background-color:#00b0f0; font-weight: bold;">Hiper</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Água Verde</td>
                            <td> <?php echo defined('P1_TKM_LOJA2')? number_format(P1_TKM_LOJA2,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_TKM_LOJA2; ?>"> <?php echo defined('P2_TKM_LOJA2')? number_format(P2_TKM_LOJA2,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_LOJA2; ?>"><?php echo defined('CRESCIMENTO_TKM_LOJA2')? number_format(CRESCIMENTO_TKM_LOJA2,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_LOJA2')? "".number_format(HIPER_TKM_P2_LOJA2,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Barigui</td>
                            <td> <?php echo defined('P1_TKM_LOJA4')? number_format(P1_TKM_LOJA4,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_TKM_LOJA4; ?>"> <?php echo defined('P2_TKM_LOJA4')? number_format(P2_TKM_LOJA4,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_LOJA4; ?>"><?php echo defined('CRESCIMENTO_TKM_LOJA4')? number_format(CRESCIMENTO_TKM_LOJA4,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_LOJA4')? "".number_format(HIPER_TKM_P2_LOJA4,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Cabral</td>
                            <td> <?php echo defined('P1_TKM_LOJA5')? number_format(P1_TKM_LOJA5,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_TKM_LOJA5; ?>"> <?php echo defined('P2_TKM_LOJA5')? number_format(P2_TKM_LOJA5,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_LOJA5; ?>"><?php echo defined('CRESCIMENTO_TKM_LOJA5')? number_format(CRESCIMENTO_TKM_LOJA5,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_LOJA5')? "".number_format(HIPER_TKM_P2_LOJA5,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">São José dos Pinhais</td>
                            <td> <?php echo defined('P1_TKM_LOJA6')? number_format(P1_TKM_LOJA6,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_TKM_LOJA6; ?>"> <?php echo defined('P2_TKM_LOJA6')? number_format(P2_TKM_LOJA6,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_LOJA6; ?>"><?php echo defined('CRESCIMENTO_TKM_LOJA6')? number_format(CRESCIMENTO_TKM_LOJA6,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_LOJA6')? "".number_format(HIPER_TKM_P2_LOJA6,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Atuba</td>
                            <td> <?php
                                    if(defined('P1_TKM_LOJA7') && (date('Y',strtotime($data_p1)) > '2019')){
                                        echo number_format(P1_TKM_LOJA7,2,',','.');
                                    }elseif(defined('P1_TKM_LOJA6')){
                                        echo number_format(P1_TKM_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td style="<?php echo COR_TKM_LOJA7; ?>">
                                <?php
                                    if(defined('P2_TKM_LOJA7') && (date('Y',strtotime($data_p2)) > '2019')){
                                        echo number_format(P2_TKM_LOJA7,2,',','.') ;
                                    }elseif(defined('P2_TKM_LOJA6')){
                                        echo number_format(P2_TKM_LOJA6,2,',','.') ;
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_LOJA7; ?>"><?php echo defined('CRESCIMENTO_TKM_LOJA7')? number_format(CRESCIMENTO_TKM_LOJA7,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_LOJA7')? "".number_format(HIPER_TKM_P2_LOJA7,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Delivery</td>
                            <td> <?php echo defined('P1_TKM_DELIVERY')? number_format(P1_TKM_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_TKM_DELIVERY')? number_format(P2_TKM_DELIVERY,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_DELIVERY; ?>"><?php echo defined('CRESCIMENTO_TKM_DELIVERY')? number_format(CRESCIMENTO_TKM_DELIVERY,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_DELIVERY')? "".number_format(HIPER_TKM_P2_DELIVERY,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">E-commerce</td>
                            <td> <?php echo defined('P1_TKM_ECOMMERCE')? number_format(P1_TKM_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_TKM_ECOMMERCE')? number_format(P2_TKM_ECOMMERCE,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_ECOMMERCE; ?>"><?php echo defined('CRESCIMENTO_TKM_ECOMMERCE')? number_format(CRESCIMENTO_TKM_ECOMMERCE,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_ECOMMERCE')? "".number_format(HIPER_TKM_P2_ECOMMERCE,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Marketplace</td>
                            <td> <?php echo defined('P1_TKM_MARKETPLACE')? number_format(P1_TKM_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_TKM_MARKETPLACE')? number_format(P2_TKM_MARKETPLACE,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_MARKETPLACE; ?>"><?php echo defined('CRESCIMENTO_TKM_MARKETPLACE')? number_format(CRESCIMENTO_TKM_MARKETPLACE,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_MARKETPLACE')? "".number_format(HIPER_TKM_P2_MARKETPLACE,2,',','.') : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional</td>
                            <td> <?php echo defined('P1_TKM_REGIONAL1')? number_format(P1_TKM_REGIONAL1,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_TKM_REGIONAL1; ?>"> <?php echo defined('P2_TKM_REGIONAL1')? number_format(P2_TKM_REGIONAL1,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_TKM_REGIONAL1; ?>"><?php echo defined('CRESCIMENTO_TKM_REGIONAL1')? number_format(CRESCIMENTO_TKM_REGIONAL1,2,',','.')."%" : "-" ; ?></td>
                            <td style="background-color:#00b0f0; font-weight: bold;"><?php echo defined('HIPER_TKM_P2_REGIONAL2')? "".number_format(HIPER_TKM_P2_REGIONAL2,2,',','.') : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim TKM -->


            <!-- Atendimentos -->
            <div class="div-atendimentos mt-5 small w-95">
                <table class="ui table-striped table pink text-center font-weight-bold">
                    <thead>
                        <tr class="small">
                            <th colspan="8" class="small text-left">
                                <div class="ui small labeled icon button bck-rosa-daju">
                                    <i class="handshake icon bck-rosa-daju"></i>ATENDIMENTOS
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="bck-rosa-daju w-20">LOJA</th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th class="bck-rosa-daju">Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Água Verde</td>
                            <td><?php echo defined('P1_ATENDIMENTO_LOJA2')? P1_ATENDIMENTO_LOJA2 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_LOJA2')? P2_ATENDIMENTO_LOJA2 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_LOJA2; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA2')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA2,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Barigui</td>
                            <td><?php echo defined('P1_ATENDIMENTO_LOJA4')? P1_ATENDIMENTO_LOJA4 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_LOJA4')? P2_ATENDIMENTO_LOJA4 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_LOJA4; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA4')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA4,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Cabral</td>
                            <td><?php echo defined('P1_ATENDIMENTO_LOJA5')? P1_ATENDIMENTO_LOJA5 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_LOJA5')? P2_ATENDIMENTO_LOJA5 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_LOJA5; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA5')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA5,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">São José dos Pinhais</td>
                            <td><?php echo defined('P1_ATENDIMENTO_LOJA6')? P1_ATENDIMENTO_LOJA6 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_LOJA6')? P2_ATENDIMENTO_LOJA6 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_LOJA6; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA6')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA6,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Atuba</td>
                            <td><?php
                                    if(defined('P1_ATENDIMENTO_LOJA7') && date('Y',strtotime($data_p1)) > '2019'){
                                        echo P1_ATENDIMENTO_LOJA7;
                                    }elseif(defined('P1_ATENDIMENTO_LOJA6')){
                                        echo P1_ATENDIMENTO_LOJA6;
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    if(defined('P2_ATENDIMENTO_LOJA7') && date('Y',strtotime($data_p2)) > '2019'){
                                        echo P2_ATENDIMENTO_LOJA7;
                                    }elseif(defined('P2_ATENDIMENTO_LOJA6')){
                                        echo P2_ATENDIMENTO_LOJA6;
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_LOJA7; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_LOJA7')? number_format(CRESCIMENTO_ATENDIMENTO_LOJA7,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Delivery</td>
                            <td><?php echo defined('P1_ATENDIMENTO_DELIVERY')? P1_ATENDIMENTO_DELIVERY : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_DELIVERY')? P2_ATENDIMENTO_DELIVERY : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_DELIVERY; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_DELIVERY')? number_format(CRESCIMENTO_ATENDIMENTO_DELIVERY,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">E-commerce</td>
                            <td><?php echo defined('P1_ATENDIMENTO_ECOMMERCE')? P1_ATENDIMENTO_ECOMMERCE : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_ECOMMERCE')? P2_ATENDIMENTO_ECOMMERCE : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_ECOMMERCE; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_ECOMMERCE')? number_format(CRESCIMENTO_ATENDIMENTO_ECOMMERCE,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Marketplace</td>
                            <td><?php echo defined('P1_ATENDIMENTO_MARKETPLACE')? P1_ATENDIMENTO_MARKETPLACE : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_MARKETPLACE')? P2_ATENDIMENTO_MARKETPLACE : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_MARKETPLACE; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_MARKETPLACE')? number_format(CRESCIMENTO_ATENDIMENTO_MARKETPLACE,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional</td>
                            <td><?php echo defined('P1_ATENDIMENTO_REGIONAL1')? P1_ATENDIMENTO_REGIONAL1 : "-" ; ?></td>
                            <td><?php echo defined('P2_ATENDIMENTO_REGIONAL1')? P2_ATENDIMENTO_REGIONAL1 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ATENDIMENTO_REGIONAL1; ?>"><?php echo defined('CRESCIMENTO_ATENDIMENTO_REGIONAL1')? number_format(CRESCIMENTO_ATENDIMENTO_REGIONAL1,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim Atendimentos -->

            <!-- Fluxo de clientes -->
            <div class="div-atendimentos mt-5 small w-95">
                <table class="ui table-striped table pink text-center font-weight-bold">
                    <thead>
                        <tr class="small">
                            <th colspan="8" class="small text-left">
                                <div class="ui small labeled icon button bck-rosa-daju">
                                    <i class="retweet icon bck-rosa-daju"></i>FLUXO DE CLIENTES
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="bck-rosa-daju w-20">LOJA</th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th class="bck-rosa-daju">Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Água Verde</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_LOJA2')? P1_FLUXO_DE_CLIENTES_LOJA2 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_LOJA2')? P2_FLUXO_DE_CLIENTES_LOJA2 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA2; ?>"><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA2')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA2,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Barigui</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_LOJA4')? P1_FLUXO_DE_CLIENTES_LOJA4 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_LOJA4')? P2_FLUXO_DE_CLIENTES_LOJA4 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA4; ?>"><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA4')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA4,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Cabral</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_LOJA5')? P1_FLUXO_DE_CLIENTES_LOJA5 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_LOJA5')? P2_FLUXO_DE_CLIENTES_LOJA5 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA5; ?>"><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA5')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA5,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">São José dos Pinhais</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_LOJA6')? P1_FLUXO_DE_CLIENTES_LOJA6 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_LOJA6')? P2_FLUXO_DE_CLIENTES_LOJA6 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA6; ?>"><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA6')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA6,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Atuba</td>
                            <td><?php
                                    if(defined('P1_FLUXO_DE_CLIENTES_LOJA7') && date('Y',strtotime($data_p1)) > '2019'){
                                        echo P1_FLUXO_DE_CLIENTES_LOJA7;
                                    }elseif(defined('P1_FLUXO_DE_CLIENTES_LOJA6')){
                                        echo P1_FLUXO_DE_CLIENTES_LOJA6;
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    if(defined('P2_FLUXO_DE_CLIENTES_LOJA7') && date('Y',strtotime($data_p2)) > '2019'){
                                        echo P2_FLUXO_DE_CLIENTES_LOJA7;
                                    }elseif(defined('P2_FLUXO_DE_CLIENTES_LOJA6')){
                                        echo P2_FLUXO_DE_CLIENTES_LOJA6;
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td style="<?php echo COR_CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA7; ?>"><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA7')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA7,2,',','.') : "-" ; ?>%</td>

                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional</td>
                            <td><?php echo defined('P1_FLUXO_DE_CLIENTES_REGIONAL1')? P1_FLUXO_DE_CLIENTES_REGIONAL1 : "-" ; ?></td>
                            <td><?php echo defined('P2_FLUXO_DE_CLIENTES_REGIONAL1')? P2_FLUXO_DE_CLIENTES_REGIONAL1 : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL1; ?>"><?php echo defined('CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL1')? number_format(CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim Fluxo de clientes -->

            <!-- Taxa de conversão -->
            <div class="div-atendimentos mt-5 small w-95">
                <table class="ui table-striped table pink text-center font-weight-bold">
                    <thead>
                        <tr class="small">
                            <th colspan="8" class="small text-left">
                                <div class="ui small labeled icon button bck-rosa-daju">
                                    <i class="sync icon bck-rosa-daju"></i>TAXA DE CONVERSÃO
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="bck-rosa-daju w-20">LOJA</th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th class="bck-rosa-daju">Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Água Verde</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_LOJA2')? number_format(P1_TAXA_DE_CONVERSAO_LOJA2,2,',','.') : "-" ; ?>%</td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_LOJA2')? number_format(P2_TAXA_DE_CONVERSAO_LOJA2,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA2; ?>"><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA2')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA2,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Barigui</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_LOJA4')? number_format(P1_TAXA_DE_CONVERSAO_LOJA4,2,',','.') : "-" ; ?>%</td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_LOJA4')? number_format(P2_TAXA_DE_CONVERSAO_LOJA4,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA4; ?>"><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA4')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA4,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Cabral</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_LOJA5')? number_format(P1_TAXA_DE_CONVERSAO_LOJA5,2,',','.') : "-" ; ?>%</td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_LOJA5')? number_format(P2_TAXA_DE_CONVERSAO_LOJA5,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA5; ?>"><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA5')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA5,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">São José dos Pinhais</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_LOJA6')? number_format(P1_TAXA_DE_CONVERSAO_LOJA6,2,',','.') : "-" ; ?>%</td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_LOJA6')? number_format(P2_TAXA_DE_CONVERSAO_LOJA6,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA6; ?>"><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA6')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA6,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Atuba</td>
                            <td><?php
                                    if(defined('P1_TAXA_DE_CONVERSAO_LOJA7') && date('Y',strtotime($data_p1)) > '2019'){
                                        echo number_format(P1_TAXA_DE_CONVERSAO_LOJA7,2,',','.');
                                    }elseif(defined('P1_TAXA_DE_CONVERSAO_LOJA6')){
                                        echo number_format(P1_TAXA_DE_CONVERSAO_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>%
                            </td>
                            <td><?php
                                    if(defined('P2_TAXA_DE_CONVERSAO_LOJA7') && date('Y',strtotime($data_p2)) > '2019'){
                                        echo number_format(P2_TAXA_DE_CONVERSAO_LOJA7,2,',','.');
                                    }elseif(defined('P2_TAXA_DE_CONVERSAO_LOJA6')){
                                        echo number_format(P2_TAXA_DE_CONVERSAO_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>%
                            </td>
                            <td style="<?php echo COR_CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA7; ?>"><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA7')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA7,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional</td>
                            <td><?php echo defined('P1_TAXA_DE_CONVERSAO_REGIONAL1')? number_format(P1_TAXA_DE_CONVERSAO_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                            <td><?php echo defined('P2_TAXA_DE_CONVERSAO_REGIONAL1')? number_format(P2_TAXA_DE_CONVERSAO_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL1; ?>"><?php echo defined('CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL1')? number_format(CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim Taxa de conversão -->


            <!-- Itens por venda -->
            <div class="div-itens-por-venda mt-5 small w-95">
                <table class="ui table-striped table pink text-center font-weight-bold">
                    <thead>
                        <tr class="small">
                            <th colspan="4" class="small text-left">
                                <div class="ui small labeled icon button bck-rosa-daju">
                                <i class="shopping cart icon bck-rosa-daju"></i> ITENS POR VENDA
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="bck-rosa-daju w-20">LOJA</th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th class="bck-rosa-daju">Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Água Verde</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_LOJA2')? number_format(P1_ITENS_POR_VENDA_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_LOJA2')? number_format(P2_ITENS_POR_VENDA_LOJA2,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ITENS_POR_VENDA_LOJA2; ?>"><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA2')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA2,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Barigui</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_LOJA4')? number_format(P1_ITENS_POR_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_LOJA4')? number_format(P2_ITENS_POR_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ITENS_POR_VENDA_LOJA4; ?>"><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA4')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA4,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Cabral</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_LOJA5')? number_format(P1_ITENS_POR_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_LOJA5')? number_format(P2_ITENS_POR_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ITENS_POR_VENDA_LOJA5; ?>"><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA5')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA5,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">São José dos Pinhais</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_LOJA6')? number_format(P1_ITENS_POR_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_LOJA6')? number_format(P2_ITENS_POR_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ITENS_POR_VENDA_LOJA6; ?>"><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA6')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA6,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Atuba</td>
                            <td><?php
                                    if(defined('P1_ITENS_POR_VENDA_LOJA7') && date('Y',strtotime($data_p1)) > '2019'){
                                        echo number_format(P1_ITENS_POR_VENDA_LOJA7,2,',','.');
                                    }elseif(defined('P1_ITENS_POR_VENDA_LOJA6')){
                                        echo number_format(P1_ITENS_POR_VENDA_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td><?php
                                    if(defined('P2_ITENS_POR_VENDA_LOJA7') && date('Y',strtotime($data_p2)) > '2019'){
                                        echo number_format(P2_ITENS_POR_VENDA_LOJA7,2,',','.');
                                    }elseif(defined('P2_ITENS_POR_VENDA_LOJA6')){
                                        echo number_format(P2_ITENS_POR_VENDA_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td style="<?php echo COR_CRESCIMENTO_ITENS_POR_VENDA_LOJA7; ?>"><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_LOJA7')? number_format(CRESCIMENTO_ITENS_POR_VENDA_LOJA7,2,',','.')."%" : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional</td>
                            <td><?php echo defined('P1_ITENS_POR_VENDA_REGIONAL1')? number_format(P1_ITENS_POR_VENDA_REGIONAL1,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('P2_ITENS_POR_VENDA_REGIONAL1')? number_format(P2_ITENS_POR_VENDA_REGIONAL1,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_ITENS_POR_VENDA_REGIONAL1; ?>"><?php echo defined('CRESCIMENTO_ITENS_POR_VENDA_REGIONAL1')? number_format(CRESCIMENTO_ITENS_POR_VENDA_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Preço médio produtos -->
            <div class="div-preco-medio-produto mt-5 small w-95">
                <table class="ui table-striped table pink text-center font-weight-bold">
                    <thead>
                        <tr class="small">
                            <th colspan="4" class="small text-left">
                                <div class="ui small labeled icon button bck-rosa-daju">
                                <i class="dollar sign icon bck-rosa-daju"></i>PREÇO MÉDIO PRODUTOS
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="bck-rosa-daju w-20">LOJA</th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th class="bck-rosa-daju">Crescimento<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Água Verde</td>
                            <td> <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_LOJA2')? number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA2,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_LOJA2')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA2,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA2; ?>"><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA2')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA2,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Barigui</td>
                            <td> <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_LOJA4')? number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA4,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_LOJA4')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA4,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA4; ?>"><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA4')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA4,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Cabral</td>
                            <td> <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_LOJA5')? number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA5,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_LOJA5')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA5,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA5; ?>"><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA5')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA5,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">São José dos Pinhais</td>
                            <td> <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_LOJA6')? number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_LOJA6')? number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA6; ?>"><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA6')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Atuba</td>
                            <td> <?php
                                    if(defined('P1_PRECO_MEDIO_PRODUTOS_LOJA7') && date('Y',strtotime($data_p1)) > '2019'){
                                        echo number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA7,2,',','.');
                                    }elseif(defined('P1_PRECO_MEDIO_PRODUTOS_LOJA6')){
                                        echo number_format(P1_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td> <?php
                                    if(defined('P2_PRECO_MEDIO_PRODUTOS_LOJA7') && date('Y',strtotime($data_p2)) > '2019'){
                                        echo number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA7,2,',','.');
                                    }elseif(defined('P2_PRECO_MEDIO_PRODUTOS_LOJA6')){
                                        echo number_format(P2_PRECO_MEDIO_PRODUTOS_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td style="<?php echo COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA7; ?>"><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA7')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA7,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional</td>
                            <td> <?php echo defined('P1_PRECO_MEDIO_PRODUTOS_REGIONAL1')? number_format(P1_PRECO_MEDIO_PRODUTOS_REGIONAL1,2,',','.') : "-" ; ?></td>
                            <td> <?php echo defined('P2_PRECO_MEDIO_PRODUTOS_REGIONAL1')? number_format(P2_PRECO_MEDIO_PRODUTOS_REGIONAL1,2,',','.') : "-" ; ?></td>
                            <td style="<?php echo COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL1; ?>"><?php echo defined('CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL1')? number_format(CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- fim preço médio produtos -->

            <!-- Margem -->
            <div class="div-preco-medio-produto mt-5 small mb-5 w-95">
                <table class="ui table-striped table pink text-center font-weight-bold">
                    <thead>
                        <tr class="small">
                            <th colspan="4" class="small text-left">
                                <div class="ui small primary labeled icon button bck-rosa-daju">
                                <i class="percent icon bck-rosa-daju"></i>MARGEM
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="bck-rosa-daju w-20">LOJA</th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?></th>
                            <th class="bck-rosa-daju"><?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th class="bck-rosa-daju">Crescimento P.P%<br><?php echo isset($data_p1)? date('d/m/Y', strtotime($data_p1)) : "-" ; ?> x <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Água Verde</td>
                            <td><?php echo defined('P1_MARGEM_LOJA2')? number_format(P1_MARGEM_LOJA2,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_MARGEM_LOJA2; ?>"><?php echo defined('P2_MARGEM_LOJA2')? number_format(P2_MARGEM_LOJA2,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_MARGEM_LOJA2; ?>"><?php echo defined('CRESCIMENTO_MARGEM_LOJA2')? number_format(CRESCIMENTO_MARGEM_LOJA2,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Barigui</td>
                            <td><?php echo defined('P1_MARGEM_LOJA4')? number_format(P1_MARGEM_LOJA4,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_MARGEM_LOJA4; ?>"><?php echo defined('P2_MARGEM_LOJA4')? number_format(P2_MARGEM_LOJA4,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_MARGEM_LOJA4; ?>"><?php echo defined('CRESCIMENTO_MARGEM_LOJA4')? number_format(CRESCIMENTO_MARGEM_LOJA4,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Cabral</td>
                            <td><?php echo defined('P1_MARGEM_LOJA5')? number_format(P1_MARGEM_LOJA5,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_MARGEM_LOJA5; ?>"><?php echo defined('P2_MARGEM_LOJA5')? number_format(P2_MARGEM_LOJA5,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_MARGEM_LOJA5; ?>"><?php echo defined('CRESCIMENTO_MARGEM_LOJA5')? number_format(CRESCIMENTO_MARGEM_LOJA5,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">São José dos Pinhais</td>
                            <td><?php echo defined('P1_MARGEM_LOJA6')? number_format(P1_MARGEM_LOJA6,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_MARGEM_LOJA6; ?>"><?php echo defined('P2_MARGEM_LOJA6')? number_format(P2_MARGEM_LOJA6,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_MARGEM_LOJA6; ?>"><?php echo defined('CRESCIMENTO_MARGEM_LOJA6')? number_format(CRESCIMENTO_MARGEM_LOJA6,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Atuba</td>
                            <td><?php
                                    if(defined('P1_MARGEM_LOJA7') && date('Y',strtotime($data_p1)) > '2019'){
                                        echo number_format(P1_MARGEM_LOJA7,2,',','.');
                                    }elseif(defined('P1_MARGEM_LOJA6')){
                                        echo number_format(P1_MARGEM_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>%
                            </td>
                            <td style="<?php echo COR_MARGEM_LOJA7; ?>"><?php
                                    if(defined('P2_MARGEM_LOJA7') && date('Y',strtotime($data_p2)) > '2019'){
                                        echo number_format(P2_MARGEM_LOJA7,2,',','.');
                                    }elseif(defined('P2_MARGEM_LOJA6')){
                                        echo number_format(P2_MARGEM_LOJA6,2,',','.');
                                    }else{
                                        echo '-';
                                    }
                                ?>%
                            </td>
                            <td style="<?php echo COR_CRESCIMENTO_MARGEM_LOJA7; ?>"><?php echo defined('CRESCIMENTO_MARGEM_LOJA7')? number_format(CRESCIMENTO_MARGEM_LOJA7,2,',','.') : "-" ; ?>%</td>
                        </tr>
                        <tr style="font-size: 1.2rem;">
                            <td class="bck-rosa-daju text-left">Regional</td>
                            <td><?php echo defined('P1_MARGEM_REGIONAL1')? number_format(P1_MARGEM_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_MARGEM_REGIONAL1; ?>"><?php echo defined('P2_MARGEM_REGIONAL1')? number_format(P2_MARGEM_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                            <td style="<?php echo COR_CRESCIMENTO_MARGEM_REGIONAL1; ?>"><?php echo defined('CRESCIMENTO_MARGEM_REGIONAL1')? number_format(CRESCIMENTO_MARGEM_REGIONAL1,2,',','.') : "-" ; ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- fim Margem -->
        </div>
    </div>

    <?php include_once('modal.php'); ?>


    <!----------------------- Scripts ----------------------->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script src="bibliotecas/js/scripts.js"></script>
</body>
</html>