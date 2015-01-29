<?php
    class Asistencia
    {
        private $_id;
        private $_hora;
        private $_fecha;
        private $_idpersona;
        
        public function __construct(){
            $this->_id = "";
            $this->_hora = date('h:i:s A');
            $this->_fecha = date('Y-m-d');
            $this->_idpersona = "";
        }
        
        public function setPropiedades($persona){            
            $this->_idpersona = $persona;
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO asistencia (idper,hora,fecha) VALUES 
                ('$this->_idpersona','$this->_hora','$this->_fecha')";
//            print_r($sql);            die();
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $this->setPropiedades($consulta['idasis'], $consulta['idper'], $consulta['hora'], $consulta['fecha']);
                    return TRUE;
                }else{
                    return FALSE;
                }
            }
        }
        
        public function modificar($sql,$conexion){
            if(($consulta = $conexion->ejecutarSql($sql))){
                if($conexion->registros > 0){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }