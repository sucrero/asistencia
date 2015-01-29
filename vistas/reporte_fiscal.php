<?php
    session_start();
    header("Content-type: application/pdf; charset=utf-8");
    require '../clases/PDF_MC_Table.php';
    include_once '../clases/Persona.php';
    include_once '../conexion/conexion.php';
    $objPer = new Persona();
    
    $datos = $_REQUEST['parametro'];
    $tipo = $_REQUEST['tipo'];
    
    if($tipo == 1){
        
        if($objPer->buscar("SELECT * FROM persona WHERE tipoper='FISCAL' and nombreper LIKE '".strtoupper($datos)."%' ORDER BY nombreper,apellidoper", $conexion)){
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
        
        $titulo = "FISCALES QUE CONTIENEN LAS SIGUIENTES LETRAS: ".strtoupper($datos);
    }else if($tipo == 2){
        $identificador = number_format($datos,'0','','.');
        if($objPer->buscar("SELECT * FROM persona WHERE tipoper='FISCAL' and cedulaper='".$datos."' ORDER BY nombreper,apellidoper", $conexion)){
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
        
        $titulo = "DATOS DEL FISCAL  ".$fecha[0].'  Y  '.$fecha[1];
    }else{
        if($objPer->buscar("SELECT * FROM persona WHERE tipoper='FISCAL' ORDER BY nombreper,apellidoper", $conexion)){
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
        $titulo = "FISCALES REGISTRADOS";
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
                $this->SetFillColor(173,216,230);
                $this->Cell(10, 5,'Nro.', 1, 0, 'C',true);
                $this->Cell(30, 5,utf8_decode(html_entity_decode('C&oacute;digo')), 1,0, 'C',true);
                $this->Cell(30, 5,utf8_decode(html_entity_decode('N&uacute;mero de C&eacute;dula')), 1, 0, 'C',true);
                $this->Cell(110, 5,'Nombre del Fiscal', 1, 1, 'C',true);
                for($i = 0;$i < count($res);$i++){
                   
                    $documento = number_format($res[$i]['cedulaper'],'0','','.');
                
                    $this->Cell(10, 5,($i+1), 1, 0, 'C');
                    $this->Cell(30, 5,$res[$i]['idpersona'], 1,0, 'C');
                    $this->Cell(30, 5,$documento, 1, 0, 'R');
                    $this->Cell(110, 5,ucwords(strtolower(utf8_decode($res[$i]['nombreper'].' '.$res[$i]['apellidoper']))), 1, 1, 'L');
                    
                } 
                $this->Ln(3);
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
    $nombre = "fiscales";
    $pdf->Output($nombre,"I");
?>