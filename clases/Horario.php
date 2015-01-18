<?php
class Horario
{
    private $_id;
    private $_horainiman;
    private $_horafinman;
    private $_horainitar;
    private $_horafintar;
    private $_descripcion;
    private $_dias;

    public function setPropiedades($horainiman,$horafinman,$horainitar,$horafintar,$descripcion,$dias)
    {
        $this->_horainiman = $horainiman;
        $this->_horafinman = $horafinman;
        $this->_horainitar = $horainitar;
        $this->_horafintar = $horafintar;
        $this->_descripcion = strtoupper($descripcion);
        $this->_dias = $dias;
    }
    
    public function ingresar($conexion){
            $sql = "INSERT INTO horario (horainiman,horafinmanana,horainitar,horafintar,descripcionhor,dias) VALUES 
                ('$this->_horainiman','$this->_horafinman','$this->_horainitar','$this->_horafintar','$this->_descripcion','$this->_dias')";
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
                $this->setPropiedades($consulta['idhor'],$consulta['horainiman'],$consulta['horafinmanana'],$consulta['horainitar'],$consulta['horafintar'],$consulta['descripcionhor'],$consulta['dias']);
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