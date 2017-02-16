<?php 

namespace Entity;
use \PDO;
use Config\Config;

class Videos {
   
  private $id;
  private $url;
  private $calidad;
  private $estado;
  private $fecha;
  private $idioma;
  private $numReproducion;
  private $idPelicula;
  private $idCapitulo;
  private $idUsuario;

  const TABLA_1 = 'videos_p';
  const TABLA_2 = 'videos_c';

  public function setId($id) {
    $this->id = $id;
  }
  public function setUrl($url) {
    $this->url = $url;
  }
  public function setCalidad($calidad) {
    $this->calidad = $calidad;
  }
  public function setEstado($estado) {
    $this->estado = $estado;
  }
  public function setFecha($fecha) {
    $this->fecha = $fecha;
  }
  public function setIdioma($idioma) {
    $this->idioma = $idioma;
  }
  public function setNumReproducion($numReproducion) {
    $this->numReproducion = $numReproducion;
  }
  public function setIdPelicula($idPelicula) {
    $this->idPelicula = $idPelicula;
  }
  public function setIdCapitulo($idCapitulo) {
    $this->idCapitulo = $idCapitulo;
  }
  public function setIdUsuario($idUsuario) {
    $this->idUsuario = $idUsuario;
  }

  public static function listAllPelicula(){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA_1 . ' ORDER BY idvideo');
     $consulta->execute();
     $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
     return $registros;
  }

  public static function listAllCapitulo(){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT idvideo, url, calidad, estado, fecha, idioma, numReproducion, idcapitulo, idusuario FROM ' . self::TABLA_2 . ' ORDER BY idvideo');
     $consulta->execute();
     $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
     return $registros;
  }

  public function savePelicula(){
    $conexion = new Conexion();
    if($this->id) /*Modifica*/ {
       $consulta = $conexion->prepare('UPDATE ' . self::TABLA_1 .' SET url = :url, calidad = :calidad, estado = :estado, fecha = :fecha, idioma = :idioma, idpelicula = :idpelicula, idusuario = :idusuario WHERE idvideo = :idvideo');
       $consulta->bindParam(':idvideo', $this->id);
    }else /*Inserta*/ {
       $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA_1 .' (url, calidad, estado, fecha, idioma, idpelicula, idusuario) VALUES(:url, :calidad, :estado, :fecha, :idioma, :idpelicula, :idusuario)');
       $this->id = $conexion->lastInsertId();
    }

    $consulta->bindParam(':url', $this->url);
    $consulta->bindParam(':calidad', $this->calidad);
    $consulta->bindParam(':estado', $this->estado);
    $consulta->bindParam(':fecha', $this->fecha);
    $consulta->bindParam(':idioma', $this->idioma);
    $consulta->bindParam(':idpelicula', $this->idPelicula);
    $consulta->bindParam(':idusuario', $this->idUsuario);
    $consulta->execute();
  }

  public function saveCapitulo(){
    $conexion = new Conexion();
    if($this->id) /*Modifica*/ {
       $consulta = $conexion->prepare('UPDATE ' . self::TABLA_2 .' SET url = :url, calidad = :calidad, estado = :estado, fecha = :fecha, idioma = :idioma, numReproducion = :numReproducion, idcapitulo = :idcapitulo, idusuario = :idusuario WHERE idvideo = :idvideo');
       $consulta->bindParam(':idvideo', $this->id);
    }else /*Inserta*/ {
       $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA_2 .' (url, calidad, estado, fecha, idioma, numReproducion, idcapitulo, idusuario) VALUES(:url, :calidad, :estado, :fecha, :idioma, :numReproducion, :idcapitulo, :idusuario)');
       $this->id = $conexion->lastInsertId();
    }

    $consulta->bindParam(':url', $this->url);
    $consulta->bindParam(':calidad', $this->calidad);
    $consulta->bindParam(':estado', $this->estado);
    $consulta->bindParam(':fecha', $this->fecha);
    $consulta->bindParam(':idioma', $this->idioma);
    $consulta->bindParam(':numReproducion', $this->numReproducion);
    $consulta->bindParam(':idcapitulo', $this->idCapitulo);
    $consulta->bindParam(':idusuario', $this->idusuario);
    $consulta->execute();
  }

  public static function viewPeliculas($id){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA_1 . ' WHERE idpelicula = :idpelicula ORDER BY idpelicula');
    $consulta->bindParam(':idpelicula', $id);
    $consulta->execute();
    $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
    if($registros){
      return $registros;
    }else{
      return false;
    } 
  }

  public static function viewPelicula($id){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA_1 . ' WHERE idpelicula = :idpelicula ORDER BY idpelicula');
    $consulta->bindParam(':idpelicula', $id);
    $consulta->execute();
    $registros = $consulta->fetch(PDO::FETCH_ASSOC);
    if($registros){
      return $registros;
    }else{
      return false;
    } 
  }

  public static function viewVideo($id){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA_1 . ' WHERE idvideo = :idvideo ORDER BY idvideo');
    $consulta->bindParam(':idvideo', $id);
    $consulta->execute();
    $registros = $consulta->fetch(PDO::FETCH_ASSOC);
    if($registros){
      return $registros;
    }else{
      return false;
    } 
  }

  public static function deletePelicula($idvideo){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA_1 . ' WHERE idvideo = :idvideo');
    $consulta->bindParam(':idvideo', $idvideo);
    $consulta->execute();
  }

  public static function deleteCapitulo($id){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA_2 . ' WHERE idvideo = :idvideo');
    $consulta->bindParam(':idvideo', $this->id);
    $consulta->execute();
  }

  

  public static function viewCapitulo($id){
    $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA_2 . ' WHERE idvideo = :idvideo');
     $consulta->bindParam(':idvideo', $id);
     $consulta->execute();
     $registro = $consulta->fetch(PDO::FETCH_ASSOC);
     if($registro){
        return $registro;
     }else{
        return false;
     }
  }

  public static function numReproducion($id){
      $conexion = new Conexion();
      $consulta = $conexion->prepare('UPDATE ' . self::TABLA_1 .' SET numReproducion = numReproducion + 1 WHERE idvideo = :idvideo');
      $consulta->bindParam(':idvideo', $id);
      $consulta->execute();
  }

  public static function countListAllPelicula(){
    $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT idvideo, url, calidad, estado, fecha, idioma numReproducion, idpelicula, idusuario FROM ' . self::TABLA_1 . ' ORDER BY idvideo');
     $consulta->execute();
     $filas = $consulta->rowCount();
     return $filas;
  }

  public static function countListAllCapitulo(){
    $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT idvideo, url, calidad, estado, fecha, idioma numReproducion, idcapitulo, idusuario FROM ' . self::TABLA_2 . ' ORDER BY idvideo');
     $consulta->execute();
     $filas = $consulta->rowCount();
     return $filas;
  }

  public function __destruct() {
    $conexion = null;
  }
}