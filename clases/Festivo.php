<?php
    class Festivo
    {
        private $_id;
        private $_descripcion;
        private $_fecha;

        public function __construct(){
            $this->_id = "";
            $this->_descripcion = "";
            $this->_fecha = "";
        }

        public function setPropiedades($descripcion,$fecha){
            $this->_descripcion = strtoupper($descripcion);
            $this->_fecha = $fecha;         
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO diasfestivo (fecha,descfest) VALUES 
                ('$this->_fecha','$this->_descripcion')";
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $this->setPropiedades($consulta['idfestivo'], $consulta['fecha'], $consulta['descfest']);
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