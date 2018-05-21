<?php 
require_once("../../sql/conexao.php");
$banco = new Conectar(); 
if($_GET['form']=="addAdm"){
	echo "
	<form action=\"../control/back/processaAdm.php?form=addAdmP\" method=\"post\">
	<center>
	<div class=\"form-inline\">
		<div class=\"form-group mx-sm-5 mb-2\">
			<h1 style=\"margin-left:20px;\"><b>SIM</b></h1>
			<input type=\"radio\" name=\"adm\" placeholder=\"TRUE\" class=\"form-control\" value=\"true\"  style=\"margin-left:20px; height:60px !important;\" required>
		</div>
		<div class=\"form-group mx-sm-5 mb-2\">
			<h1 style=\"margin-left:20px;\"><b>NÃO</b></h1>
			<input type=\"radio\" name=\"adm\" placeholder=\"FALSE\" class=\"form-control\" value=\"false\"style=\"margin-left:20px; height:60px !important;\"  required>
		</div>
	</div>
	
	<h1><b>ID DA CONTA</b></h1>
	<input type=\"number\" name=\"id\" placeholder=\"ID DA CONTA\" class=\"form-control\" required>
	<br>
	<button class=\"btn-edit adm\">TORNAR ADM</button>
	</center>
	</form>
	";
}else if($_GET['form']=="modifyNome"){
	echo "
	<form action=\"../control/back/processaAdm.php?form=modifyNomeP\" method=\"post\">
		<center>
			<h1><b>Nome atual</b></h1>
			<h4><b>LUK'S</b></h4>
			<h1><b>ID DA CONTA</b></h1>
			<input type=\"text\" name=\"nome\" placeholder=\"NOVO NOME\" class=\"form-control\" required>
			<br>
			<button class=\"btn-edit adm\">MODIFICAR NOME</button>
		</center>
	</form>
	";
}else if($_GET['form']=="modifyLogo"){
	echo "
	<form action=\"../control/back/processaAdm.php?form=modifyLogoP\" method=\"post\" enctype=\"multpart/form-data\">
	<center>
		<h1><b>logo atual</b></h1>
		<h4><img src=\"../img/logo.png\" width=\"200px\" height=\"100px\"></h4>
		<h1><b>NOVO LOGO</b></h1>
		<div class=\"custom-file\">
		  <input type=\"file\" class=\"custom-file-input\" id=\"customFileLang\" lang=\"pt\">
		  <label class=\"custom-file-label\" for=\"customFileLang\">Selecionar Arquivo</label>
		</div>
		<br>
		<button class=\"btn-edit adm\">MODIFICAR LOGO</button>
	</center>
	</form>
	
	<script type=\"text/javascript\">
		\$custom-file-text: (
	  	en: \"Browser\",
	  	es: \"Elegir\",
	  	pt:\"Pesquisar\"
	);
	</script>

	";
}else if($_GET['form']=="modifyTexto"){
	echo "
	<form action=\"../control/back/processaAdm.php?form=modifyLogoP\" method=\"post\">
		<center>
			<h1><b>ONDE?</b></h1>
			<label>Index</label>
			<input type=\"checkbox\" value=\"index\" name=\"pagina\">
			<br>
			<label>Home</label>
			<input type=\"checkbox\" value=\"index\" name=\"pagina\">
			<br>
			<label>Perfil</label>
			<input type=\"checkbox\" value=\"index\" name=\"pagina\">
			<br>
			<label>Termos de uso</label>
			<input type=\"checkbox\" value=\"index\" name=\"pagina\">
			<h1><b>Digite o texto</b></h1>
			<textarea class=\"textarea-adm\"></textarea>
			<br>
			<button class=\"btn-edit adm\">MODIFICAR LOGO</button>
		</center>
	</form>
	
	<script type=\"text/javascript\">
		\$custom-file-text: (
	  	en: \"Browser\",
	  	es: \"Elegir\",
	  	pt:\"Pesquisar\"
	);
	</script>

	";
}else if($_GET['form']=="dados"){
	$sqlConta="SELECT * FROM conta WHERE id=?;";
	$cmd=$banco->getCon()->prepare($sqlConta);
	$cmd->bindParam(1, $_GET['id']);
	$cmd->execute();
	$objFoto=$cmd->fetch(PDO::FETCH_OBJ);
	echo "
	<div class=\"row\">
		<div class=\"col-md-4\">
			<center><h5 class=\"h5\"><b>{$_GET['nome']} {$_GET['sobrenome']}</b></h5><center>";
			if($objFoto->foto==null){
				if($_GET['sexo']=="M"){
					echo "<img src=\"../img/semperfilM.jpeg\" width=\"100%\" height=\"100px\">";
				}else{
					echo "<img src=\"../img/semperfilF.jpeg\" width=\"100%\" height=\"100px\">";
				}
			}else{
				echo "<img src=\"../control/back/imagem.php?pag=perfil&idConta={$_GET['id']}\" width=\"100%\" height=\"100px\">";
			}

		$sql="SELECT amigos.*, conta.* FROM amigos INNER JOIN conta ON amigos.id_conta= conta.id WHERE conta.id=?;";
 		$mostrando=$banco->getCon()->prepare($sql);
 		$mostrando->bindParam(1, $_GET['id']);
 		$mostrando->execute();
 		$obj=$mostrando->fetch(PDO::FETCH_OBJ);				
 echo "</div>
 		<div class=\"col-md-6\">
 			<div class=\"col-md-4\">
 			
 				<h5><b>ID:</b></h5>
 				<h5><b>EMAIL:</b></h5>
 				<h5><b>SENHA:</b></h5>
 				<h5><b>ADM:</b></h5>
 				<h5><b>AMIGOS:</b></h5>
 			</div>
 			<div class=\"col-md-8\">
 				
 				<h5><b>{$_GET['id']}</b></h5>
 				<h5><b>{$_GET['email']}</b></h5>
 				<h5 class=\"senha\"><b>{$_GET['senha']}</b></h5>
 				<h5><b>{$_GET['adm']}</b></h5>";
 				if($mostrando->rowCount()>0){
 					echo "<h5><b>{$mostrando->rowCount()}</b></h5>";
 				}else{
 					echo "<h5><b>0</b></h5>";
 				}
 		echo"</div>
 		</div>
 		<div class=\"col-md-12\">
 			<div class=\"col-md-4\">
 				<br>
 				<center>
 					<h5><b>Editar Informações</b></h5>
 					<button class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal{$_GET['id']}edit\"><i class=\"material-icons\" style=\"margin-left:0px;\">edit</i></button>
 					<br>
 					<h5><b>Deletar Conta essa conta</b></h5>
 					<a href=\"../control/back/processaAdm.php?form=deleteContaAdm&id={$_GET['id']}\"><button class=\"btn btn-danger\" id=\"delete\"><i class=\"material-icons\" style=\"margin-left:0px;\">delete</i></button></a>
 				</center>
 			</div>
 			<div class=\"col-md-4\">
 				<br>
 				<center>
 					<h5><b>Verificar Amizades</b></h5>
 					<button class=\"btn btn-info\"><i class=\"material-icons\" style=\"margin-left:0px;\">share</i></button>
 					<h5><b>Verificar Pensamento</b></h5>
 					<button class=\"btn btn-info\"><i class=\"material-icons\" style=\"margin-left:0px;\">message</i></button>
 				</center>
 			</div>
 			<div class=\"col-md-4\">
 				<br>
 				<center>
 					<h5><b>Enviar um E-mail a essa conta</b></h5>
 					<button class=\"btn btn-success\"><i class=\"material-icons\" style=\"margin-left:0px;\">email</i></button>
 					<h5><b>Enviar um aviso a essa conta</b></h5>
 					<button class=\"btn btn-warning\"><i class=\"material-icons\" style=\"margin-left:0px;\">warning</i></button>
 				</center>
 			</div>
  		</div>
	</div>
	";
	#Modal
	echo "
		<div id=\"modal{$_GET['id']}edit\" class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"gridSystemModalLabel\">
	  <div class=\"modal-dialog modal-lg\" role=\"document\">
	    <div class=\"modal-content\">
	      <div class=\"modal-header\">
	      <h4 class=\"modal-title\" id=\"gridSystemModalLabel\" class=\"titulo-modal\">Editar Informações <i style=\"margin-left:10px;margin-top:2px;\" class=\"material-icons\">edit</i></h4>
	        <button type=\"button\" class=\"close close-modal\" data-dismiss=\"modal\" aria-label=\"Close\">#{$_GET['id']}</button>
	        
	      </div>
	      <div class=\"modal-body\">
	    	<div class=\"row\">  
			 	<div class=\"col-md-4\">";
			 		echo "<center><h5><b>{$_GET['nome']} {$_GET['sobrenome']}</b></h5></center>";
			 		if($objFoto->foto==null){
						if($_GET['sexo']=="M"){
							echo "<img src=\"../img/semperfilM.jpeg\" width=\"100%\" height=\"250px\">";
						}else{
							echo "<img src=\"../img/semperfilF.jpeg\" width=\"100%\" height=\"250px\">";
						}
					}else{
						echo "<img src=\"../control/back/imagem.php?pag=perfil\" width=\"100%\" height=\"250px\">";
					}
			echo"</div>
				<div class=\"col-md-8\">
					<form action=\"../control/back/processaAdm.php?form=editarInfor&id={$_GET['id']}\" method=\"post\" class=\"form-adm\">
						<div class=\"form-inline\">
							 <div class=\"form-group mb-2\">
							    <label>Nome</label>
							    <input type=\"text\" name=\"nome\" value=\"{$_GET['nome']}\" class=\"form-control rigth\" required>
							  </div>
							  <div class=\"form-group mb-2\">
							    <label>Sobrenome</label>
							    <input type=\"text\" name=\"sobrenome\"value=\"{$_GET['sobrenome']}\" class=\"form-control\" required>
							  </div> 
						</div>
						<br>
						<label>E-mail</label>
					  	<input type=\"email\" name=\"email\" value=\"{$_GET['email']} \"class=\"form-control\" required>
					  	<br>
					  	<div class=\"form-inline\">
							 <div class=\"form-group mb-2\">
							    <label>Senha</label>
							    <input type=\"text\" name=\"senha\" value=\"{$_GET['senha']}\" class=\"form-control rigth\" required>
							  </div>
							  <div class=\"form-group mb-2\">
							    <label>Confirmar Senha</label>
							    <input type=\"text\" name=\"csenha\"value=\"{$_GET['senha']}\" class=\"form-control\" required>
							  </div> 
						</div>
						<br>
						<button class=\"btn btn-success\" style=\"width:380px;\"> Salvar Informações de {$_GET['nome']}</button>
						</form>
				</div>
	       	</div>
	      </div>
	      <div class=\"modal-footer\">
	        <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Fechar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	";
	echo "
		<script>
			$('#modal{$_GET['id']}edit').modal();
		</script>
	";
}else{
	echo "FORMULARIO NÃO EXISTE";
}
?>
