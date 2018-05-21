<?php
session_start();
require_once("../sql/conexao.php");
$banco= new Conectar();
$sql="SELECT * FROM conta WHERE id=?;";
$mostrar=$banco->getCon()->prepare($sql);
$mostrar->bindParam(1,$_SESSION['id']);
$mostrar->execute();
$cor=$mostrar->fetch(PDO::FETCH_OBJ);
require_once("../control/includes/headPags.php");
echo "<body>";
require_once("../control/includes/menu.php");
echo "
	<div class=\"container modify\" style=\"border:solid #00a 2px;\">
		<h1 class=\"title\">Resultados da pesquisa \"{$_GET['search']}\"</h1>
		";
		$pesquisa="SELECT * FROM conta WHERE nome LIKE ?;";
		$busca="{$_GET['search']}%";
		$cmd=$banco->getCon()->prepare($pesquisa);
		$cmd->bindParam(1,$busca);
		$cmd->execute();
		$obj=$cmd->fetchAll(PDO::FETCH_ASSOC);
		if($_GET['search']!=null){
			if($cmd->rowCount()>0){
			echo "<div class=\"row\">";
			foreach ($obj as $linha) {
				echo "<a class=\"link hover\" href=\"perfil.php?amzd=true&idCon={$linha['id']}\">
						<div class=\"m col-md-6 hr-vertical-direita\">";
							echo"<center>";
							if($linha['foto']==null){
								if($linha['sexo']=="M"){
									echo "<img src=\"../img/semperfilM.jpeg\" width=\"100px\" height=\"100px\" style=\"border-radius:100%;\">";
								}else{
									echo "<img src=\"../img/semperfilF.jpeg\" width=\"100px\" height=\"100px\" style=\"border-radius:100%;\">";
								}
							}else{
								echo "<img src=\"../control/back/imagem.php?pag=perfil&idConta={$linha['id']}\" width=\"100px\" height=\"100px\" style=\"border-radius:100%;\">";
							}
						echo "</center>";
				echo"	</div>
						<div class=\"col-md-6\">
							<h3 style=\"margin-top:30px;color:#fff;\"><b>{$linha['nome']} {$linha['sobrenome']}</b></h3>
						</div>
					  </a>
					   <hr>
					 ";
			}
			echo "</div>";
		}else{
			echo "<br><br><center><h1>Nenhum resultado encontrado</h1></center><br><br><br><br>";
		}
		}else{
			echo "<script>window.history.back();</script>";
		}
echo "		
	</div>
	<br>
	<br>
	<br>
";

require_once("../control/includes/footer.php");
echo "</body>";  
?>
