<?php
    class Festivo
    {
        private $_id;
        private $_descripcion;
        private $_fecha;
        private $_fecha2;

        public function __construct(){
            $this->_id = "";
            $this->_descripcion = "";
            $this->_fecha = "";
            $this->_fecha2 = "";
        }

        public function setPropiedades($descripcion,$fecha,$fecha2){
            $this->_descripcion = strtoupper($descripcion);
            $this->_fecha = $fecha;
            $this->_fecha2 = $fecha2;
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO diasfestivo (fecha,descfest,fecha2) VALUES 
                ('$this->_fecha','$this->_descripcion','$this->_fecha2')";
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $this->setPropiedades($consulta['idfestivo'], $consulta['fecha'], $consulta['descfest'], $consulta['fecha2']);
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