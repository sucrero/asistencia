<?php
    class Personal
    {
        private $_id;
        private $_cedula;
        private $_nombre;
        private $_apellido;
        private $_correo;
        private $_dependencia; //nacional o estadal
        private $_telefono;
        private $_cargo;
        private $_condicion;
        private $_status;


        public function __construct(){
            $this->_id = "";
            $this->_cedula = "";
            $this->_nombre = "";
            $this->_apellido = "";
            $this->_correo = "";
            $this->_dependencia = ""; //nacional o estadal
            $this->_telefono = "";
            $this->_cargo = "";
            $this->_condicion = "";
            $this->_status = "";
        }

        public function setPropiedades($cedula,$nombre,$apellido,$correo,$dependencia,$telefono,$cargo,$condicion,$status){
            $this->_cedula = $cedula;
            $this->_nombre = strtoupper($nombre);
            $this->_apellido = strtoupper($apellido);
            $this->_correo = $correo;
            $this->_dependencia = $dependencia; //nacional o estadal
            $this->_telefono = $telefono;
            $this->_cargo = $cargo;
            $this->_condicion = $condicion;
            $this->_status = $status;
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO personal (cedper,nomper,apeper,emailper,dependencia,telfper,cargo,condicion,status) VALUES 
                ('$this->_cedula','$this->_nombre','$this->_apellido','$this->_correo','$this->_dependencia','$this->_telefono','$this->_cargo','$this->_condicion','$this->_status')";
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $this->setPropiedades($consulta['idper'], $consulta['cedper'], strtoupper($consulta['nomper']), strtoupper($consulta['apeper']),
                    $consulta['emailper'],$consulta['dependencia'], $consulta['telfper'],$consulta['cargo'], $consulta['condicion'],$consulta['status']);
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