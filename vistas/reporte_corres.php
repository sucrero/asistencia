<?php
    session_start();
    header("Content-type: application/pdf; charset=utf-8");
    require '../clases/PDF_MC_Table.php';
    include_once '../clases/Persona.php';
    include_once '../clases/Correspondencia.php';
    include_once '../clases/Usuario.php';
    include_once '../conexion/conexion.php';
    $objPer = new Persona();
    $objCor = new Correspondencia();
    $objUsu = new Usuario();
    
    $datos = $_REQUEST['parametro'];
    $tipo = $_REQUEST['tipo'];
    
    if($tipo == 1){
        
        if(ctype_alpha($datos[0])){
            $identificador = $datos[0].'-'.substr($datos, 1,8).'-'.$datos[9];
            $rif = $datos;
            $where = "WHERE rifper='".$rif."'";
        }else{
            $identificador = number_format($datos,'0','','.');
            $cedula = $datos;
            $where = "WHERE cedulaper='".$cedula."'";
        }
        $sql = 'SELECT * FROM persona '.$where;
        if($objPer->buscar($sql, $conexion)){
            $fila = $conexion->devolver_recordset();
            $contribuyente = ucwords(strtolower(utf8_decode($fila['nombreper']))).' '.ucwords(strtolower(utf8_decode($fila['apellidoper'])));
            $sql = "SELECT * FROM correspondencia WHERE idpersona='".$fila['idpersona']."' ORDER BY asuntocorres";
            if($objCor->buscar($sql, $conexion)){
                if($conexion->registros > 0){
                    $i = 0;
                    do{
                        $res[$i] = $conexion->devolver_recordset();
                        $i++;
                    }while(($conexion->siguiente()) && ($i != $conexion->registros));
                    for($i = 0; $i < count($res); $i++){
                        $objUsu->buscar("SELECT * FROM usuario WHERE idusuario='".$res[$i]['idusuario']."'", $conexion);
                        $res[$i]['u'] = $conexion->devolver_recordset();
                        $res[$i]['p'] = $fila;
                    }
                }else{
                    $res = 0;
                }
            }else{
                $res = 0;
            }
        }else{
            $res = 0;
        }
        $titulo = "CORRESPONDENCIAS DEL CONTRIBUYENTE: ".$contribuyente.'  '.$identificador;
    }else if($tipo == 2){
        $fecha = explode(" ", $datos);
        $sql = "SELECT * FROM correspondencia WHERE feccorres BETWEEN '".$fecha[0]."' AND '".$fecha[1]."' ORDER BY feccorres";
        if($objCor->buscar($sql, $conexion)){
            if($conexion->registros > 0){
                $i = 0;
                do{
                    $res[$i] = $conexion->devolver_recordset();
                    $i++;
                }while(($conexion->siguiente()) && ($i != $conexion->registros));
                for ($i = 0; $i < count($res);$i++){
                    $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
                    $res[$i]['p'] = $conexion->devolver_recordset();
                    $objUsu->buscar("SELECT * FROM usuario WHERE idusuario='".$res[$i]['idusuario']."'", $conexion);
                    $res[$i]['u'] = $conexion->devolver_recordset();
                }
            }else{
                $res = 0;
            }
        }else{
            $res = 0;
        }
        $titulo = "CORRESPONDENCIAS REGISTRADAS ENTRE  ".$fecha[0].'  Y  '.$fecha[1];
    }else if($tipo == 3){
        $sql = "SELECT * FROM usuario WHERE cedulausu='".$datos."'";
        $identificador = number_format($datos,'0','','.');
        if($objUsu->buscar($sql, $conexion)){
            $fila = $conexion->devolver_recordset();
            $datosUsu = ucwords(strtolower(utf8_decode($fila['nombusu']))).' '.ucwords(strtolower(utf8_decode($fila['apellidousu'])));
            $sql = "SELECT * FROM correspondencia WHERE idusuario='".$fila['idusuario']."' ORDER BY asuntocorres";
            if($objCor->buscar($sql, $conexion)){
                if($conexion->registros > 0){
                    $i = 0;
                    do{
                        $res[$i] = $conexion->devolver_recordset();
                        $i++;
                    }while(($conexion->siguiente()) && ($i != $conexion->registros));
                    for($i = 0; $i < count($res); $i++){
                        $objUsu->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
                        $res[$i]['p'] = $conexion->devolver_recordset();
                        $res[$i]['u'] = $fila;
                    }
                }else{
                    $res = 0;
                }
            }else{
                $res = 0;
            }
        }else{
            $res = 0;
        }
        $titulo = "CORRESPONDENCIAS REGISTRADAS POR: ".$datosUsu.' - '.$identificador;
    }else{
        if($objCor->buscar("SELECT * FROM correspondencia ORDER BY asuntocorres", $conexion)){
//            $res = 1;
            if($conexion->registros > 0){
                $i = 0;
                do{
                    $res[$i] = $conexion->devolver_recordset();
                    $i++;
                }while(($conexion->siguiente()) && ($i != $conexion->registros));
                for ($i = 0; $i < count($res);$i++){
                    $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
                    $res[$i]['p'] = $conexion->devolver_recordset();
                    $objUsu->buscar("SELECT * FROM usuario WHERE idusuario='".$res[$i]['idusuario']."'", $conexion);
                    $res[$i]['u'] = $conexion->devolver_recordset();
                }
            }else{
                $res = 0;
            }
        }else{
            $res = 0;
        }
        $titulo = "CORRESPONDENCIAS REGISTRADAS";
    }
    
    
    
    class PDF extends PDF_MC_Table{
        function Header() {
            global $titulo;            
            $size = 150;
            $absx = (210 - $size) / 2;
            $this->Image('../img/banner.jpg', $absx, 5, $size);
            $this->Ln(20);
            $this->SetFont('Arial', 'IB', 10);
            $this->Cell(180, 10, $titulo,0, 0, 'C');
            $this->Ln(15);
        }
        
        function Footer() {
            $dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $this->SetY(-15);
           $this->SetFont('Arial', 'I', 7);
            $this->SetTextColor(128);
            $this->Cell(60,4,  html_entity_decode($dias[date('w')]).' '.date('j').' de '.$meses[date('n')-1].' de '.date('Y').' - '.date("H:i:s"),0,0,'L');
            $this->Cell(60,4, 'Impreso por: '.$_SESSION['cuenta'], 0, 0, 'C');
            $this->Cell(0, 4, 'Pagina '.$this->PageNo().'/{nb}', 0, 1, 'R');
        }
        function contenido($res){
          
            $this->Ln(2);           
            if($res != 0){
                $this->SetFont('Arial','',7);
                for($i = 0;$i < count($res);$i++){
                    if($res[$i]['p']['cedulaper'] != '' && $res[$i]['p']['rifper'] != ''){
                        $documento = number_format($res[$i]['p']['cedulaper'],'0','','.');
                    }else{
                        if($res[$i]['p']['cedulaper'] != ''){
                            $documento = number_format($res[$i]['p']['cedulaper'],'0','','.');
                        }else{
                            $documento = substr(strtoupper($res[$i]['p']['rifper'],0,1)).'-'.substr($res[$i]['p']['rifper'],1,8).'-'.substr($res[$i]['p']['rifper'],9,9);
                        }
                    }
                    
                    $this->SetFillColor(173,216,230);
                    $this->Cell(180, 5,'Registro Nro.:   '.($i+1), 1, 1, 'L',true);
                    $this->Cell(90, 5,utf8_decode(html_entity_decode('C&oacute;digo:   ')).$res[$i]['idcorrespondencia'], 1,0, 'L');
                    $this->Cell(90, 5,'Registrado el: '.substr($res[$i]['feccorres'],8,2).' / '.substr($res[$i]['feccorres'],5,2).' / '.substr($res[$i]['feccorres'],0,4), 1, 1, 'L');
                    
                    $this->Cell(180, 5,'Nombre Contribuyente: '.$documento.' - '.ucwords(strtolower(utf8_decode($res[$i]['p']['nombreper'].' '.$res[$i]['p']['apellidoper']))), 1, 1, 'L');
                    
                    $this->SetFillColor(211,211,211);
                    $this->Cell(180, 5,'Datos de la Correspondencia', 1, 1, 'C',TRUE);
                    
                    $this->Cell(90, 5,'Tipo de Correspondencia: '.utf8_decode(html_entity_decode($res[$i]['tipocorres'])), 1, 0, 'L');
                    $this->Cell(90, 5,'Tipo de Solicitud : '.utf8_decode(html_entity_decode($res[$i]['recaudoscorres'])), 1, 1, 'L');
                    
                    $this->Cell(180, 5,'Asunto: '.utf8_decode(html_entity_decode($res[$i]['asuntocorres'])), 1, 1, 'L');
                    
                    $this->Ln(3);
                } 
            }else{
                $this->SetFont('Arial','B',20);
                $this->Cell(180, 5,'NO EXISTEN REGISTROS PARA MOSTRAR', 0, 1, 'C');
            }
            
            
        }
        
        
    }
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 25);
    $pdf->AddPage();
    $pdf->contenido($res);
    $nombre = "correspondencias";
    $pdf->Output($nombre,"I");
?>