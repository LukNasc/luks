<?php 
session_start();
if(isset($_SESSION['adm'])){
	require_once("../sql/conexao.php");
	$banco= new Conectar();
	require_once("../control/includes/headPags.php");
	echo "<body style=\"background-color:#0A3AC1;\">";
	if(isset($_SESSION['deleta'])){
		if($_SESSION['deleta']=="sucesso"){
			echo "<script type=\"text/javascript\">
			window.onload=function(){
				alertify.success('CONTA DE ID Nº{$_GET['id']} REMOVIDA COM SUCESSO'); 
			}
			</script>";
		}
		unset($_SESSION['deleta']);
	}
	if(isset($_SESSION['processo'])){
		if($_SESSION['processo']=="sucesso"){
			echo "<script type=\"text/javascript\">
			window.onload=function(){
				alertify.success('CONTA DE ID Nº {$_SESSION['idUser']} ATUALIZADA COM SUCESSO'); 
			}
			</script>";
		}else{
			echo "<script type=\"text/javascript\">
			window.onload=function(){
			alertify.error('OCORREU ALGUM ERRO AO ATUALIZAR A CONTA DE ÍD Nº {$_SESSION['idUser']}'); 
			}
			</script>";
		}
		unset($_SESSION['processo']);
		unset($_SESSION['idUser']);
	}
	echo "<div class=\"container modify\" style=\"margin-top:15px;\">
	<h1 class=\"title\">TABELA(S)</h1>
	<div class=\"row\">
	<div class=\"col-md-6\">
	<h3 class=\"title\"><b>Contas</b></h3>";
	$sql="SELECT * FROM conta;";
	$mostrar=$banco->getCon()->query($sql, PDO::FETCH_OBJ);
	echo "<div class=\"divisoria\">";
	foreach ($mostrar as $linha) {
		echo "
		<a class=\"link-ajax\" onclick='dados(\"ajax/conteudoAjax.php?form=dados&id={$linha->id}&nome={$linha->nome}&sobrenome={$linha->sobrenome}&email={$linha->email}&senha={$linha->senha}&adm={$linha->adm}&sexo={$linha->sexo}&cor={$pers->cor}\")'><h4><b>{$linha->id} - {$linha->nome} {$linha->sobrenome}</b></h4></a>
		";
	}
	echo "</div>";
	echo "</div>
	<div class=\"col-md-6\">
	<h2 class=\"title\"><b>Dados</b></h2>
	<div class=\"divisoria\" id=\"dados\"></div>
	</div>
	</div>
	<p class=\"link-ajax\" onclick='window.history.back()'><b>Voltar</b></p>
	</div>";
	echo "</body>
	</html>
	";
}else{
	echo "<script>window.history.back();</script>";
}

?>
<script type='text/javascript'>
	function dados(valor){
		var url = valor;

		xmlRequest.open('GET',url,true);
		xmlRequest.onreadystatechange = mudancaEstado;
		xmlRequest.send(null);

		if (xmlRequest.readyState == 1) {
			document.getElementById('dados').innerHTML = '';
		}

		return url;
	}
                                                                                                                                                              
	function mudancaEstado(){
		if (xmlRequest.readyState == 4){
			document.getElementById('dados').innerHTML = xmlRequest.responseText;
		}
	}
	function GetXMLHttp() {
		if(navigator.appName == 'Microsoft Internet Explorer') {
			xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		else {
			xmlHttp = new XMLHttpRequest();
		}
		return xmlHttp;
	}

	var xmlRequest = GetXMLHttp();
</script>
