<?php
 class vuelosModel {
     private $database;
     public function __construct($database)
     {
         $this->database=$database;
     }
     public function obtenerVuelos(){
         $sql = "SELECT * FROM vuelo ORDER BY origen";
         return $this->database->query($sql);
     }

     public function eliminarVuelo($id){
         $sql = "DELETE FROM `vuelo` WHERE `vuelo`.`id` = ".$id;
         $this->database->insert($sql);
     }

 }