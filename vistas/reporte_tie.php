<?php
    session_start();
//    header("Content-type: application/pdf; charset=utf-8");
    require '../clases/PDF_MC_Table.php';
    include_once '../clases/Persona.php';
    include_once '../clases/Tierra.php';
    include_once '../clases/Parroquia.php';
    include_once '../clases/Municipio.php';
    include_once '../clases/Usuario.php';
    include_once '../conexion/conexion.php';
    $objPer = new Persona();
    $objTie = new Tierra();
    $objPar = new Parroquia();
    $objMun = new Municipio();
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
            $sql = "SELECT * FROM tierra WHERE idpersona='".$fila['idpersona']."' ORDER BY fectierra";
            if($objTie->buscar($sql, $conexion)){
                if($conexion->registros > 0){
                    $i = 0;
                    do{
                        $res[$i] = $conexion->devolver_recordset();
                        $i++;
                    }while(($conexion->siguiente()) && ($i != $conexion->registros));
                    for($i = 0;$i < count($res);$i++){                        
                        $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
                        $res[$i]['c'] = $conexion->devolver_recordset();
                        $res[$i]['p'] = $fila;
                        $objPar->buscar("SELECT * FROM parroquia WHERE idparroquia='".$res[$i]['idparroquia']."'", $conexion);
                        $res[$i]['par'] = $conexion->devolver_recordset();
                        $objMun->buscar("SELECT * FROM municipio WHERE idmunicipio='".$res[$i]['par']['idmunicipio']."'", $conexion);
                        $res[$i]['mun'] = $conexion->devolver_recordset();
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
        
        $titulo = "TIERRA DEL CONTRIBUYENTE: ".$contribuyente.'  '.$identificador;
    }else if($tipo == 2){
        
        $fecha = explode(" ", $datos);
        $sql = "SELECT * FROM tierra WHERE fectierra BETWEEN '".$fecha[0]."' AND '".$fecha[1]."' ORDER BY fectierra";
        if($objTie->buscar($sql, $conexion)){
            if($conexion->registros > 0){
                $i = 0;
                do{
                    $res[$i] = $conexion->devolver_recordset();
                    $i++;
                }while(($conexion->siguiente()) && ($i != $conexion->registros));
                for($i = 0;$i < count($res);$i++){
                    $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
                    $res[$i]['c'] = $conexion->devolver_recordset();
                    $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
                    $res[$i]['p'] = $conexion->devolver_recordset();
                    $objPar->buscar("SELECT * FROM parroquia WHERE idparroquia='".$res[$i]['idparroquia']."'", $conexion);
                    $res[$i]['par'] = $conexion->devolver_recordset();
                    $objMun->buscar("SELECT * FROM municipio WHERE idmunicipio='".$res[$i]['par']['idmunicipio']."'", $conexion);
                    $res[$i]['mun'] = $conexion->devolver_recordset();
                }
            }else{
                $res = 0;
            }
        }else{
            $res = 0;
        }
        
        $titulo = "TIERRAS REGISTRADAS ENTRE  EL  ".$fecha[0].'  Y  '.$fecha[1];
    }else if($tipo == 3){
        
        $sql = "SELECT * FROM tierra WHERE idparroquia='".$datos."' ORDER BY fectierra";
        if($objTie->buscar($sql, $conexion)){
            if($conexion->registros > 0){
                $i = 0;
                do{
                    $res[$i] = $conexion->devolver_recordset();
                    $i++;
                }while(($conexion->siguiente()) && ($i != $conexion->registros));
                for($i = 0;$i < count($res);$i++){
                    $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
                    $res[$i]['c'] = $conexion->devolver_recordset();
                    $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
                    $res[$i]['p'] = $conexion->devolver_recordset();
                    $objPar->buscar("SELECT * FROM parroquia WHERE idparroquia='".$res[$i]['idparroquia']."'", $conexion);
                    $res[$i]['par'] = $conexion->devolver_recordset();
                    $objMun->buscar("SELECT * FROM municipio WHERE idmunicipio='".$res[$i]['par']['idmunicipio']."'", $conexion);
                    $res[$i]['mun'] = $conexion->devolver_recordset();
                }
            }else{
                $res = 0;
            }
        }else{
            $res = 0;
        }
        $titulo = "TIERRAS REGISTRADAS DE LA PARROQUIA: ".$res[0]['par']['nombreparroquia'];
    
    }else if($tipo == 4){    
        
        $sql = "SELECT * FROM usuario WHERE cedulausu='".$datos."'";
        if($objUsu->buscar($sql, $conexion)){
            $fila = $conexion->devolver_recordset();
            $operador = number_format($fila['cedulausu'],'0','','.').' - '.$fila['nombusu'].' '.$fila['apellidousu'];
            $sql = "SELECT * FROM tierra WHERE idusuario='".$fila['idusuario']."' ORDER BY fectierra";
            if($objTie->buscar($sql, $conexion)){
                if($conexion->registros > 0){
                    $i = 0;
                    do{
                        $res[$i] = $conexion->devolver_recordset();
                        $i++;
                    }while(($conexion->siguiente()) && ($i != $conexion->registros));
                    for($i = 0;$i < count($res);$i++){
                        $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
                        $res[$i]['c'] = $conexion->devolver_recordset();
                        $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
                        $res[$i]['p'] = $conexion->devolver_recordset();
                        $objPar->buscar("SELECT * FROM parroquia WHERE idparroquia='".$res[$i]['idparroquia']."'", $conexion);
                        $res[$i]['par'] = $conexion->devolver_recordset();
                        $objMun->buscar("SELECT * FROM municipio WHERE idmunicipio='".$res[$i]['par']['idmunicipio']."'", $conexion);
                        $res[$i]['mun'] = $conexion->devolver_recordset();
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
        $titulo = "TIERRAS REGISTRADAS POR: ".$operador;
        
    }else{
        
        if($objTie->buscar("SELECT * FROM tierra ORDER BY fectierra", $conexion)){
            if($conexion->registros > 0){
                $i = 0;
                do{
                    $res[$i] = $conexion->devolver_recordset();
                    $i++;
                }while(($conexion->siguiente()) && ($i != $conexion->registros));
                for ($i = 0;$i < count($res); $i++){
                    $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
                    $res[$i]['p'] = $conexion->devolver_recordset();
                    $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
                    $res[$i]['c'] = $conexion->devolver_recordset();
                    $objPar->buscar("SELECT * FROM parroquia WHERE idparroquia='".$res[$i]['idparroquia']."'", $conexion);
                    $res[$i]['par'] = $conexion->devolver_recordset();
                    $objMun->buscar("SELECT * FROM municipio WHERE idmunicipio='".$res[$i]['par']['idmunicipio']."'", $conexion);
                    $res[$i]['mun'] = $conexion->devolver_recordset();
                }
            }else{
                $res = 0;
            }
        }
        
        $titulo = "TIERRAS REGISTRADAS";
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
                    
                    if($res[$i]['c']['cedulaper'] != '' && $res[$i]['c']['rifper'] != ''){
                        $documentoc = number_format($res[$i]['c']['cedulaper'],'0','','.');
                    }else{
                        if($res[$i]['c']['cedulaper'] != ''){
                            $documentoc = number_format($res[$i]['c']['cedulaper'],'0','','.');
                        }else{
                            if($res[$i]['c']['rifper'] != ''){
                                $documentoc = substr(strtoupper($res[$i]['c']['rifper'],0,1)).'-'.substr($res[$i]['c']['rifper'],1,8).'-'.substr($res[$i]['c']['rifper'],9,9);
                            }else{
                                $documentoc = " No posee ";
                            }
                        }
                    }
                    
                    $this->SetFillColor(173,216,230);
                    $this->Cell(180, 5,'Registro Nro.:   '.($i+1), 1, 1, 'L',true);
                    $this->Cell(90, 5,utf8_decode(html_entity_decode('C&oacute;digo:   ')).$res[$i]['idtierra'], 1,0, 'L');
                    $this->Cell(90, 5,'Registrado el: '.substr($res[$i]['fectierra'],8,2).' / '.substr($res[$i]['fectierra'],5,2).' / '.substr($res[$i]['fectierra'],0,4), 1, 1, 'L');
                    
                    $this->Cell(90, 5,'Nombre Contribuyente: '.$documento.' - '.ucwords(strtolower(utf8_decode($res[$i]['p']['nombreper'].' '.$res[$i]['p']['apellidoper']))), 1, 0, 'L');
                    if($documentoc == " No posee "){
                        $this->Cell(90, 5,'Nombre Co-Propietario: '.$documentoc, 1, 1, 'L');
                    }else{
                        $this->Cell(90, 5,'Nombre Co-Propietario: '.$documentoc.' - '.$res[$i]['c']['nombreper'].' '.$res[$i]['c']['apellidoper'], 1, 1, 'L');
                    }
                    
                    $this->SetFillColor(211,211,211);
                    $this->Cell(180, 5,'Datos del Registro', 1, 1, 'C',TRUE);
                    
                    $this->Cell(90, 5,'Fecha de Registro: '.substr($res[$i]['fecregistrotierra'],8,2).' / '.substr($res[$i]['fecregistrotierra'],5,2).' / '.substr($res[$i]['fecregistrotierra'],0,4), 1, 0, 'L');
                    $this->Cell(90, 5,'Tipo de Documento: '.$res[$i]['tipodoctierra'], 1, 1, 'L');
                    
                    $this->Cell(60, 5,utf8_decode(html_entity_decode('N&uacute;mero de Folio: ')).$res[$i]['foliotierra'], 1, 0, 'L');
                    $this->Cell(60, 5,utf8_decode(html_entity_decode('N&uacute;mero de Tomo: ')).$res[$i]['tomotierra'], 1, 0, 'L');
                    $this->Cell(60, 5,utf8_decode(html_entity_decode('N&uacute;mero de Protocolo: ')).$res[$i]['protocolo'], 1, 1, 'L');
                    
                    $this->SetFillColor(211,211,211);
                    $this->Cell(180, 5,utf8_decode(html_entity_decode('Ubicaci&oacute;n y Linderos de la Tierra')), 1, 1, 'C',TRUE);
                    
                    $this->Cell(25, 5,'Estado: Sucre', 1, 0, 'L');
                    $this->Cell(40, 5,'Ciudad: '.ucwords(strtolower(utf8_decode($res[$i]['ciudadtierra']))), 1, 0, 'L');                    
                    $this->Cell(60, 5,'Municipio: '. ucwords(utf8_decode(html_entity_decode($res[$i]['mun']['nombremunicipio']))), 1, 0, 'L');
                    $this->Cell(55, 5,'Parroquia: '. ucwords(utf8_decode(html_entity_decode($res[$i]['par']['nombreparroquia']))), 1, 1, 'L');
                    $this->Cell(180, 5,'Punto de Referencia: '.ucwords(strtolower(utf8_decode($res[$i]['ptoreftierra']))), 1, 1, 'L');
                    $this->Cell(180, 5,'Lindero Norte: '.ucwords(strtolower(utf8_decode($res[$i]['nortetierra']))), 1, 1, 'L');
                    $this->Cell(180, 5,'Lindero Sur: '.ucwords(strtolower(utf8_decode($res[$i]['surtierra']))), 1, 1, 'L');
                    $this->Cell(180, 5,'Lindero Este: '.ucwords(strtolower(utf8_decode($res[$i]['estetierra']))), 1, 1, 'L');
                    $this->Cell(180, 5,'Lindero Oeste: '.ucwords(strtolower(utf8_decode($res[$i]['oestetierra']))), 1, 1, 'L');
                    
                    $this->SetFillColor(211,211,211);
                    $this->Cell(180, 5,'Uso(s) y Clase(s) de la Tierra', 1, 1, 'C',TRUE);
                    
                    $this->Cell(180, 5,'Rubro: '.$res[$i]['rubrotierra'], 1, 1, 'L');
                    
                    $this->Cell(50, 5,'Uso: '.ucwords(strtolower(utf8_decode($res[$i]['usotierra']))), 1, 0, 'L');
                    $this->Cell(50, 5,'Clase: '.$res[$i]['clasetierra'], 1, 0, 'L');
                    $this->Cell(40, 5,utf8_decode(html_entity_decode('Extensi&oacute;n por Rubro: ')).$res[$i]['extensiontierra'], 1, 0, 'L');
                    $this->Cell(40, 5,utf8_decode(html_entity_decode('Hect&aacute;reas: ')).$res[$i]['hectarreastierra'], 1, 1, 'L');
                                     
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
    $nombre = "viviendas";
    $pdf->Output($nombre,"I");
?>