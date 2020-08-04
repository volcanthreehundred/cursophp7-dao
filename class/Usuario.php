<?php

class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function __construct($deslogin="", $dessenha=""){
		$this->setDeslogin($deslogin);
		$this->setDessenha($dessenha);
	}

	public function getIdusuario(){
		return $this->idusuario;
	}

	public function setIdusuario($idusuario){
		$this->idusuario = $idusuario;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function setDeslogin($deslogin){
		$this->deslogin = $deslogin;
	}

	public function getDessenha(){
		return $this->dessenha;
	}

	public function setDessenha($dessenha){
		$this->dessenha = $dessenha;
	}	

	public function getDtcadastro(){
		return $this->dtcadastro;
	}

	public function setDtcadastro($dtcadastro){
		$this->dtcadastro = $dtcadastro;
	}

	public function loadById($id){
		$sql = new Sql();

		$usuario = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
			":ID"=>$id
		));

		if(count($usuario) > 0){
			$row = $usuario[0];

			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
		}
	}

	public function loadByName($name){
		$sql = new Sql();

		$usuario = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$name
		));

		if(count($usuario) > 0){
			$this->setData($logado[0]);
		}
	}

	public static function getList(){
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY idusuario;");

	}

	public static function search($login){
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%".$login."%"
		));
	}

	public function login($login, $pass){

		$sql = new Sql();

		$logado = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN and dessenha = :SENHA", array(
			":LOGIN"=>$login,
			":SENHA"=>$pass
		));

		if(count($logado) > 0){
			$this->setData($logado[0]);
		}else{
			throw new Exception("Login e/ou senha inválidos.");
		}
		
	}

	private function setData($data){
		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));
	}

	public function __toString(){

		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
		)); 	
	}

	public function inserir(){
		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN' => $this->getDeslogin(),
			':PASSWORD' => $this->getDessenha()
		));

		if (count($results) > 0){
			$this->setData($results[0]);
		}
	}

	public function update($deslogin, $dessenha){

		$this->setDeslogin($deslogin);
		$this->setDessenha($dessenha);
		
		$sql = new Sql();

		$updating = $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN' => $this->getDeslogin(),
			':PASSWORD' => $this->getDessenha(),
			':ID' => $this->getIdusuario()
		));

	}
}

?>