<?php
    class Permiso
    {
        private $_id;
        private $_descriopcion;


        public function __construct(){
            $this->_id = "";
            $this->_descriopcion = "";
        }

        public function setPropiedades($descrip){
            $this->_descriopcion = strtoupper($descrip);
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO permiso (descper) VALUES ('$this->_descriopcion')";
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
//    print_r($sql);
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $this->setPropiedades($consulta['idper'], strtoupper($consulta['descper']));
                    return TRUE;
                }else{
                    return FALSE;
                }
            }
        }
        
        public function modificar($sql,$conexion){
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    return TRUE;
                }else{
                    return FALSE;
                }
            }
        }
        
        public function __get($name){
            return $this->$name;
        }
        
    }