<?php 
session_start();
if(isset($_SESSION['adm'])){
	require_once("../sql/conexao.php");
	$banco= new Conectar();
	require_once("../control/includes/headPags.php");
	echo "<body style=\"background-color:#0A3AC1;\">";
	if(!isset($_SESSION['pagina'])){
		$_SESSION['pagina']=1;
	}
	if(isset($_SESSION['pagina'])){
		if($_SESSION['pagina']==1){
			echo "
				<script>
					window.onload=function(){ 
						alertify.alert(\"ATENÇÃO\",\"A PARTIR DE AGORA, QUALQUER MODIFICAÇÃO QUE VOCÊ FOR FAZER, SERÁ ABSOLUTA E NÃO TERÁ AVISOS DE SEGURANÇA\");
					}
				</script>
				";
		}
		$_SESSION['pagina']=0;
	}
	if(isset($_SESSION['erro'])){
		if($_SESSION['erro']=="id"){
				echo "<script type=\"text/javascript\">
						window.onload=function(){
							alertify.error('VOCÊ NÃO PODE MODIFICAR O ID QUE ESTÁ LOGADO'); 
						}
					</script>";
		}else if($_SESSION['erro']=="idNExists"){
				echo "<script type=\"text/javascript\">
						window.onload=function(){
							alertify.error('O ID DIGITADO NÂO EXISTE'); 
						}
					</script>";
					
		}
		unset($_SESSION['erro']);
	}
	echo"
	<div class=\"container modify\">
		<div class=\"row\">
			<div class=\"col-md-4\">
				<p class=\"title\">O QUE DESEJA FAZER?</p>
				<div class=\"divisoria\">
					<a onclick='formularios(\"ajax/conteudoAjax.php?form=addAdm\")' class=\"link-ajax\"><h4><b>Adiconar um novo adm</b></h4></a>
					<a onclick='formularios(\"ajax/conteudoAjax.php?form=modifyNome\")' class=\"link-ajax\"><h4><b>Modificar o nome do site</b></h4></a>
					<a onclick='formularios(\"ajax/conteudoAjax.php?form=modifyLogo\")' class=\"link-ajax\"><h4><b>Modificar logo do site</b></h4></a>
					<a onclick='formularios(\"ajax/conteudoAjax.php?form=modifyTexto\")' class=\"link-ajax\"><h4><b>Modificar Textos</b></h4></a>
					<a href=\"tabelas.php\" class=\"link-ajax\"><h4><b>Verificar Tabelas</b></h4></a>
				</div>
			</div>
			<div class=\"col-md-4\">
				<p class=\"title\">FORMULÁRIOS</p>
				<div class=\"divisoria\" id=\"formularios\">
					<br><br><br><br><br><br>
					<center><h2><b>ESCOLHA UMA AÇÂO</b></h2><center>
				</div>
			</div>
			<div class=\"col-md-4\">
				<p class=\"title\">ADMINISTRADOR</p>
				<div class=\"row\">
					<div class=\"col-md-12\">
						<center>";
							$sql="SELECT * FROM conta WHERE id=?;";
							$mostrar=$banco->getCon()->prepare($sql);
							$mostrar->bindParam(1,$_SESSION['id']);
							$mostrar->execute();
							$obj=$mostrar->fetch(PDO::FETCH_OBJ);
							if($obj->foto!=null){
								echo "<img src=\"../control/back/imagem.php?pag=perfil\" width=\"300px\" height=\"280px\"><br><br><br>";
							}else{
								if($obj->sexo=="M"){
									echo "<img src=\"../img/semperfilM.jpeg\" width=\"300px\" height=\"280px\"><br><br><br>";
								}else{
								echo "<img src=\"../img/semperfilF.jpeg\" width=\"300px\" height=\"280px\"><br><br><br>";
								}
							}
						echo "</center>
					</div>
					<div class=\"col-md-5\" style=\"border-right:solid 2px #fff;\">
						<h5 class=\"h5\"><b>ID:</b></h5>
						<h5 class=\"h5\"><b>Nome:</b></h5>
						<h5 class=\"h5\"><b>Email:</b></h5>
					</div>
					<div class=\"col-md-7\">
						<h5 class=\"h5\"><b>#{$_SESSION['id']}</b></h5>
						<h5 class=\"h5\"><b>{$_SESSION['nome']} {$_SESSION['sobrenome']}</b></h5>
						<h5 class=\"h5\"><b>{$_SESSION['email']}</b></h5>
					</div>
				</div>
			</div>
		</div>
		<p class=\"link-ajax\" onclick='window.history.back()'><b>Voltar</b></p>
	</div>
	";
	echo "</body>";
	echo "</html>"; 
}else{
	echo "<script>window.history.back()</script>";
}
?>	
<script>
	function formularios(valor){
		var url = valor;

		xmlRequest.open('GET',url,true);
		xmlRequest.onreadystatechange = mudancaEstado;
		xmlRequest.send(null);

		if (xmlRequest.readyState == 1) {
			document.getElementById('formularios').innerHTML = '';
		}

		return url;
	}

	function mudancaEstado(){
		if (xmlRequest.readyState == 4){
			document.getElementById('formularios').innerHTML = xmlRequest.responseText;
		}
	}
</script>
<script type='text/javascript'>
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