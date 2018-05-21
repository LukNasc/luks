<?php  
	session_start();
	require_once("../../sql/conexao.php");
	require_once("../includes/headPags.php");
	$banco=new Conectar();
	if($_GET['form']=="addAdmP"){
		if($_POST['id']==$_SESSION['id']){
			$_SESSION['erro']="id";
			header("location: ../../pags/adm.php");
		}else{
			$sql="SELECT nome FROM conta WHERE id=?;";
			$mostrar=$banco->getCon()->prepare($sql);
			$mostrar->bindParam(1,$_POST['id']);
			$mostrar->execute();
			if($mostrar->rowCount()>0){
				$sql="UPDATE conta SET adm=? WHERE id=?;";
				$atualiza=$banco->getCon()->prepare($sql);
				$atualiza->bindParam(1,$_POST['adm']);
				$atualiza->bindParam(2,$_POST['id']);
				$atualiza->execute();
				header("location: ../../pags/adm.php");
			}else{
				$_SESSION['erro']="idNExists";
				header("location: ../../pags/adm.php");
			}
		}
	}else if($_GET['form']=="deleteContaAdm"){
		$sqlAmigos="SELECT amigos.* FROM amigos INNER JOIN conta ON amigos.id_conta = conta.id;";
		$verifica=$banco->getCon()->query($sqlAmigos, PDO::FETCH_OBJ);
		$numero= $verifica->rowCount();
		$sqlPers="DELETE FROM personalizacao WHERE id_conta=?;";
		$cmd=$banco->getCon()->prepare($sqlPers);
		$cmd->bindParam(1, $_GET['id']);
		$cmd->execute();
		if($numero>0){
			$sqlDeleteAmigos="DELETE FROM amigos WHERE id_conta=?";
			$deletaAmigos=$banco->getCon()->prepare($sqlDeleteAmigos);
			$deletaAmigos->bindParam(1, $_GET['id']);
			$deletaAmigos->execute();
			$sqlDeleteAmigos2="DELETE FROM amigos WHERE id_amigo=?";
			$deletaAmigos2=$banco->getCon()->prepare($sqlDeleteAmigos2);
			$deletaAmigos2->bindParam(1, $_GET['id']);
			$deletaAmigos2->execute();
			$sql="DELETE FROM conta WHERE id=?;";
			$deleta=$banco->getCon()->prepare($sql);
			$deleta->bindParam(1, $_GET['id']);
			$deleta->execute();
		}else{
			$sql="DELETE FROM conta WHERE id=?;";
			$deleta=$banco->getCon()->prepare($sql);
			$deleta->bindParam(1, $_GET['id']);
			$deleta->execute();
		}
		$_SESSION['deleta']="sucesso";
		header("location: ../../pags/tabelas.php?id={$_GET['id']}");
	}else if($_GET['form']=="editarInfor"){
		$nome=trim($_POST['nome']);
		$sobrenome=trim($_POST['sobrenome']);
		if(!empty(trim($_POST['nome'])) && !empty(trim($_POST['sobrenome'])) && !empty($_POST['email']) && !empty($_POST['senha'])){
			if($_POST['senha']==$_POST['csenha']){
				$sql= "UPDATE conta SET nome=?, sobrenome=?, email=?, senha=? WHERE id=?;";
				$edita=$banco->getCon()->prepare($sql);
				$edita->bindParam(1, $nome);
				$edita->bindParam(2, $sobrenome);
				$edita->bindParam(3, $_POST['email']);
				$edita->bindParam(4, $_POST['senha']);
				$edita->bindParam(5, $_GET['id']);
				$edita->execute();
				$_SESSION['processo']="sucesso";
				$_SESSION['idUser']=$_GET['id'];
				header("location:../../pags/tabelas.php");
			}else{
				$_SESSION['idUser']=$_GET['id'];
			$_SESSION['processo']="erro";
			header("location: ../../pags/tabelas.php");	
			}
		}else{
			$_SESSION['idUser']=$_GET['id'];
			$_SESSION['processo']="erro";
			header("location: ../../pags/tabelas.php");
		}
	}
?>