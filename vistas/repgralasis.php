<?php
    session_start();
    require '../clases/PDF_MC_Table.php';
    require_once '../clases/Personal.php';
    require_once '../clases/Horario.php';
    require_once '../clases/Horper.php';
    require_once '../clases/Permiso.php';
    require_once '../clases/PermisoPer.php';
    require_once '../clases/Asistencia.php';
    require_once '../conexion/conexion.php';
    require_once '../clases/Festivo.php';
    
    $objPers = new Personal();
    $objHora = new Horper();
    $objHorPers = new Horper();
    $objPermi = new Permiso();
    $objPerPers = new PermisoPer();
    $objAsis = new Asistencia();
    $objFest = new Festivo();
    
    $datos = $_REQUEST['parametros'];
    
    list($cargo,$dependencia,$condicion,$mes,$anio) = explode(' ', $datos);
    
    $mesT = $mes;
    $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
    $desde = $anio.'-'.$mes.'-01';
    $hasta =  $anio.'-'.$mes.'-'.$dias;
    $habiles2 = '';
    $numHabiles = 0;
    for($i=1;$i <= $dias;$i++){
        $dia = date("N", strtotime($anio.'-'.$mes.'-'.$i));
        if($dia != 6 && $dia != 7){
            $habiles2[$numHabiles] = date('Y-m-d',strtotime($anio.'-'.$mes.'-'.$i));
            $numHabiles++;
        }
    }
    $j = 0;
    for($i=0;$i < count($habiles2);$i++){
        $sql = "SELECT * FROM diasfestivo WHERE fecha <= '".$habiles2[$i]."' AND fecha2 >= '".$habiles2[$i]."'";
        if($objHora->buscar($sql, $conexion)){
        }else{
            $habiles[$j++] = $habiles2[$i];
        }
    }
    $sql = "SELECT * FROM diasfestivo WHERE fecha >= '".$desde."' AND fecha <= '".$hasta."'";
    if($objFest->buscar($sql, $conexion)){
        $i = 0;
        do{
            $festivos[$i] = $conexion->devolver_recordset();
            $i++;
        }while(($conexion->siguiente()) && ($i != $conexion->registros));
    }
    
    for($i = 0;$i < count($festivos);$i++){
        $w = 0;
        for($j = 0;$j < count($habiles);$j++){
            if(strtotime($festivos[$i]['fecha']) == strtotime($habiles[$j])){
                unset($habiles[$j]);
            }
        }
        
    }
    $numHabiles = count($habiles);
    
    if($cargo != 'TODOS' && $dependencia == 'TODOS' && $condicion == 'TODOS'){
        $where = " WHERE a.status = 'ACTIVO' AND a.cargo = '".$cargo."'";
        $subtitulo = html_entity_decode("Cargo: ".$cargo.'  Dependencia: TODOS  Condici&oacute;n: TODOS',ENT_QUOTES,"ISO-8859-1");
    }
    else if($cargo == 'TODOS' && $dependencia != 'TODOS' && $condicion == 'TODOS'){
        $where = " WHERE a.status = 'ACTIVO' AND a.dependencia = '".$dependencia."'";
        $subtitulo = html_entity_decode("Cargo: TODOS  Dependencia: ".$dependencia."  Condici&oacute;n: TODOS",ENT_QUOTES,"ISO-8859-1");
    }
    else if($cargo == 'TODOS' && $dependencia == 'TODOS' && $condicion != 'TODOS'){
        $where = " WHERE a.status = 'ACTIVO' AND a.condicion = '".$condicion."'";
        $subtitulo = html_entity_decode("Cargo: TODOS  Dependencia: TODOS  Condici&oacute;n: ".$condicion,ENT_QUOTES,"ISO-8859-1");
    }
    else if($cargo != 'TODOS' && $dependencia != 'TODOS' && $condicion == 'TODOS'){
        $where = " WHERE a.status = 'ACTIVO' AND a.cargo = '".$cargo."' AND a.dependencia = '".$dependencia."'";
        $subtitulo = html_entity_decode("Cargo: ".$cargo."  Dependencia: ".$dependencia."  Condici&oacute;n: TODOS",ENT_QUOTES,"ISO-8859-1");
    }
    else if($cargo == 'TODOS' && $dependencia != 'TODOS' && $condicion != 'TODOS'){
        $where = " WHERE a.status = 'ACTIVO' AND a.dependencia = '".$dependencia."' AND a.condicion = '".$condicion."'";
        $subtitulo = html_entity_decode("Cargo: TODOS  Dependencia: ".$dependencia."  Condici&oacute;n: ".$condicion,ENT_QUOTES,"ISO-8859-1");
    }
    else if($cargo != 'TODOS' && $dependencia == 'TODOS' && $condicion != 'TODOS'){
        $where = " WHERE a.status = 'ACTIVO' AND a.condicion = '".$condicion."' AND a.cargo = '".$cargo."'";
        $subtitulo = html_entity_decode("Cargo: ".$cargo."  Dependencia: TODOS  Condici&oacute;n: ".$condicion,ENT_QUOTES,"ISO-8859-1");
    }
    else if($cargo != 'TODOS' && $dependencia != 'TODOS' && $condicion != 'TODOS'){
        $where = " WHERE a.status = 'ACTIVO' AND a.condicion = '".$condicion."' AND a.cargo = '".$cargo."' AND a.dependencia = '".$dependencia."'";
        $subtitulo = html_entity_decode("Cargo: ".$cargo."  Dependencia: ".$dependencia."  Condici&oacute;n: ".$condicion,ENT_QUOTES,"ISO-8859-1");
    }
    else if($cargo == 'TODOS' && $dependencia == 'TODOS' && $condicion == 'TODOS'){
        $where = " WHERE a.status = 'ACTIVO'";
        $subtitulo = html_entity_decode("Cargo: TODOS  Dependencia: TODOS  Condici&oacute;n: TODOS",ENT_QUOTES,"ISO-8859-1");
    }
        
   
    $sql = "SELECT * FROM personal as a
                JOIN horario_persona as b ON (a.idper = b.idper)
                JOIN horario as c ON (b.idhor = c.idhor)".$where." ORDER BY nomper,apeper ASC";
    if($objPers->buscar($sql, $conexion)){
        $i = 0;
        do{
            $personas[$i] = $conexion->devolver_recordset();
            $i++;
        }while(($conexion->siguiente()) && ($i != $conexion->registros));
    }else{//NO SE ENCONTRO NINGUNA PERSONA
        
    }
    
    $sql = "SELECT * FROM asistencia WHERE fecha >= '".$desde."' AND fecha <= '".$hasta."'";
    if($objAsis->buscar($sql, $conexion)){
        $i = 0;
        do{
            $asistencia[$i] = $conexion->devolver_recordset();
            $i++;
        }while(($conexion->siguiente()) && ($i != $conexion->registros));
    }else{//NO HAY REGISTROS PARA EL MES SELECCIONADO
        
    }
    
    for($j = 0;$j < count($personas);$j++){
        $asis = 0;
        $inasis = 0;
        $pm = 0;
        $pi = 0;
        $pmt = 0;
        for($k = 0;$k < $numHabiles;$k++){
                $sql = "SELECT * FROM asistencia WHERE idper = '".$personas[$j]['idper']."' AND fecha = '".$habiles[$k]."'";
                if($objAsis->buscar($sql, $conexion)){
                    $asis++;
                }else{
                    $inasis++;
                }
                $sql = "SELECT * FROM p$jermiso_persona as a INNER JOIN permiso as b ON (a.idpermiso = b.idper) WHERE a.idpersona = '".$personas[$j]['idper']."' AND '".$habiles[$k]."' BETWEEN a.desde AND a.hasta";
                if($objPermi->buscar($sql, $conexion)){
                    if($conexion->registros > 0){
                        $permiso = $conexion->devolver_recordset();
                        if($permiso['idper'] == 1){
                            $pm++;
                        }else if($permiso['idper'] == 2){
                            $pi++;
                        }else{
                            $pmt++;
                        }
                    }
                }
        }//fin dias habiles

        $personas[$j]['asis'] = $asis;
        $personas[$j]['inasis'] = $inasis;
        $personas[$j]['pm'] = $pm;
        $personas[$j]['pi'] = $pi;
        $personas[$j]['pmt'] = $pmt;
    }

    class PDF extends PDF_MC_Table{
        function Header() {$this->SetFont('Arial','', 10);
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            global $subtitulo;
            global $numHabiles;
            global $mesT;
            $size = 25;
            $this->SetFont('Arial','', 8);
            $this->Image('../img/logo_nacional.jpg', $absx, 5, 20);
            $this->Cell(190, 3, html_entity_decode("REP&Uacute;BLICA BOLIVARIANA DE VENEZUELA",ENT_QUOTES,"ISO-8859-1"), 0,1,C);
            $this->Cell(190, 3, html_entity_decode("MINISTERIO DEL PODER POPULAR PARA LA EDUCACI&Oacute;N",ENT_QUOTES,"ISO-8859-1"), 0,1,C);
            $this->Cell(190, 3, html_entity_decode("GOBERNACI&Oacute;N DEL ESTADO SUCRE",ENT_QUOTES,"ISO-8859-1"), 0,1,C);
            $this->Cell(190, 3, html_entity_decode("DIRECCI&Oacute;N DE EDUCACI&Oacute;N",ENT_QUOTES,"ISO-8859-1"), 0,1,C);
            $this->Cell(190, 3, 'E.B. "FRANCISCO DE MIRANDA"', 0,1,C);
            $this->Image('../img/logo_escuela.jpg', 100, 27, 12);
            $this->Image('../img/logo_direccion.jpg', 180, 8, 20);
            $this->Ln(18);
            $this->SetFont('Arial','', 10);
            $this->Cell(190, 8, $titulo,0, 0, 'C');
            $this->Ln(1);
            $this->SetFont('Arial','', 10);
            
            $this->Cell(181,5, html_entity_decode("D&iacute;as h&aacute;biles del mes:",ENT_QUOTES,"ISO-8859-1"),0,0,R);
            $this->SetFont('Arial','U', 10);
            $this->Cell(8,5," ".$numHabiles." ",0,1,R);
            $this->SetFont('Arial','', 10);
            $this->Cell(181,5, html_entity_decode("D&iacute;as acumulados del mes:",ENT_QUOTES,"ISO-8859-1"),0,0,R);
            $this->Cell(8,5," ___",0,1,R);
            $this->Ln(7);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(190, 5, 'CONTROL DE ASISTENCIA DEL PERSONAL',0, 1, 'C');
            $this->Cell(190, 5, $subtitulo,0, 1, 'C');
            $this->Ln(7);
            $this->SetFont('Arial','', 10);
            $this->Cell(13, 5, 'Plantel: ',0, 0, 'L');
            $this->SetFont('Arial','U', 10);
            $this->Cell(69, 5, ' E.B. "FRANCISCO DE MIRANDA" ',0, 0, 'L');
            $this->SetFont('Arial','', 10);
            $this->Cell(9, 5, 'Mes: ',0, 0, 'L');
            $this->SetFont('Arial','U', 10);
            $this->Cell(22, 5, ' '.$meses[$mesT-1].' ',0, 0, 'L');
            $this->SetFont('Arial','', 10);
            $this->Cell(60, 5, html_entity_decode('A&ntilde;o escolar: __________',ENT_QUOTES,"ISO-8859-1"),0, 1, 'C');
            $this->Ln(3);
            $this->Cell(13, 5,html_entity_decode("C&oacute;digo: ",ENT_QUOTES,"ISO-8859-1"),0, 0, 'L');
            $this->SetFont('Arial','U', 10);
            $this->Cell(50, 5," 14-061 ",0, 0, 'L');
            $this->SetFont('Arial','', 10);
            $this->Cell(17, 5,'Municipio: ',0, 0, 'L');
            $this->SetFont('Arial','U', 10);
            $this->Cell(10, 5,' SUCRE ',0, 1, 'L');
            $this->SetFont('Arial','', 10);
            $this->Cell(52, 5,html_entity_decode("C&oacute;digo Administrativo Nacional: ",ENT_QUOTES,"ISO-8859-1"),0, 0, 'L');
             $this->SetFont('Arial','U', 10);
            $this->Cell(25, 5," 0DO1491914 ",0, 1, 'L');
            
        }
        
        function Footer() {
            $this->SetY(-50);
            $this->SetFont('Arial', '', 8);
            $this->Cell(190, 5, html_entity_decode('Fecha de Env&iacute;o: __________',ENT_QUOTES,"ISO-8859-1"),0, 1, 'L');
            $this->Cell(190, 5, html_entity_decode('Fecha de Recepci&oacute;n: __________',ENT_QUOTES,"ISO-8859-1"),0, 1, 'L');
            $this->Ln(5);
            $this->Cell(60, 2,'',0, 0, 'C');
            $this->Cell(60, 2, '________________________________',0, 0, 'C');
            $this->Cell(50, 2, '_____________________',0, 1, 'C');
            $this->Cell(60, 2,'',0, 0, 'C');
            $this->Cell(60, 5, 'Apellidos y Nombres del Director',0, 0, 'C');
            $this->Cell(50, 5, 'Firma',0, 1, 'C');
            $this->Cell(190, 10, html_entity_decode('Debe enviarse en los primeros 10 d&iacute;as de cada mes',ENT_QUOTES,"ISO-8859-1"),0, 1, 'L');
            $dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 7);
            $this->SetTextColor(128);
            $this->Cell(60,4,  html_entity_decode($dias[date('w')],ENT_QUOTES,"ISO-8859-1").' '.date('j').' de '.$meses[date('n')-1].' de '.date('Y').' - '.date("H:i:s"),0,0,'L');
            $this->Cell(60,4, 'Impreso por: '.$_SESSION['cuenta'], 0, 0, 'C');
            $this->Cell(0, 4, 'Pagina '.$this->PageNo().'/{nb}', 0, 1, 'R');
        }
        function contenido($res){
            $this->SetFont('Arial','',8);
            $this->Ln(2);           
            
           
            if($res != 0){
                $this->SetFont('Arial','B',7);
                $this->SetFillColor(173,216,230);
                $this->Cell(126, 5,'',0, 0, 'C');
                $this->Cell(32, 5,'En el Mes',1, 0, 'C');
                $this->Cell(32, 5,'Acumulados',1, 1, 'C');
                $this->Cell(7, 5,'Nro.',1, 0, 'C');
                $this->Cell(62, 5,'Apellidos y Nombres',1, 0, 'C');
                $this->Cell(18, 5,'Cedula',1, 0, 'C');
                $this->Cell(39, 5,'Cargo',1, 0, 'C');
                $this->Cell(16, 5,'Asis',1, 0, 'C');
                $this->Cell(16, 5,'Inas y/o P.M',1, 0, 'C');
                $this->Cell(16, 5,'Asis',1, 0, 'C');
                $this->Cell(16, 5,'Inas y/o P.M',1, 1, 'C');
                $this->SetFont('Arial','',7);
                $num = count($res);
                for($i = 0;$i < $num;$i++){
                    $nume = ($i+1);
                    $nombre = ucwords(strtolower(utf8_decode($res[$i]['apeper'].' '.$res[$i]['nomper'])));
                    $cedula = number_format($res[$i]['cedper'],'0','','.');
                    $cargo = ucwords(strtolower(utf8_decode($res[$i]['cargo'])));
                    $asismes = $res[$i]['asis'];
                    $inasismes = $res[$i]['inasis'];
                    $asisacu = '';
                    $inasisacu = '';
                    
                    $this->SetWidths(array(7,62,18,39,16,16,16,16));
                    $this->SetAligns(array('C','L','R','C','C','C','C','C'));
                    $this->Row(array($nume,$nombre,$cedula,$cargo,$asismes,$inasismes,$asisacu,$inasisacu));
                                      
                } 
                $this->Ln(5);
            }else{
                $this->SetFont('Arial','B',20);
                $this->Cell(190, 5,'NO EXISTEN REGISTROS PARA MOSTRAR', 0, 1, 'C');
            }
        }
    }
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 25);
    $pdf->AddPage();
    $pdf->contenido($personas);
    $nombre = "personal.pdf";
    $pdf->Output($nombre,"I");