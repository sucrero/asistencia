<?php
    session_start();
    
    $fecha1 = $_GET['f1'];
    
    if($fecha1 == ''){
        print_r('vacio'); exit();
        
    }else{
        print_r('lleno'); exit();
    }
    
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 25);
    $pdf->AddPage();
//    $pdf->contenido($res);
    $nombre = "personal.pdf";
    $pdf->Output($nombre,"I");