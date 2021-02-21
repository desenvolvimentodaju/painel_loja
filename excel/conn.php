<?php

$host = "172.31.0.52";
$user = "administrator";
$senha = "Q!W@E#R$";
$banco = "db_daju";


$mysqli = new mysqli($host, $user, $senha, $banco);

if(mysqli_connect_errno()){
	printl("Não foi possivel conectar!", mysqli_connect_errno());
	exit();
}


?>