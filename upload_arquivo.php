<?php
    // echo "<pre>";
    require("conn/conn.php");
    /* Pega o nome e abre o arquivo para leitura */
    $arquivo = $_FILES['arquivo']['tmp_name'];
    /* Subir base margem */
    switch ($_POST['base']) {
        case 1:
            $objeto = fopen($arquivo, 'r');
            while (($dados = fgetcsv($objeto,'', ";")) !== FALSE){
                /* verifica se é o cabeçalho */
                if(strtolower($dados[0]) == 'regional'){
                    $cd_loja = 0;
                }else{
                    $cd_loja = $dados[0];
                }
                if(is_numeric($cd_loja)){

                    /* Data */
                    $data = explode("/", $dados[1]);
                    $data = $data[2]."-".$data[1]."-".$data[0];

                    /* Editar contribuição marginal */
                    if($dados[2] != '' && $dados[2] != NULL){
                        $cont_marg = str_replace(",", ".",$dados[2]);
                        $cont_marg = str_replace("%", "",$cont_marg);
                    }else{
                        $cont_marg = 0;
                    }

                    $sql_verificacao = "SELECT * FROM `base_margem` WHERE `cd_empresa` = '$cd_loja' AND `dt_base` = '$data'";
                    $consulta = $conn->prepare($sql_verificacao);
                    $consulta->execute();
                    $retorno = count($consulta->fetchAll(PDO::FETCH_ASSOC));
                    if($retorno == 1){
                        $consulta->execute();
                        foreach($consulta AS $update_base_margem){
                            $sql = "UPDATE `base_margem` SET `contribuicao_marginal`= ".$cont_marg."  WHERE `id` = ".$update_base_margem['id'];
                        }
                    }else{
                        $sql = "INSERT INTO `base_margem`(`id`, `cd_empresa`, `dt_base`, `contribuicao_marginal`) VALUES (0,$cd_loja, '$data',$cont_marg)";
                    }
                    // echo $sql."<br>";
                    if($mysqli->query($sql)){
                        echo "<script> alert('Importação concluída com sucesso') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }else{
                        echo "<script> alert('Algo deu errado, informe a TI') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }
                }
            }
            fclose($objeto);
        break;

        case 2:
            $objeto = fopen($arquivo, 'r');
            while (($dados = fgetcsv($objeto,'', ";")) !== FALSE){
                if(strtolower($dados[1]) == 'regional'){
                    $cd_loja = 0;
                }else{
                    $cd_loja = $dados[1];
                }
                if(is_numeric($cd_loja)){

                    $peso_hiper_dia = str_replace(",",".",$dados[0]);
                    $peso_hiper_dia = str_replace("%","",$peso_hiper_dia);

                    /* Editar data */
                    $data = explode("/", $dados[2]);
                    $data = $data[2]."-".$data[1]."-".$data[0];

                    $minima = (double) str_replace(" ","",str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$-","",$dados[3])))));
                    $minima = is_numeric($minima) ? $minima : 0;
                    
                    $meta = (double) str_replace(" ","",str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$-","",$dados[4])))));
                    $meta = is_float($meta) ? $meta : 0;

                    $super = (double) str_replace(" ","",str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$-","",$dados[5])))));
                    $super = is_float($super) ? $super : 0;

                    $hiper = (double) str_replace(" ","",str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$-","",$dados[6])))));
                    $hiper = is_float($hiper) ? $hiper : 0;

                    $mega = (double) str_replace(" ","",(str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$-","",$dados[7]))))));
                    $mega = is_float($mega) ? $mega : 0;

                    $sql_verificacao = "SELECT * FROM `metas_diarias` WHERE `cd_empresa` = '$cd_loja' AND `dt_meta` = '$data'";
                    $consulta = $conn->prepare($sql_verificacao);
                    $consulta->execute();
                    $retorno = count($consulta->fetchAll(PDO::FETCH_ASSOC));
                    if($retorno == 1){
                        $consulta->execute();
                        foreach($consulta AS $update_meta_dia){
                            $sql = "UPDATE `metas_diarias` SET `peso_hiper_dia`= '".$peso_hiper_dia."',`minima`='".$minima."',`meta`='".$meta."',`super`='".$super."',`hiper`='".$hiper."',`mega`='".$mega."' WHERE `id` = ".$update_meta_dia['id'];
                        }
                    }else{
                        $sql = "INSERT INTO `metas_diarias`(`id`, `cd_empresa`, `peso_hiper_dia`, `dt_meta`, `minima`, `meta`, `super`, `hiper`, `mega`) VALUES (0,$cd_loja,'$peso_hiper_dia','$data',$minima,$meta,$super,$hiper,$mega)";
                    }
                    // echo $sql."<br>";
                    if($mysqli->query($sql)){
                        echo "<script> alert('Importação concluída com sucesso') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }else{
                        echo "<script> alert('Algo deu errado, informe a TI') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }
                }

            }
            fclose($objeto);
        break;

        case 3:
            $objeto = fopen($arquivo, 'r');
            while (($dados = fgetcsv($objeto,'', ";")) !== FALSE){
                /* Editar data */
                if(strtolower($dados[0]) == 'regional'){
                    $cd_loja = 0;
                }else{
                    $cd_loja = $dados[0];
                }
                if(is_numeric($cd_loja)){
                    $minima = (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[2]))));
                    $minima = is_float($minima) ? $minima : 0;

                    $meta =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[3]))));
                    $meta = is_float($meta) ? $meta : 0;
                
                    $super =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[4]))));
                    $super = is_float($super) ? $super : 0;
                    
                    $hiper =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[5]))));
                    $hiper = is_float($hiper) ? $hiper : 0;

                    $mega =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[6]))));
                    $mega = is_float($mega) ? $mega : 0;

                    $sql_verificacao = "SELECT * FROM `metas_semana` WHERE `cd_empresa` = '$cd_loja' AND `semana` = '$dados[1]'";
                    // echo $sql_verificacao;
                    $consulta = $conn->prepare($sql_verificacao);
                    $consulta->execute();
                    $retorno = count($consulta->fetchAll(PDO::FETCH_ASSOC));
                    if($retorno == 1){
                        $consulta->execute();
                        foreach($consulta AS $update_meta_semana){
                            $sql = "UPDATE `metas_semana` SET `minima`='".$minima."',`meta`='".$meta."',`super`='".$super."',`hiper`='".$hiper."',`mega`='".$mega."' WHERE `id` = ".$update_meta_semana['id'];
                        }
                    }else{
                        $sql = "INSERT INTO `metas_semana`(`id`, `cd_empresa`, `semana`, `minima`,`meta`, `super`, `hiper`, `mega`) VALUES (0,".$dados[0].",".$dados[1].", '".$minima."', '".$meta."', '".$super."', '".$hiper."', '".$mega."')";
                    }

                    // echo $sql."</br>";
                    if($mysqli->query($sql)){
                        echo "<script> alert('Importação concluída com sucesso') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }else{
                        echo "<script> alert('Algo deu errado, informe a TI') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }
                }
        
            }
            fclose($objeto);
        break;

        case 4:
            $objeto = fopen($arquivo, 'r');
            while (($dados = fgetcsv($objeto,'', ";")) !== FALSE){
                /* Editar data */
                if(strtolower($dados[0]) == 'regional'){
                    $cd_loja = 0;
                }else{
                    $cd_loja = $dados[0];
                }
                if(is_numeric($cd_loja)){

                    $meta =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[1]))));
                    $meta = is_float($meta) ? $meta : 0;
                
                    $super =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[2]))));
                    $super = is_float($super) ? $super : 0;
                    
                    $hiper =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[3]))));
                    $hiper = is_float($hiper) ? $hiper : 0;

                    $mega =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$","",$dados[4]))));
                    $mega = is_float($mega) ? $mega : 0;
                    
                    /* Verifica se já existe */
                    $sql_verificacao = "SELECT * FROM `metas_tkm` WHERE `cd_empresa` = '$cd_loja'";
                    // echo $sql_verificacao;
                    $consulta = $conn->prepare($sql_verificacao);
                    $consulta->execute();
                    $retorno = count($consulta->fetchAll(PDO::FETCH_ASSOC));
                    if($retorno == 1){
                        $consulta->execute();
                        foreach($consulta AS $update_meta_tkm){
                            $sql = "UPDATE `metas_tkm` SET `meta`='".$meta."',`super`= '".$super."',`hiper`= '".$hiper."',`mega`= '".$mega."' WHERE `id` = ".$update_meta_tkm['id'];
                        }
                    }else{
                        $sql = "INSERT INTO `metas_tkm`(`id`, `cd_empresa`, `meta`, `super`, `hiper`, `mega`) VALUES (0,".$dados[0].",'".$meta."', '".$super."', '".$hiper."', '".$mega."')";
                    }

                    // echo $sql."</br>";
                    if($mysqli->query($sql)){
                        echo "<script> alert('Importação concluída com sucesso') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }else{
                        echo "<script> alert('Algo deu errado, informe a TI') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }
                }
            }
            fclose($objeto);
        break;

        case 5:
            $objeto = fopen($arquivo, 'r');
            while (($dados = fgetcsv($objeto,'', ";")) !== FALSE){
                /* Editar loja */
                if(strtolower($dados[0]) == 'regional'){
                    $cd_loja = 0;
                }else{
                    $cd_loja = $dados[0];
                }
                if(is_numeric($cd_loja)){

                    /* Editar data */
                    $data = explode("/", $dados[1]);
                    $data = $data[2]."-".$data[1]."-".$data[0];

                    $meta =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("%","",$dados[2]))));
                    $meta = is_float($meta) ? $meta : 0;

                    $super =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("%","",$dados[3]))));
                    $super = is_float($super) ? $super : 0;
                    
                    $hiper =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("%","",$dados[4]))));
                    $hiper = is_float($hiper) ? $hiper : 0;

                    $mega =  (double) str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("%","",$dados[5]))));
                    $mega = isset($mega) && is_float($mega) ? $mega : 0;
                    
                    /* Verifica se já existe */
                    $sql_verificacao = "SELECT * FROM `metas_margem` WHERE `cd_empresa` = '$cd_loja'";
                    // echo $sql_verificacao;
                    $consulta = $conn->prepare($sql_verificacao);
                    $consulta->execute();
                    $retorno = count($consulta->fetchAll(PDO::FETCH_ASSOC));
                    if($retorno == 1){
                        $consulta->execute();
                        foreach($consulta AS $update_meta_margem){
                            $sql = "UPDATE `metas_margem` SET `meta`='".$meta."',`super`= '".$super."',`hiper`= '".$hiper."',`mega`= '".$mega."' WHERE `id` = ".$update_meta_margem['id'];
                        }
                    }else{
                        $sql = "INSERT INTO `metas_margem`(`id`, `cd_empresa`, `meta`, `super`, `hiper`, `mega`) VALUES (0,".$dados[0].",'".$meta."', '".$super."', '".$hiper."', '".$mega."')";
                    }

                    // echo $sql."</br>";
                    if($mysqli->query($sql)){
                        echo "<script> alert('Importação concluída com sucesso') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }else{
                        echo "<script> alert('Algo deu errado, informe a TI') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }
                }
            }
            fclose($objeto);
        break;

        case 6:
            $objeto = fopen($arquivo, 'r');
            while (($dados = fgetcsv($objeto,'', ";")) !== FALSE){
                if(strtolower($dados[2]) == 'regional'){
                    $cd_loja = 0;
                }else{
                    $cd_loja = $dados[2];
                }
                if(is_numeric($cd_loja)){
                    /* Editar data */
                    $data = explode("/", $dados[0]);
                    $data = $data[2]."-".$data[1]."-".$data[0];
    
                    $sql_verificacao = "SELECT * FROM `fluxo_de_clientes` WHERE `cd_empresa` = '$cd_loja' AND `dt_base` = '$data'";
                    $consulta = $conn->prepare($sql_verificacao);
                    $consulta->execute();
                    $retorno = count($consulta->fetchAll(PDO::FETCH_ASSOC));
                    if($retorno == 1){
                        $consulta->execute();
                        foreach($consulta AS $update_fluxo_de_entrada){
                            $sql = "UPDATE `fluxo_de_clientes` SET `fluxo_de_clientes`= ".$dados[3]." WHERE `id` = ".$update_fluxo_de_entrada['id'];
                        }
                    }else{
                        $sql = "INSERT INTO `fluxo_de_clientes`(`id`, `cd_empresa`, `dt_base`, `fluxo_de_clientes`) VALUES (0,'$cd_loja','$data',".$dados[3].")";
                    }
                    // echo $sql."<br>";
                    if($mysqli->query($sql)){
                        echo "<script> alert('Importação concluída com sucesso') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }else{
                        echo "<script> alert('Algo deu errado, informe a TI') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }
                }
    
            }
            fclose($objeto);
        break;

        case 7:
            $objeto = fopen($arquivo, 'r');
            while (($dados = fgetcsv($objeto,'', ";")) !== FALSE){
                /* editar valor */
                $valor = (double) str_replace(" ","",(str_replace("R$","",str_replace(",",".",str_replace(".","",str_replace("R$-","",$dados[1]))))));
                $valor = is_float($valor) ? $valor : 0;
                if(is_float($valor) && strtolower($dados[1]) <> 'valor'){
                    /* Editar data */
                    $data = explode("/", $dados[0]);
                    $data = $data[2]."-".$data[1]."-".$data[0];

                    $sql_verificacao = "SELECT * FROM `db_vendas_sob_medida` WHERE `data` = '$data'";
                    $consulta = $conn->prepare($sql_verificacao);
                    $consulta->execute();
                    $retorno = count($consulta->fetchAll(PDO::FETCH_ASSOC));
                    if($retorno == 1){
                        $consulta->execute();
                        foreach($consulta AS $update_sob_medida){
                            $sql = "UPDATE `db_vendas_sob_medida` SET `valor`= $valor WHERE `id` = ".$update_sob_medida['id'];
                        }
                    }else{
                        $sql = "INSERT INTO `db_vendas_sob_medida`(`id`, `data`, `valor`) VALUES (0,'".$data."','".$valor."')";
                    }

                    if($mysqli->query($sql)){
                        // echo "<b>".$sql."</b></br>";
                        echo "<script> alert('Importação concluída com sucesso') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }else{
                        // echo "</br>".$sql;
                        echo "<script> alert('Algo deu errado, informe a TI') </script>";
                        echo "<script> window.open(document.referrer,'_self'); </script>";
                    }
                }
            }
            fclose($objeto);
        break;
        
        default:
            echo "<script> alert('Algo deu errado ao subir base, informe a TI') </script>";
            echo "<script> window.open(document.referrer,'_self'); </script>";
        break;
    }



    // echo "<script> window.open(document.referrer,'_self'); </script>";
?>