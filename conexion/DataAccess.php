<?php
    class DataAccess
    {
        private  $motor='Postgres';
        private  $objeto=null;
        public   $host='';
        public   $user='';
        public   $password='';
        public   $database='';
        function __construct($motor, $host, $user, $password, $database){     
            $this->motor = $motor;
            require_once $this->motor.'.php';
            if (class_exists($this->motor)){ 
                $this->objeto=new $this->motor();
                $this->objeto->conectar($host, $user, $password, $database);
                if ($this->objeto->conectado) {
                    return true;
                }else{
                    return false;	
                 }
            }
        }//fin function
        function __get( $propiedad ){
            return $this->objeto->$propiedad;
        }
        function __call($methodname, $args){
            if ($this->objeto->conectado){
                if (method_exists($this->objeto, $methodname)){
                    switch (count($args)){
                        case 0: 
                            $a=$this->objeto->$methodname();
                            break;
                        case 1:
                            $a=$this->objeto->$methodname($args[0]);
                            break;
                        case 2:
                            $a=$this->objeto->$methodname($args[0],$args[1]);
                            break;
                        case 3:
                            $a=$this->objeto->$methodname($args[0],$args[1],$args[2]);
                            break;
                        case 4:
                            $a=$this->objeto->$methodname($args[0],$args[1],$args[2],$args[3]);
                            break;
                    }
                    return $a;
                }    
            }
        }
    } // fin de clase