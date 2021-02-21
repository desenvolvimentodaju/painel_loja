<?php
    if (!isset($_SESSION)) session_start();
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    if(@$_SESSION['user_logado'] == 1){
        echo "<script> window.location.href='index.php' </script>";
    }else{
        include_once("../conn/conn.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Cadastro usuário</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/daju-logo-icon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
<!--===============================================================================================-->
    <script>
    function valida( frm ){
        var usuario = frm.usuario.value ;
        var msg = "" ;
        if ( usuario.search( /\s/g ) != -1 ){
            msg+= "Não é permitido espaços em branco\n" ;
            usuario = usuario.replace( /\s/g , "" ) ;
        }
        if ( msg ){
            alert( msg ) ;
            frm.usuario.value = usuario ;
            return false ;
        }
        return true ;	
    }
    </script>
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login10 overflow-auto" >
                <div class="login100-form validate-form overflow-auto ">
                    <form class=""  action="" method="POST" name="form1" >
                        <span class="login100-form-title">
                            Cadastro Usuário
                        </span>
                        
                        <div class="wrap-input100 validate-input" data-validate ="Insira o nome completo do colaborador, ex.: Leoncio Amaral">
                            <input class="input100" type="text" name="nome_colab" placeholder="Nome colaborador" >
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate ="Insira um usuário, ex.: Leo_Amaral">
                            <input class="input100" type="text" name="usuario"  placeholder="Nome de usuário" onblur="valida(document.form1);">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate ="Insira um email válido: ex@abc.xyz">
                            <input class="input100" type="text" name="email" placeholder="Email" >
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate = "Insira um número válido, ex.: 666.666.666-66">

                            <input class="inputmask input100" id="cpfcnpj" type="text" name="cpf" placeholder="Cpf do colaborador" >
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-certificate" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate = "Insira um número válido, ex.: 41 99999-9999">
                            <input class="input100" id="cpfcnpj" type="text" name="telefone" placeholder="Número de contato" >
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 " hidden data-validate = "Insira uma senha">
                            <input class="input100" type="password" value="mudar" name="pass" placeholder="Senha automática" disabled>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 " data-validate = "Acesso" >
                            <select class="form-control input100" name="cd_empresa" id="empresa" style="border:none">
                                <?php
                                    $consult = $conn->prepare("SELECT * FROM db_nome_empresa");
                                    $consult->execute();
                                    foreach($consult AS $descricao){
                                        if($descricao['cd_loja'] != 1 && $descricao['cd_loja'] != 3){
                                            echo "<option value='".$descricao['cd_loja']."'>".$descricao['ds_loja']."</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <span class="focus-input100" ></span>
                            <span class="symbol-input100"><i class="fa fa-lock"></i></span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button type="submit" name="cadastrar" class="login100-form-btn">
                                Cadastrar
                            </button>
                        </div>

                        <div class="text-center p-t-1">
                            <a class="txt2" href="index.php">
                                Voltar
                                <i class="fa fa-long-arrow-left m-l-5" aria-hidden="false"></i>
                            </a>
                        </div>
                    </form>
                </div>
				
				<div class="login100-pic">
					<img src="images/daju-logo.png" alt="IMG">
				</div>
			</div>
		</div>
	</div>
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
</body>
</html>
<?php
	if(isset($_POST['cadastrar'])){
        try{
            $id_users = NULL;
            $id_rand = rand();
            $nome_completo = $_POST['nome_colab'];
            $usuario = preg_replace("/\s+/", "", $_POST['usuario']);
            $senha         = md5('mudar');
            $email         = $_POST['email'];
            $nivel_acesso = '0';
            $empresa = $_POST['cd_empresa'];
            $funcao = '';
            $cpf = $_POST['cpf'];
            $cnpj = '';
            $loja = '';
            $telefone      = $_POST['telefone'];
            $endereco = '';
            $bairro = '';
            $cep = NULL;
            $cidade = '';
            $estado = '';
            $troca_senha = 1;
            $status = NULL;
            $nome_contato1 = '';
            $telefone_contato1 = '';
            $nome_contato2 = '';
            $telefone_contato2 = '';
			$stmt = $conn->prepare("SELECT usuario FROM users WHERE usuario = '$usuario'");
			$stmt->bindParam('usuario', $usuario, PDO::PARAM_STR);
			$stmt->execute();
			$count = $stmt->rowCount();
			$row   = $stmt->fetch(PDO::FETCH_ASSOC);
            if($count == 1 && !empty($row)) {
				echo "<script> alert('Usuário já existe!') </script>";
                echo "<script> window.location.href='index.php' </script>";
			}else{
                $sql = "INSERT INTO `users` (`id_users`, `id_rand`, `nome_completo`, `usuario`, `senha`, `email`, `nivel_acesso`, `empresa`, `funcao`, `cpf`, `cnpj`, `loja`, `telefone`, `endereco`, `bairro`, `cep`, `cidade`, `estado`, `troca_senha`, `status`, `nome_contato1`, `telefone_contato1`, `nome_contato2`, `telefone_contato2`) VALUES (:id_users, :id_rand, :nome_completo, :usuario, :senha, :email, :nivel_acesso,:empresa,:funcao,:cpf,:cnpj,:loja, :telefone, :endereco, :bairro, :cep, :cidade, :estado,:troca_senha,:status, :nome_contato1,:telefone_contato1, :nome_contato2,:telefone_contato2)";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array(
                    ':id_users' => $id_users,
                    ':id_rand' => $id_rand,
                    ':nome_completo' => $nome_completo,
                    'usuario'        => $usuario ,
                    'senha'        => $senha,
                    'email'        => $email,
                    'nivel_acesso'        => $nivel_acesso,
                    'empresa'        => $empresa,
                    'funcao'        => $funcao,
                    'cpf'        => $cpf,
                    'cnpj'        => $cnpj,
                    'loja'        => $loja,
                    'telefone'        => $telefone,
                    'endereco'        => $endereco,
                    'bairro'        => $bairro,
                    'cep'        => $cep,
                    'cidade'        => $cidade,
                    'estado'        => $estado,
                    'troca_senha'        => $troca_senha,
                    'status'        => $status,
                    'nome_contato1'        => $nome_contato1,
                    'telefone_contato1'        => $telefone_contato1,
                    'nome_contato2'        => $nome_contato2,
                    'telefone_contato2'        => $telefone_contato2
                ));
				$conn = NULL;
				ob_end_clean();
                echo "<script> alert('Usuário cadastrado com sucesso, aguarde a liberação do seu login!') </script>";
                echo "<script> window.location.href='index.php' </script>";
			}
			
		}catch (PDOException $e) {
			echo "Error : ".$e->getMessage();
		}
	}
?>