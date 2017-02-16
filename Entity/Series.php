<?php

namespace Entity;
use \PDO;

class Series {
   
  private $id;
  private $nombre;
  private $sinopsis;
  private $prod_ano;

  const TABLA = 'series';

  public function setId($id) {
    $this->id = $id;
  }
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function setSinopsis($sinopsis) {
    $this->sinopsis = $sinopsis;
  }
  public function setProd_ano($prod_ano) {
    $this->prod_ano = $prod_ano;
  }

  public static function listAll(){
     $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY idserie');
     $consulta->execute();
     $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
     return $registros;
  }

  public function save(){
    if($this->id) /*Modifica*/ {
       $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre = :nombre, sinopsis = :sinopsis, prod_ano = :prod_ano WHERE idserie = :idserie');
       $consulta->bindParam(':idserie', $this->id);
    }else /*Inserta*/ {
       $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (nombre, sinopsis, prod_ano) VALUES(:nombre, :sinopsis, :prod_ano)');
       $this->id = $conexion->lastInsertId();
    }

    $consulta->bindParam(':nombre', $this->nombre);
    $consulta->bindParam(':sinopsis', $this->sinopsis);
    $consulta->bindParam(':prod_ano', $this->prod_ano);
    $consulta->execute();
  }

  public static function delete($id){
    $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE idserie = :idserie');
    $consulta->bindParam(':idserie', $this->id);
    $consulta->execute();
  }

  public static function view($id){
     $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE idserie = :idserie');
     $consulta->bindParam(':idserie', $id);
     $consulta->execute();
     $registro = $consulta->fetch(PDO::FETCH_ASSOC);
     if($registro){
        return $registro;
     }else{
        return false;
     }
  }

  public static function countListAll(){
     $consulta = $conexion->prepare('SELECT idserie, nombre, sinopsis, prod_ano FROM ' . self::TABLA . ' ORDER BY idserie');
     $consulta->execute();
     $filas = $consulta->rowCount();
     return $filas;
  }

  public function __destruct()
  {
    $this->conexion = null;
  }
}