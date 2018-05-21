<?php
session_start();
require_once("../../sql/conexao.php");
$banco=new Conectar();
if($_GET['form']=="log"){
	$email=trim(strtolower($_POST['email']));
	$senha=$_POST['senha'];
	if(!empty($email) && !empty($senha)){
		$sql= "SELECT * FROM conta WHERE email=?;";
		$ver=$banco->getCon()->prepare($sql);
		$ver->bindParam(1,$_POST['email']);
		$ver->execute();
		$obj=$ver->fetch(PDO::FETCH_OBJ);
			if($obj->senha==$_POST['senha']){
				$_SESSION['id']=$obj->id;
				$_SESSION['nome']=$obj->nome;
				$_SESSION['sobrenome']=$obj->sobrenome;
				$_SESSION['email']=$email;
				$_SESSION['senha']=$senha;
				$_SESSION['exists']="logando";
				header("Location: ../../index.php");
			}else{
				#CONTA INEXISTENTE
				$_SESSION['notExists']=1;
				header("Location: ../../index.php");
			}
	}else{
		#CAMPOS COM ERROS
		echo "nenhum campo pode esta vazio";
		header("Location: ../../index.php");
	}
}else if($_GET['form']=="cad"){
	$lista="\\;\"\";#;*; ;(;);[;{;};];-;123456789;!;@;$;%;¨;&;/;?;°";
	$nome=trim($_POST['nome'], $lista);
	$sobrenome=trim($_POST['snome'], $lista);
	$email=trim(strtolower($_POST['email']));
	$senha=$_POST['senha'];
	$csenha=$_POST['csenha'];
	$sexo=$_POST['sexo'];
	$termos=$_POST['termos'];
	if(!empty($nome)&&!empty($sobrenome)&&!empty($email)&&!empty($senha)&&!empty($sexo)&&!empty($termos)){
		$sql= "SELECT * FROM conta WHERE email=?;";
		$ver=$banco->getCon()->prepare($sql);
		$ver->bindParam(1,$email);
		$ver->execute();
		if($ver->rowCount()==0){
			if($_POST['senha']==$_POST['csenha']){
				$cadastro="INSERT INTO conta(nome,sobrenome,email,senha,sexo) VALUES(?,?,?,?,?);";
			$cadastrar=$banco->getCon()->prepare($cadastro);
			$cadastrar->bindParam(1,$nome);
			$cadastrar->bindParam(2,$sobrenome);
			$cadastrar->bindParam(3,$email);
			$cadastrar->bindParam(4,$senha);
			$cadastrar->bindParam(5,$sexo);
			$cadastrar->execute();
			$sql2= "SELECT * FROM conta WHERE email=?;";
			$ver2=$banco->getCon()->prepare($sql);
			$ver2->bindParam(1,$email);
			$ver2->execute();
			$obj2=$ver2->fetch(PDO::FETCH_OBJ);
			$_SESSION['id']=$obj2->id;
			$_SESSION['nome']=$obj2->nome;
			$_SESSION['sobrenome']=$obj2->sobrenome;
			$_SESSION['senha']=$obj2->senha;
			$_SESSION['email']=$obj2->email;
			$personal="INSERT INTO personalizacao(id_conta) VALUES(?);";
			$cmd=$banco->getCon()->prepare($personal);
			$cmd->bindParam(1, $_SESSION['id']);
			$cmd->execute();
			$_SESSION['exists']="cadastro";
			header("Location: ../../pags/home.php");
		}else{
			$_SESSION['senha']="diferentes";
			header("Location: ../../pags/cadastro.php");
		}
		}else{
			$_SESSION['exists']="email";
			header("Location: ../../pags/cadastro.php");
		}
	}else{
		$_SESSION['empty']=1;
			header("Location: ../../pags/cadastro.php");
	}
}else if($_GET['form']=="cor"){
	$sql="UPDATE personalizacao SET cor=? WHERE id_conta=?";
	$cor=$banco->getCon()->prepare($sql);
	$cor->bindParam(1,$_POST['cor']);
	$cor->bindParam(2,$_SESSION['id']);
	$cor->execute();
	header("location: ../../pags/perfil.php");
}else if($_GET['form']=="addfoto"){
	 $foto=$_FILES['foto'];
	 if(isset($foto['name']) && isset($foto['error'])==1){
	 	$nome=$foto['name'];
	 	$arquivo=$foto['tmp_name'];
	 	$extensao= strtolower(pathinfo($nome, PATHINFO_EXTENSION));
	 	$fotosPermitidas="png;jpg;jpeg";
		 	if(strstr($fotosPermitidas, $extensao)){
		 		$imagem=fopen($arquivo, "rb");
		 		$sql="UPDATE conta SET foto=? WHERE id=?;";
		 		$cmd=$banco->getCon()->prepare($sql);
		 		$cmd->bindParam(1,$imagem, PDO::PARAM_LOB);
		 		$cmd->bindParam(2, $_SESSION['id']);
		 		$cmd->execute();
		 		echo "<script>window.history.back();</script>";
		 	}else{
		 		$_SESSION['erro']="permitido";
		 		echo "<script>window.history.back();</script>";
		 	}
	 }else{
	 	$_SESSION['erro']="enviado";
	 	echo "<script>window.history.back();</script>";
	 }
}else if($_GET['form']=="amzd"){
	$sql="INSERT INTO amigos(data_amizade, id_conta, id_amigo) VALUES(?,?,?);";
	$data=date("d-m-Y");
	$cmd=$banco->getCon()->prepare($sql);
	$cmd->bindParam(1, $data);
	$cmd->bindParam(2, $_SESSION['id']);
	$cmd->bindParam(3, $_GET['idCon']);
	$cmd->execute();
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
}else if($_GET['form']=="rmamzd"){
	$sql="DELETE FROM amigos WHERE  id_amigo=?;";
	$cmd=$banco->getCon()->prepare($sql);
	$cmd->bindParam(1, $_GET['idCon']);
	$cmd->execute();
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
}else if($_GET['form']=="status"){
	if(!isset($_GET['foto']) || $_GET['foto']==""){
		$sql="INSERT INTO posts(data_post, hora_post,id_conta,legenda_post) VALUES(?,?,?,?);";
	}else{
		$sql="INSERT INTO posts(data_post, hora_post,id_conta,img_post,legenda_post) VALUES(?,?,?,?,?);";
	}
	date_default_timezone_set('America/Fortaleza');
	$data=date("d-m-Y");
	$hora_local=date("H:i"); 
	$cmd=$banco->getCon()->prepare($sql);
	if(!isset($_GET['foto']) || $_GET['foto']==""){
		$cmd->bindParam(1, $data);
		$cmd->bindParam(2, $hora_local);
		$cmd->bindParam(3, $_SESSION['id']);
		$cmd->bindParam(4, $_GET['status']);
	}else{
		$cmd->bindParam(1, $data);
		$cmd->bindParam(2, $hora_local);
		$cmd->bindParam(3, $_SESSION['id']);
		$cmd->bindParam(4, $_GET['foto']);
		$cmd->bindParam(5, $_GET['status']);
	}
	
	$cmd->execute();
	$selectPosts="SELECT posts.*, conta.* FROM posts INNER JOIN conta ON posts.id_conta= conta.id WHERE id_conta=? ORDER BY posts.id DESC;";
	$cmdPosts=$banco->getCon()->prepare($selectPosts);
	$cmdPosts->bindParam(1, $_SESSION['id']);
	$cmdPosts->execute();
	$objPosts=$cmdPosts->fetchAll(PDO::FETCH_ASSOC);
	if($cmdPosts->rowCount()>0){
		foreach ($objPosts as $linha) {
			echo "<div class=\"dados-publicacao col-md-12\">";
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
						echo "<img src=\"imagem.php?pag=perfil&idCon={$linha['id_conta']}\">";
					}
				  
			echo "</div><br>";
			
			}
	}else{
		echo "<div class=\"col-md-12\"><center><h2>Nada para mostrar</h2><h5>Adicione seguidores ou faça uma publicação agora mesmo</h5></ceneter></div>";
		}
}else if($_GET['form']=="addfotoBack"){
	$foto=$_FILES['foto'];
	if(isset($foto['name']) && isset($foto['error'])==1){
	 	$arquivo=$_FILES['foto']['tmp_name'];
	 	$nome=$_FILES['foto']['name'];
	 	$extensao= strtolower(pathinfo($nome, PATHINFO_EXTENSION));
	 	$fotosPermitidas="png;jpg;jpeg";
		 	if(strstr($fotosPermitidas, $extensao)){
		 		$imagem=fopen($arquivo, "rb");
		 		$sql="UPDATE personalizacao SET background=? WHERE id_conta=?;";
		 		$cmd=$banco->getCon()->prepare($sql);
		 		$cmd->bindParam(1,$imagem, PDO::PARAM_LOB);
		 		$cmd->bindParam(2, $_SESSION['id']);
		 		$cmd->execute();
		 		echo "<script>window.history.back();</script>";
		 	}else{
		 		$_SESSION['erro']="permitido";
		 		echo "<script>window.history.back();</script>";
		 	}
	 }else{
	 	$_SESSION['erro']="enviado";
	 	echo "<script>window.history.back();</script>";
	 }
}else if($_GET['form']=="rmBack"){
	$sql="UPDATE personalizacao SET background=null WHERE id_conta=?;";
	$cmd=$banco->getCon()->prepare($sql);
	$cmd->bindParam(1, $_SESSION['id']);
	$cmd->execute();
	echo"<script>window.history.back()</script>";
}else if($_GET['form']=="rmPerfil"){
	$sql="UPDATE conta SET foto=null WHERE id=?;";
	$cmd=$banco->getCon()->prepare($sql);
	$cmd->bindParam(1, $_SESSION['id']);
	$cmd->execute();
	echo"<script>window.history.back()</script>";
}
?>