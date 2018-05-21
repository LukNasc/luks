function pesquisar(){
	var local=document.getElementById("localPesquisa");
	var campo=document.getElementById("searchCampo");
	var pesquisa=campo.value;
	requisitarArquivo("../control/back/pesquisa.php?p="+pesquisa,local);
}
function apagarCampo(idElemento, texto){
	if(texto==""){
		document.getElementById(idElemento).value="";
	}else{
		document.getElementById(idElemento).value=texto;
	}
}
function solicitAmzd(idConta){
	var id=idConta;
	var local=document.getElementById("divphp");
	requisitarArquivo("../control/back/processa.php?form=amzd&idCon="+id, local);
}
function removeAmzd(idConta){
	var id=idConta;
	var local=document.getElementById("divphp");
	requisitarArquivo("../control/back/processa.php?form=rmamzd&idCon="+id, local);
}
foto="";
$('document').ready(function(){
		$(function(){
		$('#Editar').change(function(){
			const file = $(this)[0].files[0]
			const fileReader = new FileReader()
				
			fileReader.onloadend = function(){
				 foto=fileReader.result;
			}
			fileReader.readAsDataURL(file);
		})
	})
});
function postar(idConta){
	var post=document.getElementById("status");
	var status=post.value;
	var local=document.getElementById("postagens");
	if(status==null || status==""){

	}else{
	var img=foto;
	if(img!=null){
		requisitarArquivo("../control/back/processa.php?form=status&idCon="+idConta+"&status="+status+"&foto="+foto, local);
		apagarCampo("status", "COM FOTOOOOOOO");
	}else{
		requisitarArquivo("../control/back/processa.php?form=status&idCon="+idConta+"&status="+status, local);
		apagarCampo("status", "COMPARTILHE SEU DIA!");
	}
	
	}
}
