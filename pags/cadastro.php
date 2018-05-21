<?php 
session_start();
require_once("../control/includes/headPags.php");
if(isset($_SESSION['id'])){
	header("location: home.php");
}else{
	if(isset($_SESSION['exists'])){
		if($_SESSION['exists']=="email"){
		echo "<script type=\"text/javascript\">
			window.onload=function(){
				alertify.error('ESSE EMAIL JÁ EXISTE'); 
			}
		</script>";
		session_destroy();
		}
	}
	if(isset($_SESSION['senha'])){
		if($_SESSION['senha']=="diferentes"){
		echo "<script type=\"text/javascript\">
			window.onload=function(){
				alertify.error('SUA CONFIRMAÇÃO DE SENHA ESTÁ INCORRETA'); 
			}
		</script>";
		session_destroy();
	}
	}
	echo "
		<body>
			<div class=\"container\">
				<center>
					<img src=\"../img/logo.png\" width=\"500px\" height=\"200px\" style=\"margin-bottom: -100px;\">
				</center>
					<div class=\"logar\" style=\"margin-left:35%; height:350px !important;\">

					<br>
					<form action=\"../control/back/processa.php?form=cad\" method=\"post\" name=\"cadastro\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<div class=\"form-inline\">
									<div class=\"form-group  mx-sm-0 mb-2\">
										<label>Nome</label>
										<input type=\"text\" name=\"nome\" placeholder=\"José\" class=\"form-control\" style=\"margin-right:10px;\" required>
									</div>
									<div class=\"form-group  mx-sm-0 mb-2\">
										<label>Sobrenome</label>
										<input type=\"text\" name=\"snome\" placeholder=\"Silva\" class=\"form-control\" required>
									</div>
								</div>
							
								<label>E-mail</label>
								<br>
								<input type=\"email\" name=\"email\" placeholder=\"exemplo@exemplo.com\" class=\"form-control \" required>
								
								<div class=\"form-inline\">
									<div class=\"form-group  mx-sm-0 mb-2\">
										<label>Senha</label>
										<input type=\"password\" name=\"senha\" placeholder=\"Suasenha123\" class=\"form-control\"  style=\"margin-right:10px;\" required>
									</div>
									<div class=\"form-group  mx-sm-0 mb-2\">
										<label>Confirmar Senha</label>
										<input type=\"password\" name=\"csenha\" placeholder=\"Suasenha123\" class=\"form-control\" required>
									</div>
								</div>
								<label>Sexo</label>
								<br>
								<div class=\"col-md-10\">
									<label>Masculino</label>
									<br>
									<label>Feminino</label>
								</div>
								<div class=\"col-md-2\">
									<input type=\"radio\" name=\"sexo\" value=\"M\" required>
									<br>
									<input type=\"radio\" name=\"sexo\" value=\"F\" required>
								</div>
								<div class=\"col-md-10\">
									<label>Concordo com os termos</label>
								</div>
								<div class=\"col-md-2\">
									<input type=\"checkbox\" name=\"termos\" value=\"sim\" required>
								</div>
								<div class=\"col-md-6\">
											<button class=\"btn-edit\" id=\"enviar\">Cadastrar</button>
										</div>
										<div class=\"col-md-6\">
											<div style=\"margin-top: 10px;\">
												<a class=\"link\" href=\"../\">Ja tenho uma conta!</a>
											</div>
										</div>
								</div>
							</div>
						</div>
					</form>

					</div>

				
			</div>
</body>
</html>

	";	
}
?>
<style type="text/css">
		a{
		color:#00a;
	}
	a:hover{
		color:#00a;
		text-shadow: none;
	}
</style>
