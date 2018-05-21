<?php  
	$sql="SELECT * FROM personalizacao WHERE id_conta=?;";
	$cmd=$banco->getCon()->prepare($sql);
	$cmd->bindParam(1, $_SESSION['id']);
	$cmd->execute();
	$pers=$cmd->fetch(PDO::FETCH_OBJ);
	echo "
	<div class=\"footer\" style=\"background-color:{$pers->cor};\">
		<div class=\"container\">
			<div class=\"col-md-4\">
				<img src=\"../img/logo.png\" width=\"100%\" height=\"250px\" style=\"margin-top:-20px;\">
				<h6 style=\"font-size:10px;margin-top:-30px; \" class=\"title\">A REDE SOCIAL DO JEITO QUE VOCÊ QUER</h6>
			</div>
			<div class=\"col-md-4\"> 
				<h3>ALGUMA COOOOOOOOISAAAAAAAAAAA
				</div>
				<div class=\"col-md-4\"> 
					<h3>ALGUMAAAAA OUTRAAAAA COISAAAAAAAAA
					</div>
				</div>
				<div class=\"col-md-12\" style=\"border-top:2px #fff solid;\">
					<div class=\"container\">
						<h5 style=\"float:left;\"><b>DEVELOPMAN LUCAS, BOOTSTRAP</b></h5>
						<h5 style=\"float:right;\"><b>2018</b></h5>
					</div>
				</div>
			</div>
	";
	

?>