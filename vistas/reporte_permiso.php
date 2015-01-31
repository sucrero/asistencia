<?php
    session_start();
    require '../clases/PDF_MC_Table.php';
    include_once '../clases/Permiso.php';
    include_once '../clases/PermisoPer.php';
    include_once '../clases/Personal.php';
    include_once '../conexion/conexion.php';
    $objPer = new Personal();
    $objPerPer = new PermisoPer();
    $objPerm = new Permiso();
    $datos = $_REQUEST['parametro'];
    $tipo = $_REQUEST['tipo'];
    if($tipo == 1){//por fiscal
        list($tipPer,$desde,$hasta) = explode(' ', $datos);
        if($tipPer == -2 && $desde == '' && $hasta == ''){
            $sql = "SELECT * FROM permiso_persona";
            $titulo = 'PERMISOS REGISTRADOS 111111111111111';
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
         $sql = "SELECT * FROM permiso_persona";
        $titulo = "PERMISOS REGISTRADOS 2222222222222222";
    }
    
    if($objPerPer->buscar($sql, $conexion)){
        if($conexion->registros > 0){
            $i = 0;
            do{
                $res[$i] = $conexion->devolver_recordset();
                $i++;
            }while(($conexion->siguiente()) && ($i != $conexion->registros));
            for ($i = 0; $i < count($res);$i++){
                $sql = "SELECT * FROM personal WHERE idper='".$res[$i]['idpersona']."'";
                $objPer->buscar($sql, $conexion);
                $res[$i]['p'] = $conexion->devolver_recordset();
            }
            for ($i = 0; $i < count($res);$i++){
                $sql = "SELECT * FROM permiso WHERE idper='".$res[$i]['idpermiso']."'";
                $objPer->buscar($sql, $conexion);
                $res[$i]['m'] = $conexion->devolver_recordset();
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
            $this->Cell(190, 5,'Cantidad de Permisos: '.$num,0, 1, 'C');
            $this->Ln(1);
            if($res != 0){
                $this->SetFont('Arial','B',7);
                $this->SetFillColor(173,216,230);
                $this->Cell(8, 5,'Nro.',1, 0, 'C',true);
                $this->Cell(19, 5,'Cedula',1, 0, 'C',true);
                $this->Cell(53, 5,'Persona',1, 0, 'C',true);
                $this->Cell(37, 5,'Descripcion',1, 0, 'C',true);
                $this->Cell(37, 5,'Tipo',1, 0, 'C',true);
                $this->Cell(18, 5,'Desde',1, 0, 'C',true);
                $this->Cell(18, 5,'Hasta',1, 1, 'C',true);
                $this->SetFont('Arial','',7);
                $a = $e = $ne =0;
                for($i = 0;$i < $num;$i++){
                    if($i % 2 == 0){
                        $this->SetFillColor(255,255,255);
                    }else{
                        $this->SetFillColor(0,191,255);
                    }
                    $cedPersona = number_format($res[$i]['p']['cedper'],'0','','.');
                    $nomPersona = ucwords(strtolower(utf8_decode($res[$i]['p']['nomper'].' '.$res[$i]['p']['apeper'])));
                                       
                    $nume = ($i+1);
                    
                    $desc = ucwords(strtolower(utf8_decode($res[$i]['descripcionper'])));
                    $tipo = ucwords(strtolower(utf8_decode(html_entity_decode($res[$i]['m']['descper']))));
                    $desde = substr($res[$i]['desde'],8,2).'/'.substr($res[$i]['desde'],5,2).'/'.substr($res[$i]['desde'],0,4);
                    $hasta = substr($res[$i]['hasta'],8,2).'/'.substr($res[$i]['hasta'],5,2).'/'.substr($res[$i]['hasta'],0,4);
                    
                    $this->SetWidths(array(8,19,53,37,37,18,18));
                    $this->SetAligns(array('C','R','L','J','L','C','C'));
                    $this->Row(array($nume,$cedPersona,$nomPersona,$desc,$tipo,$desde,$hasta));
                                      
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
    $pdf->contenido($res);
    $nombre = "permisos";
    $pdf->Output($nombre,"I");
?>