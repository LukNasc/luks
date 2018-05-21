<?php
	class Conectar{
		private $con;

		public function setCon($Conexao){
			$this->con=$Conexao;
		}
		public function getCon(){
			return $this->con;
		}

		public function __construct(){
			try{
				$server="localhost";
				$user="root";
				$pws="";
				$banco="rede";
				$con=$this->setCon(new PDO("mysql:host=$server;dbname=$banco",$user,$pws));
				$this->con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $ex){
				$ex="Erro no BD";
				echo "<script>alert({$ex}); window.history.back();</script>";
			}
		}
	}

?>