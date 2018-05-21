<?php 
session_start();
if(isset($_SESSION['id'])){
	require_once("../sql/conexao.php");
	$banco= new Conectar();
	$sql="SELECT * FROM conta WHERE id=?;";
	$mostrar=$banco->getCon()->prepare($sql);
	$mostrar->bindParam(1,$_SESSION['id']);
	$mostrar->execute();
	$cor=$mostrar->fetch(PDO::FETCH_OBJ);
	require_once("../control/includes/headPags.php");
	if($pers->background==null){
		echo "<body>";
	}else{
		echo "<body style=\"background:url('../control/back/imagem.php?pag=back');background-attachment: fixed;background-size: 100% 100%;background-repeat: no-repeat;\">";
	}
			if(isset($_SESSION['exists'])){
				 if($_SESSION['exists']=="cadastro"){
				echo "<script type=\"text/javascript\">
					window.onload=function(){
						alertify.alert('SEJA BEM VINDO', 'Olá {$_SESSION['nome']}, seja bem vindo, essa é o seu feed, aqui você poderá visualizar as publicações de seus amigos e também publicar a sua! Se você deseja fazer alguma modificação, é só apertar no seu nome que está no menú acima, lá você poderá personalizar o seu perfil e feed como você desejar! Desejamos uma boa experiencia e qualquer problema é so nos notificarmos! Tchau ', function(){ alertify.success(':)'); });	
					}
				</script>";
			}else if($_SESSION['exists']=="logando"){
				echo "<script type=\"text/javascript\">
				window.onload=function(){
					alertify.success('SEJA BEM VINDO NOVAMENTE'); 
				}
				</script>";
				
			}
			unset($_SESSION['exists']);
			}
			require_once("../control/includes/menu.php");
			echo "
				<br>
				<div class=\"container white\">
					<div class=\"row\">
						<div class=\"col-md-4\">
						<div class=\"fixed div-modify\">";
						echo"<center><h3 class=\"title\" style=\"border:solid {$pers->cor} 2px;border-radius:10px 10px 0px 0px;margin-top:0px;background-color:{$pers->cor};\"><b>{$_SESSION['nome']} {$_SESSION['sobrenome']}</b></h3></center>";
							if($cor->foto!=null){
								echo "<img src=\"../control/back/imagem.php?pag=perfil\" class=\"img-perfil-home\">";
							}else{
								if($cor->sexo=="M"){
									echo "<img src=\"../img/semperfilM.jpeg\" class=\"img-perfil-home\">";
								}else{
								echo "<img src=\"../img/semperfilF.jpeg\" class=\"img-perfil-home\">";
								}
							}
							if(isset($pers->id_conta)){
								echo "<br>
							<div class=\"cinza\" style=\"height:250px;background-color:$pers->cor;border-radius:0px 0px 10px 10px;\">";
							}else{
								echo "<br>
							<div class=\"cinza\" style=\"height:250px;background-color:#000;border-radius:0px 0px 10px 10px;\">";
							}
						echo"
							</div>
						</div>
						</div>
						<div class=\"col-md-8\">
							<div class=\"posts hr-vertical-esquerda\">
							<h2><b>STATUS</b></h2>
							<div class=\"col-md-10\">
								<textarea name=\"status\" id=\"status\" class=\"status\">COMPARTILHE SEU DIA!</textarea>
								<img id=\"img\" style=\"width:60px;height:60px;\" >
							</div>

							<div class=\"col-md-2\">
							<button onclick='postar();' class=\"btn btn-simples\" style=\"background-color:{$pers->cor};margin-bottom:10px;\"><i class=\"material-icons icon-branco\">send</i></button>
							<form>
								<label for=\"Editar\"><span class=\"btn btn-simples\" style=\"background-color:{$pers->cor}\"><i class=\"material-icons icon-branco\">camera_alt</i></span></label>
								 <div class=\"input\">
								     <input type=\"file\" id=\"Editar\" name=\"post\" class=\"editar\" onchage=\"imagepreview(this)\">
								 </div>
							</form>
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
							<div id=\"postagens\">";
							$amigos2 ="SELECT * FROM amigos INNER JOIN conta ON amigos.id_conta = conta.id WHERE amigos.id_conta=?; ";
									$processa2=$banco->getCon()->prepare($amigos2);
									$processa2->bindParam(1, $_SESSION['id']);
									$processa2->execute();
									$obj=$processa2->fetchAll(PDO::FETCH_OBJ);
									$posts="SELECT posts.*, conta.* FROM posts INNER JOIN conta ON posts.id_conta= conta.id WHERE id_conta=? ORDER BY posts.id DESC;";									
									$cmd=$banco->getCon()->prepare($posts);
									foreach ($obj as $linha) {
										$cmd->bindParam(1, $linha->id_amigo);
									}
									$cmd->execute();
									$forP=$cmd->fetchAll(PDO::FETCH_ASSOC);
									foreach ($forP as $line) {
										echo "<div class=\"dados-publicacao col-md-12\" id=\"teste\">";
										echo "<div class=\"col-md-2\">";
											if($line['foto']!=null){
												echo "<img src=\"../control/back/imagem.php?pag=perfil\" class=\"perfil-icon\">";
											}else{
												if($line['sexo']=="M"){
													echo "<img src=\"../img/semperfilM.jpeg\" class=\"perfil-icon\">";
												}else{
													echo "<img src=\"../img/semperfilF.jpeg\" class=\"perfil-icon\">";
												}
											}
										echo" </div>";
										echo "<div class=\"col-md-8\">
												<h3 style=\"margin-top:20px;\"><b>{$line['nome']} {$line['sobrenome']}</b></h3>
										      </div>";
										echo "<div class=\"col-md-2\">
												<h5 style=\"margin-top:20px;\"><b>{$line['data_post']} {$line['hora_post']}</b></h5>
											  </div>
										";
									echo "</div>";
									echo "<div class=\"col-md-12 publicacao\">
											<b>{$line['legenda_post']}</b>";
											if($line['img_post']!=null){
												echo "<img src=\"imagem.php?pag=post?idCon={$line['id_conta']}\">";
											}
										  
									echo "</div><br>";
									
									}
								$selectPosts="SELECT posts.*, conta.* FROM posts INNER JOIN conta ON posts.id_conta= conta.id WHERE id_conta=?  ORDER BY posts.id DESC;";
								$cmdPosts=$banco->getCon()->prepare($selectPosts);
								$cmdPosts->bindParam(1, $_SESSION['id']);
								$cmdPosts->execute();
								$objPosts=$cmdPosts->fetchAll(PDO::FETCH_ASSOC);
								if($cmdPosts->rowCount()>0){
									foreach ($objPosts as $linha) {
									echo "<div class=\"dados-publicacao col-md-12\" id=\"teste\">";
										echo "<div class=\"col-md-2\">";
											if($linha['foto']!=null){
												echo "<img src=\"../control/back/imagem.php?pag=perfil\" class=\"perfil-icon\">";
											}else{
												if($linha['sexo']=="M"){
													echo "<img src=\"../img/semperfilM.jpeg\" class=\"perfil-icon\">";
												}else{
													echo "<img src=\"../img/semperfilF.jpeg\" class=\"perfil-icon\">";
												}
											}
										echo" </div>";
										echo "<div class=\"col-md-8\">
												<h3 style=\"margin-top:20px;\"><b>{$linha['nome']} {$linha['sobrenome']}</b></h3>
										      </div>";
										echo "<div class=\"col-md-2\">
												<h5 style=\"margin-top:20px;\"><b>{$linha['data_post']} {$linha['hora_post']}</b></h5>
											  </div>
										";
									echo "</div>";
									echo "<div class=\"col-md-12 publicacao\">
											<b>{$linha['legenda_post']}</b>";
											if($linha['img_post']!=null){
												echo "<img src=\"imagem.php?pag=post?idCon={$linha['id_conta']}\">";
											}
										  
									echo "</div><br>";
									
									}
								}else{
									
								}
								
									

			echo"			</div>
							</div>
						</div>
					</div>
				</div>";
				require_once("../control/includes/footer.php");				
		echo"</body>
		</html>

		<script>
		  $(document).ready(function(){
		    $(\".fixed\").sticky({topSpacing:5, bottomSpacing:360});
		  });
		</script>
		";

    }else{
    	header("Location: ../index.php");
    }

    ?>