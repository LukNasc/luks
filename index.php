<?php 
session_start();


require_once("control/includes/head.php");
if(isset($_SESSION['id'])){
	header("location: pags/home.php");
}else{
	if(isset($_SESSION['notExists'])){
		echo "<script type=\"text/javascript\">
			window.onload=function(){
				alertify.error('TALVEZ ESSA CONTA NÃO EXISTA'); 
			}
		</script>";
		session_destroy();
	}
	echo "
		<body>
			<div class=\"container\">
				<center>
					<img src=\"img/logo.png\" width=\"500px\" height=\"200px\" style=\"margin-bottom: -100px;\">
					<div class=\"logar\">
					<br>

						<form  method=\"post\" action=\"control/back/processa.php?form=log\">
							<div class=\"row\">
								<br>

								<div class=\"col-md-12\">

										<label>Email</label>
										<br>
										<input type=\"email\" name=\"email\" class=\"form-control\" value=\"\" placeholder=\"email@email.com\">
										<br>
										<label>Senha</label>
										<br>
										<input type=\"password\" name=\"senha\" class=\"form-control\" value=\"\" placeholder=\"suasenha123\">
										<br>
										<br>
										<div class=\"col-md-6\">
											<button class=\"btn-edit\">Entrar</button>
										</div>
										<div class=\"col-md-6\">
											<div style=\"margin-top: 10px;\">
												<a class=\"link\" href=\"pags/cadastro.php\">Cadastre-se agora</a>
											</div>
										</div>
								</div>
								<div class=\"col-md-12\">
									<div style=\"margin-top: 10px;\">
										<a class=\"link\" href=\"recPass.php\">Esqueceu sua senha?</a>
									</div>
								</div>
							</div>	
						</form>
					</div>
				</center>
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