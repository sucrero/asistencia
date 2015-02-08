<?php
    session_start();
    include_once 'conexion/conexion.php';
    include_once 'clases/JSON.php';
    include_once 'clases/Usuario.php';
    include_once 'clases/Personal.php';
    include_once 'clases/Festivo.php';
    include_once 'clases/Horario.php';
    include_once 'clases/PermisoPer.php';
    include_once 'clases/Horper.php';
    include_once 'clases/Asistencia.php';
    $objUsu = new Usuario();
    $objPer = new Personal();
    $objFes = new Festivo();
    $objHor = new Horario();
    $objPerPer = new PermisoPer();
    $objHorPer = new Horper();
    $objAsi = new Asistencia();
    function cambiarFormatoFecha($f,$op)
    {
        $fecha='';
        if($op != 'bdd'){
            $dia=substr($f,8,2);//1982/12/05
            $mes=substr($f,5,2);
            $anio=substr($f,0,4);
            $fecha = $dia."/".$mes."/".$anio;
        }else{
            $dia=substr($f,0,2); //05/05/1982
            $mes=substr($f,3,2);
            $anio=substr($f,6,4);
            $fecha = $anio."/".$mes."/".$dia;
        }
        return $fecha;
    }
    switch ($_REQUEST['opcion']){
            case 'validarSesion'://fina
                $sql = "SELECT * FROM usuario WHERE nombreusu='".strtoupper($_REQUEST['usu'])."'";
                if($objUsu->buscar($sql, $conexion)){
                    $fila = $conexion->devolver_recordset();
                    if(crypt($_REQUEST['cla'], $fila['claveusu']) == $fila['claveusu']){
                        $sql = "SELECT * FROM personal WHERE idper='".$fila['idper']."'";
                        $objPer->buscar($sql, $conexion);
                        $res = $conexion->devolver_recordset();
                        if($fila['statususu'] == 'ACTIVO'){
                            $_SESSION['cuenta'] = ucwords(strtolower($res['nomper']).' '.strtolower($res['apeper']));
                            $_SESSION['login'] = $fila['nombreusu'];
                            $_SESSION['nivel'] = strtoupper($fila['tipousu']);
                            $_SESSION['id'] = $fila['idusuario'];
                            $res = $fila;
                        }else{
                            $res = 2;
                        }
                    }else{
                        $res = 0;
                    }
                }else{
                    $res = 0;
                }
                break;
            case 'buscarUsu'://fina
                $sql = "SELECT * FROM personal WHERE cedper='".$_REQUEST['ced']."'";
                if($objUsu->buscar($sql, $conexion)){
                    $res = $conexion->devolver_recordset();
                    $sql = "SELECT * FROM usuario WHERE idper='".$res['idper']."'";
                    if($objUsu->buscar($sql, $conexion)){
                        $res = 2;
                    }                    
                }else{
                    $res =0;
                }
                break;
            case 'guardarUsu'://fina
                $sql = "SELECT * FROM usuario WHERE nombreusu='".strtoupper($_REQUEST['usu'])."'";
                if($objUsu->buscar($sql, $conexion)){
                    $res = 2;
                }else{
                    $sql = "SELECT * FROM usuario WHERE idper='".$_REQUEST['idPer']."'";
                    if($objUsu->buscar($sql, $conexion)){
                        $res = 3;
                    }else{
//                        $codigo = $objUsu->maxId('usuario', 'idusuario', $conexion);
                        $clave = $objUsu->combinarClave($_REQUEST['cla'], 8);
                        $objUsu->setPropiedades($_REQUEST['usu'], $clave, $_REQUEST['tip'], $_REQUEST['idPer']);
                        if($objUsu->ingresar($conexion)){
                            $res = 1;
                        }else{
                            $res = 4;
                        }
                    }
                }
                break;
            case 'guardarUsuPv':
                $objPer->setPropiedades($_REQUEST['ced'], $_REQUEST['nom'], $_REQUEST['ape'], $_REQUEST['cor'], $_REQUEST['dep'], $_REQUEST['tel'], $_REQUEST['car'], $_REQUEST['con']);
                if($objPer->ingresar($conexion)){
                    $sql = "SELECT * FROM personal WHERE cedper='".$_REQUEST['ced']."'";
                    $objPer->buscar($sql, $conexion);
                    $res = $conexion->devolver_recordset();
                    
                    $clave = $objUsu->combinarClave($_REQUEST['cla'], 8);
                    $objUsu->setPropiedades($_REQUEST['usu'], $clave, $_REQUEST['tip'], $res['idper']);
                    if($objUsu->ingresar($conexion)){
                        $res = 1;
                    }else{
                        $res = 2;
                    }
                }else{
                    $res = 0;
                }
                break;
            case 'modificarUsu':
                $sql = "UPDATE usuario SET tipousu='".$_REQUEST['tip']."' WHERE idusuario = '".$_REQUEST['codusu']."'";
                if(!$objUsu->modificar($sql, $conexion)){
                    $res = 1;//MODIFICADO CON EXITO
                }else{
                    $res = 2;//HUBO UN ERROR
                }
                break;
            case 'buscarTodosUsu'://fina
                $sql = "SELECT * FROM usuario ORDER BY nombreusu ASC";
//                print_r($sql); exit();
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
//                        print_r($res); exit();
                    }else{
                        $res = 0;
                    }
                }else{
                    $res = 0;
                }          
                break;
            case 'eliminarUsu':
                if($_REQUEST['param'] != ''){
                    $ids = explode(',', $_REQUEST['param']);
                    for($i = 0;$i < count($ids); $i++){
                        $sql = "DELETE FROM usuario WHERE idusuario='".$ids[$i]."'";
                        $objUsu->modificar($sql, $conexion);
                    }
                    $res = 1;
                }else{
                    $res = 0;
                }     
                break;
            case 'buscarUsuLe':
                if($objUsu->buscar("SELECT * FROM usuario WHERE nombusu LIKE '".strtoupper($_REQUEST['letras'])."%' ORDER BY nombusu,apellidousu", $conexion)){
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
                break;
            case 'cambiarClave'://fina
                $sql = "SELECT * FROM usuario WHERE nombreusu='".strtoupper($_REQUEST['log'])."'";
                if($objUsu->buscar($sql, $conexion)){
                    $fila = $conexion->devolver_recordset();
                    if(crypt($_REQUEST['act'], $fila['claveusu']) == $fila['claveusu']){
                        $clave = $objUsu->combinarClave($_REQUEST['cla'], 8);
                        $sql = "UPDATE usuario SET claveusu='".$clave."' WHERE idusuario='".$fila['idusuario']."'";
                        if(!$objUsu->modificar($sql, $conexion)){
                            $res = 1;
                        }else{
                            $res = 3;
                        }
                    }else{
                        $res = 0;
                    }
                }else{
                    $res = 2;
                }
                break;
            case 'buscarPer':
                $sql = "SELECT * FROM personal WHERE cedper='".$_REQUEST['doc']."'";
                if($objPer->buscar($sql, $conexion)){
                    if($conexion->registros > 0){
                        $res = $conexion->devolver_recordset();
                        $objPer->buscar("SELECT * FROM horario_persona WHERE idper='".$res['idper']."'", $conexion);
                        $res['h'] = $conexion->devolver_recordset();
//                        $res = 0;//existe una persona con la cedula
                    }else{
                        $res = 2;
                    }
                }else{
                    $res = 2;
                }
                
                break;
            case 'buscarPerMod':
                $sql = "SELECT * FROM personal WHERE idper='".$_REQUEST['cod']."'";
                if($objPer->buscar($sql, $conexion)){
                    if($conexion->registros > 0){
                        $res = $conexion->devolver_recordset();
                        $objPer->buscar("SELECT * FROM horario_persona WHERE idper='".$_REQUEST['cod']."'", $conexion);
                        $res['h'] = $conexion->devolver_recordset();
//                        $res = 0;//existe una persona con la cedula
                    }else{
                        $res = 0;
                    }
                }else{
                    $res = 0;
                }
                break;
            case 'guardarPer':
                
                if($_REQUEST['idPer'] != ''){//MODIFICAR
                    
                }else{//GUARDAR
                    $objPer->setPropiedades($_REQUEST['doc'], $_REQUEST['nom'], $_REQUEST['ape'], $_REQUEST['cor'], $_REQUEST['dep'], $_REQUEST['tel'], $_REQUEST['car'], $_REQUEST['con']);
                    if($objPer->ingresar($conexion)){
                        $sql = "SELECT * FROM personal WHERE cedper = '".$_REQUEST['doc']."'";
//                        print_r($sql);                        die();
                        $objPer->buscar($sql, $conexion);
                        $res = $conexion->devolver_recordset();
                        $objHorPer->setPropiedades($res['idper'], $_REQUEST['hor']);
                        $objHorPer->ingresar($conexion);
                        
                        $res = 1;
                    }else{
                        $res = 2;
                    }
                }
                break;
            case 'modificarPer':
                if($_REQUEST['ced'] == $_REQUEST['cedPer']){
                    $w = 1;
                }else{
                    $sql = "SELECT * FROM personal WHERE cedper = '".$_REQUEST['ced']."'";
                    if($objPer->buscar($sql, $conexion)){
                        $w = 0;
                    }else{
                        $w = 1;
                    }
                }
                if($w == 1){
                    $sql = "UPDATE personal SET cedper='".$_REQUEST['ced']."', nomper='".$_REQUEST['nom']."', apeper='".$_REQUEST['ape']."', emailper='".$_REQUEST['cor']."', dependencia='".$_REQUEST['dep']."', telfper='".$_REQUEST['tel']."', cargo='".$_REQUEST['car']."', condicion='".$_REQUEST['con']."' WHERE idper='".$_REQUEST['idPer']."'";
//                    print_r($sql); exit();
                    $objPer->modificar($sql, $conexion);
                    
                    $sql = "SELECT * FROM horario_persona WHERE idper = '".$_REQUEST['idPer']."'";
                    if($objHorPer->buscar($sql, $conexion)){
//                        print_r('consiguio algo'); exit();
                        $sql = "UPDATE horario_persona SET idhor = '".$_REQUEST['hor']."' WHERE idper = '".$_REQUEST['idPer']."'";
                        $objHorPer->modificar($sql, $conexion);
                    }else{
//                        print_r('NOOOOO consiguio algo'); exit();
                        $objHorPer->setPropiedades($_REQUEST['idPer'], $_REQUEST['hor']);
                        $objHorPer->ingresar($conexion);
                    }
                    $res = 1;
                }else{
                    $res = 0;//existe una persona con la misma cedula modificada
                }
                break;
            case 'buscarTodosPer'://fina
                if($objPer->buscar("SELECT * FROM personal ORDER BY nomper,apeper DESC", $conexion)){
                    if($conexion->registros > 0){
                        $i = 0;
                        do{
                            $res[$i] = $conexion->devolver_recordset();
                            $i++;
                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
                        for($i = 0;$i < count($res);$i++){
                            $sql = "SELECT * FROM horario_persona WHERE idper = '".$res[$i]['idper']."'";
                            $objPer->buscar($sql, $conexion);
                            $res[$i]['h'] = $conexion->devolver_recordset();
                        }
                    }else{
                        $res = 0;
                    }
                }else{
                    $res = 0;
                }          
                break;
            case 'buscarxTipo':
                $sql = "SELECT * FROM personal WHERE tipoper='".$_REQUEST['tip']."'";
//                print_r($sql);
                if($objPer->buscar($sql, $conexion)){
                    $fila = $conexion->devolver_recordset();
                    
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
                break;
            case 'eliminarPer'://fina
                if($_REQUEST['param'] != ''){
                    $si = 0;
                    $no = 0;
                    $ids = explode(',', $_REQUEST['param']);
//                    print_r($ids);
                    $cant = count($ids);
                    for($i = 0;$i < $cant; $i++){
                        $sql = "SELECT * FROM asistencia WHERE idper = '".$ids[$i]."'";
                        if($objPer->buscar($sql, $conexion)){
                            $no++;
                        }else{
                            $sql = "DELETE FROM personal WHERE idper='".$ids[$i]."'";
                            $objPer->modificar($sql, $conexion);
                            $si++;
                        }
                    }
                }else{
                    $res = 0;
                }
                if($si != 0){
                    $res = 1;//elimino algun registro
                }else if($si == $cant){
                    $res = 2;//elimino a todos
                }else{
                    $res = 3;//no elimino nada
                }
                break;
            case 'buscarxCargo':
                if($_REQUEST['car'] == -1){
                    $sql = "SELECT * FROM personal ORDER BY nomper,apeper ASC";
                }else{
                    $sql = "SELECT * FROM personal WHERE cargo= '".$_REQUEST['car']."' ORDER BY nomper,apeper ASC";
                }
                
                if($objPer->buscar($sql, $conexion)){
                    $i = 0;
                    do{
                        $res[$i] = $conexion->devolver_recordset();
                        $i++;
                    }while(($conexion->siguiente()) && ($i != $conexion->registros));
                }else{
                    $res = 0;
                }
                break;
            case 'buscarxDepen':
                if($_REQUEST['depen'] == -1){
                    $sql = "SELECT * FROM personal ORDER BY nomper,apeper ASC";
                }else{
                    $sql = "SELECT * FROM personal WHERE dependencia= '".$_REQUEST['depen']."' ORDER BY nomper,apeper ASC";
                }
                
                if($objPer->buscar($sql, $conexion)){
                    $i = 0;
                    do{
                        $res[$i] = $conexion->devolver_recordset();
                        $i++;
                    }while(($conexion->siguiente()) && ($i != $conexion->registros));
                }else{
                    $res = 0;
                }
                break;
            case 'buscarxCond':
                if($_REQUEST['cond'] == -1){
                    $sql = "SELECT * FROM personal ORDER BY nomper,apeper ASC";
                }else{
                    $sql = "SELECT * FROM personal WHERE condicion= '".$_REQUEST['cond']."' ORDER BY nomper,apeper ASC";
                }
                
                if($objPer->buscar($sql, $conexion)){
                    $i = 0;
                    do{
                        $res[$i] = $conexion->devolver_recordset();
                        $i++;
                    }while(($conexion->siguiente()) && ($i != $conexion->registros));
                }else{
                    $res = 0;
                }
                break;
            case 'buscarPerxCed':
                if($_REQUEST['ced'] == -1){
                    $sql = "SELECT * FROM personal ORDER BY nomper,apeper ASC";
                }else{
                    $sql = "SELECT * FROM personal WHERE cedper= '".$_REQUEST['ced']."' ORDER BY nomper,apeper ASC";
                }
                
                if($objPer->buscar($sql, $conexion)){
                    $i = 0;
                    do{
                        $res[$i] = $conexion->devolver_recordset();
                        $i++;
                    }while(($conexion->siguiente()) && ($i != $conexion->registros));
                }else{
                    $res = 0;
                }
                break;
            case 'guardarFes':
                $sql = "SELECT * FROM diasfestivo WHERE fecha = '".cambiarFormatoFecha($_REQUEST['fec'],'bdd')."'";
//                print_r($sql);
                if ($objFes->buscar($sql, $conexion)){
                    $res = 2;
                }else{
                    $objFes->setPropiedades($_REQUEST['des'], $_REQUEST['fec']);    
                    if($objFes->ingresar($conexion)){
                        $res = 1;
                    }else{
                        $res = 0;
                    } 
                }
                
            break;
            case 'buscarTodosFes'://fina
                if($objFes->buscar("SELECT * FROM diasfestivo ORDER BY descfest DESC", $conexion)){
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
                break;
            case 'eliminarFes'://fina
                if($_REQUEST['param'] != ''){
                    $ids = explode(',', $_REQUEST['param']);
                    for($i = 0;$i < count($ids); $i++){
                        $sql = "DELETE FROM diasfestivo WHERE idfestivo='".$ids[$i]."'";
                        $objFes->modificar($sql, $conexion);
                    }
                    $res = 1;
                }else{
                    $res = 0;
                } 
                break;
            case 'modificarFes':
                $sql = "UPDATE diasfestivo SET descfest='".$_REQUEST['des']."', fecha='".$_REQUEST['fec']."' WHERE idfestivo='".$_REQUEST['id']."'";
                $objFes->modificar($sql, $conexion);
                $res = 1;
                break;
            case 'buscarxFechFes':
                $sql = "SELECT * FROM diasfestivo WHERE fecha BETWEEN '".$_REQUEST['fe1']."' AND '".$_REQUEST['fe2']."' ORDER BY fecha";
                if($objFes->buscar($sql, $conexion)){
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
                break;
             case 'buscarxPalFes':
                $sql = "SELECT * FROM diasfestivo WHERE descfest LIKE '%".strtoupper($_REQUEST['pal'])."%' ORDER BY fecha";
                if($objFes->buscar($sql, $conexion)){
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
                break;
            case 'guardarH'://fina
                $sql = "SELECT * FROM horario WHERE descripcionhor = '".strtoupper($_REQUEST['des'])."'";
                if($objHor->buscar($sql, $conexion)){
                    $res = -1;
                }else{
                   $objHor->setPropiedades($_REQUEST['desdeM'], $_REQUEST['hastaM'], $_REQUEST['des']);
                    if($objHor->ingresar($conexion)){
                        $res = 1;
                    }else{
                        $res = 0;
                    } 
                }
                break;
            case 'modificarH':
                $w = 0;
                $sql = "SELECT * FROM horario WHERE idhor = '".$_REQUEST['id']."'";
                if($objHor->buscar($sql, $conexion)){
                    if($conexion->registros > 0){
                        $fila = $conexion->devolver_recordset();
                        if(strtoupper($fila['descripcionhor']) == strtoupper($_REQUEST['desc'])){
                            $w = 1;
                        }else{
                            $sql = "SELECT * FROM horario WHERE descripcionhor = '".strtoupper($_REQUEST['desc'])."'";
                            if($objHor->buscar($sql, $conexion)){
                                if($conexion->registros > 0){
                                    $w = 0;
                                }else{
                                    $w = 1;
                                }
                            }else{
                                $w = 1;
                            }
                        }
                    }else{
                        $w = 0;
                    }
                }else{
                    $w = 0;
                }   
                
                if($w == 1){
                    $sql = "UPDATE horario SET descripcionhor='".strtoupper($_REQUEST['des'])."', horentrada='".$_REQUEST['desdeM']."', horasalida='".$_REQUEST['hastaM']."' WHERE idhor='".$_REQUEST['id']."'";
                    $objHor->modificar($sql, $conexion);
                    $res = 1;
                }else{
                    $res = -1;
                }
                
                
                
                
                break;
            case 'buscarTodosHor'://fina
                if($objHor->buscar("SELECT * FROM horario ORDER BY descripcionhor DESC", $conexion)){
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
                break;
            case 'eliminarHor'://fina
                $si = 0;
                $no = 0;
//                print_r($_REQUEST['param']); exit();
                if($_REQUEST['param'] != ''){
                    $ids = explode(',', $_REQUEST['param']);
//                    print_r($ids); exit();
//                    print_r($ids);
                    $cant = count($ids);
//                    print_r('///cantidad: '.$cant.'///');
                    for($i = 0;$i < $cant; $i++){
                        $sql = "SELECT * FROM horario_persona WHERE idhor = '".$ids[$i]."'";
//                        print_r($sql);                            exit();
                        if($objHor->buscar($sql, $conexion)){
                            $no++;
                        }else{
                            $sql = "DELETE FROM horario WHERE idhor='".$ids[$i]."'";
//                            print_r('///si hay///');
                            $objFes->modificar($sql, $conexion);
                            $si++;
                        }
                    }
//                    print_r('si: '.$si); exit();
                    if($si != 0){
                        if($si == $cant){//SE ELIMINARON todos los registros
                            $res = 1;
                        }else{//SE ELIMINARON ALGUNOS
                            $res = 2;
                        }
                    }else{//NO SE ELIMINARON NINGUN REGISTRO
                        $res = 0;
                    }
                }else{
                    $res = 3;
                } 
                break;
            case 'guardarPerm':
                $objPerPer->setPropiedades($_REQUEST['persona'], $_REQUEST['des'], cambiarFormatoFecha($_REQUEST['desde'],'bdd'), cambiarFormatoFecha($_REQUEST['hasta'],'bdd'),$_REQUEST['permi']);
                if($objPerPer->ingresar($conexion)){
                    $res = 1;
                }else{
                    $res = 2;
                }
                break;
//            case 'maxRegCor':
//                $res = $objUsu->maxId("correspondencia","idcorrespondencia",$conexion);
//                break;
//            
            case 'buscarTodosPerm':
                if($objPerPer->buscar("SELECT * FROM permiso_persona ORDER BY desde DESC", $conexion)){
                    if($conexion->registros > 0){
                        $i = 0;
                        do{
                            $res[$i] = $conexion->devolver_recordset();
                            $i++;
                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
                        for ($i = 0; $i < count($res);$i++){
                            $sql = "SELECT * FROM personal WHERE idper='".$res[$i]['idpersona']."'";
//                            print_r($sql);                            exit();
                            $objPer->buscar($sql, $conexion);
                            $res[$i]['p'] = $conexion->devolver_recordset();
                        }
                    }else{
                        $res = 0;
                    }
                }else{
                    $res = 0;
                }        
                break;
            case 'registrarAsis':
                $sql = "SELECT * FROM personal WHERE cedper = '".$_REQUEST['ced']."'";
                if($objAsi->buscar($sql, $conexion)){
                    if($conexion->registros > 0){
                        $res = $conexion->devolver_recordset();
                        $objAsi->setPropiedades($res['idper']);
                        if($objAsi->ingresar($conexion)){
                            $res = 1;
                        }else{
                            $res = 2;
                        }
                    }else{
                        $res = 0;//no existe persona con esa cedula
                    }
                }else{
                    $res = 0;//no existe persona con esa cedula
                }
                break;
            case 'buscarrepPer':
                $tipo = $_REQUEST['tip'];
                $desde = $_REQUEST['des'];
                $hasta = $_REQUEST['has'];
                if($tipo == -2 && $desde == '' && $hasta == ''){
                    $sql = "SELECT * FROM permiso_persona";
                }else if ($tipo != -2  && $desde == '' && $hasta == ''){
                    $sql = "SELECT * FROM permiso_persona WHERE idpermiso='".$tipo."'";
                }else if ($tipo != -2 && $desde != '' && $hasta != ''){
                    $sql = "SELECT * FROM permiso_persona WHERE idpermiso='".$tipo."' AND desde >='".cambiarFormatoFecha($desde, 'bdd')."' AND hasta <='".cambiarFormatoFecha($hasta, 'bdd')."'";
                }else{
                    $sql = "SELECT * FROM permiso_persona WHERE desde >='".cambiarFormatoFecha($desde, 'bdd')."' AND hasta <='".cambiarFormatoFecha($hasta, 'bdd')."'";
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
                    }else{
                        $res = 0;
                    }
                }else{
                    
                    $res = 0;
                }                
                break;
            case 'eliminarPerm':
                if($_REQUEST['param'] != ''){
                    $ids = explode(',', $_REQUEST['param']);
                    for($i = 0;$i < count($ids); $i++){
                        $sql = "DELETE FROM permiso_persona WHERE idperper='".$ids[$i]."'";
                        $objPerPer->modificar($sql, $conexion);
                    }
                    $res = 1;
                }else{
                    $res = 0;
                }     
                break;
            case 'modificarPerm':
                $sql = "UPDATE permiso_persona SET idpersona='".$_REQUEST['per']."', desde='".$_REQUEST['desde']."', hasta='".$_REQUEST['hasta']."',descripcionper='".$_REQUEST['des']."',idpermiso='".$_REQUEST['permi']."' WHERE idperper='".$_REQUEST['cod']."'";
                $objPerPer->modificar($sql, $conexion);
                $res = 1;
                break;
    }
    $json = new Services_JSON();
    $resp = $json->encode($res);
    
    echo html_entity_decode($resp,ENT_QUOTES,'UTF-8');