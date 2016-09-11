<?php
    class Horper
    {
        private $_id;
        private $_idpersona;
        private $_idhorario;

        public function __construct(){
            $this->_id = "";
            $this->_idpersona= "";
            $this->_idhorario = "";
        }

        public function setPropiedades($idpersona,$idhorario){
            $this->_idpersona = $idpersona;
            $this->_idhorario = $idhorario;         
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO horario_persona (idper,idhor) VALUES 
                ('$this->_idpersona','$this->_idhorario')";
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $this->setPropiedades($consulta['idhorper'], $consulta['idper'], $consulta['idhor']);
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
    }