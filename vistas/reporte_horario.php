<?php
    session_start();
    require '../clases/PDF_MC_Table.php';
    include_once '../clases/Horario.php';
    include_once '../conexion/conexion.php';
    $objHor = new Horario();
    $datos = $_REQUEST['parametro'];
    $tipo = $_REQUEST['tipo'];
    
    $sql = "SELECT * FROM horario ORDER BY descripcionhor DESC";
    $titulo = "HORARIOS REGISTRADOS";
    
    if($objHor->buscar($sql, $conexion)){
        if($conexion->registros > 0){
            $i = 0;
            do{
                $res[$i] = $conexion->devolver_recordset();
                $i++;
            }while(($conexion->siguiente()) && ($i != $conexion->registros));
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
            $this->Cell(190, 5,'Cantidad de Horarios: '.$num,0, 1, 'C');
            $this->Ln(1);
            if($res != 0){
                $this->SetFont('Arial','B',7);
                $this->SetFillColor(173,216,230);
                $this->Cell(8, 5,'Nro.',1, 0, 'C',true);
                $this->Cell(146, 5,'Descripcion',1, 0, 'C',true);
                $this->Cell(18, 5,'Hora entrada',1, 0, 'C',true);
                $this->Cell(18, 5,'Hora salida',1, 1, 'C',true);
                $this->SetFont('Arial','',7);
                $a = $e = $ne =0;
                for($i = 0;$i < $num;$i++){
                    if($i % 2 == 0){
                        $this->SetFillColor(255,255,255);
                    }else{
                        $this->SetFillColor(0,191,255);
                    }
                   
                    $desc = ucwords(strtolower(utf8_decode($res[$i]['descripcionhor'])));
                                       
                    $nume = ($i+1);
                    
                    $entrada = $res[$i]['horentrada'];
                    $salida = $res[$i]['horasalida'];
                   
                    
                    $this->SetWidths(array(8,146,18,18));
                    $this->SetAligns(array('C','J','C','C'));
                    $this->Row(array($nume,$desc,$entrada,$salida));
                                      
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
    $nombre = "horarios.pdf";
    $pdf->Output($nombre,"I");
?>