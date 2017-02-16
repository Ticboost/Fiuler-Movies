<?php

namespace Entity;
use \PDO;
use Entity\Videos;
use Config\Config;

class Peliculas {
   
  private $id;
  private $nombre;
  private $sinopsis;
  private $trailer;
  private $imagen;
  private $prod_ano;

  const TABLA = 'peliculas';
  const TABLA2 = 'videos_p';

  public function setId($id) {
    $this->id = $id;
  }
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function setSinopsis($sinopsis) {
    $this->sinopsis = $sinopsis;
  }
  public function setTrailer($trailer) {
    $this->trailer = $trailer;
  }
  public function setImagen($imagen) {
    $this->imagen = $imagen;
  }
  public function setPortada($portada) {
    $this->portada = $portada;
  }
  public function setProd_ano($prod_ano) {
    $this->prod_ano = $prod_ano;
  }

  public static function listAll(){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE idpelicula ORDER BY idpelicula DESC LIMIT 14');
    $consulta->execute();
    $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    /*foreach ($registros as $registro) {
      $url = Config::url_exists($registro['url']);
      if(!$url){
        $consulta_2 = $conexion->prepare('UPDATE ' . self::TABLA2 .' SET estado = "DEACTIVATE" WHERE idvideo = :idvideo');
        $consulta_2->bindParam(':idvideo', $registro['idvideo']);
        $consulta_2->execute();
      }
    }*/

    return $registros;
  }

  public static function listSlider(){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE idpelicula ORDER BY idpelicula DESC LIMIT 4');
    $consulta->execute();
    $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $registros;
  }

  public function save(){
    $conexion = new Conexion();
    if($this->id) /*Modifica*/ {
       $consulta = $conexion->prepare('UPDATE ' . self::TABLA .' SET nombre = :nombre, sinopsis = :sinopsis, trailer = :trailer, imagen = :imagen, portada = :portada, prod_ano = :prod_ano WHERE idpelicula = :idpelicula');
       $consulta->bindParam(':idpelicula', $this->id);
    }else /*Inserta*/ {
       $consulta = $conexion->prepare('INSERT INTO ' . self::TABLA .' (nombre, sinopsis, trailer, imagen, portada, prod_ano) VALUES(:nombre, :sinopsis, :trailer, :imagen, :portada, :prod_ano)');
       $this->id = $conexion->lastInsertId();
    }

    $consulta->bindParam(':nombre', $this->nombre);
    $consulta->bindParam(':sinopsis', $this->sinopsis);
    $consulta->bindParam(':trailer', $this->trailer);
    $consulta->bindParam(':imagen', $this->imagen);
    $consulta->bindParam(':portada', $this->portada);
    $consulta->bindParam(':prod_ano', $this->prod_ano);
    $consulta->execute();
  }

  public static function delete($id){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE idpelicula = :idpelicula');
    $consulta->bindParam(':idpelicula', $id);
    $consulta->execute();
  }

  public static function view($id){
     $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE idpelicula = :idpelicula');
     $consulta->bindParam(':idpelicula', $id);
     $consulta->execute();
     $registro = $consulta->fetch(PDO::FETCH_ASSOC);
     if($registro){
        return $registro;
     }else{
        return false;
     }
  }

  public static function countListAll(){
     $conexion = new Conexion();
     $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY idpelicula');
     $consulta->execute();
     $filas = $consulta->rowCount();
     return $filas;
  }

  public static function search($search){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT idpelicula, nombre, imagen, prod_ano FROM ' . self::TABLA . ' WHERE nombre LIKE "%' . $search . '%" AND idpelicula LIKE "%' . $search . '%" ORDER BY nombre ASC LIMIT 14');
    $consulta->execute();
    $registros = $consulta->fetchALL(PDO::FETCH_ASSOC);
    if($registros){
      return $registros;
    }else{
      return false;
    }
  }

  public function limpiarString($texto) {
      $textoEspacios = preg_replace('[\s+]', '', $texto);
      $textoLimpio = preg_replace('([^A-Za-z0-9])', '', $textoEspacios);                
      return $textoLimpio;
  }

  public function fileImagen($imagen){

    foreach($imagen as $nombre_campo => $valor){ 
      $variable = "\$" . $nombre_campo . "='" . $valor . "';"; 
      eval($variable); 
    }
    copy($tmp_name,'./web/assets/img/' . $this->limpiarString($this->nombre) . '.jpg');

    $name = $this->limpiarString($this->nombre) . '.jpg';
    $this->setImagen($name);
  }

  public function filePortada($imagen){

    foreach($imagen as $nombre_campo => $valor){ 
      $variable = "\$" . $nombre_campo . "='" . $valor . "';"; 
      eval($variable); 
    }
    copy($tmp_name,'./web/assets/img/' . $this->limpiarString($this->nombre) . '_back.jpg');

    $name = $this->limpiarString($this->nombre) . '_back.jpg';
    $this->setPortada($name);
  }
  
  public function __destruct() {
    $conexion = null;
  }
}