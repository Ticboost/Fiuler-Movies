<?php

namespace Entity;
use \PDO;

class Etiquetas {
	// propiedades
	private $id;
	private $nombre;

	const TABLA = 'etiquetas';

	// setters para obtencion de datos
	public function setId($id) {
		$this->id = $id;
	}

	public function setnombre($nombre) {
		$this->nombre = $nombre;
	}

	//metodos para CRUD database
	public static function listAll(){
		$conexion = new Conexion();
		$consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY idetiqueta');
		$consulta->execute();
		$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}

	public function save(){
	  if($this->id) /*Modifica*/ {
	     $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre = :nombre  = : WHERE idetiqueta = :idetiqueta');
	  }else /*Inserta*/ {
	     $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (nombre) VALUES(:nombre :)');
	     $this->id = $conexion->lastInsertId();
	  }

	  $consulta->bindParam(':nombre', $this->nombre);
	  $consulta->bindParam(':idetiqueta', $this->id);
	  $consulta->execute();
	}

	public static function delete($id){

		$consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE idetiqueta = :idetiqueta');
		$consulta->bindParam(':idetiqueta', $this->id);
	  $consulta->execute();
	}

	public static function view($id){
		$consulta = $conexion->prepare('SELECT nombre  FROM ' . self::TABLA . ' WHERE idetiqueta = :idetiqueta');
		$consulta->bindParam(':idetiqueta', $id);
		$consulta->execute();
		$registro = $consulta->fetch(PDO::FETCH_ASSOC);

		if($registro){
			return $registro;
		}else{
			return false;
		}
	}

	public static function countListAll(){
		$consulta = $conexion->prepare('SELECT idetiqueta, nombre  FROM ' . self::TABLA . ' ORDER BY nombre');
		 $consulta->execute();
     $filas = $consulta->rowCount();

		return $filas;
	}

	public function __destruct()
	{
		$this->conexion = null;
	}
}

