<?php
session_start();
	require_once("../../sql/conexao.php");
	$banco= new Conectar();
	if ($_GET['pag']=="perfil") {
		$mostrarImg="SELECT foto FROM conta WHERE id=?;";
		$preparar = $banco->getCon()->prepare($mostrarImg);
		if(isset($_GET['idConta'])){
			$preparar-> bindParam(1, $_GET['idConta']);
		}else{
			$preparar-> bindParam(1, $_SESSION['id']);
		}
		$preparar->execute();
		$preparar->bindColumn(1, $imagem, PDO::PARAM_LOB );

		$arquivo = $preparar->fetch(PDO::FETCH_BOUND);

		header("Content-type: image");
		echo $imagem;
	}else if($_GET['pag']=="back"){
		$mostrarImg="SELECT background FROM personalizacao WHERE id_conta=?;";
		$preparar = $banco->getCon()->prepare($mostrarImg);
		if(isset($_GET['idCon'])){
			$preparar-> bindParam(1, $_GET['idCon']);
		}else{
			$preparar-> bindParam(1, $_SESSION['id']);
		}
		$preparar->execute();
		$preparar->bindColumn(1, $imagem, PDO::PARAM_LOB );

		$arquivo = $preparar->fetch(PDO::FETCH_BOUND);

		header("Content-type: image");
		echo $imagem;

	}
?>