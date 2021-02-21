<?php
    include_once("conn.php");

    //pega as datas de comparação
    /* Perío 1 ou data ano passado */
    if(isset($_POST['data_p1'])){
        $data_p1 = $_POST['data_p1'];
    }else{
        $data_p1 = date('Y-m-d');
    }
    if(isset($_POST['hora_inicio_p1'])){
        $hora_inicio_p1 = $_POST['hora_inicio_p1'];
    }else{
        $hora_inicio_p1 = '07:00:00';
    }
    if(isset($_POST['hora_fim_p1'])){
        $hora_fim_p1 = $_POST['hora_fim_p1'];
    }else{
        $hora_fim_p1 = '23:59:00';
    }
    /* Fim período 1 */

    /* Início período 2 */
    if(isset($_POST['data_p2'])){
        $data_p2 = $_POST['data_p2'];
    }elseif(date('L') == 1){
        $data_p2 = date('Y-m-d', strtotime('-'. 364 .' days', strtotime(date('Y-m-d'))));
    }else{
        $data_p2 = date('Y-m-d', strtotime('-'. 365 .' days', strtotime(date('Y-m-d'))));
    }
    if(isset($_POST['hora_inicio_p2'])){
        $hora_inicio_p2 = $_POST['hora_inicio_p2'];
    }else{
        $hora_inicio_p2 = '07:00:00';
    }
    if(isset($_POST['hora_fim_p2'])){
        $hora_fim_p2 = $_POST['hora_fim_p2'];
    }else{
        $hora_fim_p2 = '23:59:00';
    }
    /* Fim período 2 */

    /* Início período 3 */
    if(isset($_POST['data_p3'])){
        $data_p3 = $_POST['data_p3'];
    }elseif(date('L') == 1){
        $data_p3 = date('Y-m-d', strtotime('-'. 364 .' days', strtotime(date('Y-m-d'))));
    }else{
        $data_p3 = date('Y-m-d', strtotime('-'. 365 .' days', strtotime(date('Y-m-d'))));
    }
    if(isset($_POST['hora_inicio_p3'])){
        $hora_inicio_p3 = $_POST['hora_inicio_p3'];
    }else{
        $hora_inicio_p3 = '07:00:00';
    }
    if(isset($_POST['hora_fim_p3'])){
        $hora_fim_p3 = $_POST['hora_fim_p3'];
    }else{
        $hora_fim_p3 = '23:59:00';
    }
    /* Fim período 3 */

    define('DATA_P1', $data_p1);
    define('DATA_P2', $data_p2);
    define('DATA_P3', $data_p3);
    define('HORA_INICIO_P1', $hora_inicio_p1);
    define('HORA_INICIO_P2', $hora_inicio_p2);
    define('HORA_INICIO_P3', $hora_inicio_p3);
    define('HORA_FIM_P1', $hora_fim_p1);
    define('HORA_FIM_P2', $hora_fim_p1);
    define('HORA_FIM_P3', $hora_fim_p3);
    
    /* ***************************************************************************************************************************** */
    /* Selecionar as empresas no banco */
    // $sqlLojas = "SELECT DISTINCT(cd_empresa) AS 'cd_loja', B.ds_loja FROM `db_venda` A INNER JOIN db_nome_empresa B ON A.cd_empresa = B.cd_loja";
    $sqlLojas = "SELECT * FROM `db_nome_empresa`";
    $conexaoLoja = $conn -> prepare($sqlLojas);
    $conexaoLoja -> execute();
    /******** Início definição dos valores por loja ********/
    foreach($conexaoLoja AS $linha_consulta_loja){
        /* Loja selecionada */
        $loja = $linha_consulta_loja['cd_loja'];
        $ds_loja = $linha_consulta_loja['ds_loja'];
        
        /*************************** SOMA VENDAS ***************************/
        /* Soma período 1 */
        $sql_p1 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p1' FROM db_venda WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio_p1."' AND '".$hora_fim_p1."' AND cd_produto <> 999 and cd_empresa = ".$loja;
        $conexao = $conn ->prepare($sql_p1);
        $conexao ->execute();
        foreach($conexao AS $linha_consulta_p1){
            $nome_var_p1 = "P1_VENDA_LOJA".$loja;
            $vl_total_venda_p1 = $linha_consulta_p1['total_venda_p1'];
            define($nome_var_p1, $vl_total_venda_p1);
        }
        /* Fim soma período 1 */
        
        /* Soma período 2 */
        $sql_p2 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p2' FROM db_venda WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio_p2."' AND '".$hora_fim_p2."' AND cd_produto <> 999 and cd_empresa = ".$loja;
        $conexao = $conn ->prepare($sql_p2);
        $conexao ->execute();
        foreach($conexao AS $linha_consulta_p2){
            $nome_var_p2 = "P2_VENDA_LOJA".$loja;
            $vl_total_venda_p2 = $linha_consulta_p2['total_venda_p2']; 
            define($nome_var_p2, $vl_total_venda_p2);
        }
        /* Fim Soma período 2 */
        
        /* Soma período 3 */
        $sql_p3 = "SELECT round(SUM(vl_total_venda),2) AS 'total_venda_p3' FROM db_venda WHERE dt_transacao = '".$data_p3."' AND hr_saida BETWEEN '".$hora_inicio_p3."' AND '".$hora_fim_p3."' AND cd_produto <> 999 and cd_empresa = ".$loja;
        $conexao = $conn ->prepare($sql_p3);
        $conexao ->execute();
        foreach($conexao AS $linha_consulta_p3){
            $nome_var_p3 = "P3_VENDA_LOJA".$loja;
            $vl_total_venda_p3 = $linha_consulta_p3['total_venda_p3']; 
            define($nome_var_p3, $vl_total_venda_p3);
        }
        /* Fim Soma período 3 */
        
        /* Crescimento Vendas Loja  */
        $var_crescimento = "CRESCIMENTO_LOJA".$loja;
        if($vl_total_venda_p2 != 0 && $vl_total_venda_p2 != NULL){
            $crescimento = (($vl_total_venda_p1 / $vl_total_venda_p2)*100) - 100;
        }else{
            $crescimento = 0;
        }
        define($var_crescimento, $crescimento);
        /* Fim crescimento Vendas Loja  */
        
        /* Hiper Loja  */
        // ~
        // ~
        // ~
        /* selecionar */
        
        $parciais = array(
            array(  "loja" => $linha_consulta_loja['ds_loja'],
                    "vendas1" => $vl_total_venda_p1,
                    "vendas2" => $vl_total_venda_p2,
                    "vendas3" => $vl_total_venda_p3,
                    "crescimento_vendas" => $crescimento)
        );
        var_dump($parciais);
            // var_dump($vendas);
    
            /*************************** ATENDIMENTOS ***************************/
            /* Início atendimentos período 1 */
            $sql_atendimentos_p1 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio_p1."' AND '".$hora_fim_p1."' AND cd_produto <> 999 and cd_empresa = ".$loja;
            $atendimentos_p1 = $conn->query($sql_atendimentos_p1)->fetchColumn();
            $atendimento_var_p1 = "P1_ATENDIMENTO_LOJA".$loja;
            define($atendimento_var_p1, $atendimentos_p1);
            /* Fim atendimentos período 1 */
    
            /* Início atendimentos período 2 */
            $sql_atendimentos_p2 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p2."' AND hr_saida BETWEEN '".$hora_inicio_p2."' AND '".$hora_fim_p2."' AND cd_produto <> 999 and cd_empresa = ".$loja;
            $atendimentos_p2 = $conn->query($sql_atendimentos_p2)->fetchColumn();
            $atendimento_var_p2 = "P2_ATENDIMENTO_LOJA".$loja;
            define($atendimento_var_p2, $atendimentos_p2);
            /* Fim atendimentos período 2 */
    
            /* Início atendimentos período 3 */
            $sql_atendimentos_p3 = "SELECT COUNT(DISTINCT(nr_transacao)) FROM `db_venda` WHERE dt_transacao = '".$data_p3."' AND hr_saida BETWEEN '".$hora_inicio_p3."' AND '".$hora_fim_p3."' AND cd_produto <> 999 and cd_empresa = ".$loja;
            $atendimentos_p3 = $conn->query($sql_atendimentos_p3)->fetchColumn();
            $atendimento_var_p3 = "P3_ATENDIMENTO_LOJA".$loja;
            define($atendimento_var_p3, $atendimentos_p3);
            /* Fim atendimentos período 3 */
    
    
            /* Crescimento atendimento */
            $var_crescimento_atendimentos = "CRESCIMENTO_ATENDIMENTO_LOJA".$loja;
            if($atendimentos_p2 != 0 && $atendimentos_p2 != NULL){
                $crescimento_atendimentos = (((($atendimentos_p1 / $atendimentos_p2)*100)-100));
            }else{
                $crescimento_atendimentos = 0;
            }
            define($var_crescimento_atendimentos, $crescimento_atendimentos);
            /* Fim crescimento atendimento */
    
    
    
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
            if($tkm_p2 != 0 && $tkm_p2 != NULL){
                $crescimento_tkm = (($tkm_p1 / $tkm_p2)*100)-100;
            }else{
                $crescimento_tkm = 0;
            }
            define($var_crescimento_tkm, $crescimento_tkm);
            /* Fim crescimento TKM  */
    
    
    
            /*************************** QUANTIDADE PRODUTOS ***************************/
            /* Quantidade de produtos p1 */
            $sql_qt_produtos_p1 = "SELECT SUM(qt_venda) AS 'qt_venda' FROM `db_venda` WHERE dt_transacao = '".$data_p1."' AND hr_saida BETWEEN '".$hora_inicio_p1."' AND '".$hora_fim_p1 ."' AND cd_produto <> 999 and cd_empresa = ".$loja;
            $conexaoProdutos = $conn -> prepare($sql_qt_produtos_p1);
            $conexaoProdutos -> execute();
            foreach($conexaoProdutos AS $linha_consulta_qt_produto_p1){
                $nome_var_produtos = "P1_QT_PRODUTOS_LOJA".$loja;
                $produtos_p1 = $linha_consulta_qt_produto_p1['qt_venda'];
                define($nome_var_produtos, $produtos_p1);
            }
            /* Fim quantidade produtos p1 */
    
    
            /* Quantidade de produtos p2 */
            $sql_qt_produtos_p2  = "SELECT SUM(qt_venda) AS 'qt_venda' FROM `db_venda` WHERE dt_transacao = '".$data_p2 ."' AND hr_saida BETWEEN '".$hora_inicio_p2 ."' AND '".$hora_fim_p2  ."' AND cd_produto <> 999 and cd_empresa = ".$loja;
            $conexaoProdutos = $conn -> prepare($sql_qt_produtos_p2 );
            $conexaoProdutos -> execute();
            foreach($conexaoProdutos AS $linha_consulta_qt_produto_p2){
                $nome_var_produtos = "P2 _QT_PRODUTOS_LOJA".$loja;
                $produtos_p2  = $linha_consulta_qt_produto_p2['qt_venda'];
                define($nome_var_produtos, $produtos_p2 );
            }
            /* Fim quantidade produtos p2 */
    
            
            /* Crescimento de qt produtos */
            $var_produtos = "CRESCIMENTO_PRODUTOS_LOJA".$loja;
            if($produtos_p2 != 0 && $produtos_p2 != NULL){
                $crescimento_produtos = ((($produtos_p1/$produtos_p2)*100)-100);
            }else{
                $crescimento_produtos = 0;
            }
            define($var_produtos, $crescimento_produtos);
            /* Fim crescimento de qt produtos */
    
    
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
            if($preco_medio_produtos_p2 != 0 && $preco_medio_produtos_p2 != NULL){
                define($var_crescimento_preco_medio_produtos, ((($preco_medio_produtos_p1 / $preco_medio_produtos_p2)*100)-100));
            }else{
                define($var_crescimento_preco_medio_produtos, 0);
            }
            /* Fim crescimento preço médio produtos  */
        }
        /******** Fim definição dos valores por loja ********/



?>