<?php
    //***************Cálculos referente as visualizações de desempenho de cada loja***************//
    include_once("conn/conn.php");
    //pega as datas de comparação
    /* Definir data período 1 ou data ano passado */
    if((isset($_POST['dataP1'])) && (strtotime($_POST['dataP1']) != strtotime('1969-31-12'))){
        $data_p1 = $_POST['dataP1'];
    }elseif((isset($_POST['dataP2'])) && (strtotime($_POST['dataP2']) != strtotime('1969-31-12')) && date('L') == 1){
        $data_p1 = date('Y-m-d', strtotime('-'. 364 .' days', strtotime(date($_POST['dataP2']))));
    }elseif((isset($_POST['dataP2'])) && (strtotime($_POST['dataP2']) != strtotime('1969-31-12'))){
        $data_p1 = date('Y-m-d', strtotime('-'. 365 .' days', strtotime(date($_POST['dataP2']))));
    }else{
        $data_p1 = date('Y-m-d', strtotime('-'. 365 .' days', strtotime(date('Y-m-d'))));
    }
    /* Fim definição data período 1 ou data ano passado */

    /* definir data período 2 ou hoje*/
    if(isset($_POST['dataP2']) && (strtotime($_POST['dataP2']) != strtotime('1969-31-12'))){
        $data_p2 = $_POST['dataP2'];
    }else{
        $data_p2 = date('Y-m-d');
    }
    /* Hora geral */
    if(isset($_POST['horaInicio']) && $_POST['horaInicio'] != ''){
        $hora_inicio = $_POST['horaInicio'];
    }else{
        $hora_inicio = '00:00:00';
    }
    if(isset($_POST['horaFim']) && $_POST['horaFim'] != ''){
        $hora_fim = $_POST['horaFim'];
    }else{
        $hora_fim = '23:59:00';
    }


    define('DATA_P1', $data_p1);
    define('DATA_P2', $data_p2);
    define('HORA_INICIO', $hora_inicio);
    define('HORA_FIM', $hora_fim);



    /* **********SOB MEDIDA*********** */
    /* Soma período 1 */
    $nome_var_venda_p1 = "P1_VENDA_SOB_MEDIDA";
    // $sql_sob_medida_p1 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_sob_medida' FROM db_venda WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_operacao IN ('0','')";
    $sql_sob_medida_p1 = "SELECT * FROM `db_vendas_sob_medida` WHERE data = '".$data_p1."'";
    $conexao_venda_sob_medida = $conn->prepare($sql_sob_medida_p1);
    $conexao_venda_sob_medida ->execute();
    foreach($conexao_venda_sob_medida AS $linha_consulta_venda_p1_sob_medida){
        $vl_total_venda_p1_sob_medida = $linha_consulta_venda_p1_sob_medida['valor'];
    }
    if(isset($vl_total_venda_p1_sob_medida)){
        define($nome_var_venda_p1, $vl_total_venda_p1_sob_medida);
    }else{
        define($nome_var_venda_p1, 0);
    }
    /* Fim soma período 1 */

    /* Soma período 2 */
    $nome_var_venda_p2 = "P2_VENDA_SOB_MEDIDA";
    // $sql_sob_medida_p2 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_sob_medida' FROM db_venda WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_operacao IN ('0','')";
    $sql_sob_medida_p2 = "SELECT * FROM `db_vendas_sob_medida` WHERE data = '".$data_p2."'";
    $conexao_venda_sob_medida = $conn->prepare($sql_sob_medida_p2);
    $conexao_venda_sob_medida ->execute();
    foreach($conexao_venda_sob_medida AS $linha_consulta_venda_p2_sob_medida){
        $vl_total_venda_p2_sob_medida = $linha_consulta_venda_p2_sob_medida['valor'];
    }
    if(isset($vl_total_venda_p2_sob_medida)){
        define($nome_var_venda_p2, $vl_total_venda_p2_sob_medida);
    }else{
        define($nome_var_venda_p2, 0);
    }
    /* Fim soma período 2 */


    /* **************************************************************************************************************************** */
    /* **************************************************************************************************************************** */
    /* **************************************************************************************************************************** */
    /* Selecionar as empresas no banco */
    $sqlLojas = "SELECT * FROM `db_nome_empresa`";
    $conexaoLoja = $conn -> prepare($sqlLojas);
    $conexaoLoja -> execute();
    /******** Início definição dos valores por empresa ********/
    foreach($conexaoLoja AS $linha_consulta_loja){
        /* Loja selecionada */
        $loja = $linha_consulta_loja['cd_loja'];
        $ds_loja = $linha_consulta_loja['ds_loja'];
        $hora_trabalhada_loja = gmdate('H.i', strtotime($linha_consulta_loja['hora_fim']) - strtotime($linha_consulta_loja['hora_inicio']));
        $tempo_decorrido = gmdate('H.i', strtotime( $hora_fim ) - strtotime( $linha_consulta_loja['hora_inicio']));
        $porcento_hiper_parcial = $tempo_decorrido / $hora_trabalhada_loja;
        if($porcento_hiper_parcial > 1){
            $porcento_hiper_parcial = 1;
        }
        isset($porcento_hiper_parcial) ? $porcento_hiper_parcial = $porcento_hiper_parcial : $porcento_hiper_parcial = 0;
        /*************************** SOMA VENDAS ***************************/
        /* Soma período 1 */
        $sql_p1 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p1' FROM db_venda WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_produto <> 999 AND cd_operacao NOT IN('1501','501') and cd_empresa = ".$loja;
        $conexao_venda = $conn ->prepare($sql_p1);
        $conexao_venda ->execute();
        $nome_var_venda_p1 = "P1_VENDA_LOJA".$loja;
        foreach($conexao_venda AS $linha_consulta_venda_p1){
            $vl_total_venda_p1 = $linha_consulta_venda_p1['total_venda_p1'];
        }
        isset($vl_total_venda_p1) ? define($nome_var_venda_p1, $vl_total_venda_p1) : define($nome_var_venda_p1, 0);
        /* Fim soma período 1 */

        /* Soma período 2 */
        $sql_p2 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p2' FROM db_venda WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_produto <> 999 AND cd_operacao NOT IN('1501','501') AND cd_empresa = ".$loja;
        $conexao_venda = $conn ->prepare($sql_p2);
        $conexao_venda ->execute();
        $nome_var_venda_p2 = "P2_VENDA_LOJA".$loja;
        foreach($conexao_venda AS $linha_consulta_venda_p2){
            $vl_total_venda_p2 = $linha_consulta_venda_p2['total_venda_p2'];
        }
        isset($vl_total_venda_p2) ? define($nome_var_venda_p2, $vl_total_venda_p2) : define($nome_var_venda_p2, 0);

        /* Fim Soma período 2 */

        /* Crescimento Vendas Loja  */
        $var_crescimento = "CRESCIMENTO_LOJA".$loja;
        $var_cor_crescimento = "COR_CRESCIMENTO_LOJA".$loja;
        if($loja == 2){
            if($vl_total_venda_p1 != 0 && $vl_total_venda_p1 != NULL){
                $crescimento = ((($vl_total_venda_p2 + P2_VENDA_SOB_MEDIDA) / ($vl_total_venda_p1 + P1_VENDA_SOB_MEDIDA))*100) - 100;
            }else{
                $crescimento = 0;
            }
        }else{
            if($vl_total_venda_p1 != 0 && $vl_total_venda_p1 != NULL){
                $crescimento = (($vl_total_venda_p2 / $vl_total_venda_p1)*100) - 100;
            }else{
                $crescimento = 0;
            }
        }
        if ($crescimento <= 0) {
            define($var_cor_crescimento,'color:#f00');
        }else {
            define($var_cor_crescimento,'');
        }
        define($var_crescimento, $crescimento);
        /* Fim crescimento Vendas Loja  */

        /* Hiper Loja Dia */
        $sql_hiper_vendas_p2 = "SELECT * FROM `metas_diarias` WHERE dt_meta = '".$data_p2."' AND cd_empresa = ".$loja;
        $conexao_hiper = $conn ->prepare($sql_hiper_vendas_p2);
        $conexao_hiper ->execute();
        $nome_var_hiper_p2 = "HIPER_VENDAS_P2_LOJA".$loja;
        foreach($conexao_hiper AS $linha_consulta_hiper_vendas_p2){
            $hiper_total_hiper_venda_p2 = $linha_consulta_hiper_vendas_p2['hiper'];
        }
        isset($hiper_total_hiper_venda_p2) ? define($nome_var_hiper_p2, $hiper_total_hiper_venda_p2) : define($nome_var_hiper_p2, 0);
        /* selecionar */

        /* Hiper Loja Parcial */
        $sql_hiper_parcial_vendas_p2 = "SELECT * FROM `metas_diarias` WHERE dt_meta = '".$data_p2."' AND cd_empresa = ".$loja;
        $conexao_hiper_parcial = $conn ->prepare($sql_hiper_parcial_vendas_p2);
        $conexao_hiper_parcial ->execute();
        $nome_var_hiper_parcial_p2 = "HIPER_PARCIAL_VENDAS_P2_LOJA".$loja;
        foreach($conexao_hiper_parcial AS $linha_consulta_hiper_parcial_vendas_p2){
            $hiper_total_hiper_parcial_venda_p2 = $linha_consulta_hiper_parcial_vendas_p2['hiper'] * $porcento_hiper_parcial;
        }
        isset($hiper_total_hiper_parcial_venda_p2) ? define($nome_var_hiper_parcial_p2, $hiper_total_hiper_parcial_venda_p2) : define($nome_var_hiper_parcial_p2, 0);
        /* selecionar */


        /*************************** ATENDIMENTOS ***************************/
        /* Início atendimentos período 1 */
        $sql_atendimentos_p1 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE vl_total_venda > '0.00' AND dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_produto <> 999 and cd_empresa = ".$loja;
        $atendimentos_p1 = $conn->query($sql_atendimentos_p1)->fetchColumn();
        $atendimento_var_p1 = "P1_ATENDIMENTO_LOJA".$loja;
        define($atendimento_var_p1, $atendimentos_p1);
        /* Fim atendimentos período 1 */

        /* Início atendimentos período 2 */
        $sql_atendimentos_p2 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE vl_total_venda > '0.00' AND dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_produto <> 999 and cd_empresa = ".$loja;
        $atendimentos_p2 = $conn->query($sql_atendimentos_p2)->fetchColumn();
        $atendimento_var_p2 = "P2_ATENDIMENTO_LOJA".$loja;
        define($atendimento_var_p2, $atendimentos_p2);
        /* Fim atendimentos período 2 */

        /* Crescimento atendimento */
        $var_crescimento_atendimentos = "CRESCIMENTO_ATENDIMENTO_LOJA".$loja;
        $var_cor_crescimento_atendimentos = "COR_CRESCIMENTO_ATENDIMENTO_LOJA".$loja;
        if($atendimentos_p1 != 0 && $atendimentos_p1 != NULL){
            $crescimento_atendimentos = (((($atendimentos_p2 / $atendimentos_p1)*100)-100));
        }else{
            $crescimento_atendimentos = 0;
        }
        if ($crescimento_atendimentos <= 0 ) {
            define($var_cor_crescimento_atendimentos,"color: #f00");
        } else {
            define($var_cor_crescimento_atendimentos,"");
        }
        define($var_crescimento_atendimentos, $crescimento_atendimentos);
        /* Fim crescimento atendimento */


        /*************************** Fluxo de Clientes ***************************/
        /* Início fluxo de clientes período 1 */
        $sql_fluxo_de_clientes_p1 = "SELECT * FROM `fluxo_de_clientes` WHERE dt_base = '".$data_p1."' AND cd_empresa = ".$loja." GROUP BY id ASC";
        $conexao_fluxo_clientes = $conn ->prepare($sql_fluxo_de_clientes_p1);
        $conexao_fluxo_clientes ->execute();
        $fluxo_de_clientes_p1 = 0;
        $nome_var_fluxo_clientes_p1 = "P1_FLUXO_DE_CLIENTES_LOJA".$loja;
        foreach($conexao_fluxo_clientes AS $linha_consulta_fluxo_p1){
            $fluxo_de_clientes_p1 = $fluxo_de_clientes_p1 + $linha_consulta_fluxo_p1['fluxo_de_clientes'];
        }
        define($nome_var_fluxo_clientes_p1, $fluxo_de_clientes_p1);
        /* Fim fluxo de clientes período 1 */

        /* Início fluxo de clientes período 2 */
        $sql_fluxo_de_clientes_p2 = "SELECT * FROM `fluxo_de_clientes` WHERE dt_base = '".$data_p2."' AND cd_empresa = ".$loja." GROUP BY id ASC";
        $conexao_fluxo_clientes = $conn ->prepare($sql_fluxo_de_clientes_p2);
        $conexao_fluxo_clientes->execute();
        $nome_var_fluxo_p2 = "P2_FLUXO_DE_CLIENTES_LOJA".$loja;
        $fluxo_de_clientes_p2 = 0;
        foreach($conexao_fluxo_clientes AS $linha_consulta_fluxo_p2){
            $fluxo_de_clientes_p2 = $fluxo_de_clientes_p2 + $linha_consulta_fluxo_p2['fluxo_de_clientes'];
        }
        define($nome_var_fluxo_p2, $fluxo_de_clientes_p2);
        /* Fim fluxo de clientes período 2 */

        /* Crescimento atendimento */
        $var_crescimento_fluxo_de_clientes = "CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA".$loja;
        $var_cor_crescimento_fluxo_de_clientes = "COR_CRESCIMENTO_FLUXO_DE_CLIENTES_LOJA".$loja;
        if($fluxo_de_clientes_p1 != 0 && $fluxo_de_clientes_p1 != NULL){
            $crescimento_fluxo_de_clientes = (((($fluxo_de_clientes_p2 / $fluxo_de_clientes_p1)*100)-100));
        }else{
            $crescimento_fluxo_de_clientes = 0;
        }
        if ($crescimento_fluxo_de_clientes <= 0 ) {
            define($var_cor_crescimento_fluxo_de_clientes,"color: #f00");
        } else {
            define($var_cor_crescimento_fluxo_de_clientes,"");
        }
        define($var_crescimento_fluxo_de_clientes, $crescimento_fluxo_de_clientes);
        /* Fim crescimento fluxo de clientes */


        /*************************** TAXA DE CONVERSÃO ***************************/
        /* Taxa de conversão p1*/
        $taxa_de_conversao_p1_var = "P1_TAXA_DE_CONVERSAO_LOJA".$loja; //Cria nome da variável
        if($fluxo_de_clientes_p1 != 0 && $fluxo_de_clientes_p1 != NULL){
            $taxa_de_conversao_p1 = ($atendimentos_p1/$fluxo_de_clientes_p1)*100;
        }else{
            $taxa_de_conversao_p1 = 0;
        }
        define($taxa_de_conversao_p1_var, $taxa_de_conversao_p1);
        /* Fim Taxa de conversão p1 */

        /* Taxa de conversão p2*/
        $taxa_de_conversao_p2_var = "P2_TAXA_DE_CONVERSAO_LOJA".$loja; //Cria nome da variável
        if($fluxo_de_clientes_p2 != 0 && $fluxo_de_clientes_p2 != NULL){
            $taxa_de_conversao_p2 = ($atendimentos_p2/$fluxo_de_clientes_p2)*100;
        }else{
            $taxa_de_conversao_p2 = 0;
        }
        define($taxa_de_conversao_p2_var, $taxa_de_conversao_p2);
        /* Fim Taxa de conversão p2 */

        /* Crescimento Taxa de conversão */
        $var_crescimento_taxa_de_conversao = "CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA".$loja;
        $var_cor_crescimento_taxa_de_conversao = "COR_CRESCIMENTO_TAXA_DE_CONVERSAO_LOJA".$loja;
        if($taxa_de_conversao_p1 != 0 && $taxa_de_conversao_p1 != NULL){
            $crescimento_taxa_de_conversao = ((($taxa_de_conversao_p2/$taxa_de_conversao_p1)*100)-100);
        }else{
            $crescimento_taxa_de_conversao = 0;
        }
        if ($crescimento_taxa_de_conversao <= 0 ) {
            define($var_cor_crescimento_taxa_de_conversao,"color: #f00");
        } else {
            define($var_cor_crescimento_taxa_de_conversao,"");
        }
        define($var_crescimento_taxa_de_conversao, $crescimento_taxa_de_conversao);
        /* Fim crescimento Taxa de conversão  */

        /*************************** TKM ***************************/
        /* TKM período 1*/
        $tkm_var_p1 = "P1_TKM_LOJA".$loja; //Cria nome da variável
        if($atendimentos_p1 != 0 && $atendimentos_p1 != NULL){
            $tkm_p1 = ($vl_total_venda_p1/$atendimentos_p1);
        }else{
            $tkm_p1 = 0;
        }
        define($tkm_var_p1, $tkm_p1);
        /* Fim TKM período 1*/

        /* TKM período 2*/
        $tkm_var_p2 = "P2_TKM_LOJA".$loja; //Cria nome da variável
        if($atendimentos_p2 != 0 && $atendimentos_p2 != NULL){
            $tkm_p2 = ($vl_total_venda_p2/$atendimentos_p2);
        }else{
            $tkm_p2 = 0;
        }
        define($tkm_var_p2, $tkm_p2);
        /* Fim TKM período 2*/


        /* Crescimento TKM  */
        $var_crescimento_tkm = "CRESCIMENTO_TKM_LOJA".$loja;
        $var_cor_crescimento_tkm = "COR_CRESCIMENTO_TKM_LOJA".$loja;
        if($tkm_p1 != 0 && $tkm_p1 != NULL){
            $crescimento_tkm = (($tkm_p2 / $tkm_p1)*100)-100;
        }else{
            $crescimento_tkm = 0;
        }
        if ($crescimento_tkm <= 0) {
            define($var_cor_crescimento_tkm,'color: #f00;');
        }else{
            define($var_cor_crescimento_tkm, '');
        }
        define($var_crescimento_tkm, $crescimento_tkm);
        /* Fim crescimento TKM  */

        /* Hiper Loja tkm */
        $sql_hiper_tkm_p2 = "SELECT * FROM `metas_tkm` WHERE cd_empresa = ".$loja;
        $conexao_tkm = $conn ->prepare($sql_hiper_tkm_p2);
        $conexao_tkm ->execute();
        /* Criar as variáveis para a hiper e cor do tkm */
        $nome_var_tkm_p2 = "HIPER_TKM_P2_LOJA".$loja;
        $nome_var_cor_p2 = "COR_TKM_LOJA".$loja;
        foreach($conexao_tkm AS $linha_consulta_hiper_tkm_p2){
            $vl_total_tkm_p2 = $linha_consulta_hiper_tkm_p2['hiper'];
            define($nome_var_tkm_p2, $linha_consulta_hiper_tkm_p2['hiper']);
            if($tkm_p2 > $linha_consulta_hiper_tkm_p2['hiper']){
                define($nome_var_cor_p2,'background-color:#00b0f0;');//azul
            }elseif($tkm_p2 < $linha_consulta_hiper_tkm_p2['hiper'] && $tkm_p2 > $linha_consulta_hiper_tkm_p2['super']) {
                define($nome_var_cor_p2,'background-color:#00ff00;');//verde claro brilhante
            }elseif($tkm_p2 < $linha_consulta_hiper_tkm_p2['super'] && $tkm_p2 > $linha_consulta_hiper_tkm_p2['meta']){
                define($nome_var_cor_p2,'background-color:#28a745;color: #fff;');//verde musgo
            }else{
                define($nome_var_cor_p2,'background-color:#ff0000;color: #fff;');//vermelho claro brilhante
            }
        }
        /* selecionar */
        


        /*************************** QUANTIDADE PRODUTOS ***************************/
        /* Quantidade de produtos p1 */
        $sql_qt_produtos_p1 = "SELECT SUM(qt_venda) AS 'qt_venda' FROM `db_venda` WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim ."' AND cd_produto <> 999 and cd_empresa = ".$loja;
        $conexaoProdutos = $conn -> prepare($sql_qt_produtos_p1);
        $conexaoProdutos -> execute();
        foreach($conexaoProdutos AS $linha_consulta_qt_produtos){
            $nome_var_produtos = "P1_QT_PRODUTOS_LOJA".$loja;
            $produtos_p1 = $linha_consulta_qt_produtos['qt_venda'];
            define($nome_var_produtos, $produtos_p1);
        }
        /* Fim quantidade produtos p1 */


        /* Quantidade de produtos p2 */
        $sql_qt_produtos_p2  = "SELECT SUM(qt_venda) AS 'qt_venda' FROM `db_venda` WHERE dt_transacao = '".$data_p2 ."' AND hr_saida BETWEEN '".$hora_inicio ."' AND '".$hora_fim  ."' AND cd_produto <> 999 and cd_empresa = ".$loja;
        $conexaoProdutos = $conn -> prepare($sql_qt_produtos_p2 );
        $conexaoProdutos -> execute();
        foreach($conexaoProdutos AS $linha_consulta_qt_produtos){
            $nome_var_produtos = "P2_QT_PRODUTOS_LOJA".$loja;
            $produtos_p2  = $linha_consulta_qt_produtos['qt_venda'];
            define($nome_var_produtos, $produtos_p2 );
        }
        /* Fim quantidade produtos p2 */


        /* Crescimento de qt produtos */
        $var_produtos = "CRESCIMENTO_PRODUTOS_LOJA".$loja;
        $var_cor_produtos = "COR_CRESCIMENTO_PRODUTOS_LOJA".$loja;
        if($produtos_p1 != 0 && $produtos_p1 != NULL){
            $crescimento_produtos = ((($produtos_p2/$produtos_p1)*100)-100);
        }else{
            $crescimento_produtos = 0;
        }
        if ($crescimento_produtos <= 0) {
            define($var_cor_produtos,'color: #f00;');
        }else{
            define($var_cor_produtos, '');
        }
        define($var_produtos, $crescimento_produtos);
        /* Fim crescimento de qt produtos */


        /*************************** ITENS POR VENDA ***************************/
        /* Itens por venda p1*/
        $itens_por_venda_p1_var = "P1_ITENS_POR_VENDA_LOJA".$loja; //Cria nome da variável
        if($atendimentos_p1 != 0 && $atendimentos_p1 != NULL){
            $itens_por_venda_p1 = ($produtos_p1/$atendimentos_p1);
        }else{
            $itens_por_venda_p1 = 0;
        }
        define($itens_por_venda_p1_var, $itens_por_venda_p1);
        /* Fim Itens por venda  p1 */

        /* Itens por venda p2*/
        $itens_por_venda_p2_var = "P2_ITENS_POR_VENDA_LOJA".$loja; //Cria nome da variável
        if($atendimentos_p2 != 0 && $atendimentos_p2 != NULL){
            $itens_por_venda_p2 = ($produtos_p2/$atendimentos_p2);
        }else{
            $itens_por_venda_p2 = 0;
        }
        define($itens_por_venda_p2_var, $itens_por_venda_p2);
        /* Fim Itens por venda  p2 */


        /* Crescimento itens por venda */
        $var_crescimento_itens_por_venda = "CRESCIMENTO_ITENS_POR_VENDA_LOJA".$loja;
        $var_cor_crescimento_itens_por_venda = "COR_CRESCIMENTO_ITENS_POR_VENDA_LOJA".$loja;
        if($itens_por_venda_p1 != 0 && $itens_por_venda_p1 != NULL){
            $crescimento_itens_por_venda = ((($itens_por_venda_p2 / $itens_por_venda_p1)*100)-100);
        }else{
            $crescimento_itens_por_venda = 0;
        }
        if ($crescimento_produtos <= 0) {
            define($var_cor_crescimento_itens_por_venda,'color: #f00;');
        }else{
            define($var_cor_crescimento_itens_por_venda, '');
        }
        define($var_crescimento_itens_por_venda, $crescimento_itens_por_venda);
        /* Fim crescimento itens por venda */


        /*************************** PREÇO MÉDIO PRODUTOS ***************************/
        /* Preço médio produtos p1*/
        $preco_medio_produtos_p1_var = "P1_PRECO_MEDIO_PRODUTOS_LOJA".$loja; //Cria nome da variável
        if($produtos_p1 != 0 && $produtos_p1 != NULL){
            $preco_medio_produtos_p1 = ($vl_total_venda_p1/$produtos_p1);
        }else{
            $preco_medio_produtos_p1 = 0;
        }
        define($preco_medio_produtos_p1_var, $preco_medio_produtos_p1);
        /* Fim preço médio produtos p1 */

        /* Preço médio produtos p2*/
        $preco_medio_produtos_p2_var = "P2_PRECO_MEDIO_PRODUTOS_LOJA".$loja; //Cria nome da variável
        if($produtos_p2 != 0 && $produtos_p2 != NULL){
            $preco_medio_produtos_p2 = ($vl_total_venda_p2/$produtos_p2);
        }else{
            $preco_medio_produtos_p2 = 0;
        }
        define($preco_medio_produtos_p2_var, $preco_medio_produtos_p2);
        /* Fim preço médio produtos p2 */


        /* Crescimento preço médio produtos */
        $var_crescimento_preco_medio_produtos = "CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA".$loja;
        $var_cor_crescimento_preco_medio_produtos = "COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_LOJA".$loja;
        if($preco_medio_produtos_p1 != 0 && $preco_medio_produtos_p1 != NULL){
            $crescimento_preco_medio_produtos = ((($preco_medio_produtos_p2 / $preco_medio_produtos_p1)*100)-100);
        }else{
            $crescimento_preco_medio_produtos = 0;
        }
        if ($crescimento_preco_medio_produtos <= 0) {
            define($var_cor_crescimento_preco_medio_produtos,'color: #f00;');
        }else{
            define($var_cor_crescimento_preco_medio_produtos, '');
        }
        define($var_crescimento_preco_medio_produtos, $crescimento_preco_medio_produtos);
        /* Fim crescimento preço médio produtos  */

        /*************************** MARGEM ***************************/
        /* Margem p1 */
        $sql_margem_p1 = "SELECT * FROM `base_margem` WHERE dt_base = '".$data_p1."' and cd_empresa = ".$loja;
        $conexaoMargem = $conn -> prepare($sql_margem_p1);
        $conexaoMargem -> execute();
        foreach($conexaoMargem AS $linha_consulta_loja){
            $nome_var_margem = "P1_MARGEM_LOJA".$loja;
            $margem_p1 = $linha_consulta_loja['contribuicao_marginal'];
            define($nome_var_margem,$margem_p1);
        }
        /* Fim margem p1 */

        /* Margem p2 */
        $sql_margem_p2 = "SELECT * FROM `base_margem` WHERE dt_base = '".$data_p2."' and cd_empresa = ".$loja;
        $conexaoMargem = $conn -> prepare($sql_margem_p2);
        $conexaoMargem -> execute();
        $nome_var_margem = "P2_MARGEM_LOJA".$loja;
        foreach($conexaoMargem AS $linha_consulta_loja){
            $margem_p2 = $linha_consulta_loja['contribuicao_marginal'];
            define($nome_var_margem,$margem_p2);
        }
        /* Fim Margem p2 */

        /* Crescimento margem */
        $var_margem = "CRESCIMENTO_MARGEM_LOJA".$loja;
        $var_cor_margem = "COR_CRESCIMENTO_MARGEM_LOJA".$loja;
        if(isset($margem_p1) && isset($margem_p2)/*  && $margem_p2 != 0 && $margem_p2 != NULL */){
            // $crescimento_margem = ((($margem_p1/$margem_p2)*100)-100);
            $crescimento_margem = $margem_p2-$margem_p1;
        }else{
            $crescimento_margem = 0;
        }
        if ($crescimento_margem <= 0) {
            define($var_cor_margem,'color: #f00;');
        }else{
            define($var_cor_margem, '');
        }
        define($var_margem, $crescimento_margem);
        /* Fim Crescimento margem */

        /* Hiper margem */
        $sql_hiper_margem_p2 = "SELECT * FROM `metas_margem` WHERE cd_empresa = ".$loja;
        $conexaoMargem = $conn ->prepare($sql_hiper_margem_p2);
        $conexaoMargem ->execute();
        $nome_var_margem_p2 = "HIPER_MARGEM_P2_LOJA".$loja;
        $nome_var_margem_cor_p2 = "COR_MARGEM_LOJA".$loja;
        foreach($conexaoMargem AS $linha_consulta_hiper_margem_p2){
            $vl_total_margem_p2 = $linha_consulta_hiper_margem_p2['hiper'];
            if(!isset($margem_p2) || $linha_consulta_hiper_margem_p2['hiper'] == NULL){
                define($nome_var_margem_p2, 0);
                define($nome_var_margem_cor_p2,'background-color:#ff0000;color: #fff;');
            }else{
                define($nome_var_margem_p2, $vl_total_margem_p2);
                if($margem_p2 >= $linha_consulta_hiper_margem_p2['hiper']){
                    define($nome_var_margem_cor_p2,'background-color:#00b0f0');
                }elseif($margem_p2 >= $linha_consulta_hiper_margem_p2['super'] && $margem_p2 < $linha_consulta_hiper_margem_p2['hiper']) {
                    define($nome_var_margem_cor_p2,'background-color:#00ff00');
                }elseif($margem_p2 >= $linha_consulta_hiper_margem_p2['meta'] && $margem_p2 < $linha_consulta_hiper_margem_p2['super']){
                    define($nome_var_margem_cor_p2,'background-color:#28a745');
                }else{
                    define($nome_var_margem_cor_p2,'background-color:#ff0000;color: #fff;');
                }
            }
        }
        /* fim hiper margem */

    }
    /******** Fim definição dos valores por loja ********/


    /* Início definição dos valores por loja virtual */
    /*************************** SOMA VENDAS ***************************/
    /* E-commerce */
    /* Soma período 1 */
    $sql_p1 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p1' FROM db_venda WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_produto <> 999 and cd_operacao IN ('133','134','9080','8080')";
    $conexao = $conn ->prepare($sql_p1);
    $conexao ->execute();
    foreach($conexao AS $linha_consulta_p1){
        $nome_var_p1_ecommerce = "P1_VENDA_ECOMMERCE";
        $vl_total_venda_p1_ecommerce = $linha_consulta_p1['total_venda_p1']; 
        define($nome_var_p1_ecommerce, $vl_total_venda_p1_ecommerce);
    }
    /* Fim soma período 1 */

    /* Soma período 2 */
    $sql_p2 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p2' FROM db_venda WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('133','134','9080','8080')";
    $conexao = $conn ->prepare($sql_p2);
    $conexao ->execute();
    foreach($conexao AS $linha_consulta_p2){
        $nome_var_p2_ecommerce = "P2_VENDA_ECOMMERCE";
        $vl_total_venda_p2_ecommerce = $linha_consulta_p2['total_venda_p2']; 
        define($nome_var_p2_ecommerce, $vl_total_venda_p2_ecommerce);
    }
    /* Fim Soma período 2 */

    /* Crescimento Vendas Loja  */
    $var_crescimento = "CRESCIMENTO_ECOMMERCE";
    $var_cor_crescimento = "COR_CRESCIMENTO_ECOMMERCE";
    if($vl_total_venda_p1_ecommerce != 0 && $vl_total_venda_p1_ecommerce != NULL){
        $crescimento_ecommerce = (($vl_total_venda_p2_ecommerce / $vl_total_venda_p1_ecommerce)*100) - 100;
    }else{
        $crescimento_ecommerce = 0;
    }
    if ($crescimento_ecommerce <= 0) {
        define($var_cor_crescimento,'color: #f00;');
    }else{
        define($var_cor_crescimento, '');
    }
    define($var_crescimento, $crescimento_ecommerce);
    /* Fim crescimento Vendas Loja  */

    /* Hiper Loja Dia */
    $sql_hiper_vendas_p2_ecommerce = "SELECT * FROM `metas_diarias` WHERE dt_meta = '".$data_p2."' AND cd_empresa = 1";
    $conexao_hiper_ecommerce = $conn ->prepare($sql_hiper_vendas_p2_ecommerce);
    $conexao_hiper_ecommerce ->execute();
    $nome_var_hiper_p2_ecommerce = "HIPER_VENDAS_P2_ECOMMERCE";
    foreach($conexao_hiper_ecommerce AS $linha_consulta_hiper_vendas_p2_ecommerce){
        $hiper_total_hiper_venda_p2_ecommerce = $linha_consulta_hiper_vendas_p2_ecommerce['hiper'];
    }
    isset($hiper_total_hiper_venda_p2_ecommerce) ? define($nome_var_hiper_p2_ecommerce, $hiper_total_hiper_venda_p2_ecommerce) : define($nome_var_hiper_p2_ecommerce, 0);
    /* selecionar */

    /* Hiper Loja Parcial */
    $sql_hiper_parcial_vendas_p2_ecommerce = "SELECT * FROM `metas_diarias` WHERE dt_meta = '".$data_p2."' AND cd_empresa = 1";
    $conexao_hiper_parcial_ecommerce = $conn ->prepare($sql_hiper_parcial_vendas_p2_ecommerce);
    $conexao_hiper_parcial_ecommerce ->execute();
    $nome_var_hiper_parcial_p2_ecommerce = "HIPER_PARCIAL_VENDAS_P2_ECOMMERCE";
    foreach($conexao_hiper_parcial_ecommerce AS $linha_consulta_hiper_parcial_vendas_p2_ecommerce){
        $hiper_total_hiper_parcial_venda_p2_ecommerce = $linha_consulta_hiper_parcial_vendas_p2_ecommerce['hiper'] * $porcento_hiper_parcial;
    }
    isset($hiper_total_hiper_parcial_venda_p2_ecommerce) ? define($nome_var_hiper_parcial_p2_ecommerce, $hiper_total_hiper_parcial_venda_p2_ecommerce) : define($nome_var_hiper_parcial_p2_ecommerce, 0);
    /* selecionar */

    /*************************** ATENDIMENTOS ***************************/
    /* Início atendimentos período 1 */
    $sql_atendimentos_ecommerce_p1 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('133','134','9080','8080')";
    $atendimentos_ecommerce_p1 = $conn->query($sql_atendimentos_ecommerce_p1)->fetchColumn();
    define('P1_ATENDIMENTO_ECOMMERCE', $atendimentos_ecommerce_p1);
    /* Fim atendimentos período 1 */

    /* Início atendimentos período 2 */
    $sql_atendimentos_ecommerce_p2 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('133','134','9080','8080')";
    $atendimentos_ecommerce_p2 = $conn->query($sql_atendimentos_ecommerce_p2)->fetchColumn();
    define('P2_ATENDIMENTO_ECOMMERCE', $atendimentos_ecommerce_p2);
    /* Fim atendimentos período 2 */

    /* Crescimento atendimento */
    $var_crescimento_atendimentos_ecommerce = "CRESCIMENTO_ATENDIMENTO_ECOMMERCE";
    $var_cor_crescimento_atendimentos_ecommerce = "COR_CRESCIMENTO_ATENDIMENTO_ECOMMERCE";
    if($atendimentos_ecommerce_p1 != 0 && $atendimentos_ecommerce_p1 != NULL){
        $crescimento_atendimentos_ecommerce = (((($atendimentos_ecommerce_p2 / $atendimentos_ecommerce_p1)*100)-100));
    }else{
        $crescimento_atendimentos_ecommerce = 0;
    }
    if ($crescimento_atendimentos_ecommerce <= 0) {
        define($var_cor_crescimento_atendimentos_ecommerce,'color: #f00;');
    }else{
        define($var_cor_crescimento_atendimentos_ecommerce, '');
    }
    define($var_crescimento_atendimentos_ecommerce, $crescimento_atendimentos_ecommerce);
    /* Fim crescimento atendimento */

    /*************************** TKM ***************************/
    /* TKM período 1*/
    $tkm_var_p1_ecommerce = "P1_TKM_ECOMMERCE"; //Cria nome da variável
    if($atendimentos_ecommerce_p1 != 0 && $atendimentos_ecommerce_p1 != NULL){
        $tkm_p1_ecommerce = ($vl_total_venda_p1_ecommerce/$atendimentos_ecommerce_p1);
    }else{
        $tkm_p1_ecommerce = 0;
    }
    define($tkm_var_p1_ecommerce, $tkm_p1_ecommerce);
    /* Fim TKM período 1*/

    /* TKM período 2*/
    $tkm_var_p2_ecommerce = "P2_TKM_ECOMMERCE"; //Cria nome da variável
    if($atendimentos_ecommerce_p2 != 0 && $atendimentos_ecommerce_p2 != NULL){
        $tkm_p2_ecommerce = ($vl_total_venda_p2_ecommerce/$atendimentos_ecommerce_p2);
    }else{
        $tkm_p2_ecommerce = 0;
    }
    define($tkm_var_p2_ecommerce, $tkm_p2_ecommerce);
    /* Fim TKM período 2*/


    /* Crescimento TKM  */
    if($tkm_p1_ecommerce != 0 && $tkm_p1_ecommerce != NULL){
        $crescimento_tkm_ecommerce = (($tkm_p2_ecommerce / $tkm_p1_ecommerce)*100)-100;
    }else{
        $crescimento_tkm_ecommerce = 0;
    }
    if ($crescimento_tkm_ecommerce <= 0) {
        define('COR_CRESCIMENTO_TKM_ECOMMERCE','color: #f00;');
    }else{
        define('COR_CRESCIMENTO_TKM_ECOMMERCE', '');
    }
    define('CRESCIMENTO_TKM_ECOMMERCE', $crescimento_tkm_ecommerce);
    /* Fim crescimento TKM  */

    /* Hiper Loja tkm */
    $sql_hiper_tkm_p2_ecommerce = "SELECT * FROM `metas_tkm` WHERE cd_empresa = 1";
    $conexao_tkm_ecommerce = $conn ->prepare($sql_hiper_tkm_p2_ecommerce);
    $conexao_tkm_ecommerce ->execute();
    /* Criar as variáveis para a hiper e cor do tkm */
    $nome_var_tkm_p2_ecommerce = "HIPER_TKM_P2_ECOMMERCE";
    $nome_var_cor_p2_ecommerce = "COR_TKM_ECOMMERCE";
    foreach($conexao_tkm_ecommerce AS $linha_consulta_hiper_tkm_p2_ecommerce){
        $vl_total_tkm_p2_ecommerce = $linha_consulta_hiper_tkm_p2_ecommerce['hiper'];
        if($tkm_p2_ecommerce > $linha_consulta_hiper_tkm_p2_ecommerce['hiper']){
            define($nome_var_cor_p2_ecommerce,'background-color:#00b0f0;');//azul
        }elseif($tkm_p2_ecommerce < $linha_consulta_hiper_tkm_p2_ecommerce['hiper'] && $tkm_p2_ecommerce > $linha_consulta_hiper_tkm_p2_ecommerce['super']) {
            define($nome_var_cor_p2_ecommerce,'background-color:#00ff00;');//verde claro brilhante
        }elseif($tkm_p2_ecommerce < $linha_consulta_hiper_tkm_p2_ecommerce['super'] && $tkm_p2_ecommerce > $linha_consulta_hiper_tkm_p2_ecommerce['meta']){
            define($nome_var_cor_p2_ecommerce,'background-color:#28a745;');//verde musgo
        }else{
            define($nome_var_cor_p2_ecommerce,'background-color:#ff0000;color: #fff;');//vermelho claro brilhante
        }
    }
    isset($vl_total_tkm_p2_ecommerce)? define($nome_var_tkm_p2_ecommerce, $vl_total_tkm_p2_ecommerce) : define($nome_var_tkm_p2_ecommerce, 0);
    /* selecionar */
    /*************************** FIM SOMA VENDAS E-COMMERCE ***************************/


    /*************************** SOMA VENDAS DELIVERY***************************/
    /* Soma período 1 */
    $sql_p1 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p1' FROM db_venda WHERE dt_transacao = '".DATA_P1."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_produto <> 999 and cd_operacao IN ('1501','501')";
    $conexao = $conn ->prepare($sql_p1);
    $conexao ->execute();
    foreach($conexao AS $linha_consulta_p1){
        $nome_var_p1 = "P1_VENDA_DELIVERY";
        $vl_total_venda_p1 = $linha_consulta_p1['total_venda_p1']; 
        define($nome_var_p1, $vl_total_venda_p1);
    }
    /* Fim soma período 1 */

    /* Soma período 2 */
    $sql_p2 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p2' FROM db_venda WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('1501','501')";
    $conexao = $conn ->prepare($sql_p2);
    $conexao ->execute();
    foreach($conexao AS $linha_consulta_p2){
        $nome_var_p2 = "P2_VENDA_DELIVERY";
        $vl_total_venda_p2 = $linha_consulta_p2['total_venda_p2']; 
        define($nome_var_p2, $vl_total_venda_p2);
    }
    /* Fim Soma período 2 */

    /* Crescimento Vendas Loja  */
    $var_crescimento = "CRESCIMENTO_DELIVERY";
    $var_cor_crescimento = "COR_CRESCIMENTO_DELIVERY";
    if($vl_total_venda_p1 != 0 && $vl_total_venda_p1 != NULL){
        $crescimento = (($vl_total_venda_p2 / $vl_total_venda_p1)*100) - 100;
    }else{
        $crescimento = 0;
    }
    if ($crescimento <= 0) {
        define($var_cor_crescimento,'color: #f00;');
    }else{
        define($var_cor_crescimento, '');
    }
    define($var_crescimento, $crescimento);
    /* Fim crescimento Vendas Loja  */

    
    /* Hiper Loja Dia */
    $sql_hiper_vendas_p2_delivery = "SELECT * FROM `metas_diarias` WHERE dt_meta = '".$data_p2."' AND cd_empresa = 1";
    $conexao_hiper_delivery = $conn ->prepare($sql_hiper_vendas_p2_delivery);
    $conexao_hiper_delivery ->execute();
    $nome_var_hiper_p2_delivery = "HIPER_VENDAS_P2_DELIVERY";
    foreach($conexao_hiper_delivery AS $linha_consulta_hiper_vendas_p2_delivery){
        $hiper_total_hiper_venda_p2_delivery = $linha_consulta_hiper_vendas_p2_delivery['hiper'];
    }
    isset($hiper_total_hiper_venda_p2_delivery) ? define($nome_var_hiper_p2_delivery, $hiper_total_hiper_venda_p2_delivery) : define($nome_var_hiper_p2_delivery, 0);
    /* selecionar */

    /* Hiper Loja Parcial */
    $sql_hiper_parcial_vendas_p2_delivery = "SELECT * FROM `metas_diarias` WHERE dt_meta = '".$data_p2."' AND cd_empresa = 1";
    $conexao_hiper_parcial_delivery = $conn ->prepare($sql_hiper_parcial_vendas_p2_delivery);
    $conexao_hiper_parcial_delivery ->execute();
    $nome_var_hiper_parcial_p2_delivery = "HIPER_PARCIAL_VENDAS_P2_DELIVERY";
    foreach($conexao_hiper_parcial_delivery AS $linha_consulta_hiper_parcial_vendas_p2_delivery){
        $hiper_total_hiper_parcial_venda_p2_delivery = $linha_consulta_hiper_parcial_vendas_p2_delivery['hiper'] * $porcento_hiper_parcial;
    }
    isset($hiper_total_hiper_parcial_venda_p2_delivery) ? define($nome_var_hiper_parcial_p2_delivery, $hiper_total_hiper_parcial_venda_p2_delivery) : define($nome_var_hiper_parcial_p2_delivery, 0);
    /* selecionar */


    /*************************** ATENDIMENTOS ***************************/
    /* Início atendimentos período 1 */
    $sql_atendimentos_p1 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('1501','501')";
    $atendimentos_delivery_p1 = $conn->query($sql_atendimentos_p1)->fetchColumn();
    $atendimento_delivery_var_p1 = "P1_ATENDIMENTO_DELIVERY";
    define($atendimento_delivery_var_p1, $atendimentos_delivery_p1);
    /* Fim atendimentos período 1 */

    /* Início atendimentos período 2 */
    $sql_atendimentos_p2 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('1501','501')";
    $atendimentos_delivery_p2 = $conn->query($sql_atendimentos_p2)->fetchColumn();
    $atendimento_delivery_var_p2 = "P2_ATENDIMENTO_DELIVERY";
    define($atendimento_delivery_var_p2, $atendimentos_delivery_p2);
    /* Fim atendimentos período 2 */

    /* Crescimento atendimento */
    if($atendimentos_delivery_p1 != 0 && $atendimentos_delivery_p1 != NULL){
        $crescimento_atendimentos_delivery = (((($atendimentos_delivery_p2 / $atendimentos_delivery_p1)*100)-100));
    }else{
        $crescimento_atendimentos_delivery = 0;
    }
    if ($crescimento_atendimentos_delivery <= 0) {
        define('COR_CRESCIMENTO_ATENDIMENTO_DELIVERY','color: #f00;');
    }else{
        define('COR_CRESCIMENTO_ATENDIMENTO_DELIVERY', '');
    }
    define('CRESCIMENTO_ATENDIMENTO_DELIVERY', $crescimento_atendimentos_delivery);
    /* Fim crescimento atendimento */

    /*************************** TKM ***************************/
    /* TKM período 1*/
    $tkm_var_p1_delivery = "P1_TKM_DELIVERY"; //Cria nome da variável
    if(isset($atendimentos_delivery_p1) && isset($vl_total_venda_p1_delivery) && $atendimentos_delivery_p1 != 0 && $atendimentos_delivery_p1 != NULL){
        $tkm_p1_delivery = ($vl_total_venda_p1_delivery/$atendimentos_delivery_p1);
    }else{
        $tkm_p1_delivery = 0;
    }
    define($tkm_var_p1_delivery, $tkm_p1_delivery);
    /* Fim TKM período 1*/

    /* TKM período 2*/
    $tkm_var_p2_delivery = "P2_TKM_DELIVERY"; //Cria nome da variável
    if(isset($vl_total_venda_p2_delivery) && $atendimentos_delivery_p2 != 0 && $atendimentos_delivery_p2 != NULL){
        $tkm_p2_delivery = ($vl_total_venda_p2_delivery/$atendimentos_delivery_p2);
    }else{
        $tkm_p2_delivery = 0;
    }
    isset($tkm_p2_delivery) ? define($tkm_var_p2_delivery, $tkm_p2_delivery) : define($tkm_var_p2_delivery, 0);
    /* Fim TKM período 2*/


    /* Crescimento TKM  */
    if($tkm_p1_delivery != 0 && $tkm_p1_delivery != NULL){
        $crescimento_tkm_delivery = (($tkm_p2_delivery / $tkm_p1_delivery)*100)-100;
    }else{
        $crescimento_tkm_delivery = 0;
    }
    if ($crescimento_tkm_delivery <= 0) {
        define('COR_CRESCIMENTO_TKM_DELIVERY','color: #f00;');
    }else{
        define('COR_CRESCIMENTO_TKM_DELIVERY', '');
    }
    define('CRESCIMENTO_TKM_DELIVERY', $crescimento_tkm_delivery);
    /* Fim crescimento TKM  */

    /* Hiper Loja tkm */
    $sql_hiper_tkm_p2_delivery = "SELECT * FROM `metas_tkm` WHERE cd_empresa = 1";
    $conexao_tkm_delivery = $conn ->prepare($sql_hiper_tkm_p2_delivery);
    $conexao_tkm_delivery ->execute();
    /* Criar as variáveis para a hiper e cor do tkm */
    $nome_var_tkm_p2_delivery = "HIPER_TKM_P2_DELIVERY";
    $nome_var_cor_p2_delivery = "COR_TKM_DELIVERY";
    foreach($conexao_tkm_delivery AS $linha_consulta_hiper_tkm_p2_delivery){
        $vl_total_tkm_p2_delivery = $linha_consulta_hiper_tkm_p2_delivery['hiper'];
        if($tkm_p2_delivery > $linha_consulta_hiper_tkm_p2_delivery['hiper']){
            define($nome_var_cor_p2_delivery,'background-color:#00b0f0;');//azul
        }elseif($tkm_p2_delivery < $linha_consulta_hiper_tkm_p2_delivery['hiper'] && $tkm_p2_delivery > $linha_consulta_hiper_tkm_p2_delivery['super']) {
            define($nome_var_cor_p2_delivery,'background-color:#00ff00;');//verde claro brilhante
        }elseif($tkm_p2_delivery < $linha_consulta_hiper_tkm_p2_delivery['super'] && $tkm_p2_delivery > $linha_consulta_hiper_tkm_p2_delivery['meta']){
            define($nome_var_cor_p2_delivery,'background-color:#28a745;');//verde musgo
        }else{
            define($nome_var_cor_p2_delivery,'background-color:#ff0000;color: #fff;');//vermelho claro brilhante
        }
    }
    isset($vl_total_tkm_p2_delivery)? define($nome_var_tkm_p2_delivery, $vl_total_tkm_p2_delivery) : define($nome_var_tkm_p2_delivery, 0);
    /* selecionar */

    /* Marketplace */
    /* Soma período 1 */
    $sql_p1 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p1' FROM db_venda WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".HORA_INICIO."' AND '".HORA_FIM."' AND cd_produto <> 999 and cd_operacao IN ('9020','8020')";
    $conexao = $conn ->prepare($sql_p1);
    $conexao ->execute();
    foreach($conexao AS $linha_consulta_p1){
        $nome_var_p1_marketplace = "P1_VENDA_MARKETPLACE";
        $vl_total_venda_p1_marketplace = $linha_consulta_p1['total_venda_p1']; 
        define($nome_var_p1_marketplace, $vl_total_venda_p1_marketplace);
    }
    /* Fim soma período 1 */

    /* Soma período 2 */
    $sql_p2 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p2' FROM db_venda WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('9020','8020')";
    $conexao = $conn ->prepare($sql_p2);
    $conexao ->execute();
    foreach($conexao AS $linha_consulta_p2){
        $nome_var_p2_marketplace = "P2_VENDA_MARKETPLACE";
        $vl_total_venda_p2_marketplace = $linha_consulta_p2['total_venda_p2']; 
        define($nome_var_p2_marketplace, $vl_total_venda_p2_marketplace);
    }
    /* Fim Soma período 2 */

    /* Crescimento Vendas Loja  */
    $var_crescimento = "CRESCIMENTO_MARKETPLACE";
    $var_cor_crescimento = "COR_CRESCIMENTO_MARKETPLACE";
    if($vl_total_venda_p1_marketplace != 0 && $vl_total_venda_p1_marketplace != NULL){
        $crescimento_marketplace = (($vl_total_venda_p2_marketplace / $vl_total_venda_p1_marketplace)*100) - 100;
    }else{
        $crescimento_marketplace = 0;
    }
    if ($crescimento_marketplace <= 0) {
        define($var_cor_crescimento,'color: #f00;');
    }else{
        define($var_cor_crescimento, '');
    }
    define($var_crescimento, $crescimento_marketplace);
    /* Fim crescimento Vendas Loja  */

    
    /* Hiper Loja Dia */
    $sql_hiper_vendas_p2_marketplace = "SELECT * FROM `metas_diarias` WHERE dt_meta = '".$data_p2."' AND cd_empresa = 1";
    $conexao_hiper_marketplace = $conn ->prepare($sql_hiper_vendas_p2_marketplace);
    $conexao_hiper_marketplace ->execute();
    $nome_var_hiper_p2_marketplace = "HIPER_VENDAS_P2_MARKETPLACE";
    foreach($conexao_hiper_marketplace AS $linha_consulta_hiper_vendas_p2_marketplace){
        $hiper_total_hiper_venda_p2_marketplace = $linha_consulta_hiper_vendas_p2_marketplace['hiper'];
    }
    isset($hiper_total_hiper_venda_p2_marketplace) ? define($nome_var_hiper_p2_marketplace, $hiper_total_hiper_venda_p2_marketplace) : define($nome_var_hiper_p2_marketplace, 0);
    /* selecionar */

    /* Hiper Loja Parcial */
    $sql_hiper_parcial_vendas_p2_marketplace = "SELECT * FROM `metas_diarias` WHERE dt_meta = '".$data_p2."' AND cd_empresa = 1";
    $conexao_hiper_parcial_marketplace = $conn ->prepare($sql_hiper_parcial_vendas_p2_marketplace);
    $conexao_hiper_parcial_marketplace ->execute();
    $nome_var_hiper_parcial_p2_marketplace = "HIPER_PARCIAL_VENDAS_P2_MARKETPLACE";
    foreach($conexao_hiper_parcial_marketplace AS $linha_consulta_hiper_parcial_vendas_p2_marketplace){
        $hiper_total_hiper_parcial_venda_p2_marketplace = $linha_consulta_hiper_parcial_vendas_p2_marketplace['hiper'] * $porcento_hiper_parcial;
    }
    isset($hiper_total_hiper_parcial_venda_p2_marketplace) ? define($nome_var_hiper_parcial_p2_marketplace, $hiper_total_hiper_parcial_venda_p2_marketplace) : define($nome_var_hiper_parcial_p2_marketplace, 0);
    /* selecionar */

    /*************************** ATENDIMENTOS ***************************/
    /* Início atendimentos período 1 */
    $sql_atendimentos_marketplace_p1 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('9020','8020')";
    $atendimentos_marketplace_p1 = $conn->query($sql_atendimentos_marketplace_p1)->fetchColumn();
    define('P1_ATENDIMENTO_MARKETPLACE', $atendimentos_marketplace_p1);
    /* Fim atendimentos período 1 */

    /* Início atendimentos período 2 */
    $sql_atendimentos_marketplace_p2 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_operacao IN ('9020','8020')";
    $atendimentos_marketplace_p2 = $conn->query($sql_atendimentos_marketplace_p2)->fetchColumn();
    define('P2_ATENDIMENTO_MARKETPLACE', $atendimentos_marketplace_p2);
    /* Fim atendimentos período 2 */

    /* Crescimento atendimento */
    $var_crescimento_atendimentos_marketplace = "CRESCIMENTO_ATENDIMENTO_MARKETPLACE";
    $var_cor_crescimento_atendimentos_marketplace = "COR_CRESCIMENTO_ATENDIMENTO_MARKETPLACE";
    if($atendimentos_marketplace_p1 != 0 && $atendimentos_marketplace_p1 != NULL){
        $crescimento_atendimentos_marketplace = (((($atendimentos_marketplace_p2 / $atendimentos_marketplace_p1)*100)-100));
    }else{
        $crescimento_atendimentos_marketplace = 0;
    }
    if ($crescimento_atendimentos_marketplace <= 0) {
        define($var_cor_crescimento_atendimentos_marketplace,'color: #f00;');
    }else{
        define($var_cor_crescimento_atendimentos_marketplace, '');
    }
    define($var_crescimento_atendimentos_marketplace, $crescimento_atendimentos_marketplace);
    /* Fim crescimento atendimento */

    /*************************** TKM ***************************/
    /* TKM período 1*/
    $tkm_var_p1_marketplace = "P1_TKM_MARKETPLACE"; //Cria nome da variável
    if($atendimentos_marketplace_p1 != 0 && $atendimentos_marketplace_p1 != NULL){
        $tkm_p1_marketplace = ($vl_total_venda_p1_marketplace/$atendimentos_marketplace_p1);
    }else{
        $tkm_p1_marketplace = 0;
    }
    define($tkm_var_p1_marketplace, $tkm_p1_marketplace);
    /* Fim TKM período 1*/

    /* TKM período 2*/
    $tkm_var_p2_marketplace = "P2_TKM_MARKETPLACE"; //Cria nome da variável
    if($atendimentos_marketplace_p2 != 0 && $atendimentos_marketplace_p2 != NULL){
        $tkm_p2_marketplace = ($vl_total_venda_p2_marketplace/$atendimentos_marketplace_p2);
    }else{
        $tkm_p2_marketplace = 0;
    }
    define($tkm_var_p2_marketplace, $tkm_p2_marketplace);

    /* Crescimento TKM  */
    if($tkm_p1_marketplace != 0 && $tkm_p1_marketplace != NULL){
        $crescimento_tkm_marketplace = (($tkm_p2_marketplace / $tkm_p1_marketplace)*100)-100;
    }else{
        $crescimento_tkm_marketplace = 0;
    }
    if ($crescimento_tkm_marketplace <= 0) {
        define('COR_CRESCIMENTO_TKM_MARKETPLACE','color: #f00;');
    }else{
        define('COR_CRESCIMENTO_TKM_MARKETPLACE', '');
    }
    define('CRESCIMENTO_TKM_MARKETPLACE', $crescimento_tkm_marketplace);
    /* Fim crescimento TKM  */

    /* Hiper Loja tkm */
    $sql_hiper_tkm_p2_marketplace = "SELECT * FROM `metas_tkm` WHERE cd_empresa = 1";
    $conexao_tkm_marketplace = $conn ->prepare($sql_hiper_tkm_p2_marketplace);
    $conexao_tkm_marketplace ->execute();
    /* Criar as variáveis para a hiper e cor do tkm */
    $nome_var_tkm_p2_marketplace = "HIPER_TKM_P2_MARKETPLACE";
    $nome_var_cor_p2_marketplace = "COR_TKM_MARKETPLACE";
    foreach($conexao_tkm_marketplace AS $linha_consulta_hiper_tkm_p2_marketplace){
        $vl_total_tkm_p2_marketplace = $linha_consulta_hiper_tkm_p2_marketplace['hiper'];
        if($tkm_p2_marketplace > $linha_consulta_hiper_tkm_p2_marketplace['hiper']){
            define($nome_var_cor_p2_marketplace,'background-color:#00b0f0;');//azul
        }elseif($tkm_p2_marketplace < $linha_consulta_hiper_tkm_p2_marketplace['hiper'] && $tkm_p2_marketplace > $linha_consulta_hiper_tkm_p2_marketplace['super']) {
            define($nome_var_cor_p2_marketplace,'background-color:#00ff00;');//verde claro brilhante
        }elseif($tkm_p2_marketplace < $linha_consulta_hiper_tkm_p2_marketplace['super'] && $tkm_p2_marketplace > $linha_consulta_hiper_tkm_p2_marketplace['meta']){
            define($nome_var_cor_p2_marketplace,'background-color:#28a745;');//verde musgo
        }else{
            define($nome_var_cor_p2_marketplace,'background-color:#ff0000;color: #fff;');//vermelho claro brilhante
        }
    }
    isset($vl_total_tkm_p2_marketplace)? define($nome_var_tkm_p2_marketplace, $vl_total_tkm_p2_marketplace) : define($nome_var_tkm_p2_marketplace, 0);
    /* selecionar */
    /*************************** FIM SOMA VENDAS Marketplace ***************************/

    /**************************************************************************************************************************************/
    /**************************************************************************************************************************************/
    /******************************************************** Resultados Regional ********************************************************/
    /**************************************************************************************************************************************/
    /**************************************************************************************************************************************/


    /*************************** Venda de todas as loja *****************************/
    /* Filtrar porcentagem para as parciais */
    $sqlLojas = "SELECT * FROM `db_nome_empresa` WHERE cd_loja = 3";
    $conexaoLoja = $conn -> prepare($sqlLojas);
    $conexaoLoja -> execute();
    /******** Início definição dos valores por empresa ********/
    foreach($conexaoLoja AS $linha_consulta_loja){
        /* Loja selecionada */
        $hora_trabalhada_loja = gmdate('H.i', strtotime($linha_consulta_loja['hora_fim']) - strtotime($linha_consulta_loja['hora_inicio']));
        $tempo_decorrido = gmdate('H.i', strtotime( $hora_fim ) - strtotime( $linha_consulta_loja['hora_inicio']));
        $porcento_hiper_parcial_regional1 = $tempo_decorrido / $hora_trabalhada_loja;
        if($porcento_hiper_parcial_regional1 > 1){
            $porcento_hiper_parcial_regional1 = 1;
        }
        isset($porcento_hiper_parcial_regional1) ? ($porcento_hiper_parcial_regional1 = $porcento_hiper_parcial_regional1) : $porcento_hiper_parcial_regional1 = 0;
    }
    /* Período 1 */
    $vendas_total_regional_p1_r1 = P1_VENDA_ECOMMERCE + P1_VENDA_DELIVERY + P1_VENDA_MARKETPLACE + P1_VENDA_LOJA2 + P1_VENDA_LOJA4 + P1_VENDA_LOJA5 + P1_VENDA_LOJA6 + P1_VENDA_LOJA7;
    define('P1_VENDAS_REGIONAL1',$vendas_total_regional_p1_r1);
    /* Período 2 */
    $vendas_total_regional_p2_r1 = P2_VENDA_ECOMMERCE + P2_VENDA_DELIVERY + P2_VENDA_MARKETPLACE + P2_VENDA_LOJA2 + P2_VENDA_LOJA4 + P2_VENDA_LOJA5 + P2_VENDA_LOJA6 + P2_VENDA_LOJA7;
    define('P2_VENDAS_REGIONAL1',$vendas_total_regional_p2_r1);

    /* Crescimento Vendas regional1 dia */
    if(isset($vendas_total_regional_p2_r1) && $vendas_total_regional_p1_r1 != 0 && $vendas_total_regional_p1_r1 != NULL){
        $crescimento_venda_r1 = (($vendas_total_regional_p2_r1 / $vendas_total_regional_p1_r1)*100) - 100;
    }else{
        $crescimento_venda_r1 = 0;
    }
    if ($crescimento_venda_r1 <= 0) {
        define('COR_CRESCIMENTO_REGIONAL1','color: #f00;');
    }else{
        define('COR_CRESCIMENTO_REGIONAL1', '');
    }
    define('CRESCIMENTO_REGIONAL1', $crescimento_venda_r1);
    /* Fim crescimento Vendas Loja  */

    /* Hiper todas as lojas */
    $vl_total_hiper_venda_p2_r1 = HIPER_VENDAS_P2_LOJA1 + HIPER_VENDAS_P2_LOJA2 + HIPER_VENDAS_P2_LOJA4 + HIPER_VENDAS_P2_LOJA5 + HIPER_VENDAS_P2_LOJA6 + HIPER_VENDAS_P2_LOJA7;
    define('HIPER_VENDAS_P2_REGIONAL1', $vl_total_hiper_venda_p2_r1);
    /* selecionar */

    /* Hiper Loja Parcial */
    $nome_var_hiper_parcial_p2_regional1 = "HIPER_PARCIAL_VENDAS_P2_REGIONAL1";
    $hiper_total_hiper_parcial_venda_p2_regional1 = HIPER_VENDAS_P2_REGIONAL1 * $porcento_hiper_parcial_regional1;
    isset($hiper_total_hiper_parcial_venda_p2_regional1) ? define($nome_var_hiper_parcial_p2_regional1, $hiper_total_hiper_parcial_venda_p2_regional1) : define($nome_var_hiper_parcial_p2_regional1, 0);
    /* selecionar */
    /*************************************************** Atendimentos todas as lojas ***************************************************/
    /* Venda de todas as lojas */
    /* Período 1 */
    $atendimentos_total_p1_r1 = P1_ATENDIMENTO_DELIVERY + P1_ATENDIMENTO_ECOMMERCE + P1_ATENDIMENTO_MARKETPLACE + P1_ATENDIMENTO_LOJA2 + P1_ATENDIMENTO_LOJA4 + P1_ATENDIMENTO_LOJA5 + P1_ATENDIMENTO_LOJA6 + P1_ATENDIMENTO_LOJA7;
    define('P1_ATENDIMENTO_REGIONAL1',$atendimentos_total_p1_r1);
    /* Período 2 */
    $atendimentos_total_p2_r1 = P2_ATENDIMENTO_DELIVERY + P2_ATENDIMENTO_ECOMMERCE + P2_ATENDIMENTO_MARKETPLACE + P2_ATENDIMENTO_LOJA2 + P2_ATENDIMENTO_LOJA4 + P2_ATENDIMENTO_LOJA5 + P2_ATENDIMENTO_LOJA6 + P2_ATENDIMENTO_LOJA7;
    define('P2_ATENDIMENTO_REGIONAL1',$atendimentos_total_p2_r1);

    /* Crescimento atendimentos regional1 dia */
    if(isset($atendimentos_total_p2_r1) && $atendimentos_total_p1_r1 != 0 && $atendimentos_total_p1_r1 != NULL){
        $crescimento_atendimentos_r1 = (($atendimentos_total_p2_r1 / $atendimentos_total_p1_r1)*100) - 100;
    }else{
        $crescimento_atendimentos_r1 = 0;
    }
    if($crescimento_atendimentos_r1 <= 0){
        define('COR_CRESCIMENTO_ATENDIMENTO_REGIONAL1','color: #f00');
    }else{
        define('COR_CRESCIMENTO_ATENDIMENTO_REGIONAL1','');
    }
    define('CRESCIMENTO_ATENDIMENTO_REGIONAL1', $crescimento_atendimentos_r1);
    /* Fim crescimento atendimentos r1 */
    /**************************************************** Tkm todas as lojas ****************************************************/
    /* Tkm todas as lojas */
    /* Período 1 */
    if((P1_VENDAS_REGIONAL1 != 0 && P1_ATENDIMENTO_REGIONAL1 != 0) || (P1_VENDAS_REGIONAL1 != NULL && P1_ATENDIMENTO_REGIONAL1 != NULL)){
        $tkm_total_regional_p1_r1 = P1_VENDAS_REGIONAL1/P1_ATENDIMENTO_REGIONAL1;
    }else {
        $tkm_total_regional_p1_r1 = 0;
    }
    define('P1_TKM_REGIONAL1',$tkm_total_regional_p1_r1);
    /* Período 2 */
    if((P2_VENDAS_REGIONAL1 != 0 && P2_ATENDIMENTO_REGIONAL1 != 0) || (P2_VENDAS_REGIONAL1 != NULL && P2_ATENDIMENTO_REGIONAL1 != NULL)){
        $tkm_total_regional_p2_r1 = P2_VENDAS_REGIONAL1/P2_ATENDIMENTO_REGIONAL1;
    }else {
        $tkm_total_regional_p2_r1 = 0;
    }
    define('P2_TKM_REGIONAL1',$tkm_total_regional_p2_r1);

    /* Crescimento tkm regional1 */
    if($tkm_total_regional_p1_r1 != 0 && $tkm_total_regional_p1_r1 != NULL){
        $crescimento_venda_r1 = (($tkm_total_regional_p2_r1 / $tkm_total_regional_p1_r1)*100) - 100;
    }else{
        $crescimento_venda_r1 = 0;
    }
    if($crescimento_venda_r1 <= 0){
        define('COR_CRESCIMENTO_TKM_REGIONAL1', 'color: #f00;');
    }else{
        define('COR_CRESCIMENTO_TKM_REGIONAL1', '');
    }
    define('CRESCIMENTO_TKM_REGIONAL1', $crescimento_venda_r1);
    /* Fim crescimento tkm  */

    /* Hiper Loja tkm */
    $sql_hiper_tkm_p2_regional1 = "SELECT * FROM `metas_tkm` WHERE cd_empresa = 0";
    $conexao_tkm_regional1 = $conn ->prepare($sql_hiper_tkm_p2_regional1);
    $conexao_tkm_regional1 ->execute();
    /* Criar as variáveis para a hiper e cor do tkm */
    $nome_var_tkm_p2_regional1 = "HIPER_TKM_P2_REGIONAL1";
    $nome_var_cor_p2_regional1 = "COR_TKM_REGIONAL1";
    foreach($conexao_tkm_regional1 AS $linha_consulta_hiper_tkm_p2_regional1){
        $vl_total_tkm_p2_regional1 = $linha_consulta_hiper_tkm_p2_regional1['hiper'];
        define($nome_var_tkm_p2_regional1, $linha_consulta_hiper_tkm_p2_regional1['hiper']);
        if($tkm_total_regional_p2_r1 > $linha_consulta_hiper_tkm_p2_regional1['hiper']){
            define($nome_var_cor_p2_regional1,'background-color:#00b0f0');//azul
        }elseif($tkm_total_regional_p2_r1 < $linha_consulta_hiper_tkm_p2_regional1['hiper'] && $tkm_total_regional_p2_r1 > $linha_consulta_hiper_tkm_p2_regional1['super']) {
            define($nome_var_cor_p2_regional1,'background-color:#00ff00');//verde claro brilhante
        }elseif($tkm_total_regional_p2_r1 < $linha_consulta_hiper_tkm_p2_regional1['super'] && $tkm_total_regional_p2_r1 > $linha_consulta_hiper_tkm_p2_regional1['meta']){
            define($nome_var_cor_p2_regional1,'background-color:#28a745;color: #fff;');//verde musgo
        }else{
            define($nome_var_cor_p2_regional1,'background-color:#ff0000;color: #fff;');//vermelho claro brilhante
        }
    }
    /* selecionar */

    /*************************** Fluxo de Clientes ***************************/
    /* Início fluxo de clientes período 1 */
    /* Período 1 */
    $fluxo_de_clientes_total_regional_p1_r1 = P1_FLUXO_DE_CLIENTES_LOJA2 + P1_FLUXO_DE_CLIENTES_LOJA4 + P1_FLUXO_DE_CLIENTES_LOJA5 + P1_FLUXO_DE_CLIENTES_LOJA6 + P1_FLUXO_DE_CLIENTES_LOJA7;
    define('P1_FLUXO_DE_CLIENTES_REGIONAL1',$fluxo_de_clientes_total_regional_p1_r1);
    /* Fim fluxo de clientes período 1 */

    /* Início fluxo de clientes período 2 */
    $fluxo_de_clientes_total_regional_p2_r1 =  P2_FLUXO_DE_CLIENTES_LOJA2 + P2_FLUXO_DE_CLIENTES_LOJA4 + P2_FLUXO_DE_CLIENTES_LOJA5 + P2_FLUXO_DE_CLIENTES_LOJA6 + P2_FLUXO_DE_CLIENTES_LOJA7;
    define('P2_FLUXO_DE_CLIENTES_REGIONAL1',$fluxo_de_clientes_total_regional_p2_r1);
    /* Fim fluxo de clientes período 2 */

    /* Crescimento atendimento */
    if($fluxo_de_clientes_total_regional_p1_r1 != 0 && $fluxo_de_clientes_total_regional_p1_r1 != NULL){
        $crescimento_fluxo_de_clientes_r1 = (($fluxo_de_clientes_total_regional_p2_r1 / $fluxo_de_clientes_total_regional_p1_r1)*100) - 100;
    }else{
        $crescimento_fluxo_de_clientes_r1 = 0;
    }
    if ($crescimento_fluxo_de_clientes_r1 <= 0) {
        define('COR_CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL1','color: #f00');
    } else {
        define('COR_CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL1','');
    }
    define('CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL1', $crescimento_fluxo_de_clientes_r1);
    /* Fim crescimento fluxo de clientes */
    
    /*************************** TAXA DE CONVERSÃO Todas as lojas ***************************/
    /* Taxa de conversão p1*/
    if(isset($atendimentos_total_p1_r1) && $fluxo_de_clientes_total_regional_p1_r1 != 0 && $fluxo_de_clientes_total_regional_p1_r1 != NULL){
        $taxa_de_conversao_p1_r1 = ($atendimentos_total_p1_r1/$fluxo_de_clientes_total_regional_p1_r1)*100;
    }else{
        $taxa_de_conversao_p1_r1 = 0;
    }
    define('P1_TAXA_DE_CONVERSAO_REGIONAL1', $taxa_de_conversao_p1_r1);
    /* Fim Taxa de conversão p1 */
    
    /* Taxa de conversão p2*/
    if(isset($atendimentos_total_p2_r1) && $fluxo_de_clientes_total_regional_p2_r1 != 0 && $fluxo_de_clientes_total_regional_p2_r1 != NULL){
        $taxa_de_conversao_p2_r1 = ($atendimentos_total_p2_r1/$fluxo_de_clientes_total_regional_p2_r1)*100;
    }else{
        $taxa_de_conversao_p2_r1 = 0;
    }
    define('P2_TAXA_DE_CONVERSAO_REGIONAL1', $taxa_de_conversao_p2_r1);
    /* Fim Taxa de conversão p1 */


    /* Crescimento Taxa de conversão */
    $var_crescimento_taxa_de_conversao_r1 = "CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL1";
    $var_cor_crescimento_taxa_de_conversao_r1 = "COR_CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL1";
    if($taxa_de_conversao_p1_r1 != 0 && $taxa_de_conversao_p1_r1 != NULL){
        $crescimento_taxa_de_conversao_r1 = ((($taxa_de_conversao_p2_r1/$taxa_de_conversao_p1_r1)*100)-100);
    }else{
        $crescimento_taxa_de_conversao_r1 = 0;
    }
    if ($crescimento_taxa_de_conversao_r1 <= 0) {
        define($var_cor_crescimento_taxa_de_conversao_r1,'color: #f00');
    }else {
        define($var_cor_crescimento_taxa_de_conversao_r1,'');
    }
    define($var_crescimento_taxa_de_conversao_r1, $crescimento_taxa_de_conversao_r1);
    /* Fim crescimento Taxa de conversão  */

    /*************************** QUANTIDADE PRODUTOS ***************************/
    /* Quantidade de produtos p1 */
    $sql_qt_produtos_p1_r1 = "SELECT SUM(qt_venda) AS 'qt_venda' FROM `db_venda` WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim ."' AND cd_produto <> 999 and cd_empresa != 1";
    $conexaoProdutos_regional1 = $conn -> prepare($sql_qt_produtos_p1_r1);
    $conexaoProdutos_regional1 -> execute();
    $nome_var_produtos_regional1 = "P1_QT_PRODUTOS_REGIONAL1";
    foreach($conexaoProdutos_regional1 AS $linha_consulta_qt_produtos_regional1){
        $produtos_p1_r1 = $linha_consulta_qt_produtos_regional1['qt_venda'];
    }
    isset($produtos_p1_r1) ? define($nome_var_produtos_regional1, $produtos_p1_r1) : define($nome_var_produtos_regional1, 0);
    /* Fim quantidade produtos p1 */

    /* Quantidade de produtos p2 */
    $sql_qt_produtos_p2_r1 = "SELECT SUM(qt_venda) AS 'qt_venda' FROM `db_venda` WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_empresa != 1";
    $conexaoProdutos_regional1 = $conn -> prepare($sql_qt_produtos_p2_r1);
    $conexaoProdutos_regional1 -> execute();
    foreach($conexaoProdutos_regional1 AS $linha_consulta_qt_produtos_regional1){
        $nome_var_produtos_regional1 = "P2_QT_PRODUTOS_REGIONAL1";
        $produtos_p2_r1  = $linha_consulta_qt_produtos_regional1['qt_venda'];
    }
    isset($produtos_p2_r1) ? define($nome_var_produtos_regional1, $produtos_p2_r1) : define($nome_var_produtos_regional1, 0);
    /* Fim quantidade produtos p2 */

    /* Crescimento de qt produtos */
    $var_produtos_r1 = "CRESCIMENTO_PRODUTOS_REGIONAL1";
    if($produtos_p1_r1 != 0 && $produtos_p1_r1 != NULL){
        $crescimento_produtos_regional_r1 = ((($produtos_p2_r1/$produtos_p1_r1)*100)-100);
    }else{
        $crescimento_produtos_regional_r1 = 0;
    }
    define($var_produtos_r1, $crescimento_produtos_regional_r1);
    /* Fim crescimento de qt produtos */


    /*************************** ITENS POR VENDA ***************************/
    /* Itens por venda p1*/
    $itens_por_venda_p1_var_regional1 = "P1_ITENS_POR_VENDA_REGIONAL1"; //Cria nome da variável
    if($atendimentos_total_p1_r1 != 0 && $atendimentos_total_p1_r1 != NULL){
        $itens_por_venda_p1_regional1 = ($produtos_p1_r1/$atendimentos_total_p1_r1);
    }else{
        $itens_por_venda_p1_regional1 = 0;
    }
    define($itens_por_venda_p1_var_regional1, $itens_por_venda_p1_regional1);
    /* Fim Itens por venda  p1 */

    /* Itens por venda p2*/
    $itens_por_venda_p2_var_regional1 = "P2_ITENS_POR_VENDA_REGIONAL1"; //Cria nome da variável
    if($atendimentos_total_p2_r1 != 0 && $atendimentos_total_p2_r1 != NULL){
        $itens_por_venda_p2_regional1 = ($produtos_p2_r1/$atendimentos_total_p2_r1);
    }else{
        $itens_por_venda_p2_regional1 = 0;
    }
    define($itens_por_venda_p2_var_regional1, $itens_por_venda_p2_regional1);
    /* Fim Itens por venda  p2 */


    /* Crescimento itens por venda */
    $var_crescimento_itens_por_venda_regional1 = "CRESCIMENTO_ITENS_POR_VENDA_REGIONAL1";
    $var_cor_crescimento_itens_por_venda_regional1 = "COR_CRESCIMENTO_ITENS_POR_VENDA_REGIONAL1";
    if($itens_por_venda_p1_regional1 != 0 && $itens_por_venda_p1_regional1 != NULL){
        $crescimento_itens_por_venda_regional1 = ((($itens_por_venda_p2_regional1 / $itens_por_venda_p1_regional1)*100)-100);
    }else{
        $crescimento_itens_por_venda_regional1 = 0;
    }
    if ($crescimento_itens_por_venda_regional1 <= 0) {
        define($var_cor_crescimento_itens_por_venda_regional1, 'color: #f00');
    }else {
        define($var_cor_crescimento_itens_por_venda_regional1, 0);
    }
    define($var_crescimento_itens_por_venda_regional1, $crescimento_itens_por_venda_regional1);
    /* Fim crescimento itens por venda */


    /*************************** PREÇO MÉDIO PRODUTOS ***************************/
    /* Preço médio produtos p1*/
    $preco_medio_produtos_p1_var_regional1 = "P1_PRECO_MEDIO_PRODUTOS_REGIONAL1"; //Cria nome da variável
    if($produtos_p1_r1 != 0 && $produtos_p1_r1 != NULL){
        $preco_medio_produtos_p1_r1 = ($vendas_total_regional_p1_r1/$produtos_p1_r1);
    }else{
        $preco_medio_produtos_p1_r1 = 0;
    }
    define($preco_medio_produtos_p1_var_regional1, $preco_medio_produtos_p1_r1);
    /* Fim preço médio produtos p1 */

    /* Preço médio produtos p2*/
    $preco_medio_produtos_p2_var_regional1 = "P2_PRECO_MEDIO_PRODUTOS_REGIONAL1"; //Cria nome da variável
    if($produtos_p2_r1 != 0 && $produtos_p2_r1 != NULL){
        $preco_medio_produtos_p2_r1 = ($vendas_total_regional_p2_r1/$produtos_p2_r1);
    }else{
        $preco_medio_produtos_p2_r1 = 0;
    }
    define($preco_medio_produtos_p2_var_regional1, $preco_medio_produtos_p2_r1);
    /* Fim preço médio produtos p2 */

    /* Crescimento preço médio produtos */
    $var_crescimento_preco_medio_produtos_regional1 = "CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL1";
    $var_cor_crescimento_preco_medio_produtos_regional1 = "COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL1";
    if($preco_medio_produtos_p1_r1 != 0 && $preco_medio_produtos_p1_r1 != NULL){
        $crescimento_preco_medio_produtos_regional1 = ((($preco_medio_produtos_p2_r1 / $preco_medio_produtos_p1_r1)*100)-100);
    }else{
        $crescimento_preco_medio_produtos_regional1 = 0;
    }
    if($crescimento_preco_medio_produtos_regional1 <= 0){
        define($var_cor_crescimento_preco_medio_produtos_regional1,'color: #f00;');
    }else{
        define($var_cor_crescimento_preco_medio_produtos_regional1,'');
    }
    define($var_crescimento_preco_medio_produtos_regional1, $crescimento_preco_medio_produtos_regional1);
    /* Fim crescimento preço médio produtos  */

    /*************************** MARGEM ***************************/
    /* Margem p1 */
    $sql_margem_p1_regional1 = "SELECT * FROM `base_margem` WHERE dt_base = '".$data_p1."' and cd_empresa = 0";
    $conexaoMargem_regional1 = $conn -> prepare($sql_margem_p1_regional1);
    $conexaoMargem_regional1 -> execute();
    $nome_var_margem_regional1 = "P1_MARGEM_REGIONAL1";
    foreach($conexaoMargem_regional1 AS $linha_consulta_loja_regional1){
        $margem_p1_regional1 = $linha_consulta_loja_regional1['contribuicao_marginal'];
    }
    isset($margem_p1_regional1) ? define($nome_var_margem_regional1,$margem_p1_regional1) : define($nome_var_margem_regional1,0);
    /* Fim margem p1 */
    
    /* Margem p2 */
    $sql_margem_p2_regional1 = "SELECT * FROM `base_margem` WHERE dt_base = '".$data_p2."' and cd_empresa = 0";
    $conexaoMargem_regional1 = $conn -> prepare($sql_margem_p2_regional1);
    $conexaoMargem_regional1 -> execute();
    $nome_var_margem_regional1 = "P2_MARGEM_REGIONAL1";
    foreach($conexaoMargem_regional1 AS $linha_consulta_loja_regional1){
        $margem_p2_regional1 = $linha_consulta_loja_regional1['contribuicao_marginal'];
    }
    isset($margem_p2_regional1) ? define($nome_var_margem_regional1,$margem_p2_regional1) : define($nome_var_margem_regional1,0);
    /* Fim margem p2 */


    /* Crescimento margem */
    if(isset($margem_p1_regional1) && isset($margem_p2_regional1) && $margem_p2_regional1 != 0 && $margem_p2_regional1 != NULL){
        $crescimento_margem_regional1 = $margem_p2_regional1-$margem_p1_regional1;
    }else{
        $crescimento_margem_regional1 = 0;
    }
    if($crescimento_margem_regional1 <= 0){
        define('COR_CRESCIMENTO_MARGEM_REGIONAL1','color:#f00');
    }else {
        define('COR_CRESCIMENTO_MARGEM_REGIONAL1','');
    }
    define('CRESCIMENTO_MARGEM_REGIONAL1', $crescimento_margem_regional1);
    /* Fim Crescimento margem */

    /* Hiper margem */
    $sql_hiper_margem_p2_regional1 = "SELECT * FROM `metas_margem` WHERE cd_empresa = 0";
    $conexaoMargem_r1 = $conn ->prepare($sql_hiper_margem_p2_regional1);
    $conexaoMargem_r1 ->execute();
    $nome_var_margem_p2_regional1 = "HIPER_MARGEM_P2_REGIONAL1";
    $nome_var_margem_cor_p2_regional1 = "COR_MARGEM_REGIONAL1";
    foreach($conexaoMargem_r1 AS $linha_consulta_hiper_margem_p2_regional1){
        $vl_total_margem_p2_regional1 = $linha_consulta_hiper_margem_p2_regional1['hiper'];
        if(!isset($margem_p2_regional1) || $linha_consulta_hiper_margem_p2_regional1['hiper'] == NULL){
            define($nome_var_margem_p2_regional1, 0);
            define($nome_var_margem_cor_p2_regional1,'background-color:#ff0000;color: #fff;');
        }else{
            define($nome_var_margem_p2_regional1, $vl_total_margem_p2_regional1);
            if($margem_p2_regional1 >= $linha_consulta_hiper_margem_p2_regional1['hiper']){
                define($nome_var_margem_cor_p2_regional1,'background-color:#00b0f0');
            }elseif($margem_p2_regional1 >= $linha_consulta_hiper_margem_p2_regional1['super'] && $margem_p2_regional1 < $linha_consulta_hiper_margem_p2_regional1['hiper']) {
                define($nome_var_margem_cor_p2_regional1,'background-color:#00ff00');
            }elseif($margem_p2_regional1 >= $linha_consulta_hiper_margem_p2_regional1['meta'] && $margem_p2_regional1 < $linha_consulta_hiper_margem_p2_regional1['super']){
                define($nome_var_margem_cor_p2_regional1,'background-color:#28a745');
            }else{
                define($nome_var_margem_cor_p2_regional1,'background-color:#ff0000;color: #fff;');
            }
        }
    }
        /* fim hiper margem */


    /************************************************* ****************************** ***************************************************/
    /************************************************* Venda de lojas físicas ***************************************************/
    /* Filtrar porcentagem para as parciais */
    $sqlLojas = "SELECT * FROM `db_nome_empresa` WHERE cd_loja = 3";
    $conexaoLoja = $conn -> prepare($sqlLojas);
    $conexaoLoja -> execute();
    /******** Início definição dos valores por empresa ********/
    foreach($conexaoLoja AS $linha_consulta_loja){
        /* Loja selecionada */
        $hora_trabalhada_loja = gmdate('H.i', strtotime($linha_consulta_loja['hora_fim']) - strtotime($linha_consulta_loja['hora_inicio']));
        $tempo_decorrido = gmdate('H.i', strtotime( $hora_fim ) - strtotime( $linha_consulta_loja['hora_inicio']));
        $porcento_hiper_parcial_regional2 = $tempo_decorrido / $hora_trabalhada_loja;
        if($porcento_hiper_parcial_regional2 > 1){
            $porcento_hiper_parcial_regional2 = 1;
        }
        isset($porcento_hiper_parcial_regional2) ? $porcento_hiper_parcial_regional2 = $porcento_hiper_parcial_regional2 : $porcento_hiper_parcial_regional2 = 0;
    }
    /* Período 1 */
    $vendas_total_regional_p1_r2 = P1_VENDA_LOJA2 + P1_VENDA_LOJA4 + P1_VENDA_LOJA5 + P1_VENDA_LOJA6;
    define('P1_VENDAS_REGIONAL2',$vendas_total_regional_p1_r2);
    /* Período 2 */
    $vendas_total_regional_p2_r2 = P2_VENDA_LOJA2 + P2_VENDA_LOJA4 + P2_VENDA_LOJA5 + P2_VENDA_LOJA6;
    define('P2_VENDAS_REGIONAL2',$vendas_total_regional_p2_r2);

    /* Crescimento Vendas regional1 dia */
    if(isset($vendas_total_regional_p2_r2) && $vendas_total_regional_p1_r2 != 0 && $vendas_total_regional_p1_r2 != NULL){
        $crescimento_venda_r2 = (($vendas_total_regional_p2_r2 / $vendas_total_regional_p1_r2)*100) - 100;
    }else{
        $crescimento_venda_r2 = 0;
    }
    if ($crescimento_venda_r2 <= 0) {
        define('COR_CRESCIMENTO_REGIONAL2','color: #f00;');
    }else{
        define('COR_CRESCIMENTO_REGIONAL2', '');
    }
    define('CRESCIMENTO_REGIONAL2', $crescimento_venda_r2);
    /* Fim crescimento Vendas Loja  */


    /* Hiper Lojas físicas*/
    $vl_total_hiper_venda_p2 = HIPER_VENDAS_P2_LOJA2 + HIPER_VENDAS_P2_LOJA4 + HIPER_VENDAS_P2_LOJA5 + HIPER_VENDAS_P2_LOJA6;
    define('HIPER_VENDAS_P2_REGIONAL2', $vl_total_hiper_venda_p2);
    /* selecionar */

    /* Hiper Loja Parcial */
    $nome_var_hiper_parcial_p2_regional2 = "HIPER_PARCIAL_VENDAS_P2_REGIONAL2";
    $hiper_total_hiper_parcial_venda_p2_regional2 = HIPER_VENDAS_P2_REGIONAL2 * $porcento_hiper_parcial_regional2;
    isset($hiper_total_hiper_parcial_venda_p2_regional2) ? define($nome_var_hiper_parcial_p2_regional2, $hiper_total_hiper_parcial_venda_p2_regional2) : define($nome_var_hiper_parcial_p2_regional2, 0);
    /* selecionar */

    /* Atendimentos lojas físicas */
    /* Período 1 */
    $atendimentos_total_p1_r2 = P1_ATENDIMENTO_LOJA2 + P1_ATENDIMENTO_LOJA4 + P1_ATENDIMENTO_LOJA5 + P1_ATENDIMENTO_LOJA6;
    define('P1_ATENDIMENTO_REGIONAL2',$atendimentos_total_p1_r2);
    /* Período 2 */
    $atendimentos_total_p2_r2 = P2_ATENDIMENTO_LOJA2 + P2_ATENDIMENTO_LOJA4 + P2_ATENDIMENTO_LOJA5 + P2_ATENDIMENTO_LOJA6;
    define('P2_ATENDIMENTO_REGIONAL2',$atendimentos_total_p2_r2);

    /* Crescimento atendimentos regional2 */
    if($atendimentos_total_p1_r2 != 0 && $atendimentos_total_p1_r2 != NULL){
        $crescimento_atendimentos_r2 = (($atendimentos_total_p2_r2 / $atendimentos_total_p1_r2)*100) - 100;
    }else{
        $crescimento_atendimentos_r2 = 0;
    }
    if ($crescimento_atendimentos_r2 <= 0) {
        define('COR_CRESCIMENTO_ATENDIMENTO_REGIONAL2','color: #f00;');
    }else{
        define('COR_CRESCIMENTO_ATENDIMENTO_REGIONAL2', '');
    }
    define('CRESCIMENTO_ATENDIMENTO_REGIONAL2', $crescimento_atendimentos_r2);
    /* Fim crescimento atendimentos r1 */
    /******* Fim atendimentos lojas físicas *******/
    /* Venda de lojas físicas */
    if((P1_VENDAS_REGIONAL2!= 0 && P1_ATENDIMENTO_REGIONAL2 != 0) || (P1_VENDAS_REGIONAL2 != NULL && P1_ATENDIMENTO_REGIONAL2 != NULL)){
        $tkm_total_regional_p1_r2 = P1_VENDAS_REGIONAL2/P1_ATENDIMENTO_REGIONAL2;
    }else {
        $tkm_total_regional_p1_r2 = 0;
    }
    define('P1_TKM_REGIONAL2',$tkm_total_regional_p1_r2);
    /* Período 2 */
    if((P2_VENDAS_REGIONAL2 != 0 && P2_ATENDIMENTO_REGIONAL2 != 0) || (P2_VENDAS_REGIONAL2 != NULL && P2_ATENDIMENTO_REGIONAL2 != NULL)){
        $tkm_total_regional_p2_r2 = P2_VENDAS_REGIONAL2/P2_ATENDIMENTO_REGIONAL2;
        define('P2_TKM_REGIONAL2',$tkm_total_regional_p2_r2);
    }else {
        $tkm_total_regional_p2_r2 = 0;
    }
    /* Crescimento Vendas regional1 dia */
    if(isset($tkm_total_regional_p2_r2) && $tkm_total_regional_p1_r2 != 0 && $tkm_total_regional_p1_r2 != NULL){
        $crescimento_venda_r2 = (($tkm_total_regional_p2_r2 / $tkm_total_regional_p1_r2)*100) - 100;
    }else{
        $crescimento_venda_r2 = 0;
    }
    if($crescimento_venda_r2 <= 0){
        define('COR_CRESCIMENTO_TKM_REGIONAL2', 'color: #f00;');
    }else{
        define('COR_CRESCIMENTO_TKM_REGIONAL2', '');
    }
    define('CRESCIMENTO_TKM_REGIONAL2', $crescimento_venda_r2);
    /* Fim crescimento Vendas Loja  */

    /* Hiper Loja tkm */
    $sql_hiper_tkm_p2_regional2 = "SELECT * FROM `metas_tkm` WHERE cd_empresa = 0";
    $conexao_tkm_regional2 = $conn ->prepare($sql_hiper_tkm_p2_regional2);
    $conexao_tkm_regional2 ->execute();
    /* Criar as variáveis para a hiper e cor do tkm */
    $nome_var_tkm_p2_regional2 = "HIPER_TKM_P2_REGIONAL2";
    $nome_var_cor_p2_regional2 = "COR_TKM_REGIONAL2";
    foreach($conexao_tkm_regional2 AS $linha_consulta_hiper_tkm_p2_regional2){
        $vl_total_tkm_p2_regional2 = $linha_consulta_hiper_tkm_p2_regional2['hiper'];
        define($nome_var_tkm_p2_regional2, $linha_consulta_hiper_tkm_p2_regional2['hiper']);
        if($tkm_total_regional_p2_r2 > $linha_consulta_hiper_tkm_p2_regional2['hiper']){
            define($nome_var_cor_p2_regional2,'background-color:#00b0f0');//azul
        }elseif($tkm_total_regional_p2_r2 < $linha_consulta_hiper_tkm_p2_regional2['hiper'] && $tkm_total_regional_p2_r2 > $linha_consulta_hiper_tkm_p2_regional2['super']) {
            define($nome_var_cor_p2_regional2,'background-color:#00ff00');//verde claro brilhante
        }elseif($tkm_total_regional_p2_r2 < $linha_consulta_hiper_tkm_p2_regional2['super'] && $tkm_total_regional_p2_r2 > $linha_consulta_hiper_tkm_p2_regional2['meta']){
            define($nome_var_cor_p2_regional2,'background-color:#28a745');//verde musgo
        }else{
            define($nome_var_cor_p2_regional2,'background-color:#ff0000;color: #fff;');//vermelho claro brilhante
        }
    }
    /* selecionar */

    /****** Fluxo de clientes ******/
    /* Lojas físicas */
    /* Período 1 */
    $fluxo_de_clientes_total_regional_p1_r2 = P1_FLUXO_DE_CLIENTES_LOJA2 + P1_FLUXO_DE_CLIENTES_LOJA4 + P1_FLUXO_DE_CLIENTES_LOJA5 + P1_FLUXO_DE_CLIENTES_LOJA6 + P1_FLUXO_DE_CLIENTES_LOJA7;
    define('P1_FLUXO_DE_CLIENTES_REGIONAL2',$fluxo_de_clientes_total_regional_p1_r2);
    /* Fim fluxo de clientes período 1 */

    /* Início fluxo de clientes período 2 */
    $fluxo_de_clientes_total_regional_p2_r2 = P2_FLUXO_DE_CLIENTES_LOJA2 + P2_FLUXO_DE_CLIENTES_LOJA4 + P2_FLUXO_DE_CLIENTES_LOJA5 + P2_FLUXO_DE_CLIENTES_LOJA6 + P2_FLUXO_DE_CLIENTES_LOJA7;
    define('P2_FLUXO_DE_CLIENTES_REGIONAL2',$fluxo_de_clientes_total_regional_p2_r2);
    /* Fim fluxo de clientes período 2 */

    /* Crescimento atendimento */
    if($fluxo_de_clientes_total_regional_p1_r2 != 0 && $fluxo_de_clientes_total_regional_p1_r2 != NULL){
        $crescimento_fluxo_de_clientes_r2 = (($fluxo_de_clientes_total_regional_p2_r2 / $fluxo_de_clientes_total_regional_p1_r2)*100) - 100;
    }else{
        $crescimento_fluxo_de_clientes_r2 = 0;
    }
    define('CRESCIMENTO_FLUXO_DE_CLIENTES_REGIONAL2', $crescimento_fluxo_de_clientes_r2);
    /* Fim crescimento fluxo de clientes */

    /*************************** TAXA DE CONVERSÃO Todas as lojas ***************************/
    /* Taxa de conversão p1*/
    if($atendimentos_total_p1_r2 != 0 && $atendimentos_total_p1_r2 != NULL){
        $taxa_de_conversao_p1_r2 = ($atendimentos_total_p1_r2/$fluxo_de_clientes_total_regional_p1_r2)*100;
    }else{
        $taxa_de_conversao_p1_r2 = 0;
    }
    define('P1_TAXA_DE_CONVERSAO_REGIONAL2', $taxa_de_conversao_p1_r2);
    /* Fim Taxa de conversão p1 */

    /* Taxa de conversão p2*/
    if(isset($fluxo_de_clientes_total_p2_r2) && $fluxo_de_clientes_total_p2_r2 != 0 && $fluxo_de_clientes_total_p2_r2 != NULL){
        $taxa_de_conversao_p2_r2 = ($atendimentos_total_p2_r2 / $fluxo_de_clientes_total_p2_r2)*100;
    }else{
        $taxa_de_conversao_p2_r2 = 0;
    }
    define('P2_TAXA_DE_CONVERSAO_REGIONAL2', $taxa_de_conversao_p2_r2);
    /* Fim Taxa de conversão p2 */


    /* Crescimento Taxa de conversão */
    $var_crescimento_taxa_de_conversao_r2 = "CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL2";
    $var_cor_crescimento_taxa_de_conversao_r2 = "COR_CRESCIMENTO_TAXA_DE_CONVERSAO_REGIONAL2";
    if($taxa_de_conversao_p1_r2 != 0 && $taxa_de_conversao_p1_r2 != NULL){
        $crescimento_taxa_de_conversao_r2 = ((($taxa_de_conversao_p2_r2/$taxa_de_conversao_p1_r2)*100)-100);
    }else{
        $crescimento_taxa_de_conversao_r2 = 0;
    }
    if ($crescimento_taxa_de_conversao_r2 <= 0) {
        define($var_cor_crescimento_taxa_de_conversao_r2,'color: #f00');
    }else {
        define($var_cor_crescimento_taxa_de_conversao_r2,'');
    }
    define($var_crescimento_taxa_de_conversao_r2, $crescimento_taxa_de_conversao_r2);
    /* Fim crescimento Taxa de conversão  */

    /*************************** QUANTIDADE PRODUTOS ***************************/
    /* Quantidade de produtos p1 */
    $sql_qt_produtos_p1_r2 = "SELECT SUM(qt_venda) AS 'qt_venda' FROM `db_venda` WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim ."' AND cd_produto <> 999 and cd_empresa != 1";
    $conexaoProdutos_regional2 = $conn -> prepare($sql_qt_produtos_p1_r2);
    $conexaoProdutos_regional2 -> execute();
    $nome_var_produtos_regional2 = "P1_QT_PRODUTOS_REGIONAL2";
    foreach($conexaoProdutos_regional2 AS $linha_consulta_qt_produtos_regional2){
        $produtos_p1_r2 = $linha_consulta_qt_produtos_regional2['qt_venda'];
    }
    isset($produtos_p1_r2) ? define($nome_var_produtos_regional2, $produtos_p1_r2) : define($nome_var_produtos_regional2, 0);
    /* Fim quantidade produtos p1 */

    /* Quantidade de produtos p2 */
    $sql_qt_produtos_p2_r2 = "SELECT SUM(qt_venda) AS 'qt_venda' FROM `db_venda` WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio."' AND '".$hora_fim."' AND cd_produto <> 999 and cd_empresa != 1";
    $conexaoProdutos_regional2 = $conn -> prepare($sql_qt_produtos_p2_r2);
    $conexaoProdutos_regional2 -> execute();
    foreach($conexaoProdutos_regional2 AS $linha_consulta_qt_produtos_regional2){
        $nome_var_produtos_regional2 = "P2_QT_PRODUTOS_REGIONAL2";
        $produtos_p2_r2  = $linha_consulta_qt_produtos_regional2['qt_venda'];
    }
    isset($produtos_p2_r2) ? define($nome_var_produtos_regional2, $produtos_p2_r2) : define($nome_var_produtos_regional2, 0);
    /* Fim quantidade produtos p2 */

    /* Crescimento de qt produtos */
    $var_produtos_r2 = "CRESCIMENTO_PRODUTOS_REGIONAL2";
    if($produtos_p1_r2 != 0 && $produtos_p1_r2 != NULL){
        $crescimento_produtos_regional_r2 = ((($produtos_p2_r2/$produtos_p1_r2)*100)-100);
    }else{
        $crescimento_produtos_regional_r2 = 0;
    }
    define($var_produtos_r2, $crescimento_produtos_regional_r2);
    /* Fim crescimento de qt produtos */


    /*************************** ITENS POR VENDA ***************************/
    /* Itens por venda p1*/
    $itens_por_venda_p1_var_regional2 = "P1_ITENS_POR_VENDA_REGIONAL2"; //Cria nome da variável
    if($atendimentos_total_p1_r2 != 0 && $atendimentos_total_p1_r2 != NULL){
        $itens_por_venda_p1_regional2 = ($produtos_p1_r2/$atendimentos_total_p1_r2);
    }else{
        $itens_por_venda_p1_regional2 = 0;
    }
    define($itens_por_venda_p1_var_regional2, $itens_por_venda_p1_regional2);
    /* Fim Itens por venda  p1 */

    /* Itens por venda p2*/
    $itens_por_venda_p2_var_regional2 = "P2_ITENS_POR_VENDA_REGIONAL2"; //Cria nome da variável
    if($atendimentos_total_p2_r2 != 0 && $atendimentos_total_p2_r2 != NULL){
        $itens_por_venda_p2_regional2 = ($produtos_p2_r2/$atendimentos_total_p2_r2);
    }else{
        $itens_por_venda_p2_regional2 = 0;
    }
    define($itens_por_venda_p2_var_regional2, $itens_por_venda_p2_regional2);
    /* Fim Itens por venda  p2 */


    /* Crescimento itens por venda */
    $var_crescimento_itens_por_venda_regional2 = "CRESCIMENTO_ITENS_POR_VENDA_REGIONAL2";
    $var_cor_crescimento_itens_por_venda_regional2 = "COR_CRESCIMENTO_ITENS_POR_VENDA_REGIONAL2";
    if($itens_por_venda_p1_regional2 != 0 && $itens_por_venda_p1_regional2 != NULL){
        $crescimento_itens_por_venda_regional2 = ((($itens_por_venda_p2_regional2 / $itens_por_venda_p1_regional2)*100)-100);
    }else{
        $crescimento_itens_por_venda_regional2 = 0;
    }
    if ($crescimento_itens_por_venda_regional2 <= 0) {
        define($var_cor_crescimento_itens_por_venda_regional2, 'color: #f00');
    }else {
        define($var_cor_crescimento_itens_por_venda_regional2, '');
    }
    define($var_crescimento_itens_por_venda_regional2, 0);
    /* Fim crescimento itens por venda */


    /*************************** PREÇO MÉDIO PRODUTOS ***************************/
    /* Preço médio produtos p1*/
    $preco_medio_produtos_p1_var_regional2 = "P1_PRECO_MEDIO_PRODUTOS_REGIONAL2"; //Cria nome da variável
    if($produtos_p1_r2 != 0 && $produtos_p1_r2 != NULL){
        $preco_medio_produtos_p1_r2 = ($vendas_total_regional_p1_r2/$produtos_p1_r2);
    }else{
        $preco_medio_produtos_p1_r2 = 0;
    }
    define($preco_medio_produtos_p1_var_regional2, $preco_medio_produtos_p1_r2);
    /* Fim preço médio produtos p1 */

    /* Preço médio produtos p2*/
    $preco_medio_produtos_p2_var_regional2 = "P2_PRECO_MEDIO_PRODUTOS_REGIONAL2"; //Cria nome da variável
    if($produtos_p2_r2 != 0 && $produtos_p2_r2 != NULL){
        $preco_medio_produtos_p2_r2 = ($vendas_total_regional_p2_r2/$produtos_p2_r2);
    }else{
        $preco_medio_produtos_p2_r2 = 0;
    }
    define($preco_medio_produtos_p2_var_regional2, $preco_medio_produtos_p2_r2);
    /* Fim preço médio produtos p2 */

    /* Crescimento preço médio produtos */
    $var_crescimento_preco_medio_produtos_regional2 = "CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL2";
    $var_cor_crescimento_preco_medio_produtos_regional2 = "COR_CRESCIMENTO_PRECO_MEDIO_PRODUTOS_REGIONAL2";
    if($preco_medio_produtos_p1_r2 != 0 && $preco_medio_produtos_p1_r2 != NULL){
        $crescimento_preco_medio_produtos_regional2 = ((($preco_medio_produtos_p2_r2 / $preco_medio_produtos_p1_r2)*100)-100);
    }else{
        $crescimento_preco_medio_produtos_regional2 = 0;
    }
    if($crescimento_preco_medio_produtos_regional2 <= 0){
        define($var_cor_crescimento_preco_medio_produtos_regional2,'color: #f00;');
    }else{
        define($var_cor_crescimento_preco_medio_produtos_regional2,'');
    }
    define($var_crescimento_preco_medio_produtos_regional2, $crescimento_preco_medio_produtos_regional2);
    /* Fim crescimento preço médio produtos  */

    /*************************** MARGEM ***************************/
    /* Margem p1 */
    $sql_margem_p1_regional2 = "SELECT * FROM `base_margem` WHERE dt_base = '".$data_p1."' and cd_empresa = 0";
    $conexaoMargem_regional2 = $conn -> prepare($sql_margem_p1_regional2);
    $conexaoMargem_regional2 -> execute();
    $nome_var_margem_regional2 = "P1_MARGEM_REGIONAL2";
    foreach($conexaoMargem_regional2 AS $linha_consulta_loja_regional2){
        $margem_p1_regional2 = $linha_consulta_loja_regional2['contribuicao_marginal'];
    }
    isset($margem_p1_regional2) ? define($nome_var_margem_regional2,$margem_p1_regional2) : define($nome_var_margem_regional2,0);
    /* Fim margem p1 */
    
    /* Margem p2 */
    $sql_margem_p2_regional2 = "SELECT * FROM `base_margem` WHERE dt_base = '".$data_p2."' and cd_empresa = 0";
    $conexaoMargem_regional2 = $conn -> prepare($sql_margem_p2_regional2);
    $conexaoMargem_regional2 -> execute();
    $nome_var_margem_regional2 = "P2_MARGEM_REGIONAL2";
    foreach($conexaoMargem_regional2 AS $linha_consulta_loja_regional2){
        $margem_p2_regional2 = $linha_consulta_loja_regional2['contribuicao_marginal'];
    }
    isset($margem_p2_regional2) ? define($nome_var_margem_regional2,$margem_p2_regional2) : define($nome_var_margem_regional2,0);
    /* Fim margem p2 */


    /* Crescimento margem */
    if(isset($margem_p1_regional2) && isset($margem_p2_regional2) && $margem_p2_regional2 != 0 && $margem_p2_regional2 != NULL){
        $crescimento_margem_regional2 = $margem_p2_regional2-$margem_p1_regional2;
    }else{
        $crescimento_margem_regional2 = 0;
    }
    if($crescimento_margem_regional2 <= 0){
        define('COR_CRESCIMENTO_MARGEM_REGIONAL2','color:#f00');
    }else {
        define('COR_CRESCIMENTO_MARGEM_REGIONAL2','');
    }
    define('CRESCIMENTO_MARGEM_REGIONAL2', $crescimento_margem_regional2);
    /* Fim Crescimento margem */

    /* Hiper margem */
    $sql_hiper_margem_p2_regional2 = "SELECT * FROM `metas_margem` WHERE cd_empresa = 0";
    $conexaoMargem_r2 = $conn ->prepare($sql_hiper_margem_p2_regional2);
    $conexaoMargem_r2 ->execute();
    $nome_var_margem_p2_regional2 = "HIPER_MARGEM_P2_REGIONAL2";
    $nome_var_margem_cor_p2_regional2 = "COR_MARGEM_REGIONAL2";
    foreach($conexaoMargem_r2 AS $linha_consulta_hiper_margem_p2_regional2){
        $vl_total_margem_p2_regional2 = $linha_consulta_hiper_margem_p2_regional2['hiper'];
        if(!isset($margem_p2_regional2) || $linha_consulta_hiper_margem_p2_regional2['hiper'] == NULL){
            define($nome_var_margem_p2_regional2, 0);
            define($nome_var_margem_cor_p2_regional2,'background-color:#ff0000;color: #fff;');
        }else{
            define($nome_var_margem_p2_regional2, $vl_total_margem_p2_regional2);
            if($margem_p2_regional2 >= $linha_consulta_hiper_margem_p2_regional2['hiper']){
                define($nome_var_margem_cor_p2_regional2,'background-color:#00b0f0');
            }elseif($margem_p2_regional2 >= $linha_consulta_hiper_margem_p2_regional2['super'] && $margem_p2_regional2 < $linha_consulta_hiper_margem_p2_regional2['hiper']) {
                define($nome_var_margem_cor_p2_regional2,'background-color:#00ff00');
            }elseif($margem_p2_regional2 >= $linha_consulta_hiper_margem_p2_regional2['meta'] && $margem_p2_regional2 < $linha_consulta_hiper_margem_p2_regional2['super']){
                define($nome_var_margem_cor_p2_regional2,'background-color:#28a745');
            }else{
                define($nome_var_margem_cor_p2_regional2,'background-color:#ff0000;color: #fff;');
            }
        }
    }
        /* fim hiper margem */

?>