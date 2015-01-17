<?php
    class Personal
    {
        private $_id;
        private $_cedula;
        private $_nombre;
        private $_apellido;
        private $_correo;
        private $_tipo; //nacional o estadal
        private $_telefono;


        public function __construct(){
            $this->_id = "";
            $this->_cedula = "";
            $this->_nombre = "";
            $this->_apellido = "";
            $this->_correo = "";
            $this->_tipo = ""; //nacional o estadal
            $this->_telefono = "";
            
        }

        public function setPropiedades($cedula,$nombre,$apellido,$correo,$tipo,$telefono){
            $this->_cedula = $cedula;
            $this->_nombre = strtoupper($nombre);
            $this->_apellido = strtoupper($apellido);
            $this->_correo = $correo;
            $this->_tipo = $tipo; //nacional o estadal
            $this->_telefono = $telefono;
        }
        
        public function ingresar($conexion){
            $sql = "INSERT INTO personal (cedper,nomper,apeper,emailper,tipoper,telfper) VALUES 
                ('$this->_cedula','$this->_nombre','$this->_apellido','$this->_correo','$this->_tipo','$this->_telefono')";
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
                    $consulta['emailper'],$consulta['tipoper'], $consulta['telfper']);
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