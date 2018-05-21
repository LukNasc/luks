<?php
require_once("../sql/conexao.php");
$banco= new Conectar();
$sql="SELECT * FROM conta WHERE id=?;";
$mostrar=$banco->getCon()->prepare($sql);
if(isset($_GET['amzd'])){
  $mostrar->bindParam(1,$_GET['idCon']);
}else{
  $mostrar->bindParam(1,$_SESSION['id']);
}
$mostrar->execute();
$obj=$mostrar->fetch(PDO::FETCH_OBJ);
if(isset($_GET['amzd'])){
  echo "<nav class=\"navbar navbar-expand-lg\" style=\"background-color:{$pers->cor} ;color:#fff;border-radius: 0px;\">";
}else{
  echo "<nav class=\"navbar navbar-expand-lg\" style=\"background-color:{$pers->cor} ;color:#fff;border-radius: 0px;\">";
}
echo"
<img src=\"../img/logo.png\" width=\"100px\" height=\"60px\">
     <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
    <ul class=\"navbar-nav mr-auto\">
      <li class=\"nav-item active\">
        <a class=\"nav-link\" href=\"home.php\"><b>Inicio</b></a>
      </li>
      <li class=\"nav-item\">
        <a class=\"nav-link\" href=\"perfil.php\"><b>{$_SESSION['nome']} {$_SESSION['sobrenome']}</b></a>
      </li>
      <li class=\"nav-item dropdown\">
        <a class=\"nav-link dropdown-toggle\" href=\"\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><b>Conta</b></a>
        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">";
          if(isset($_GET['amzd'])){
            $sql2="SELECT * FROM conta WHERE id=?;";
            $cmd=$banco->getCon()->prepare($sql2);
            $cmd->bindParam(1,$_SESSION['id']);
            $cmd->execute();
            $true=$cmd->fetch(PDO::FETCH_OBJ);
          }
          if($obj->adm=="true"){
            if(isset($true)){
               echo "<a class=\"link dropdown-item\" href=\"adm.php\">Administração</a>";
              $_SESSION['adm']="true";
            }else{
               echo "<a class=\"link dropdown-item\" href=\"adm.php\">Administração</a>";
              $_SESSION['adm']="true";
            }
          }
          echo "
          <a class=\" link dropdown-item\" href=\"\">Sobre</a>
          <a class=\" link dropdown-item\" href=\"\">Privacidade</a>
          <a class=\" link dropdown-item\" href=\"\">Denuciar</a>
           <a class=\" link dropdown-item\" href=\"../pags/configConta.php\">Configurações de conta</a>
          <div class=\"dropdown-divider\"></div>
          <a class=\" link dropdown-item\" href=\"../control/back/sair.php\">Sair</a>
        </div>
      </li>
    </ul>
  </div>
     <div class=\"pesquisa\">
        <form class=\"form-inline\" action=\"pesquisa.php\" method=\"get\"> 
          <div class=\"form-group  mx-sm-0 mb-2\">
            <input autocomplete=\"off\" type=\"search\" name=\"search\" class=\"form-control\" placeholder=\"Pesquise por nome\" id=\"searchCampo\" onkeyup='pesquisar()'>
          </div>
          <div class=\"form-group  mx-sm-0 mb-2\">
            <button class=\"search\" id=\"btn\" ><i class=\"material-icons tiny\">search</i></button>
            <div id=\"localPesquisa\"></div>
          </div>
        </form>
     </div>
</nav>";
# <img src=\"../img/logo.png\" width=\"100px\" height=\"60px\">
  #<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"#navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
  #  <span class=\"navbar-toggler-icon\"></span>
 # </button>
#
  
?>