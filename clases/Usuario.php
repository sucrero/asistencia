<?php
    class Usuario
    {
        private $_id;
        private $_login;
        private $_clave;
        private $_tipo;
        private $_fecha;
        private $_status;
        private $_cedula;
        private $_nombre;
        private $_apellido;


        public function __construct(){
            $this->_id = "";
            $this->_login = "";
            $this->_clave = "";
            $this->_tipo = "";
            $this->_fecha = "";
            $this->_status = "ACTIVO";
            $this->_cedula = "";
            $this->_nombre = "";
            $this->_apellido = "";
        }

        public function setPropiedades($login,$clave,$tipo,$cedula,$nombre,$apellido){
            $this->_login = strtoupper($login);
            $this->_clave = $clave;
            $this->_tipo = strtoupper($tipo);
            $this->_fecha = date('Y-m-d H:m:s');
            $this->_cedula = $cedula;
            $this->_nombre = strtoupper($nombre);
            $this->_apellido = strtoupper($apellido);
        }
        public function ingresar($conexion){
            $sql = "INSERT INTO usuario (nombreusu,claveusu,tipousu,fechausu,statususu,cedulausu,nombusu,apeusu) VALUES 
                ('$this->_login','$this->_clave','$this->_tipo','$this->_fecha','ACTIVO','$this->_cedula','$this->_nombre','$this->_apellido')";
//            print_r($sql);
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
        
        public function buscar($sql,$conexion){
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $f = $consulta['fechausu'];
                    $this->setPropiedades($consulta['idusuario'], strtoupper($consulta['nombreusu']), $consulta['claveusu'], $consulta['tipousu'], substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4),
                    $consulta['statususu'],$consulta['cedulausu'], strtoupper($consulta['nombusu']), strtoupper($consulta['apeusu']));
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
        
        public function maxId($tabla,$campo,$conexion){
            $sql = "SELECT MAX($campo) AS maximo FROM $tabla";
            if($conexion->ejecutarSql($sql)){
                if($conexion->registros > 0){
                    $consulta = $conexion->devolver_recordset();
                    $id = $consulta['maximo'] + 1;
                }else{
                    $id = 0;
                }
            }
            return $id;
        }
        
        public function combinarClave($pas,$num){
            $patron = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $selt = sprintf('$2a$%02d$', $num);
            for($i = 0; $i < 22; $i++){
                $selt .= $patron[ rand(0, strlen($patron)-1) ];
            }
            return crypt($pas, $selt);
        }
        
        public function descombinarClave($clavenormal,$clavecifrada){
            if(crypt($clavenormal, $clavecifrada) == $clavecifrada){
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }