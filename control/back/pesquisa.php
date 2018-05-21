<?php 
	require_once("../../sql/conexao.php");
	$con=new Conectar();
	$sql="SELECT * FROM conta WHERE nome LIKE ?;";
	$pesquisa="{$_GET['p']}%";
	$cmd=$con->getCon()->prepare($sql);
	$cmd->bindParam(1, $pesquisa);
	$cmd->execute();
	$obj=$cmd->fetchAll(PDO::FETCH_ASSOC);
	if($_GET['p']!=null){
		echo "<ol class=\"return\">";
		if ($cmd->rowCount()>0) {
		foreach ($obj as $linha) {
			echo "<a class=\"link\" style=\"margin-left:15px;\" href=\"../pags/perfil.php?amzd=true&idCon={$linha['id']}\"><li>";
			if($linha['foto']==null){
				if($linha['sexo']=="M"){
					echo "<img src=\"../img/semperfilM.jpeg\" width=\"60px\" height=\"60px\" style=\"border-radius:100%;margin-right:30px;;\">";
				}else{
					echo "<img src=\"../img/semperfilF.jpeg\" width=\"60px\" height=\"60px\" style=\"border-radius:100%;margin-right:30px;;\">";
				}
			}else{
				echo "<img src=\"../control/back/imagem.php?pag=perfil&idConta={$linha['id']}\" width=\"60px\" height=\"60px\" style=\"border-radius:100%;margin-right:30px;;\">";
			}
			echo "{$linha['nome']}";
		echo "</li></a>";
		}
	}else{
		echo "<li>Nenhum resultado encontrado</li>";
	}
	echo "</ol>";
	}
	
?>