<?php
    class PermisoPer
    {
        private $_id;
        private $_idpersona;
        private $_desde;
        private $_hasta;
        private $_descripcion;
        private $_idpermiso;

        public function __construct(){
            $this->_id = "";
            $this->_idpersona = "";
            $this->_descripcion = "";
            $this->_desde = "";
            $this->_hasta = "";
            $this->_idpermiso = "";
        }

        public function setPropiedades($idpersona,$descripcion,$desde,$hasta,$idpermiso){
            $this->_idpersona = $idpersona;
            $this->_descripcion = $descripcion;
            $this->_desde = $desde;
            $this->_hasta = $hasta;
            $this->_idpermiso = $idpermiso;
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO permiso_persona (idpersona,desde,hasta,descripcionper,idpermiso) VALUES 
                ('$this->_idpersona','$this->_desde','$this->_hasta','$this->_descripcion','$this->_idpermiso')";
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $this->setPropiedades($consulta['idperper'], $consulta['idpersona'], $consulta['descripcionper'], $consulta['desde'],
                    $consulta['hasta'],$consulta['idpermiso']);
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