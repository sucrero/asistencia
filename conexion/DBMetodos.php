<?php 
    interface DBMetodos{
        public function conectar($host, $user, $password, $database);
        public function desconectar();
        public function seleccionarDB($Nombre_DB);
        public function ejecutarSql($sql);
        public function siguiente();
        public function anterior();	
        public function seek($id);
        public function &devolver_recordset();
        public function limpiar();	
    }