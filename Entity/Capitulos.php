<?php

namespace Entity;
use \PDO;

class Capitulos {
   
  private $id;
  private $nombre;
  private $temporada;
  private $idSerie;

  const TABLA = 'capitulos';

  public function setId($id) {
    $this->id = $id;
  }
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function settemporada($temporada) {
    $this->temporada = $temporada;
  }
  public function setIdserie($idSerie) {
    $this->idSerie = $idSerie;
  }

  public static function listAll(){
    $consulta = $conexion->prepare('SELECT idcapitulo, nombre, temporada, idserie FROM ' . self::TABLA . ' ORDER BY idserie');
     $consulta->execute();
     $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
     return $registros;
  }

  public static function listCapitulos($id){
     $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE idserie = :idserie');
     $consulta->bindParam(':idserie', $id);
     $consulta->execute();
     $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
     return $registros;
   
  }

  public function save(){
    if($this->id) /*Modifica*/ {
       $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre = :nombre, temporada = :temporada, idserie = :idserie WHERE idserie = :idserie');
       $consulta->bindParam(':idcapitulo', $this->id);
    }else /*Inserta*/ {
       $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (nombre, temporada, idserie) VALUES(:nombre, :temporada, :idserie)');
       $this->id = $conexion->lastInsertId();
    }

    $consulta->bindParam(':nombre', $this->nombre);
    $consulta->bindParam(':temporada', $this->temporada);
    $consulta->bindParam(':idserie', $this->idSerie);
    $consulta->execute();
  }

  public static function delete($id){
    $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE idserie = :idserie');
    $consulta->bindParam(':idcapitulo', $this->id);
    $consulta->execute();
  }

  public static function view($id){
     $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE idcapitulo = :idcapitulo');
     $consulta->bindParam(':idcapitulo', $id);
     $consulta->execute();
     $registro = $consulta->fetch(PDO::FETCH_ASSOC);
     if($registro){
        return $registro;
     }else{
        return false;
     }
  }

  public static function countListAll(){
     $consulta = $conexion->prepare('SELECT idcapitulo, nombre, temporada, idserie FROM ' . self::TABLA . ' ORDER BY idcapitulo');
     $consulta->execute();
     $filas = $consulta->rowCount();
     return $filas;
  }

  public function __destruct()
  {
    $this->conexion = null;
  }
}