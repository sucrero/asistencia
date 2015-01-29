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
        }

        public function setPropiedades($cedula,$nombre,$apellido,$correo,$dependencia,$telefono,$cargo,$condicion){
            $this->_cedula = $cedula;
            $this->_nombre = strtoupper($nombre);
            $this->_apellido = strtoupper($apellido);
            $this->_correo = $correo;
            $this->_dependencia = $dependencia; //nacional o estadal
            $this->_telefono = $telefono;
            $this->_cargo = $cargo;
            $this->_condicion = $condicion;
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO personal (cedper,nomper,apeper,emailper,dependencia,telfper,cargo,condicion) VALUES 
                ('$this->_cedula','$this->_nombre','$this->_apellido','$this->_correo','$this->_dependencia','$this->_telefono','$this->_cargo','$this->_condicion')";
//            print_r($sql);            exit();
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
//    print_r($sql);
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $this->setPropiedades($consulta['idper'], $consulta['cedper'], strtoupper($consulta['nomper']), strtoupper($consulta['apeper']),
                    $consulta['emailper'],$consulta['dependencia'], $consulta['telfper'],$consulta['cargo'], $consulta['condicion']);
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