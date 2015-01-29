<?php
class Horario
{
    private $_id;
    private $_horaentrada;
    private $_horasalida;
    private $_descripcion;

    public function setPropiedades($horaentrada,$horasalida,$descripcion)
    {
        $this->_horaentrada = $horaentrada;
        $this->_horasalida = $horasalida;
        $this->_descripcion = strtoupper($descripcion);
    }
    
    public function ingresar($conexion){
            $sql = "INSERT INTO horario (horentrada,horasalida,descripcionhor) VALUES 
                ('$this->_horaentrada','$this->_horasalida','$this->_descripcion')";
//            print_r($sql);            exit();
            if($consulta = $conexion->ejecutarSql($sql)){
                return $consulta;
            }
        }
    
    public function buscar($sql,$conexion)
    {
        if(($consulta=$conexion->ejecutarSql($sql)))
        {
             if($conexion->registros>0)
             {
                $consulta=$conexion->devolver_recordset();
                $this->setPropiedades($consulta['idhor'],$consulta['horentrada'],$consulta['horasalida'],$consulta['descripcionhor']);
                return true;
             }
             else
             {
                return false;
             }
        }
    }
    public function mostrar($sql,$conexion)
    {
        if(($consulta=$conexion->ejecutarSql($sql)))
            {
                    return $consulta;
            }

    }    
}