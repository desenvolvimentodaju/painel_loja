<?php
    if (!isset($_SESSION)) session_start();
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    if(@$_SESSION['user_logado'] == 1){
        $usuario = $_SESSION['usuario'];
    }else{
        $usuario = '';
    }
    if(isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] <> 1){
        $visu = "hidden";
    }else{
        $visu = "visibilitty";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Esqueceu a senha</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
<!--===============================================================================================-->
<script src='http://momentjs.com/downloads/moment.min.js'></script>
    <link rel="icon" type="image/png" href="images/icons/daju-logo-icon.png"/>
    <link rel="stylesheet" href="css/portal.css">
    <link rel="stylesheet" href="css/util.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.css">
    <script src="js/jquery-3.4.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="js/arquivos_validar_ajax.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/arquivos_ajax.js"></script>
    <link rel="icon" type="image/png" href="images/icons/daju-logo-icon.png"/>
    <link rel="stylesheet" href="css/icofont/icofont.min.css">
    <link href="css/fontawesome/css/all.css" rel="stylesheet"> 
    <link rel="stylesheet" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100" style="padding-top: 120px">
				<div class="login100-pic">
					<img src="images/daju-logo.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="" method="POST" autocomplete="off">
					<span class="login100-form-title">
						Nova Senha
					</span>

                    <div class="wrap-input100 validate-input" data-validate = "Insira um email válido: ex@abc.xyz">
						<input class="input100" type="text" name="usuario" placeholder="Nome de usuário" value="<?php echo $usuario; ?>" autofocus>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user-circle" aria-hidden="true"></i>
						</span>
					</div>

                    <div class="wrap-input100 validate-input" data-validate = "Insira um número válido, ex.: 666.666.666-66">

						<input class="inputmask input100" id="cpfcnpj" type="text" name="cpf" placeholder="Cpf do colaborador" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-certificate" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Insira a nova senha">
						<input class="input100" type="password" name="pass" placeholder="Nova senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="submit" name="trocar" class="login100-form-btn" >
							Mudar Senha
						</button>
					</div>

					<div class="text-center p-t-1">
						<a class="txt2" href="index.php">
							<i class="fa fa-arrow-left m-l-5" aria-hidden="false"></i>
							Voltar
						</a>
					</div>
				</form>
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
    date_default_timezone_set('America/Sao_Paulo');
    if(isset($_POST['trocar'])){
        if(!empty($_POST['usuario'])){
            if(!empty($_POST['cpf'])){
                    if(!empty($_POST['pass'])){
                        try{
                            $usuario = $_POST['usuario'];
                            $cpf = $_POST['cpf'];
                            $crip = $_POST['pass'];
                            $senha = md5($crip);
                            echo $senha;
                            echo $crip;
                            $sql = "SELECT * FROM users WHERE usuario = '$usuario' AND cpf = '$cpf'";
                            include_once("conn_acesso.php");
                            //verificar se existe no banco
                            $stmt = $conn_acesso->prepare($sql);
                            $stmt->bindParam('usuario', $usuario, PDO::PARAM_STR);
                            $stmt->bindParam('cpf', $cpf, PDO::PARAM_STR);
                            $stmt->bindParam('senha', $senha, PDO::PARAM_STR);
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            $row   = $stmt->fetch(PDO::FETCH_ASSOC);
                            if($count == 1 && !empty($row)){
                                //conexao com PDO
                                include("conn_acesso.php");
                                if($mysqli->query("UPDATE users SET senha = '$senha',troca_senha = 0 WHERE usuario = '$usuario' AND cpf = '$cpf'")){
                                    echo"<script> alert('Senha alterada com sucesso!') </script>";
                                    echo "<script> window.location.href='index.php' </script>";
                                }else{
                                    echo"<script> alert('Erro ao mudar senha') </script>";
                                }
                                mysqli_close($mysqli);
                            }else{
                                echo"<script> alert('Nome de usuário ou cpf não encontrados!') </script>";
                            }
                        }catch (PDOException $e){
                            echo"<script> alert('Nome de usuário ou senha não encontrados!') </script>";
                            echo "Error : ".$e->getMessage();
                        }
                    }else{
                        echo("<script> alert('Digite o cpf!!') </script>");
                    }
            }else{
                echo("<script> alert('Digite um cpf!!') </script>");
            }
        }else{
            echo("<script> alert('Digite um login!!') </script>");
            // echo "<script> window.location.href='index.php' </script>";
        }
    }
?>