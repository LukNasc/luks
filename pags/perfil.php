<?php
	session_start();
	if(isset($_SESSION['id']) || isset($_GET['amzd'])){
		if(isset($_GET['idCon'])){
			if($_GET['idCon']==$_SESSION['id']){
				header("location: perfil.php");	
			}
		}
		require_once("../sql/conexao.php");
		$banco= new Conectar();
		require_once("../control/includes/headPags.php");
		if($pers->background==null){
		echo "<body>";
		}else{
			echo "<body style=\"background:url('../control/back/imagem.php?pag=back');background-attachment: fixed;background-size: 100% 100%;background-repeat: no-repeat;\">";
		}
		require_once("../control/includes/menu.php");
		if(isset($_SESSION['erro'])){
			if($_SESSION['erro']=="permitido"){
				echo "<script>window.onload=function(){
						alertify.error('ARQUIVO NÃO PERMITIDO'); 
					}</script>";
			}else if($_SESSION['erro']=="enviado"){
				echo "<script>window.onload=function(){
						alertify.error('ARQUIVO NÃO ENVIADO'); 
					}</script>";
			}
			unset($_SESSION['erro']);
		}
		echo "
			<div class=\"container white\">
				<div class=\"row\">
					<div class=\"col-md-4\">";
								$sql="SELECT * FROM conta WHERE id=?;";
								$mostrar=$banco->getCon()->prepare($sql);
								if(isset($_GET['amzd'])){
									$mostrar->bindParam(1,$_GET['idCon']);
								}else{
									$mostrar->bindParam(1,$_SESSION['id']);
								}
								$mostrar->execute();
								$obj=$mostrar->fetch(PDO::FETCH_OBJ);
								echo "<center>";
								if($obj->foto==null){
									if($obj->sexo=="M"){
									echo "<img src=\"../img/semperfilM.jpeg\" class=\"img-perfil\"><br><br><br>";
									}else{
									echo "<img src=\"../img/semperfilF.jpeg\" class=\"img-perfil\"><br><br><br>";
									}
								}else{
									if(isset($_GET['idCon'])){
										echo "<img src=\"../control/back/imagem.php?pag=perfil&idConta={$_GET['idCon']}\" class=\"img-perfil\"><br><br><br>";
									}else{
										echo "<img src=\"../control/back/imagem.php?pag=perfil\" class=\"img-perfil\"><br><br><br>";
									}
								}
								echo "</center>";
							if(isset($_GET['amzd'])){
								echo"<div id=\"divphp\">";
								$sqlAmigos="SELECT * FROM amigos WHERE id_conta=?;";
								$cmdAmigos=$banco->getCon()->prepare($sqlAmigos);
								$cmdAmigos->bindParam(1, $_SESSION['id']);
								$cmdAmigos->execute();
								if($cmdAmigos->rowCount()>1){
									$objAmigos=$cmdAmigos->fetchAll(PDO::FETCH_OBJ);
									foreach ($objAmigos as $linha) {
										if($linha->id_amigo==$_GET['idCon']){
											echo "<center><button class=\"btn btn-danger btn-solit\" onclick=\"removeAmzd({$_GET['idCon']});\">Deixar de Seguir</button></center>";
										}
									}
								}else{
									$objAmigos=$cmdAmigos->fetch(PDO::FETCH_OBJ);
									if($cmdAmigos->rowCount()==1){
										if($objAmigos->id_amigo==$_GET['idCon']){
											echo "<center><button class=\"btn btn-danger btn-solit\" onclick=\"removeAmzd({$_GET['idCon']});\">Deixar de Seguir</button></center>";
										}else{
											echo "<center><button class=\"btn btn-success btn-solit\" onclick=\"solicitAmzd({$_GET['idCon']});\">Seguir</button></center>";
										}
									}else{
										echo "<center><button class=\"btn btn-success btn-solit\" onclick=\"solicitAmzd({$_GET['idCon']});\">Seguir</button></center>";
									}
								}
								echo"</div>";
								#echo "<center><button class=\"mudarPerfil btn-danger\" onclick=\"removeAmzd({$_GET['idCon']});\">Deixar de seguir</button></center>";
							}else{
								echo"<center><button class=\"mudarPerfil\" data-toggle=\"modal\" data-target=\"#mudarPerfil\">Clique para mudar a foto perfil</button></center>";

								#Modal
							echo "	<div class=\"modal fade\" id=\"mudarPerfil\">
									  <div class=\"modal-dialog\" role=\"document\">
									    <div class=\"modal-content\">
									      <div class=\"modal-header\">
									        <h3 class=\"modal-title\"><b style=\"color:#fff;\">Mudar foto de perfil</b></h3>
									        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
									          <span aria-hidden=\"true\"><i class=\"material-icons\">close</i></span>
									        </button>
									      </div>
									      <div class=\"modal-body\">
									          <form action=\"../control/back/processa.php?form=addfoto\" method=\"post\" enctype=\"multipart/form-data\">
										         <center><label for=\"Editar\"><span class=\"file btn \" id=\"label\">Mudar foto de perfil</span></label></center>
										         <div class=\"input\">
												     <input type=\"file\" id=\"Editar\" name=\"foto\" class=\"editar\" onchage=\"imagepreview(this)\">
												     <center><img id=\"img\" style=\"width:300px;height: 168px;\" ></center>
												 </div>
									      </div>
									      <div class=\"modal-footer\">
									        <input type=\"submit\" class=\"btn btn-success\" value=\"Salvar Mudança\">
									        </form>
									        <a href=\"../control/back/processa.php?form=rmPerfil\"><button type=\"button\" class=\"btn btn-danger\">Remover foto</button></a>
									        <button type=\"button\" class=\"btn btn-secundary\" data-dismiss=\"modal\">Fechar</button>
									      </div>
									    </div>
									  </div>
									</div>
									 <script>
									$(function(){
										$('#Editar').change(function(){
											const file = $(this)[0].files[0]
											const fileReader = new FileReader()
												
											fileReader.onloadend = function(){
												$('#img').attr('src',fileReader.result)
											}
											fileReader.readAsDataURL(file)
										})
									})
								</script>	
											";
							}
					echo "</div>
					<div class=\"col-md-5\">
						<div class=\"perfil\">
							<h3 class=\"title\" style=\"background-color:{$pers->cor};\"><b>{$obj->nome} {$obj->sobrenome}</b></h3>
							<h4><b>Pensamento do Dia</b></h4>
							<div class=\"pensamento\">
								<p>
									Be sure to have your pages set up with the latest design and development standards. That means using an HTML5 doctype and including a viewport meta tag for proper responsive behaviors. Put it all together and your pages should look like this:
								</p>
							</div>";
							if(!isset($_GET['amzd'])){
								echo "
									<div class=\"icons\">
									<i class=\"material-icons\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Mudar Pensamento\">create</i>
									<i class=\"material-icons\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Deletar minha conta\">delete</i>
									<h5  style=\"float:right;margin-top:10px;margin-right:180px;\"><b>Mudar as cores do perfil</b></h5>
									<form action=\"../control/back/processa.php?form=cor\" method=\"post\">
										<input type=\"color\" name=\"cor\" value={$pers->cor} style=\"float:right;margin-top:-30px;margin-right:80px;\">
										<button style=\"border:none;background-color:#00a;padding:2px;color:#fff;float:right;margin-top:-32px;margin-right:20px;\">Mudar</button>
									</form>
									</div>
								";
							}else{
								echo "
									<div class=\"icons\" style=\"padding:20px;\">
										
									</div>
								";
							}
				echo"	</div>
					</div>
					<br>
					<div class=\"col-md-3\">
						";
						$amigos ="SELECT * FROM amigos INNER JOIN conta ON amigos.id_conta = conta.id WHERE amigos.id_amigo=?; ";
						$processa=$banco->getCon()->prepare($amigos);
						if(isset($_GET['amzd'])){
							$processa->bindParam(1, $_GET['idCon']);
						}else{
							$processa->bindParam(1, $_SESSION['id']);
						}
						$processa->execute();
	
						echo "<center>";
		 					echo "<h5 class=\"title\" style=\"background-color:{$pers->cor};\"><b>{$processa->rowCount()}";
		 					if($processa->rowCount()>1 || $processa->rowCount()==0){
		 					 echo " Seguidores";
		 					}else{
		 					echo " Seguidor";
		 					}
						echo "</b></5>";
		 				echo "</center>";
		 				echo "<h3><b>Em desenvolvimento</b></h3>";
						echo"
						<form>
						<input autocomplete=\"off\" type=\"search\" name=\"searchAm\" placeholder=\"Pesquisar Amizades\" id=\"searchCampoAm\" onkeyup='pesquisar()' style=\"margin-top:160px;padding:10px;width:100%;\">
						</form>
					</div>
				</div> <!--row-->
				<hr>
				<div class=\"row\">
					<div class=\"col-md-4\">
						<div class=\"divisoria\">

						</div>
					</div>
				</div>
			</div><!--container-->";
		require_once("../control/includes/footer.php");
		echo "</body>";
	}else{
		header("Location: ../index.php");
	}
	
?>
