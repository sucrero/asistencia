<?php
    session_start();
    require '../clases/PDF_MC_Table.php';
    include_once '../clases/Usuario.php';
    include_once '../clases/Personal.php';
    include_once '../conexion/conexion.php';
    $objPer = new Personal();
    $objUsu = new Usuario();
    $datos = $_REQUEST['parametro'];
    $tipo = $_REQUEST['tipo'];
    
    if($tipo == 1){
        list($tipPer,$desde,$hasta) = explode(' ', $datos);
        if($tipPer == -2 && $desde == '' && $hasta == ''){
            $sql = "SELECT * FROM permiso_persona";
            $titulo = 'PERMISOS REGISTRADOS';
        }else if ($tipPer != -2  && $desde == '' && $hasta == ''){
            
            $sql = "SELECT * FROM permiso WHERE idper='".$tipPer."'";
            if($objPerm->buscar($sql, $conexion)){
                if($conexion->registros > 0){
                     $res2 = $conexion->devolver_recordset();
                }
            }            
            $titulo = strtoupper($res2['descper']).' REGISTRADOS';
            $sql = "SELECT * FROM permiso_persona WHERE idpermiso='".$tipPer."'";
        }else if ($tipPer != -2 && $desde != '' && $hasta != ''){
            
            $sql = "SELECT * FROM permiso WHERE idper='".$tipPer."'";
            if($objPerm->buscar($sql, $conexion)){
                if($conexion->registros > 0){
                     $res2 = $conexion->devolver_recordset();
                }
            }
            $titulo = strtoupper($res2['descper']).' REGISTRADOS DESDE '.$desde.' HASTA '.$hasta;
            $sql = "SELECT * FROM permiso_persona WHERE idpermiso='".$tipPer."' AND desde >='".$desde."' AND hasta <='".$hasta."'";
        }else{
            
            $sql = "SELECT * FROM permiso_persona WHERE desde >='".$desde."' AND hasta <='".$hasta."'";
            $titulo = 'PERMISOS REGISTRADOS DESDE '.$desde.' HASTA '.$hasta;
        }
    }else{ //TODOS
        $sql = "SELECT * FROM usuario";
        $titulo = "USUARIOS REGISTRADOS";
    }
    
    if($objUsu->buscar($sql, $conexion)){
        if($conexion->registros > 0){
            $i = 0;
            do{
                $res[$i] = $conexion->devolver_recordset();
                $i++;
            }while(($conexion->siguiente()) && ($i != $conexion->registros));
            for($i = 0;$i < count($res); $i++){
                $sql = "SELECT * FROM personal WHERE idper='".$res[$i]['idper']."'";
                $objPer->buscar($sql, $conexion);
                $res[$i]['p'] = $conexion->devolver_recordset();
            }
        }else{
            $res = 0;
        }
    }else{
        $res = 0;
    }    
    
    class PDF extends PDF_MC_Table{
        function Header() {
            global $titulo;            
            $size = 15;
//            $absx = (210 - $size) / 2;
            $this->SetFont('Arial','', 8);
            $this->Image('../img/logo_nacional.jpg', $absx, 5, 20);
            $this->Cell(190, 3, html_entity_decode("REP&Uacute;BLICA BOLIVARIANA DE VENEZUELA",ENT_QUOTES,"ISO-8859-1"), 0,1,C);
            $this->Cell(190, 3, html_entity_decode("MINISTERIO DEL PODER POPULAR PARA LA EDUCACI&Oacute;N",ENT_QUOTES,"ISO-8859-1"), 0,1,C);
            $this->Cell(190, 3, html_entity_decode("GOBERNACI&Oacute;N DEL ESTADO SUCRE",ENT_QUOTES,"ISO-8859-1"), 0,1,C);
            $this->Cell(190, 3, html_entity_decode("DIRECCI&Oacute;N DE EDUCACI&Oacute;N",ENT_QUOTES,"ISO-8859-1"), 0,1,C);
            $this->Cell(190, 3, "E.B. FRANCISCO DE MIRANDA", 0,1,C);
            $this->Image('../img/logo_estadal.jpg', 180, 10, 20);
            $this->Ln(5);
            $this->SetFont('Arial','', 10);
            $this->Cell(190, 8, $titulo,0, 0, 'C');
            $this->Ln(15);
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
            $num = count($res);
            $this->Cell(190, 5,'Cantidad de Usuarios: '.$num,0, 1, 'C');
            $this->Ln(1);
            if($res != 0){
                $this->SetFont('Arial','B',7);
                $this->SetFillColor(173,216,230);
                $this->Cell(8, 5,'Nro.',1, 0, 'C',true);
                $this->Cell(20, 5,'Usuario',1, 0, 'C',true);
                $this->Cell(28, 5,'Tipo',1, 0, 'C',true);
                $this->Cell(20, 5,html_entity_decode('C&eacute;dula',ENT_QUOTES,"ISO-8859-1"),1, 0, 'C',true);
                $this->Cell(30, 5,'Persona',1, 0, 'C',true);
                $this->Cell(28, 5,'Cargo',1, 0, 'C',true);
                $this->Cell(28, 5,'Dependencia',1, 0, 'C',true);
                $this->Cell(28, 5,html_entity_decode('Condici&oacute;n',ENT_QUOTES,"ISO-8859-1"),1, 1, 'C',true);
                $this->SetFont('Arial','',7);
                $a = $e = $ne =0;
                for($i = 0;$i < $num;$i++){
                    if($i % 2 == 0){
                        $this->SetFillColor(255,255,255);
                    }else{
                        $this->SetFillColor(0,191,255);
                    }
                    
                    $usu = strtolower($res[$i]['nombreusu']);
                    $tip = ucwords(strtolower($res[$i]['tipousu']));
                    $cedPersona = number_format($res[$i]['p']['cedper'],'0','','.');
                    $nomPersona = ucwords(strtolower(utf8_decode($res[$i]['p']['nomper'].' '.$res[$i]['p']['apeper'])));
                    $cargo = ucwords(strtolower($res[$i]['p']['cargo']));
                    $dependencia = ucwords(strtolower($res[$i]['p']['dependencia']));
                    $condicion = ucwords(strtolower($res[$i]['p']['condicion']));
                    
                    $nume = ($i+1);
                    
                    $this->SetWidths(array(8,20,28,20,30,28,28,28));
                    $this->SetAligns(array('C','C','C','R','L','C','C','C'));
                    $this->Row(array($nume,$usu,$tip,$cedPersona,$nomPersona,$cargo,$dependencia,$condicion));
                                      
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
                $this->Cell(190, 5,'NO EXISTEN REGISTROS PARA MOSTRAR', 0, 1, 'C');
            }
        }
    }
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 25);
    $pdf->AddPage();
    $pdf->contenido($res);
    $nombre = "permisos";
    $pdf->Output($nombre,"I");
?>