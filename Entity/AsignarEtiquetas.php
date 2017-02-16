<?php

namespace Entity;

class Etiquetas {
	// propiedades
	private $id;
	private $idPelicula;
	private $idSerie;

	const TABLA_1 = 'peliculas_etiquetas';
	const TABLA_2 = 'series_etiquetas';

	// setters para obtencion de datos
	public function setId($id) {
		$this->id = $id
	}
	public function setIdPelicula($idPelicula) {
		$this->idPelicula = $idPelicula;
	}
	public function setiIdSerie($idSerie) {
		$this->idSerie = $idSerie;
	}

	public function __construct()
	{
		$this->conexion = new Conexion();
	}

	//metodos para CRUD database
	public function savePelicula(){
	     $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA_1 .' (idpelicula, idetiqueta) VALUES(:idpelicula, :idetiqueta)');

	  $consulta->bindParam(':idpelicula', $this->idPelicula);
	  $consulta->bindParam(':idetiqueta', $this->id);
	  $consulta->execute();
	}

	public function saveSerie(){
	     $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA_2 .' (idserie, idetiqueta) VALUES(:idserie, :idetiqueta)');

	  $consulta->bindParam(':idserie', $this->idSerie);
	  $consulta->bindParam(':idetiqueta', $this->id);
	  $consulta->execute();
	}

	public static function viewPelicula($id){
		$consulta = $conexion->prepare('SELECT idpelicula  FROM ' . self::TABLA_1 . ' WHERE idetiqueta = :idetiqueta');
		$consulta->bindParam(':idetiqueta', $id);
		$consulta->execute();
		$registro = $consulta->fetch(PDO::FETCH_ASSOC);

		if($registro){
			return $registro;
		}else{
			return false;
		}
	}

	public static function viewSerie($id){
		$consulta = $conexion->prepare('SELECT idserie  FROM ' . self::TABLA_2 . ' WHERE idetiqueta = :idetiqueta');
		$consulta->bindParam(':idetiqueta', $id);
		$consulta->execute();
		$registro = $consulta->fetch(PDO::FETCH_ASSOC);

		if($registro){
			return $registro;
		}else{
			return false;
		}
	}


	public static function countListAllPelicula(){
		$consulta = $conexion->prepare('SELECT idpelicula, idetiqueta  FROM ' . self::TABLA_1 . ' ORDER BY idpelicula');
		 $consulta->execute();
     $filas = $consulta->rowCount();

		return $filas;
	}

	public static function countListAllSerie(){
		$consulta = $conexion->prepare('SELECT idserie, idetiqueta  FROM ' . self::TABLA_2 . ' ORDER BY idserie');
		 $consulta->execute();
     $filas = $consulta->rowCount();

		return $filas;
	}

	public function __destruct()
	{
		$this->conexion = null;
	}
}

