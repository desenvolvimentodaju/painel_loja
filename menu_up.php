<?php
    if($_SESSION['nivel_acesso'] == 0){
        $visibilitty = "hidden";
        $visibilittyGerente = "hidden";
    }elseif($_SESSION['nivel_acesso'] == 1 && $_SESSION['funcao'] == 'gerente de loja'){
        $visibilittyGerente = "";
        $visibilitty  = "hidden";
    }else{
        $visibilittyGerente = " ";
        $visibilitty  = " ";
    }
    include_once('conn/conn.php');
    $conexao = $conn -> prepare("SELECT ds_loja FROM db_nome_empresa WHERE cd_loja =".$_SESSION['loja']);
    $conexao->execute();
    foreach($conexao AS $descricao){
        if($descricao['ds_loja'] != 'NULL' || $descricao['ds_loja'] != ''){
            $ds_loja = $descricao['ds_loja'];
        }else{
            $ds_loja = '-';
        }
    }
    $conexao2 = $conn -> prepare("SELECT dt_transacao,hr_saida FROM `db_venda` ORDER BY dt_transacao DESC LIMIT 1");
    $conexao2->execute();
    foreach($conexao2 AS $descricao){
        $data_atualização = $descricao['dt_transacao'];
        $hora_atualização = $descricao['hr_saida'];
    }
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-uppercase" href="index.php"><b> Acompanhamento de vendas</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Início<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bases e metas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="margem.php">Base margem</a>
                    <a class="dropdown-item" href="metas-diarias.php">Metas Diárias</a>
                    <a class="dropdown-item" href="metas-semana.php">Metas Semana</a>
                    <a class="dropdown-item" href="metas-tkm.php">Metas TKM</a>
                    <a class="dropdown-item" href="metas-margem.php">Metas Margem</a>
                    <a class="dropdown-item" href="fluxo-de-clientes.php">Fluxo de clientes</a>
                <div class="dropdown-divider"></div>
                    <a class="nav-link" onclick="upPlanilhas()" data-toggle="modal" data-target="#exampleModalUpPlanilhas" href="#">Upload de Base</a>
                    <a class="nav-link" href="horario-loja.php">Horário de lojas</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary bck-azul-claro-daju border-color-azul-claro-daju" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="filter icon"></i>Filtrar
                </a>
            </li>
        </ul>
        <div class="text-white text-uppercase mr-3" title='Última venda registrada <?php 
                    $expHora = explode(":", $hora_atualização);
                    $hora_atualização = $expHora[0].":".$expHora[1];
                    echo $hora_atualização; ?>'>
            <div style="color: #000;">
                <?php echo $_SESSION['nome_user']; ?>
            </div>
            <div style="color: #000;">
                Atualização <?php 
                    $expHora = explode(":", $hora_atualização);
                    $hora_atualização = $expHora[0].":".$expHora[1];
                    echo $hora_atualização; ?>

            </div>
        </div>
        <a class="btn btn-outline-info my-2 my-sm-0" href="verificar/logout.php">
            Sair
            <svg width="2em" height="2em" viewBox="0 1 16 16" class="bi bi-door-open" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1 15.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM11.5 2H11V1h.5A1.5 1.5 0 0 1 13 2.5V15h-1V2.5a.5.5 0 0 0-.5-.5z"/>
                <path fill-rule="evenodd" d="M10.828.122A.5.5 0 0 1 11 .5V15h-1V1.077l-6 .857V15H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117z"/>
                <path d="M8 9c0 .552.224 1 .5 1s.5-.448.5-1-.224-1-.5-1-.5.448-.5 1z"/>
            </svg>
        </a>
    </div>
</nav>