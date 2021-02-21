<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Base margem</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="bibliotecas/bootstrap/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="bibliotecas/css/style.css">
    <!-- Semantic -->
    <link rel="stylesheet" type="text/css" href="bibliotecas/semantic/semantic.min.css">
    <script src="bibliotecas/semantic/semantic.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="bibliotecas/bootstrap/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- ULkit -->
    <link rel="stylesheet" href="bibliotecas/uikit/css/uikit.min.css" />
    <script src="bibliotecas/uikit/js/uikit.min.js"></script>
    <script src="bibliotecas/uikit/js/uikit-icons.min.js"></script>
    <!-- Icofont -->
    <link rel="stylesheet" href="bibliotecas/icofont/icofont.min.css">
    <!-- Developer settings -->
    <link rel="stylesheet" href="bibliotecas/css/style.css">
    <link rel="icon" type="image/png" href="img/icons/daju-logo-icon.png"/>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/44c8065d81.js" crossorigin="anonymous"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php //include_once('navbar-up.php'); ?>
        <?php //include_once('navbar-right.php'); ?>
        <div class="d-flex flex-column align-items-center w-90 mt-3">
            <!-- Filtro de buscas -->
            <div class="box_busca mt-5">
                <!-- Fim magem promoção -->
                <form action="painel_loja.php" method="post" class="text-center w-100">
                    <div class="cont-periodos">
                        <div class="div-periodo">
                            <div class="div-btn-periodo text-center w-20 ">
                                <span uk-icon="icon:clock" class="h-100"></span>
                                <input type="text" value="Período 1" id="" disabled class="btn-periodo w-75">
                            </div>
                            <div class="div-btn-data w-25 ">
                                <input type="date" name="data_p1" id="" class="text-center btn-data">
                            </div>
                            <div class="div-btn-horai w-10 ">
                                <input type="time" name="hora_inicio_p1" id="" class="text-center btn-horai">
                            </div>
                            <div class="div-btn-horaf w-10 ">
                                <input type="time" name="hora_fim_p1" id="" class="text-center btn-horaf">
                            </div>
                        </div>
                        <div class="div-periodo">
                            <div class="div-btn-periodo text-center w-20">
                                <span uk-icon="icon: history" class="h-100"></span>
                                <input type="text" value="Período 2" id="" disabled class="btn-periodo w-75">
                            </div>
                            <div class="div-btn-data w-25">
                                <input type="date" name="data_p2" id="" class="text-center btn-data">
                            </div>
                            <div class="div-btn-horai w-10">
                                <input type="time" name="hora_inicio_p2" id="" class="text-center btn-horai">
                            </div>
                            <div class="div-btn-horaf w-10">
                                <input type="time" name="hora_fim_p2" id="" class="text-center btn-horaf">
                            </div>
                        </div>
                        <div class="div-periodo">
                            <div class="div-btn-periodo text-center w-20">
                                <span uk-icon="icon:history" class="h-100"></span>
                                <input type="text" value="Período 3" id="" disabled class="btn-periodo w-75">
                            </div>
                            <div class="div-btn-data w-25">
                                <input type="date" name="data_p3" id="" class="text-center btn-data">
                            </div>
                            <div class="div-btn-horai w-10">
                                <input type="time" name="hora_inicio_p3" id="" class="text-center btn-horai">
                            </div>
                            <div class="div-btn-horaf w-10">
                                <input type="time" name="hora_fim_p3" id="" class="text-center btn-horaf">
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="pesquisar">
                </form>
            </div>
            <!-- Fim filtro de buscas -->

        <!-- Tabelas -->
        <div class="div-tabelas mt-3 ">
            <!-- Vendas -->
            <div class="div-vendas mt-5 small w-75vw">
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
                            <th><?php echo isset($data_p3)? date('d/m/Y', strtotime($data_p3)) : "-" ; ?></th>
                            <th>Crescimento<br><?php echo isset($data_p3)? date('d/m/Y', strtotime($data_p3)) : "-" ; ?> X <?php echo isset($data_p2)? date('d/m/Y', strtotime($data_p2)) : "-" ; ?></th>
                            <th>Crescimento 20x19</th>
                            <th>Hiper do Dia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Água Verde</dh>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA2')? number_format(P1_VENDA_LOJA2,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA2')? number_format(P2_VENDA_LOJA2,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P3_VENDA_LOJA2')? number_format(P3_VENDA_LOJA2,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_SEMANA_LOJA2')? number_format(CRESCIMENTO_SEMANA_LOJA2,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA2')? number_format(CRESCIMENTO_LOJA2,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('HIPER_VENDAS_P3_LOJA2')? number_format(HIPER_VENDAS_P3_LOJA2,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Atuba</dh>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA7')? number_format(P1_VENDA_LOJA7,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA7')? number_format(P2_VENDA_LOJA7,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P3_VENDA_LOJA7')? number_format(P3_VENDA_LOJA7,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_SEMANA_LOJA7')? number_format(CRESCIMENTO_SEMANA_LOJA7,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA7')? number_format(CRESCIMENTO_LOJA7,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('HIPER_VENDAS_P3_LOJA7')? number_format(HIPER_VENDAS_P3_LOJA7,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Barigui</dh>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA4')? number_format(P1_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA4')? number_format(P2_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P3_VENDA_LOJA4')? number_format(P3_VENDA_LOJA4,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_SEMANA_LOJA4')? number_format(CRESCIMENTO_SEMANA_LOJA4,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA4')? number_format(CRESCIMENTO_LOJA4,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('HIPER_VENDAS_P3_LOJA4')? number_format(HIPER_VENDAS_P3_LOJA4,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>Cabral</dh>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA5')? number_format(P1_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA5')? number_format(P2_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P3_VENDA_LOJA5')? number_format(P3_VENDA_LOJA5,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_SEMANA_LOJA5')? number_format(CRESCIMENTO_SEMANA_LOJA5,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA5')? number_format(CRESCIMENTO_LOJA5,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('HIPER_VENDAS_P3_LOJA5')? number_format(HIPER_VENDAS_P3_LOJA5,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                        <tr>
                            <td>São José</dh>
                            <td>R$ <?php echo defined('P1_VENDA_LOJA6')? number_format(P1_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P2_VENDA_LOJA6')? number_format(P2_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td>R$ <?php echo defined('P3_VENDA_LOJA6')? number_format(P3_VENDA_LOJA6,2,',','.') : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_SEMANA_LOJA6')? number_format(CRESCIMENTO_SEMANA_LOJA6,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('CRESCIMENTO_LOJA6')? number_format(CRESCIMENTO_LOJA6,2,',','.')."%" : "-" ; ?></td>
                            <td><?php echo defined('HIPER_VENDAS_P3_LOJA6')? number_format(HIPER_VENDAS_P3_LOJA6,2,',','.')."%" : "-" ; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
    <strong>Copyright&copy;2020 <a href="http://portaldaju.com.br" target="_blank">DAJU COMERCIO DE TECIDOS LTDA</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
    </div>
    </footer>
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="dist/js/demo.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>

    <!-- PAGE SCRIPTS -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <!----------------------- Scripts ----------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="bibliotecas/js/scripts.js"></script>
</body>
</html>