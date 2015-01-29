<?php
    session_start();
    header("Content-type: application/pdf; charset=utf-8");
    require '../clases/PDF_MC_Table.php';
    
    include_once '../clases/Correspondencia.php';
    include_once '../clases/Consulta.php';
    include_once '../clases/Tierra.php';
    include_once '../clases/Vivienda.php';
    include_once '../clases/Usuario.php';
    include_once '../clases/Notificacion.php';
    include_once '../conexion/conexion.php';
    
    $objCor = new Correspondencia();
    $objCon = new Consulta();
    $objTie = new Tierra();
    $objViv = new Vivienda();
    $objUsu = new Usuario();
    $objNot = new Notificacion();
    
    $f1 = substr($_REQUEST['f1'],7,4).'-'.substr($_REQUEST['f1'],4,2).'-'.substr($_REQUEST['f1'],1,2);
    $f2 = substr($_REQUEST['f2'],7,4).'-'.substr($_REQUEST['f2'],4,2).'-'.substr($_REQUEST['f2'],1,2);
    
    $titulo = "REGISTROS REALIZADOS DESDE EL  ".substr($f1,8,2).'-'.substr($f1,5,2).'-'.substr($f1,0,4)." HASTA EL  ".substr($f2,8,2).'-'.substr($f2,5,2).'-'.substr($f2,0,4);
    
    $sql =  "SELECT COUNT(*) as cantidad FROM correspondencia WHERE feccorres BETWEEN '".$f1."' AND '".$f2."'";
    if($objCor->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numCorTot'] = $fila['cantidad'];
        }else{
            $res[0]['numCorTot'] = 0;
        } 
    }
    
    $sql =  "SELECT COUNT(*) as cantidad  FROM correspondencia WHERE tipocorres ='solicitud' AND feccorres BETWEEN '".$_REQUEST['f1']."' AND '".$_REQUEST['f2']."'";
    if($objCor->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numCorSol'] = $fila['cantidad'];
        }else{
            $res[0]['numCorSol'] = 0;
        } 
    }
    
    
    $sql =  "SELECT COUNT(*) as cantidad  FROM correspondencia WHERE tipocorres ='consignación' AND feccorres BETWEEN '".$_REQUEST['f1']."' AND '".$_REQUEST['f2']."'";
    if($objCor->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numCorCon'] = $fila['cantidad'];
        }else{
            $res[0]['numCorCon'] = 0;
        } 
    }
    
    $sql =  "SELECT COUNT(*) as cantidad  FROM consulta WHERE fecconsulta BETWEEN '".$_REQUEST['f1']."' AND '".$_REQUEST['f2']."'";
    if($objCon->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numCon'] = $fila['cantidad'];
        }else{
            $res[0]['numCon'] = 0;
        } 
    }
    
    $sql =  "SELECT COUNT(*) as cantidad  FROM tierra WHERE fectierra BETWEEN '".$_REQUEST['f1']."' AND '".$_REQUEST['f2']."'";
    if($objTie->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numTie'] = $fila['cantidad'];
        }else{
            $res[0]['numTie'] = 0;
        } 
    }
    
    $sql =  "SELECT COUNT(*) as cantidad  FROM vivienda WHERE fechavivienda BETWEEN '".$_REQUEST['f1']."' AND '".$_REQUEST['f2']."'";
    if($objViv->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numViv'] = $fila['cantidad'];
        }else{
            $res[0]['numViv'] = 0;
        } 
    }
    
    $sql = "SELECT COUNT(*) AS cantidad FROM notificacion WHERE estadonoti='NOENTREGADA' AND fechanoti BETWEEN '".$_REQUEST['f1']."' AND '".$_REQUEST['f2']."'";
    if($objNot->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numNotNoe'] = $fila['cantidad'];
        }else{
            $res[0]['numNotNoe'] = 0;
        }
    }
    
    $sql = "SELECT COUNT(*) AS cantidad FROM notificacion WHERE estadonoti='ENTREGADA' AND fechanoti BETWEEN '".$_REQUEST['f1']."' AND '".$_REQUEST['f2']."'";
    if($objNot->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numNotEnt'] = $fila['cantidad'];
        }else{
            $res[0]['numNotEnt'] = 0;
        }
    }
    
    $sql = "SELECT COUNT(*) AS cantidad FROM notificacion WHERE estadonoti='ASIGNADA' AND fechanoti BETWEEN '".$_REQUEST['f1']."' AND '".$_REQUEST['f2']."'";
    if($objNot->buscar($sql, $conexion)){
        $fila = $conexion->devolver_recordset();
        if($fila['cantidad'] > 0){
            $res[0]['numNotAsi'] = $fila['cantidad'];
        }else{
            $res[0]['numNotAsi'] = 0;
        }
    }
    
    
    class PDF extends PDF_MC_Table{
        function Header() {
            global $titulo;            
            $size = 150;
            $absx = (210 - $size) / 2;
            $this->Image('../img/banner.jpg', $absx, 5, $size);
            $this->Ln(20);
            $this->SetFont('Arial', 'IB', 12);
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
        function contenido($res,$sql1){
          
            $this->Ln(2);
            $total = (int)($res[0]['numCorSol']+$res[0]['numCorCon']+$res[0]['numCon']+$res[0]['numTie']+$res[0]['numViv']);
            if($total > 0){
                $this->SetFont('Arial','B',11);
                
                $this->Cell(180, 5,'Total de Registros realizados:   '.$total, 0, 1, 'C');
                $this->Ln(5);
                
                $this->SetFont('Arial','',9);
                $totCorresp = (int)($res[0]['numCorSol']+$res[0]['numCorCon']);
                $this->Cell(180, 7,'Registros de Correpondencias:   '.$totCorresp, 1, 1, 'L');
                $this->Cell(90, 7,'Correspondencias Tipo Solicitud:  '.$res[0]['numCorSol'], 1,0, 'L');
                $this->Cell(90, 7,'Correspondencias Tipo Consignacion: '.$res[0]['numCorCon'], 1, 1, 'L');
                    
                $this->Ln(5);
                
                $totNotifi = (int)($res[0]['numNotEnt']+$res[0]['numNotAsi']+$res[0]['numNotNoe']);
                $this->Cell(180, 7,'Registros de Notificaciones:   '.$totNotifi, 1, 1, 'L');
                $this->Cell(60, 7,'Notificaciones Asignadas:  '.$res[0]['numNotAsi'], 1,0, 'L');
                $this->Cell(60, 7,'Notificaciones Entregadas: '.$res[0]['numNotEnt'], 1, 0, 'L');
                $this->Cell(60, 7,'Notificaciones No Entregadas: '.$res[0]['numNotNoe'], 1, 1, 'L');
                    
                $this->Ln(5);
                    
                $this->Cell(180, 7,'Consultas Registradas:  '.$res[0]['numCon'], 1, 1, 'L');
                    
                $this->Ln(5);
                    
                $this->Cell(180, 7,'Tierras Registradas  '.$res[0]['numTie'], 1, 1, 'L');
                    
                $this->Ln(5);
                    
                $this->Cell(180, 7,'Viviendas Registradas  '.$res[0]['numViv'], 1, 1, 'L');
                                      
                $this->Ln(3);
                
                //GRAFICO
                include '../jpgraph/src/jpgraph.php';
                include '../jpgraph/src/jpgraph_pie.php';
                include '../jpgraph/src/jpgraph_pie3d.php';
                
                
                $data = array($totCorresp,$totNotifi,$res[0]['numCon'],$res[0]['numTie'],$res[0]['numViv']);
                
                $grafico = new PieGraph(500, 300, "auto");
                $grafico->SetShadow();
//                $grafico->title->Set("Notificaciones Registradas");
                $grafico->title->SetFont(FF_FONT1,FS_BOLD);
                
                $torta = new PiePlot3D($data);
                $torta->SetShadow();
                $torta->SetSize(0.3);
                $torta->SetCenter(0.5);
                $torta->SetLegends(array("Correspondencias","Notificaciones","Consultas", "Tierras","Viviendas"));
//                $torta->SetHeight(15);
                $grafico->Add($torta);
      
                $img = $grafico->Stroke( _IMG_HANDLER);
                $filename = "chart.png";
                $grafico->img->Stream($filename);
                $this->Image($filename);
                //FIN GRAFICO
                
            
            }else{
                $this->Ln(30);
                $this->SetFont('Arial','IB',20);
                $this->Cell(180, 5,'NO EXISTEN REGISTROS PARA MOSTRAR', 0, 1, 'C');
                

                
           
            }
            
            
        }
        
        
    }
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 25);
    $pdf->AddPage();
    $pdf->contenido($res,$sql1);
    $nombre = "correspondencias";
    $pdf->Output($nombre,"I");
?>