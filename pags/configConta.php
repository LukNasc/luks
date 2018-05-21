<?php  
session_start();
require_once("../sql/conexao.php");
$banco=new Conectar();
require_once("../control/includes/headPags.php");
echo "<body>";
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
echo "<div class=\"container modify\">";
	echo "<div class=\"row\">";
		echo "<div class=\"col-md-6\">";
			echo"<h2>Configurações</h2><br>";
			echo"<ol class=\"config\">";
				echo "<li class=\"link\">Mudar Senha</li>";
				echo "<li class=\"link\">Mudar Email</li>";
				echo "<li class=\"link\" data-toggle=\"modal\" data-target=\"#mudarPlanoDeFundo\">Mudar Plano de fundo</li>";
				echo "<li class=\"link\">Desejo excluir minha conta</li>";
			echo "</ol>";
		echo "</div>";
		echo "<div class=\"col-md-6\">";
			echo "<center><h2>Termos de uso</h2></center>";
			echo "<p>
					Nossos termos e condições de uso

					Imagine um mundo onde todos os seres humanos possam compartilhar livremente a soma de todo conhecimento. Este é o nosso compromisso. – Nossa Visão

					Bem-vindo(a) à Wikimedia! A Wikimedia Foundation, Inc. é uma organização filantrópica sem fins lucrativos cuja missão é capacitar e engajar pessoas de todo o mundo para coletar e desenvolver conteúdo sob uma licença livre ou em domínio público e disseminá-lo de maneira eficiente e global, sem custos.

					Para apoiar nossa vibrante comunidade, proporcionamos a infraestrutura e estrutura organizacional básicas para o desenvolvimento de projetos wikis multilíngues e suas edições (como explicado aqui) e outros empreendimentos que atendem a esta missão. Nós nos esforçamos para disponibilizar e manter conteúdos educacionais e informativos dos projetos na internet sem custos, em caráter perpétuo.

					Nós lhe damos boas-vindas (\"você\" ou \"usuário\") como leitor, editor, autor ou colaborador dos projetos Wikimedia e o encorajamos a fazer parte da comunidade Wikimedia. Antes de participar, contudo, solicitamos que leia e concorde com os termos de uso (\"termos de uso\") a seguir.
					Visão geral

					Estes termos de uso informam sobre nossos serviços públicos na Fundação Wikimedia, nosso relacionamento com você como usuário e os direitos e responsabilidades que guiarão a ambos. Queremos que você saiba que hospedamos uma quantidade incrível de conteúdo educacional e informativo, fruto da contribuição e graças aos usuários como você. Em geral, não contribuímos com conteúdo nem monitoramos ou excluímos conteúdo (com a rara exceção de políticas como estes Termos de uso ou para fins de conformidade legal em caso de notificações referentes à DMCA). Isso significa que o controle editorial está nas suas mãos e nas mãos dos seus amigos usuários, que criam e gerenciam conteúdo. Nós apenas hospedamos esse conteúdo.

					A comunidade - a rede de usuários que estão constantemente construindo e usando os vários sites ou projetos - é o principal meio pelo qual as metas da missão são alcançadas. A comunidade contribui e ajuda a administrar nossos sites. A comunidade empreende a função crucial de criar e fazer valer as políticas para as edições de projetos específicos (tais como a edição em diferentes idiomas do projeto Wikipédia ou a edição multilíngue do Wikimedia Commons).

					Você está convidado a participar como colaborador, editor, ou autor, mas você deve seguir as políticas que regem cada uma das edições independente do Projeto. O maior dos nossos projetos é a Wikipedia, mas hospedamos outros projetos também, cada um com diferentes objetivos e métodos de trabalho. Cada edição do projeto conta com uma equipe de colaboradores, editores e autores que trabalham em conjunto para criar e gerenciar o conteúdo naquele projeto. Você está convidado a juntar-se a essas equipes e trabalhar com elas para melhorar esses projetos. Porque nos dedicamos a tornar o conteúdo livremente acessível ao público, isso geralmente exige que todo o conteúdo que contribuir está disponível sob uma licença livre ou de domínio público.

					Esteja ciente de que você é legalmente responsável por todas as suas contribuições, edições e reutilização de conteúdo da Wikimedia sob as leis dos Estados Unidos da América e outras leis aplicáveis (o que pode incluir as leis de onde você vive ou de onde você visualiza ou edita conteúdo). Isso significa que é importante ter cautela ao publicar conteúdo. À luz dessa responsabilidade, temos algumas regras sobre o que você não pode publicar. A maioria delas é para sua proteção ou para a proteção de outros usuários como você. Tenha em mente que o conteúdo que hospedamos é somente para fins de informação geral. Assim, caso você precise de aconselhamento especializado para uma questão específica (tais como questões médicas, jurídicas ou financeiras), você deverá buscar a ajuda de um profissional licenciado ou qualificado. Também incluímos outros avisos importantes e isenções de responsabilidade. Assim, leia esses termos de uso, integralmente.

					Para que fique claro: outras organizações, tais como divisões e associações locais da Wikimedia, que podem compartilhar da mesma missão, são, ainda assim, legalmente independentes e separadas da Fundação Wikimédia e não têm responsabilidade sobre as operações do website ou o seu conteúdo. 		
			     </p>";
		echo "</div>";
	echo "</div>";
echo "</div>";
echo"<center><button class=\"mudarPlanoDeFundo\" data-toggle=\"modal\" data-target=\"#mudarPlanoDeFundo\">Clique para mudar a foto perfil</button></center>";

								#Modal
echo "	<div class=\"modal fade\" id=\"mudarPlanoDeFundo\">
		  <div class=\"modal-dialog\" role=\"document\">
		    <div class=\"modal-content\">
		      <div class=\"modal-header\">
		        <h3 class=\"modal-title\"><b style=\"color:#fff;\">Mudar Plano De Fundo</b></h3>
		        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
		          <span aria-hidden=\"true\"><i class=\"material-icons\">close</i></span>
		        </button>
		      </div>
		      <div class=\"modal-body\">
		      	<center><h4 style=\"color:#fff;\"><b>ATENÇÃO <i class=\"material-icons\" style=\"color:yellow\">warning</i></b></h4>
		      	<h5 style=\"color:#fff;\"><b>O LIMITE DE TAMANHO MÁXIMO É DE 2MB E O TAMANHO RECOMENDADO É DE 1280X720, ESSA PERSONALIZAÇÃO PODE CAUSAR LENTIDÃO NO PROCESSAMENTO EM COMPUTADORES MAIS FRACOS</b></h5></center>
		        <form action=\"../control/back/processa.php?form=addfotoBack\" method=\"post\" enctype=\"multipart/form-data\">
		         <center><label for=\"Editar\"><span class=\"file btn \" id=\"label\">Mudar Background</span></label></center>
		         <div class=\"input\">
				     <input type=\"file\" id=\"Editar\" name=\"foto\" class=\"editar\" onchage=\"imagepreview(this)\">
				     <center><img id=\"img\" style=\"width:300px;height: 168px;\" ></center>
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
		      <div class=\"modal-footer\">
		        <input type=\"submit\" class=\"btn btn-success\" value=\"Salvar Mudança\">
		        </form>
		        <a href=\"../control/back/processa.php?form=rmBack\"><button type=\"button\" class=\"btn btn-danger\">Remover plano de fundo</button></a>
		        <button type=\"button\" class=\"btn btn-secundary\" data-dismiss=\"modal\">Fechar</button>
		      </div>
		    </div>
		  </div>
		</div>
				";
require_once("../control/includes/footer.php");
echo "</body>";
echo "</html>";
?>