<?php

/* $funcionarios = array(
	array("nome" => "Alex", "idade" => 21, "salario" => 1285.27, "ativo" => true), 
	array("nome" => "Emerson", "idade" => 35, "salario" => 3885.27, "ativo" => false),
	array("nome" => "Osvaldo", "idade" => 54, "salario" => 5285.27, "ativo" => true),
);

$bonificacao = 10;

foreach($funcionarios as $funcionario){
	if($funcionario["ativo"]){
		$funcionario["salario"] += $funcionario["salario"] * ($bonificacao/100);
		
		// echo "Funcionario: {$funcionario['nome']} - {$funcionario['salario']}\n";
	} else {
		// echo "Funcionario: {$funcionario['nome']} - INATIVO\n";
	}
}
    include_once('conn/conn.php');
    $sql_hiper_vendas_p3 = "SELECT * FROM `metas_semana` WHERE `cd_empresa` = 2";
    echo $sql_hiper_vendas_p3;
    $conexao = $conn ->prepare($sql_hiper_vendas_p3);
    $conexao ->execute();
    foreach($conexao AS $linha_consulta_hiper_vendas_p3){
        // $nome_var_p3 = "HIPER_VENDAS_P3_LOJA".$loja;
        $vl_total_venda_p3 = $linha_consulta_hiper_vendas_p3['semana'];
        echo "</br>".$vl_total_venda_p3;
        // define($nome_var_p3, $vl_total_venda_p3);
    } */
    $ano = '2020';
    $mes = '09';
    function countSemanasMes ($ano, $mes) {

        $data = new DateTime("$ano-$mes-01");
        $dataFimMes = new DateTime($data->format('Y-m-t'));
    
        $numSemanaInicio = $data->format('W');
        $numSemanaFinal  = $dataFimMes->format('W') + 1;
    
        // Última semana do ano pode ser semana 1
        $numeroSemanas = ($numSemanaFinal < $numSemanaInicio) ? (52 + $numSemanaFinal) - $numSemanaInicio : $numSemanaFinal - $numSemanaInicio;
    
        return $numeroSemanas;
        
    }

    $data = new DateTime("$ano-$mes-01");
    $dataFimMes = new DateTime($data->format('Y-m-t'));

    $numSemanaInicio = $data->format('W');
    $numSemanaFinal  = $dataFimMes->format('W') + 1;

    // Última semana do ano pode ser semana 1
    $numeroSemanas = ($numSemanaFinal < $numSemanaInicio) ? (52 + $numSemanaFinal) - $numSemanaInicio : $numSemanaFinal - $numSemanaInicio;
    echo $numeroSemanas;
    echo date('w', strtotime('2020-09-22'));