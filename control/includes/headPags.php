<!doctype HTML>
<html>
<head>

	<script src="../js/jquery.js"></script>
<!-- 	<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script> -->
	<script src="../js/ajax.js"></script>
<!-- 	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css"/>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/themes/bootstrap.min.css"/>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/themes/default.min.css"/>-->
	<script src="../stick/jquery.sticky.js"></script>
	<script src="../js/geral.js"></script>
	<link rel="stylesheet" type="text/css" href="../bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../bootstrap/dist/css/bootstrap-grid.css">
	<script src="../bootstrap/dist/js/bootstrap.js"></script>
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> -->
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/forma.css">
	<meta charset="utf-8">
	<meta lang="pt-br">	
</head>
<?php
 	$local=$_SERVER ['REQUEST_URI'];
	if(strstr($local, "/luks/control/back/")){
		require_once("../../sql/conexao.php");
	}else{
		require_once("../sql/conexao.php");
	}
	$banco=new Conectar(); 
	$sql="SELECT * FROM personalizacao WHERE id_conta=?;";
	$cmd=$banco->getCon()->prepare($sql);
	if(isset($_GET['amzd'])){
		$cmd->bindParam(1, $_GET['idCon']);
	}else{
		$cmd->bindParam(1, $_SESSION['id']);
	}
	$cmd->execute();
	$pers=$cmd->fetch(PDO::FETCH_OBJ);
	if(isset($cmd->id_conta)){
		if($pers->background!=null){
		echo "<style>
				body{
					background-image:url(imagem.php?pag=background&idConta={$_SESSION['id']});
				}
			 </style>";
	}
	}
?>