<?php
    require_once 'DataAccess.php';
    $motor="Postgres";
    $host="127.0.0.1";
    $usuario="postgres";
    $clave="postgres";
    $base_datos="asistencia";
    $conexion = new DataAccess($motor, $host, $usuario, $clave, $base_datos);