<?php 

namespace Entity;
use \PDO;
use \PDOException;

class Conexion extends PDO { 
   private $tipo_de_base = 'mysql';
   private $nombre_de_base = 'fiulerm';
   private $host = 'localhost';
   private $usuario = 'root';
   private $contrasena = '';

   //private $nombre_de_base = 'u625098780_mov';
   //private $host = 'mysql.hostinger.co';
   //private $usuario = 'u625098780_mov';
   //private $contrasena = '@JcKtB0VYx[PzV^#je';
   
   public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
         parent::__construct($this->tipo_de_base.':host='.$this->host./*';port='.$this->port.*/';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
         );
      }catch(PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   } 
} 

