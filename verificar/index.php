<?php
    if (!isset($_SESSION)) session_start();
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    if(@$_SESSION['user_logado'] == 1 && isset($_SESSION['nivel_acesso'])){
        echo "<script> window.location.href='../index.php' </script>";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Login</title>
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
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100" style="overflow: auto;">
				<div class="login100-pic logo-img align-center">
					<img src="images/daju-logo.png" alt="IMG">
                    <span class="w-100 d-flex justify-content-center"><strong>Acompanhamento de Vendas</strong></span>
				</div>

				<form class="login100-form validate-form" action="verificar.php" method="POST">
					<span class="login100-form-title">
						Login usuário
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Insira um usuário válido: Nome Exemplo ou 1234">
						<input class="input100" type="text" name="user_name" placeholder="Login" autofocus>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Insira uma senha">
						<input class="input100" type="password" name="pass" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" name="login" class="login100-form-btn">
							Login
						</button>
					</div>
					<!-- <div class="text-center p-t-12">
						<span class="txt1">
							Esqueceu 
						</span>
						<a class="txt2" href="resetsenha.php">
							Login / Senha?
						</a>
					</div>
					<div class="text-center p-t-1">
						<a class="txt2" href="new_user.php">
							Criar conta
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="false"></i>
						</a>
					</div>-->
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
			scale: 1.2
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>