<?php
    function  __autoload($class_name){
      include_once 'DBMetodos.php';
    }
    class Postgres extends DataAccess implements DBMetodos{
        public $rowset;
        public $conexion=null;
        public $conectado=false;
        public $registros=0;
        public $resultado=null;

        function __construct(){}

        function __destruct(){
            if ($this->conectado){
                $this->desconectar();
            }
        }		
        function conectar($host, $user, $password, $database){
            $this->conexion=@pg_connect("dbname=$database host=$host user=$user password=$password");
            if ($this->conexion){
                $this->conectado=true;
                return true;
            }else{
                $this->conectado=false;
            }
        }
        function desconectar(){
            if ($this->conectado){
                pg_close($this->conexion);
            }
        }
        function seleccionarDB($database){
            if ($this->conectado){
                $sql='use $database';
                pg_query($sql, $this->conexion);
                if ($database==pg_dbname($this->conexion))
                    return true;
                else
                    return false;
            }
        }

        function ejecutarSql($sql){
            if ($this->conectado){
                if ($this->resultado = pg_query($this->conexion, $sql)){
                    if(pg_affected_rows($this->resultado)>=0){
                        $this->rowset=pg_fetch_assoc($this->resultado);
                        $this->registros= pg_num_rows($this->resultado);
                        return true;
                    }
                }
            }
        }
        function operarRegistro($sql){
            if ($this->conectado){
                $this->resultado = pg_query($this->conexion,$sql);
                if ($this->resultado){
                    return true;
                }else{
                    return false;				
                }
            }
        }

        function limpiar(){
            if ($this->conectado){		
                if ($this->resultado){
                    pg_free_result($this->resultado);
                    $this->resultado=null;
                    // unset ($this->resultado);
                }
            }
        }

        function &devolver_recordset(){
            if ($this->conectado){		
                if ($this->resultado){
                    return $this->rowset;
                }
            }
        }

        function siguiente(){
            if ($this->conectado){		
                if ($this->resultado){
                    if ($this->rowset){	
                        $this->rowset=pg_fetch_assoc($this->resultado);
                        return true;
                    }else{
                        return false;	
                    }
                }
            }
        }
        function seek($id){
            if ($this->registros>$id){
                pg_result_seek($this->resultado,$id);
                $this->rowset=pg_fetch_assoc($this->resultado);
                return true;
            }
        }
        function anterior() {}
    } // fin de la clase
    // @: desabilita el error
    // pg_errno (postgre)
    // $mysqli->errno