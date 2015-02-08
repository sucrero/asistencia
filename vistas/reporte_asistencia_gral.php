<?php
    session_start();
    require '../clases/PDF_MC_Table.php';
//    include_once '../clases/Personal.php';
//    include_once '../clases/Horario.php';
//    include_once '../clases/Horper.php';
//    include_once '../clases/Festivo.php';
//    include_once '../clases/Permiso.php';
//    include_once '../clases/PermisoPer.php';
//    include_once '../clases/Asistencia.php';
//    include_once '../conexion/conexion.php';
//    $objPer = new Personal();
//    $objHor = new Horario();
//    $objHorPer = new Horper();
//    $objFes = new Festivo();
//    $objPerm = new Permiso();
//    $objPerPer = new PermisoPer();
//    $objAsi = new Asistencia();
    $d = $_REQUEST['f1'];
//    $h = $_REQUEST['f2'];
//    $c = $_REQUEST['car'];
//    $de = $_REQUEST['dep'];
//    $co = $_REQUEST['con'];
    
//    print_r($desde.'  // '.$hasta.' // '.$cargo.' // '.$dependencia.' // '.$condicion);exit();
   
    
//    $sql = "SELECT * FROM personal ".$where;
//    print_r($sql); exit();
//    if($objPer->buscar($sql, $conexion)){
//        $i = 0;
//        do{
//            $res[$i]['personal'] = $conexion->devolver_recordset();
//            $i++;
//        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//    }else{
//        
//    }
    
    
    if($d != ''){
        print_r('si es'); exit();
    }else{
        print_r('no es'); exit();
    }
    
    
    
