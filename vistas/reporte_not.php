<?php
    session_start();
//    header("Content-type: application/pdf; charset=utf-8");
    require '../clases/PDF_MC_Table.php';
    include_once '../clases/Persona.php';
    include_once '../clases/Notificacion.php';
    include_once '../clases/Usuario.php';
    include_once '../conexion/conexion.php';
    $objPer = new Persona();
    $objNot = new Notificacion();
    $objUsu = new Usuario();
    
    $datos = $_REQUEST['parametro'];
    $tipo = $_REQUEST['tipo'];
//    print_r($datos.'    '.$tipo);
    if($tipo == 1){//por fiscal
        $sql = 'SELECT * FROM notificacion WHERE idfiscal="'.$datos.'"';
        $identificador = number_format( $res[$i]['f']['cedulaper'],'0','','.');
        $contribuyente = ucwords(strtolower(utf8_decode( $res[0]['f']['nombreper']))).' '.ucwords(strtolower(utf8_decode( $res[$i]['f']['apellidoper'])));
        $titulo = "NOTIFICACIONES ASIGNADAS AL FISCAL: ".$contribuyente.'  '.$identificador;
    }else if($tipo == 2){// POR FECHA
        $fecha = explode(" ", $datos);
        $sql = "SELECT * FROM notificacion WHERE fechanoti BETWEEN '".$fecha[0]."' AND '".$fecha[1]."' ORDER BY fechanoti";
        $titulo = "NOTIFICACIONES ASIGANDAS ENTRE  ".$fecha[0].'  Y  '.$fecha[1];
    }else if($tipo == 3){// POR ESTADO
        $sql = "SELECT * FROM notificacion WHERE estadonoti='".$datos."'";
        $titulo = "NOTIFICACIONES REGISTRADAS CON ESTADO: ".$datos;
    }else if($tipo == 4){// POR OPERADOR
        $sql = "SELECT * FROM usuario WHERE cedulausu='".$datos."'";
        if($objUsu->buscar($sql, $conexion)){
            $fila = $conexion->devolver_recordset();
            $operador = number_format($fila['cedulausu'],'0','','.').' - '.$fila['nombusu'].' '.$fila['apellidousu'];
        }    
        $sql = "SELECT * FROM notificacion WHERE idusuario='".$fila['idusuario']."'";
        $titulo = "NOTIFICACIONES REGISTRADAS POR: ".$operador;
    }else{ //TODOS
        $sql = "SELECT * FROM notificacion ORDER BY fechanoti";
        $titulo = "NOTIFICACIONES REGISTRADAS";
    }
    
    if($objNot->buscar($sql, $conexion)){
        if($conexion->registros > 0){
            $i = 0;
            do{
                $res[$i] = $conexion->devolver_recordset();
                $i++;
            }while(($conexion->siguiente()) && ($i != $conexion->registros));
            $a = $e = $ne = 0;
            for ($i = 0; $i < count($res);$i++){
                if($res[$i]['estadonoti'] == 'ASIGNADA'){
                    $a++;
                }else if($res[$i]['estadonoti'] == 'ENTREGADA'){
                    $e++;
                }else{
                    $ne++;
                }
                
                $objPer->buscar("SELECT * FROM persona WHERE idpersona = '".$res[$i]['idfiscal']."'", $conexion);
                $res[$i]['f'] = $conexion->devolver_recordset();
                $objPer->buscar("SELECT * FROM persona WHERE idpersona = '".$res[$i]['idpersona']."'", $conexion);
                $res[$i]['p'] = $conexion->devolver_recordset();
            }
            $res[0]['a'] = $a;
            $res[0]['e'] = $e;
            $res[0]['ne'] = $ne;
        }else{
            $res = 0;
        }
    }else{
        $res = 0;
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
            $this->SetFont('Arial','',8);
            $this->Ln(2);           
            $num = count($res);
            $this->Cell(190, 5,'Cantidad de Notificaciones: '.$num,0, 1, 'C');
            $this->Ln(1);
            $this->Cell(63, 5,'Asignadas (A): '.$res[0]['a'],0, 0, 'C');
            $this->Cell(63, 5,'Entregadas (E): '.$res[0]['e'],0, 0, 'C');
            $this->Cell(63, 5,'No Entregadas (NE): '.$res[0]['ne'],0, 1, 'C');
            $this->Ln(1);
            if($res != 0){
                $this->SetFont('Arial','B',7);
                $this->SetFillColor(173,216,230);
                $this->Cell(8, 5,'NRO.',1, 0, 'C',true);
                $this->Cell(15, 5,'FECHA',1, 0, 'C',true);
                $this->Cell(12, 5,'ESTADO',1, 0, 'C',true);
                $this->Cell(37, 5,'CONTRIBUYENTE',1, 0, 'C',true);
                $this->Cell(78, 5,'DESCRIPCION DE LA NOTIFICACION',1, 0, 'C',true);
                $this->Cell(40, 5,'FISCAL',1, 1, 'C',true);
                $this->SetFont('Arial','',7);
                $a = $e = $ne =0;
                for($i = 0;$i < $num;$i++){
                    
                    if($i % 2 == 0){
                        $this->SetFillColor(255,255,255);
                    }else{
                        $this->SetFillColor(0,191,255);
                    }
                    $cedFiscal = number_format($res[$i]['f']['cedulaper'],'0','','.');
                    $nomFiscal = ucwords(strtolower(utf8_decode($res[$i]['f']['nombreper'].' '.$res[$i]['f']['apellidoper'])));

//                    if($res[$i]['p']['cedulaper'] != '' && $res[$i]['p']['rifper'] != ''){
//                        $cedContri = number_format($res[$i]['p']['cedulaper'],'0','','.');
//                    }else{
//                        if($res[$i]['p']['cedulaper'] != ''){
//                            $cedContri = number_format($res[$i]['p']['cedulaper'],'0','','.');
//                        }else{
//                            $cedContri = substr(strtoupper($res[$i]['p']['rifper'],0,1)).'-'.substr($res[$i]['p']['rifper'],1,8).'-'.substr($res[$i]['p']['rifper'],9,9);
//                        }
//                    }
                    
                    if($res[$i]['estadonoti'] == 'ASIGNADA'){
                        $est = 'A';
                        $a++;
                    }else if($res[$i]['estadonoti'] == 'ENTREGADA'){
                        $est = 'E';
                        $e++;
                    }else{
                        $est = 'NE';
                        $ne++;
                    }
                                       
                    $nume = ($i+1);
                    $fech = substr($res[$i]['fechanoti'],8,2).'/'.substr($res[$i]['fechanoti'],5,2).'/'.substr($res[$i]['fechanoti'],0,4);
                    $cont = ucwords(strtolower(utf8_decode($res[$i]['p']['nombreper'].' '.$res[$i]['p']['apellidoper'])));
                    $noti = ucwords(strtolower(utf8_decode(html_entity_decode($res[$i]['descripcionnoti']))));
                    $fisc = ucwords(strtolower(utf8_decode($res[$i]['f']['nombreper'].' '.$res[$i]['f']['apellidoper'])));
                    
                    $this->SetWidths(array(8,15,12,37,78,40));
                    $this->SetAligns(array('C','C','C','J','J','J'));
                    $this->Row(array($nume,$fech,$est,$cont,$noti,$fisc));
                                      
                } 
                $this->Ln(5);
                $total = $a+$e+$ne;
                
                $porcA = ($a*100)/$total;
                $porcE = ($e*100)/$total;
                $porcNE = ($ne*100)/$total;
                
              
                //GRAFICO
                include '../jpgraph/src/jpgraph.php';
                include '../jpgraph/src/jpgraph_pie.php';
                include '../jpgraph/src/jpgraph_pie3d.php';
                
                
                $data = array($porcA,$porcE,$porcNE);
                
                $grafico = new PieGraph(500, 300, "auto");
                $grafico->SetShadow();
//                $grafico->title->Set("Notificaciones Registradas");
                $grafico->title->SetFont(FF_FONT1,FS_BOLD);
                
                $torta = new PiePlot3D($data);
                $torta->SetShadow();
                $torta->SetSize(0.3);
                $torta->SetCenter(0.5);
                $torta->SetLegends(array("Asignadas","Entregadas", "No Entregadas"));
                
                $grafico->Add($torta);
      
                $img = $grafico->Stroke( _IMG_HANDLER);
                $filename = "chart.png";
                $grafico->img->Stream($filename);
                $this->Image($filename);
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
    $nombre = "notificaciones";
    $pdf->Output($nombre,"I");
?>