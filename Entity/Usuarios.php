<?php

namespace Entity;
use \PDO;

class Usuarios {
	// propiedades
	private $id;
	private $email;
	private $contrasena;
	private $perfil;

	const TABLA = 'usuarios';

	// setters para obtencion de datos
	public function setId($id) {
		$this->id = $id;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function setContrasena($contrasena) {
		$opciones = ['cost' => 12];
		$this->contrasena = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);
	}
	public function setPerfil($perfil) {
		$this->perfil = $perfil;
	}

	//metodos para CRUD database
	public static function listAll(){
		$conexion = new Conexion();
		$consulta = $conexion->prepare('SELECT idusuario, email, contrasena, perfil FROM ' . self::TABLA . ' ORDER BY email');
		$consulta->execute();
		$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);

		return $registros;
	}

	public function save(){
	  $conexion = new Conexion();
	  if($this->id) /*Modifica*/ {
	    $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET email = :email, contrasena = :contrasena, perfil = :perfil WHERE idusuario = :idusuario');
	 	$consulta->bindParam(':idusuario', $this->id);
	  }else /*Inserta*/ {
	     $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (email, contrasena, perfil) VALUES(:email, :contrasena, :perfil)');
	     //var_dump($this->id);
	  }
	  $consulta->bindParam(':email', $this->email);
	  $consulta->bindParam(':contrasena', $this->contrasena);
	  $consulta->bindParam(':perfil', $this->perfil);
	  $consulta->execute();
	}

	public static function delete($id){
		$conexion = new Conexion();
		$consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE idusuario = :idusuario');
		$consulta->bindParam(':idusuario', $id);
	  	$consulta->execute();
	}

	public static function view($id){
		$conexion = new Conexion();
		$consulta = $conexion->prepare('SELECT email, contrasena, perfil FROM ' . self::TABLA . ' WHERE idusuario = :idusuario');
		$consulta->bindParam(':idusuario', $id);
		$consulta->execute();
		$registro = $consulta->fetch(PDO::FETCH_ASSOC);
		if($registro){
			return $registro;
		}else{
			return false;
		}
	}

	public static function verifyUser($email, $contrasena){
		$conexion = new Conexion();
		$consulta = $conexion->prepare('SELECT contrasena, perfil, idusuario FROM ' . self::TABLA . ' WHERE email = :email ');
		$consulta->bindParam(':email', $email);
		$consulta->execute();
		$registro = $consulta->fetch(PDO::FETCH_ASSOC);
		if ($registro) {
			$pass_encrypt = array_shift($registro);
			$verify = password_verify($contrasena, $pass_encrypt);
			if($verify){
				return $registro;
			}else{
				return $verify;
	 		}
		}else{
			return false;
		}
	}

	public static function countListAll(){
		$conexion = new Conexion();
		$consulta = $conexion->prepare('SELECT idusuario, email, contrasena, perfil FROM ' . self::TABLA . ' ORDER BY email');
		$consulta->execute();
     	$filas = $consulta->rowCount();

		return $filas;
	}

	public function __destruct()
	{
		$conexion = null;
	}
}