//    if($desde == '' && $hasta = ''){
//        $sql = "SELECT * FROM asistencia as a 
//                    INNER JOIN personal as b ON ( a.idper = b.idper)
//                    INNER JOIN horario_persona as c ON (b.idper = c.idper)
//                    INNER JOIN horario as d ON (c.idhor = d.idhor)
//                    ORDER BY fecha ASC";
////        $sql = "SELECT * FROM asistencia ORDER BY fecha ASC";
//    }else{
////        $sql = "SELECT * FROM asistencia WHERE fecha BETWEEN '".$desde."' AND '".$hasta."' ORDER BY fecha ASC";
//    }
//    if($objAsi->buscar($sql, $conexion)){
//        $i = 0;
//        do{
//            $res[$i] = $conexion->devolver_recordset();
//            $i++;
//        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//        
//    }else{// no consiguio nada en asistencia
//        
//    }
    
    
//    if($objPer->buscar($sql, $conexion)){
//        if($conexion->registros > 0){
//            $i = 0;
//            do{
//                $res[$i] = $conexion->devolver_recordset();
//                $i++;
//            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//            for($i = 0;$i < count($res);$i++){
//                $sql = "SELECT * FROM horario_persona WHERE idper = '".$res[$i]['idper']."'";
//                $objPer->buscar($sql, $conexion);
//                $res[$i]['h'] = $conexion->devolver_recordset();
//            }
////            print_r($res); exit();
//            for($i = 0;$i < count($res);$i++){
//                $sql = "SELECT * FROM horario WHERE idhor = '".$res[$i]['h']['idhor']."'";
//                $objPer->buscar($sql, $conexion);
//                $res[$i]['hd'] = $conexion->devolver_recordset();
////                print_r($sql); exit();
//
//            }
////                                        print_r($res); exit();
//        }else{
//            $res = 0;
//        }
//    }else{
//        $res = 0;
//    }   
    
    class PDF extends PDF_MC_Table{
        function Header() {
            global $titulo;            
            $size = 15;
//            $absx = (210 - $size) / 2;
            $this->SetFont('Arial','', 7);
            $this->Image('../img/logo_escuela.jpg', $absx, 5, $size);
            $this->Cell(190, 3, "REPUBLICA BOLIVARIANA DE VENEZUELA", 0,1,C);
            $this->Cell(190, 3, "MINISTERIO DEL PODER POPULAR PARA LA EDUCACION", 0,1,C);
            $this->Cell(190, 3, "GOBERNACION DEL ESTADO SUCRE", 0,1,C);
            $this->Cell(190, 3, "DIRECCION DE EDUCACION", 0,1,C);
            $this->Cell(190, 3, "E.B. FRANCISCO DE MIRANDA", 0,1,C);
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(190, 8, $titulo,0, 0, 'C');
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
            $this->SetFont('Arial','',8);
            $this->Ln(2);           
            $num = count($res);
            $this->Cell(190, 5,'Cantidad de Personas: '.$num,0, 1, 'C');
            $this->Ln(1);
            if($res != 0){
                $this->SetFont('Arial','B',7);
                $this->SetFillColor(173,216,230);
                $this->Cell(7, 5,'Nro.',1, 0, 'C',true);
                $this->Cell(15, 5,'Cedula',1, 0, 'C',true);
                $this->Cell(42, 5,'Nombre',1, 0, 'C',true);
//                $this->Cell(20, 5,'Correo',1, 0, 'C',true);
                $this->Cell(19, 5,'Telefono',1, 0, 'C',true);
                $this->Cell(25, 5,'Dependencia',1, 0, 'C',true);
                $this->Cell(32, 5,'Cargo',1, 0, 'C',true);
                $this->Cell(27, 5,'Condicion',1, 0, 'C',true);
                $this->Cell(23, 5,'Horario',1, 1, 'C',true);
                $this->SetFont('Arial','',7);
//                $a = $e = $ne =0;
                for($i = 0;$i < $num;$i++){
                    if($i % 2 == 0){
                        $this->SetFillColor(255,255,255);
                    }else{
                        $this->SetFillColor(0,191,255);
                    }
                    
                    $cedPersona = number_format($res[$i]['cedper'],'0','','.');
                    $nomPersona = ucwords(strtolower(utf8_decode($res[$i]['nomper'].' '.$res[$i]['apeper'])));
                    $correo = $res[$i]['emailper'];
                    $dependencia = ucwords(strtolower(utf8_decode($res[$i]['dependencia'])));
                    $cargo = ucwords(strtolower(utf8_decode($res[$i]['cargo'])));
                    $condicion = ucwords(strtolower(utf8_decode($res[$i]['condicion'])));
                    $telf = substr($res[$i]['telfper'], 0, 4).'-'.substr($res[$i]['telfper'], 4, 11);
                    $nume = ($i+1);
                    $horario = ucwords(strtolower(utf8_decode($res[$i]['hd']['descripcionhor'])));
                    
                    
                    $this->SetWidths(array(7,15,42,19,25,32,27,23));
                    $this->SetAligns(array('C','R','L','C','L','L','L','L'));
                    $this->Row(array($nume,$cedPersona,$nomPersona,$telf,$dependencia,$cargo,$condicion,$horario));
                                      
                } 
                $this->Ln(5);
//                $total = $a+$e+$ne;
//                
//                $porcA = ($a*100)/$total;
//                $porcE = ($e*100)/$total;
//                $porcNE = ($ne*100)/$total;
//                
//              
//                //GRAFICO
//                include '../jpgraph/src/jpgraph.php';
//                include '../jpgraph/src/jpgraph_pie.php';
//                include '../jpgraph/src/jpgraph_pie3d.php';
//                
//                
//                $data = array($porcA,$porcE,$porcNE);
//                
//                $grafico = new PieGraph(500, 300, "auto");
//                $grafico->SetShadow();
////                $grafico->title->Set("Notificaciones Registradas");
//                $grafico->title->SetFont(FF_FONT1,FS_BOLD);
//                
//                $torta = new PiePlot3D($data);
//                $torta->SetShadow();
//                $torta->SetSize(0.3);
//                $torta->SetCenter(0.5);
//                $torta->SetLegends(array("Asignadas","Entregadas", "No Entregadas"));
//                
//                $grafico->Add($torta);
//      
//                $img = $grafico->Stroke( _IMG_HANDLER);
//                $filename = "chart.png";
//                $grafico->img->Stream($filename);
//                $this->Image($filename);
                //FIN GRAFICO
                
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
//    $pdf->contenido($res);
    $nombre = "personal.pdf";
    $pdf->Output($nombre,"I");
?>