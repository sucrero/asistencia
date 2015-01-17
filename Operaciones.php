<?php
    session_start();
    include_once 'conexion/conexion.php';
    include_once 'clases/JSON.php';
    include_once 'clases/Usuario.php';
//    include_once 'clases/Correspondencia.php';
//    include_once 'clases/Persona.php';
//    include_once 'clases/Municipio.php';
//    include_once 'clases/Parroquia.php';
//    include_once 'clases/Vivienda.php';
//    include_once 'clases/Tierra.php';
//    include_once 'clases/Consulta.php';
//    include_once 'clases/Notificacion.php';
    $objUsu = new Usuario();
//    $objCor = new Correspondencia();
//    $objPer = new Persona();
//    $objViv = new Vivienda();
//    $objPar = new Parroquia();
//    $objTie = new Tierra();
//    $objCon = new Consulta();
//    $objNot = new Notificacion();
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
                        if($fila['statususu'] == 'ACTIVO'){
                            $_SESSION['cuenta'] = $fila['nombusu']."  ".$fila['apeusu'];
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
                $sql = "SELECT * FROM usuario WHERE cedulausu='".$_REQUEST['ced']."'";
                if($objUsu->buscar($sql, $conexion)){
                    $res = $conexion->devolver_recordset();
                }else{
                    $res =0;
                }
                break;
            case 'guardarUsu'://fina
                $sql = "SELECT * FROM usuario WHERE nombreusu='".strtoupper($_REQUEST['usu'])."'";
                if($objUsu->buscar($sql, $conexion)){
                    $res = 2;
                }else{
                    $sql = "SELECT * FROM usuario WHERE cedulausu='".$_REQUEST['ced']."'";
                    if($objUsu->buscar($sql, $conexion)){
                        $res = 3;
                    }else{
//                        $codigo = $objUsu->maxId('usuario', 'idusuario', $conexion);
                        $clave = $objUsu->combinarClave($_REQUEST['cla'], 8);
                        
                        $objUsu->setPropiedades($_REQUEST['usu'], $clave, $_REQUEST['tip'], $_REQUEST['ced'], $_REQUEST['nom'], $_REQUEST['ape']);
                        if($objUsu->ingresar($conexion)){
                            $res = 1;
                        }else{
                            $res = 4;
                        }
                    }
                }
                break;
            case 'modificarUsu':
                $sql = "SELECT * FROM usuario WHERE idusuario='".$_REQUEST['id']."'";
                if($objUsu->buscar($sql, $conexion)){
                    $fila = $conexion->devolver_recordset();
                    $cedOld = $fila['cedulausu'];
                    $emailOld = $fila['correousu'];
                    if($cedOld != $_REQUEST['ced']){
                        $sql = "SELECT * FROM usuario WHERE cedulausu = '".$_REQUEST['ced']."'";
                        if($objUsu->buscar($sql, $conexion)){
                            $res = 6;//PERSONA ENCONTRADA CON UNA MISMA CEDULA
                            $w = FALSE;
                        }else{                         
                            $w = TRUE;
                        }
                    }else{
                        $w = TRUE;
                    }
                    if($w){
                        if($emailOld != $_REQUEST['mai']){
                            $sql = "SELECT * FROM usuario WHERE correousu = '".strtoupper($_REQUEST['mai'])."'";
                            if($objUsu->buscar($sql, $conexion)){
                                $res = 7;//PERSONA CON EL MISMO EMAIL
                                $w = FALSE;
                            }else{
                                $w = TRUE;
                            }
                        }else{
                            $w = TRUE;
                        }
                        if($w){
                            $sql = "UPDATE usuario SET tipousu='".$_REQUEST['tip']."',cedulausu='".$_REQUEST['ced']."',nombusu='".strtoupper($_REQUEST['nom'])."',apellidousu='".strtoupper($_REQUEST['ape'])."',telfusu='".$_REQUEST['tel']."',correousu='".strtoupper($_REQUEST['mai'])."' WHERE idusuario = '".$_REQUEST['id']."'";
                            if(!$objUsu->modificar($sql, $conexion)){
                                $res = 9;//MODIFICADO CON EXITO
                            }else{
                                $res = 8;//HUBO UN ERROR
                            }
                        }
                    }
                }else{
                    $res = 5;//no se encontro ningun registro con el id
                }
                break;
            case 'buscarTodosUsu'://fina
                if($objUsu->buscar("SELECT * FROM usuario ORDER BY nombusu,apeusu DESC", $conexion)){
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
//            case 'buscarPer':
//                if(ctype_alpha($_REQUEST['doc'][0])){
//                    $campo = 'rifper';
//                }else{
//                    $campo = 'cedulaper';
//                }
//                $sql = "SELECT * FROM persona WHERE tipoper='".  strtoupper($_REQUEST['tipo'])."' AND ".$campo."='".strtoupper($_REQUEST['doc'])."'";
//                if($objPer->buscar($sql, $conexion)){
//                    if($conexion->registros > 0){
//                        $res = $conexion->devolver_recordset();
//                    }else{
//                        $res = 2;
//                    }
//                }else{
//                    $res = 2;
//                }
//                
//                break;
//            case 'guardarCor':
//                $codigoPer = '';
//                $cedula = '';
//                $rif = '';
//                if(ctype_alpha($_REQUEST['doc'][0])){
//                    $rif = $_REQUEST['doc'];
//                }else{
//                    $cedula = $_REQUEST['doc'];
//                }
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nom'], $_REQUEST['ape'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                if($w){
//                    $codigoCor = $objUsu->maxId('correspondencia', 'idcorrespondencia', $conexion);
//                    $objCor->setPropiedades($codigoCor, $codigoPer, $_SESSION['id'], $_REQUEST['tip'], $_REQUEST['rec'], $_REQUEST['asu']);
//                    if($objCor->ingresar($conexion)){
//                        $res = 1;
//                    }else{
//                        $res = 2;
//                    }
//                }else{
//                    $res = 3;
//                }
//                break;
//            case 'maxRegCor':
//                $res = $objUsu->maxId("correspondencia","idcorrespondencia",$conexion);
//                break;
//            
//            case 'buscarTodosCor':
//                if($objCor->buscar("SELECT * FROM correspondencia ORDER BY feccorres DESC", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for ($i = 0; $i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                            $objUsu->buscar("SELECT * FROM usuario WHERE idusuario='".$res[$i]['idusuario']."'", $conexion);
//                            $res[$i]['u'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }        
//                break;
//            case 'buscarxCont':
//                if(ctype_alpha($_REQUEST['doc'][0])){
//                    $rif = $_REQUEST['doc'];
//                    $where = "WHERE rifper='".$rif."'";
//                }else{
//                    $cedula = $_REQUEST['doc'];
//                    $where = "WHERE cedulaper='".$cedula."'";
//                }
//                $sql = 'SELECT * FROM persona '.$where;
//                if($objPer->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM correspondencia WHERE idpersona='".$fila['idpersona']."' ORDER BY feccorres";
//                    if($objCor->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0; $i < count($res); $i++){
//                                $objUsu->buscar("SELECT * FROM usuario WHERE idusuario='".$res[$i]['idusuario']."'", $conexion);
//                                $res[$i]['u'] = $conexion->devolver_recordset();
//                                $res[$i]['p'] = $fila;
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxFech':
//                $sql = "SELECT * FROM correspondencia WHERE feccorres BETWEEN '".$_REQUEST['fe1']."' AND '".$_REQUEST['fe2']."' ORDER BY feccorres";
//                if($objCor->buscar($sql, $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for ($i = 0; $i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                            $objUsu->buscar("SELECT * FROM usuario WHERE idusuario='".$res[$i]['idusuario']."'", $conexion);
//                            $res[$i]['u'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxOper':
//                $sql = "SELECT * FROM usuario WHERE cedulausu='".$_REQUEST['ced']."'";
//                if($objUsu->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM correspondencia WHERE idusuario='".$fila['idusuario']."' ORDER BY feccorres";
//                    if($objCor->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0; $i < count($res); $i++){
//                                $objUsu->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                                $res[$i]['p'] = $conexion->devolver_recordset();
//                                $res[$i]['u'] = $fila;
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'maxRegViv':
//                $res = $objUsu->maxId("vivienda","idvivienda",$conexion);
//                break;
//            case 'buscarMun':
//                $objMun = new Municipio();
//                    if($objMun->buscar("select * from municipio WHERE idestado='".$_POST['codEstado']."' ORDER BY nombremunicipio ASC", $conexion)){
//                        if($conexion->registros > 0){                           
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        }else{
//                            $res = 0;
//                        }
//                   }
//                break;
//            case 'buscarPar':
//                $objPar = new Parroquia();
//                if($objPar->buscar("select * from parroquia WHERE idmunicipio='".$_POST['codMunicipio']."' ORDER BY nombreparroquia ASC", $conexion)){
//                    if($conexion->registros>0){
//                        $i = 0;
//                        do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                     }else{
//                        $res = 0;
//                     }
//                }
//                break;
//            case 'guardarViv':
//                $cedula = '';
//                $rif = '';
//                $cedulaco = '';
//                $rifco = '';
//                if(ctype_alpha($_REQUEST['docTit'][0])){
//                    $rif = $_REQUEST['docTit'];
//                }else{
//                    $cedula = $_REQUEST['docTit'];
//                }
//                
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nomTit'], $_REQUEST['apeTit'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                
//                if($_REQUEST['docCot'] != '' && $_REQUEST['nomCot'] != '' && $_REQUEST['apeCot'] != ''){
//                    if(ctype_alpha($_REQUEST['docCot'][0])){
//                        $rifco = $_REQUEST['docCot'];
//                    }else{
//                        $cedulaco = $_REQUEST['docCot'];
//                    }
//                    if($_REQUEST['idPerCo'] == ''){
//                        $correo = '';
//                        $telefono = '';
//                        $tipoPer = 'cotitular';
//                        $codigoPerCo = $objUsu->maxId('persona', 'idpersona', $conexion);
//                        $objPer->setPropiedades($codigoPerCo, $cedulaco, $rifco, $correo, $telefono, $_REQUEST['nomCot'], $_REQUEST['apeCot'], $tipoPer);
//                        if($objPer->ingresar($conexion)){
//                            $y = TRUE;
//                        }else{
//                            $y = FALSE;
//                        }
//                    }else{
//                        $codigoPerCo = $_REQUEST['idPerCo'];
//                        $y = TRUE;
//                    }
//                }else{
//                    $codigoPerCo = 0;
//                    $y = TRUE;
//                }
//                
//                if($w && $y){
//                    $fecha = date('Y-m-d');
//                    $codViv = $objUsu->maxId('vivienda', 'idvivienda', $conexion);
//                    $objViv->setPropiedades($codViv, $codigoPer, $codigoPerCo, $_REQUEST['par'], $_SESSION['id'], 
//                                            $_REQUEST['zonPos'], cambiarFormatoFecha($_REQUEST['fecAdq'],'bdd'), $_REQUEST['sec'], $_REQUEST['tip'], 
//                                            $_REQUEST['nroCas'], $_REQUEST['valInm'], $_REQUEST['valMej'], $fecha, cambiarFormatoFecha($_REQUEST['fecReg'],'bdd'), 
//                                            $_REQUEST['numDoc'], $_REQUEST['numTom']);
//                    if($objViv->ingresar($conexion)){
//                        $res = 1;
//                    }else{
//                        $res = 2;
//                    }
//                }else{
//                    $res = 3;
//                }
//                
//                break;
//                
//            case 'modificarViv':
//                $cedula = '';
//                $rif = '';
//                $cedulaco = '';
//                $rifco = '';
//                if(ctype_alpha($_REQUEST['docTit'][0])){
//                    $rif = $_REQUEST['docTit'];
//                }else{
//                    $cedula = $_REQUEST['docTit'];
//                }
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nomTit'], $_REQUEST['apeTit'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                
//                if($_REQUEST['docCot'] != '' && $_REQUEST['nomCot'] != '' && $_REQUEST['apeCot'] != ''){
//                    if(ctype_alpha($_REQUEST['docCot'][0])){
//                        $rifco = $_REQUEST['docCot'];
//                    }else{
//                        $cedulaco = $_REQUEST['docCot'];
//                    }
//                    if($_REQUEST['idPerCo'] == ''){
//                        $correo = '';
//                        $telefono = '';
//                        $tipoPer = 'cotitular';
//                        $codigoPerCo = $objUsu->maxId('persona', 'idpersona', $conexion);
//                        $objPer->setPropiedades($codigoPerCo, $cedulaco, $rifco, $correo, $telefono, $_REQUEST['nomCot'], $_REQUEST['apeCot'], $tipoPer);
//                        if($objPer->ingresar($conexion)){
//                            $y = TRUE;
//                        }else{
//                            $y = FALSE;
//                        }
//                    }else{
//                        $codigoPerCo = $_REQUEST['idPerCo'];
//                        $y = TRUE;
//                    }
//                }else{
//                    $codigoPerCo = 0;
//                    $y = TRUE;
//                }
//                if($w && $y){
//                    $fecha = date('Y-m-d');
//                    $sql = "UPDATE vivienda SET idpersona='".$codigoPer."', per_idpersona='".$codigoPerCo."', idparroquia='".$_REQUEST['par']."', idusuario='".$_SESSION['id']."', zonapostal='".$_REQUEST['zonPos']."', fecadquisicion='".cambiarFormatoFecha($_REQUEST['fecAdq'],'bdd')."',sector='".strtoupper($_REQUEST['sec'])."', tipovivienda='".strtoupper($_REQUEST['tip'])."', nrovivienda='".$_REQUEST['nroCas']."', valorinmueble='".$_REQUEST['valInm']."', valormejora='".$_REQUEST['valMej']."', fechavivienda='".$fecha."', fecregistro='".cambiarFormatoFecha($_REQUEST['fecReg'],'bdd')."', documentovivienda='".$_REQUEST['numDoc']."', tomovivienda='".$_REQUEST['numTom']."' WHERE idvivienda='".$_REQUEST['cod']."'";
//                    $objViv->modificar($sql, $conexion);
//                    $res = 1;
//                }else{
//                    $res = 2;
//                }
//                break;
//            case 'buscarTodosViv':
//                if($objViv->buscar("SELECT * FROM vivienda ORDER BY fechavivienda DESC", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for ($i = 0;$i < count($res); $i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                            $res[$i]['c'] = $conexion->devolver_recordset();
//                            $objPar->buscar("SELECT * FROM parroquia WHERE idparroquia='".$res[$i]['idparroquia']."'", $conexion);
//                            $res[$i]['par'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }
//                break;
//            case 'buscarxContV':
//                if(ctype_alpha($_REQUEST['doc'][0])){
//                    $rif = $_REQUEST['doc'];
//                    $where = "WHERE rifper='".$rif."'";
//                }else{
//                    $cedula = $_REQUEST['doc'];
//                    $where = "WHERE cedulaper='".$cedula."'";
//                }
//                $sql = 'SELECT * FROM persona '.$where;
//                if($objPer->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM vivienda WHERE idpersona='".$fila['idpersona']."' ORDER BY fechavivienda";
//                    if($objViv->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0;$i < count($res);$i++){
//                                $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                                $res[$i]['c'] = $conexion->devolver_recordset();
//                                $res[$i]['p'] = $fila;
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            
//            case 'eliminarViv':
//                if($_REQUEST['param'] != ''){
//                    $ids = explode(',', $_REQUEST['param']);
//                    for($i = 0;$i < count($ids); $i++){
//                        $sql = "DELETE FROM vivienda WHERE idvivienda='".$ids[$i]."'";
//                        $objViv->modificar($sql, $conexion);
//                    }
//                    $res = 1;
//                }else{
//                    $res = 0;
//                }       
//                break;
//            case 'buscarxUbic';
//                $sql = "SELECT * FROM vivienda WHERE idparroquia='".$_REQUEST['par']."' ORDER BY fechavivienda";
//                if($objViv->buscar($sql, $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                            $res[$i]['c'] = $conexion->devolver_recordset();
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'maxRegTie':
//                $res = $objUsu->maxId("tierra","idtierra",$conexion);
//                break;
//            case 'guardarTie':
//                $cedula = '';
//                $rif = '';
//                $cedulaco = '';
//                $rifco = '';
//                
//                if(ctype_alpha($_REQUEST['docTit'][0])){
//                    $rif = $_REQUEST['docTit'];
//                }else{
//                    $cedula = $_REQUEST['docTit'];
//                }
//                
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nomTit'], $_REQUEST['apeTit'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                
//                if($_REQUEST['docCot'] != '' && $_REQUEST['nomCot'] != '' && $_REQUEST['apeCot'] != ''){
//                    if(ctype_alpha($_REQUEST['docCot'][0])){
//                        $rifco = $_REQUEST['docCot'];
//                    }else{
//                        $cedulaco = $_REQUEST['docCot'];
//                    }
//                    if($_REQUEST['idPerCo'] == ''){
//                        $correo = '';
//                        $telefono = '';
//                        $tipoPer = 'cotitular';
//                        $codigoPerCo = $objUsu->maxId('persona', 'idpersona', $conexion);
//                        $objPer->setPropiedades($codigoPerCo, $cedulaco, $rifco, $correo, $telefono, $_REQUEST['nomCot'], $_REQUEST['apeCot'], $tipoPer);
//                        if($objPer->ingresar($conexion)){
//                            $y = TRUE;
//                        }else{
//                            $y = FALSE;
//                        }
//                    }else{
//                        $codigoPerCo = $_REQUEST['idPerCo'];
//                        $y = TRUE;
//                    }
//                }else{
//                    $codigoPerCo = 0;
//                    $y = TRUE;
//                }
//                
//                if($w && $y){
//                    $fecha = date('Y-m-d');
//                    $codTie = $objUsu->maxId('tierra', 'idtierra', $conexion);
//                            
//                    $objTie->setPropiedades($codTie, $_SESSION['id'], $codigoPer, $_REQUEST['par'],$codigoPerCo, $fecha, cambiarFormatoFecha($_REQUEST['fecReg'],'bdd'), 
//                                            $_REQUEST['tipDoc'],$_REQUEST['numFolio'],$_REQUEST['numTom'],'',$_REQUEST['ptoRef'],$_REQUEST['linNor'],$_REQUEST['linSur'],
//                                            $_REQUEST['linEst'],$_REQUEST['linOes'],$_REQUEST['uso'],$_REQUEST['cla'],$_REQUEST['rub'],$_REQUEST['ext'],$_REQUEST['hec'],
//                                            $_REQUEST['numPro'],$_REQUEST['ciu']);
//                    
//                    if($objTie->ingresar($conexion)){
//                        $res = 1;
//                    }else{
//                        $res = 2;
//                    }
//                }else{
//                    $res = 3;
//                }
//                break;
//            case 'modificarTie':
//                $cedula = '';
//                $rif = '';
//                $cedulaco = '';
//                $rifco = '';
//                
//                if(ctype_alpha($_REQUEST['docTit'][0])){
//                    $rif = $_REQUEST['docTit'];
//                }else{
//                    $cedula = $_REQUEST['docTit'];
//                }
//                
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nomTit'], $_REQUEST['apeTit'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                
//                if($_REQUEST['docCot'] != '' && $_REQUEST['nomCot'] != '' && $_REQUEST['apeCot'] != ''){
//                    if(ctype_alpha($_REQUEST['docCot'][0])){
//                        $rifco = $_REQUEST['docCot'];
//                    }else{
//                        $cedulaco = $_REQUEST['docCot'];
//                    }
//                    if($_REQUEST['idPerCo'] == ''){
//                        $correo = '';
//                        $telefono = '';
//                        $tipoPer = 'cotitular';
//                        $codigoPerCo = $objUsu->maxId('persona', 'idpersona', $conexion);
//                        $objPer->setPropiedades($codigoPerCo, $cedulaco, $rifco, $correo, $telefono, $_REQUEST['nomCot'], $_REQUEST['apeCot'], $tipoPer);
//                        if($objPer->ingresar($conexion)){
//                            $y = TRUE;
//                        }else{
//                            $y = FALSE;
//                        }
//                    }else{
//                        $codigoPerCo = $_REQUEST['idPerCo'];
//                        $y = TRUE;
//                    }
//                }else{
//                    $codigoPerCo = 0;
//                    $y = TRUE;
//                }
//                if($w && $y){
//                    $fecha = date('Y-m-d');
////                    $codTie = $objUsu->maxId('tierra', 'idtierra', $conexion);
//            
//                    $sql = "UPDATE tierra SET idusuario='".$_SESSION['id']."', idpersona='".$codigoPer."', idparroquia='".$_REQUEST['par']."', per_idpersona='".$codigoPerCo."', fectierra='".$fecha."', fecregistrotierra='".cambiarFormatoFecha($_REQUEST['fecReg'],'bdd')."', 
//                                            tipodoctierra='".strtoupper($_REQUEST['tipDoc'])."', foliotierra='".$_REQUEST['numFolio']."',tomotierra='".$_REQUEST['numTom']."',ptoreftierra='".strtoupper($_REQUEST['ptoRef'])."',nortetierra='".strtoupper($_REQUEST['linNor'])."', surtierra='".strtoupper($_REQUEST['linSur'])."',
//                                            estetierra='".strtoupper($_REQUEST['linEst'])."', oestetierra='".strtoupper($_REQUEST['linOes'])."', usotierra='".strtoupper($_REQUEST['uso'])."', clasetierra='".$_REQUEST['cla']."', rubrotierra='".strtoupper($_REQUEST['rub'])."', extensiontierra='".$_REQUEST['ext']."', hectarreastierra='".$_REQUEST['hec']."',
//                                            protocolo='".$_REQUEST['numPro']."', ciudadtierra='".strtoupper($_REQUEST['ciu'])."' WHERE idtierra='".$_REQUEST['cod']."'";
//                    $objTie->modificar($sql, $conexion);
//                    $res = 1;
//                }else{
//                    $res = 2;
//                }
//                break;
//            case 'buscarTodosTie':
//                if($objTie->buscar("SELECT * FROM tierra ORDER BY fectierra DESC", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for ($i = 0;$i < count($res); $i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                            $res[$i]['c'] = $conexion->devolver_recordset();
//                            $objPar->buscar("SELECT * FROM parroquia WHERE idparroquia='".$res[$i]['idparroquia']."'", $conexion);
//                            $res[$i]['par'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }
//                break;
//            case 'eliminarTie':
//                if($_REQUEST['param'] != ''){
//                    $ids = explode(',', $_REQUEST['param']);
//                    for($i = 0;$i < count($ids); $i++){
//                        $sql = "DELETE FROM tierra WHERE idtierra='".$ids[$i]."'";
//                        $objTie->modificar($sql, $conexion);
//                    }
//                    $res = 1;
//                }else{
//                    $res = 0;
//                } 
//                break;
//            case 'buscarxContT':
//                if(ctype_alpha($_REQUEST['doc'][0])){
//                    $rif = $_REQUEST['doc'];
//                    $where = "WHERE rifper='".$rif."'";
//                }else{
//                    $cedula = $_REQUEST['doc'];
//                    $where = "WHERE cedulaper='".$cedula."'";
//                }
//                $sql = 'SELECT * FROM persona '.$where;
//                if($objPer->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM tierra WHERE idpersona='".$fila['idpersona']."' ORDER BY fectierra";
//                    if($objTie->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0;$i < count($res);$i++){
//                                $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                                $res[$i]['c'] = $conexion->devolver_recordset();
//                                $res[$i]['p'] = $fila;
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxFechT':
//                $sql = "SELECT * FROM tierra WHERE fectierra BETWEEN '".$_REQUEST['fe1']."' AND '".$_REQUEST['fe2']."' ORDER BY fectierra";
//                if($objTie->buscar($sql, $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                            $res[$i]['c'] = $conexion->devolver_recordset();
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxUbicT':
//                $sql = "SELECT * FROM tierra WHERE idparroquia='".$_REQUEST['par']."' ORDER BY fectierra";
//                if($objViv->buscar($sql, $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                            $res[$i]['c'] = $conexion->devolver_recordset();
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'maxRegCon':
//                $res = $objUsu->maxId("consulta","idconsulta",$conexion);
//                break;
//            case 'guardarCon':
//                $cedula = '';
//                $rif = '';
//                if(ctype_alpha($_REQUEST['docTit'][0])){
//                    $rif = $_REQUEST['docTit'];
//                }else{
//                    $cedula = $_REQUEST['docTit'];
//                }
//                
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nomTit'], $_REQUEST['apeTit'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                
//                if($w){
//                    $fecha = date('Y-m-d');
//                    $codCon = $objUsu->maxId('consulta', 'idconsulta', $conexion);
//                                        
//                    $objCon->setPropiedades($codCon, $_SESSION['id'], $codigoPer, $_REQUEST['con'], $fecha);
//                    
//                    if($objCon->ingresar($conexion)){
//                        $res = 1;
//                    }else{
//                        $res = 2;
//                    }
//                }else{
//                    $res = 3;
//                }
//                break;
//            case 'modificarCon':
//                $cedula = '';
//                $rif = '';
//                if(ctype_alpha($_REQUEST['docTit'][0])){
//                    $rif = $_REQUEST['docTit'];
//                }else{
//                    $cedula = $_REQUEST['docTit'];
//                }
//                
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nomTit'], $_REQUEST['apeTit'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                
//                if($w){
//                    $fecha = date('Y-m-d');
//                    $sql = "UPDATE consulta SET idusuario='".$_SESSION['id']."', idpersona='".$codigoPer."', descripcioncons='".strtoupper($_REQUEST['con'])."', fecconsulta='".$fecha."' WHERE idconsulta='".$_REQUEST['cod']."'";
//                    $objCon->modificar($sql, $conexion);
//                    $res = 1;
//                }else{
//                    $res = 2;
//                }
//                break;
//            case 'buscarTodosCon':
//                if($objCon->buscar("SELECT * FROM consulta ORDER BY fecconsulta DESC", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for ($i = 0;$i < count($res); $i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }
//                break;
//            case 'eliminarCon':
//                if($_REQUEST['param'] != ''){
//                    $ids = explode(',', $_REQUEST['param']);
//                    for($i = 0;$i < count($ids); $i++){
//                        $sql = "DELETE FROM consulta WHERE idconsulta='".$ids[$i]."'";
//                        $objCor->modificar($sql, $conexion);
//                    }
//                    $res = 1;
//                }else{
//                    $res = 0;
//                } 
//                break;
//            case 'buscarxContCon':
//                if(ctype_alpha($_REQUEST['doc'][0])){
//                    $rif = $_REQUEST['doc'];
//                    $where = "WHERE rifper='".$rif."'";
//                }else{
//                    $cedula = $_REQUEST['doc'];
//                    $where = "WHERE cedulaper='".$cedula."'";
//                }
//                $sql = 'SELECT * FROM persona '.$where;
//                if($objPer->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM consulta WHERE idpersona='".$fila['idpersona']."' ORDER BY fecconsulta";
//                    if($objCon->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0;$i < count($res);$i++){
//                                $res[$i]['p'] = $fila;
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxFechCon':
//                $sql = "SELECT * FROM consulta WHERE fecconsulta BETWEEN '".$_REQUEST['fe1']."' AND '".$_REQUEST['fe2']."' ORDER BY fecconsulta";
//                if($objCon->buscar($sql, $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxPalabra':
//                $sql = "SELECT * FROM consulta WHERE descripcioncons LIKE '%".strtoupper($_REQUEST['pal'])."%' ORDER BY fecconsulta";
//                if($objCon->buscar($sql, $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'eliminarCor':
//                if($_REQUEST['param'] != ''){
//                    $ids = explode(',', $_REQUEST['param']);
//                    for($i = 0;$i < count($ids); $i++){
//                        $sql = "DELETE FROM correspondencia WHERE idcorrespondencia='".$ids[$i]."'";
//                        $objCor->modificar($sql, $conexion);
//                    }
//                    $res = 1;
//                }else{
//                    $res = 0;
//                }               
//                break;
//            case 'modCor':
//                if($_REQUEST['cod'] != ''){
//                    $sql = "SELECT * FROM correspondencia as C INNER JOIN persona as P ON C.idpersona = P.idpersona WHERE idcorrespondencia='".$_REQUEST['cod']."'";
//                    if($objCor->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $res = $conexion->devolver_recordset();
//                        }else{
//                            $res = 0;
//                        }
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'modificarCor':
//                $codigoPer = '';
//                $cedula = '';
//                $rif = '';
//                if(ctype_alpha($_REQUEST['doc'][0])){
//                    $rif = $_REQUEST['doc'];
//                }else{
//                    $cedula = $_REQUEST['doc'];
//                }
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nom'], $_REQUEST['ape'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                if($w){
////                    $codigoCor = $objUsu->maxId('correspondencia', 'idcorrespondencia', $conexion);
//                    $sql = "UPDATE correspondencia SET idpersona='".$codigoPer."',tipocorres='".$_REQUEST['tip']."', recaudoscorres='".$_REQUEST['rec']."',asuntocorres='".$_REQUEST['asu']."' WHERE idcorrespondencia='".$_REQUEST['cod']."'";
//                    $objCor->modificar($sql, $conexion);
//                    $res = 1;
//                }else{
//                    $res = 2;
//                }
//                
//                break;
//            case 'maxRegNot':
//                $res = $objUsu->maxId("notificacion","idnotificacion",$conexion);
//                break;
//            case 'guardarNot':
//                $cedula = '';
//                $rif = '';
//                if(ctype_alpha($_REQUEST['docTit'][0])){
//                    $rif = $_REQUEST['docTit'];
//                }else{
//                    $cedula = $_REQUEST['docTit'];
//                }
//                
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nomTit'], $_REQUEST['apeTit'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                
//                if($w){
//                    $fecha = date('Y-m-d');
//                    $codNot = $objUsu->maxId('notificacion', 'idnotificacion', $conexion);
//                                        
//                    $objNot->setPropiedades($codNot, $_REQUEST['con'], $fecha, 'ASIGNADA', $_SESSION['id'], $codigoPer, $_REQUEST['idFis']);
//                    
//                    if($objNot->ingresar($conexion)){
//                        $res = 1;
//                    }else{
//                        $res = 2;
//                    }
//                }else{
//                    $res = 3;
//                }
//                break;
//            case 'modificarNot':
//                $cedula = '';
//                $rif = '';
//                if(ctype_alpha($_REQUEST['docTit'][0])){
//                    $rif = $_REQUEST['docTit'];
//                }else{
//                    $cedula = $_REQUEST['docTit'];
//                }
//                
//                if($_REQUEST['idPer'] == ''){
//                    $correo = '';
//                    $telefono = '';
//                    $tipoPer = 'titular';
//                    $codigoPer = $objUsu->maxId('persona', 'idpersona', $conexion);
//                    $objPer->setPropiedades($codigoPer, $cedula, $rif, $correo, $telefono, $_REQUEST['nomTit'], $_REQUEST['apeTit'], $tipoPer);
//                    if($objPer->ingresar($conexion)){
//                        $w = TRUE;
//                    }else{
//                        $w = FALSE;
//                    }
//                }else{
//                    $codigoPer = $_REQUEST['idPer'];
//                    $w = TRUE;
//                }
//                
//                if($w){
//                    $fecha = date('Y-m-d');
//                    $sql = "UPDATE notificacion SET descripcionnoti='".strtoupper($_REQUEST['con'])."', fechanoti='".$fecha."', idusuario='".$_SESSION['id']."', idpersona='".$codigoPer."', idfiscal='".$_REQUEST['idFis']."' WHERE idnotificacion='".$_REQUEST['cod']."'";
//                    
//                    $objNot->modificar($sql, $conexion);
//                    $res = 1;
//                }else{
//                    $res = 2;
//                }
//                break;
//            case 'eliminarNot':
//                if($_REQUEST['param'] != ''){
//                    $ids = explode(',', $_REQUEST['param']);
//                    for($i = 0;$i < count($ids); $i++){
//                        $sql = "DELETE FROM notificacion WHERE idnotificacion='".$ids[$i]."'";
//                        $objNot->modificar($sql, $conexion);
//                    }
//                    $res = 1;
//                }else{
//                    $res = 0;
//                }     
//                break;
//            case 'buscarFis':
//                $sql = "SELECT * FROM persona WHERE cedulaper='".$_REQUEST['ced']."' AND tipoper='FISCAL'";
//                if($objPer->buscar($sql, $conexion)){
//                    $res = $conexion->devolver_recordset();
//                }else{
//                    $res =0;
//                }
//                break;
//            case 'guardarFis':
//                
//                $codigo = $objUsu->maxId('persona', 'idpersona', $conexion);
//                
//                $objPer->setPropiedades($codigo, $_REQUEST['ced'], '', '', '', $_REQUEST['nom'], $_REQUEST['ape'], 'FISCAL');
//                
//                if($objPer->ingresar($conexion)){
//                    $res = 1;
//                }else{
//                    $res = 2;
//                }
//               
//                break;
//            case 'modificarFis':
//                $sql = "SELECT * FROM persona WHERE idpersona='".$_REQUEST['idfis']."'";
//                if($objPer->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $cedOld = $fila['cedulaper'];
//                    if($cedOld != $_REQUEST['ced']){
//                        $sql = "SELECT * FROM persona WHERE cedulaper = '".$_REQUEST['ced']."'";
//                        if($objPer->buscar($sql, $conexion)){
//                            $res = 3;//PERSONA ENCONTRADA CON UNA MISMA CEDULA
//                            $w = FALSE;
//                        }else{                         
//                            $w = TRUE;
//                        }
//                    }else{
//                        $w = TRUE;
//                    }
//                    if($w){
//                        $sql = "UPDATE persona SET cedulaper='".$_REQUEST['ced']."',nombreper='".strtoupper($_REQUEST['nom'])."',apellidoper='".strtoupper($_REQUEST['ape'])."' WHERE idpersona = '".$_REQUEST['idfis']."'";
//                        if(!$objPer->modificar($sql, $conexion)){
//                            $res = 4;//MODIFICADO CON EXITO
//                        }else{
//                            $res = 5;//HUBO UN ERROR
//                        }
//                    }
//                }else{
//                    $res = 6;//no se encontro ningun registro con el id
//                }
//                break;
//            case 'buscarTodosFis':
//                if($objPer->buscar("SELECT * FROM persona WHERE tipoper='FISCAL' ORDER BY nombreper,apellidoper DESC", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }          
//                break;
//            case 'buscarFisLe':
//                if($objPer->buscar("SELECT * FROM persona WHERE tipoper='FISCAL' and nombreper LIKE '".strtoupper($_REQUEST['letras'])."%' ORDER BY nombreper,apellidoper", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarFisxCed':
//                if($objPer->buscar("SELECT * FROM persona WHERE tipoper='FISCAL' and cedulaper='".$_REQUEST['ced']."' ORDER BY nombreper,apellidoper", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'eliminarFis':
//                if($_REQUEST['param'] != ''){
//                    $ids = explode(',', $_REQUEST['param']);
//                    $n = '';
//                    foreach ($ids as $val){
//                        $sql = "SELECT * FROM notificacion WHERE idfiscal='".$val."'";
//                        if(!$objNot->buscar($sql, $conexion)){
//                            if($n == ''){
//                                $n = $val;
//                            }else{
//                                $n = $n.':'.$val;
//                            }
//                        }
//                    }
//                    $ids = explode(':', $n);
//                    for($i = 0;$i < count($ids); $i++){
//                        $sql = "DELETE FROM persona WHERE idpersona='".$ids[$i]."'";
//                        $objCor->modificar($sql, $conexion);
//                    }
//                    $res = 1;
//                }else{
//                    $res = 0;
//                }               
//                break;
//            case 'buscarTodosNot':
//                if($objNot->buscar("SELECT * FROM notificacion ORDER BY fechanoti DESC", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idfiscal']."'", $conexion);
//                            $res[$i]['f'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxFisNot':
//                if($objNot->buscar("SELECT * FROM notificacion WHERE idfiscal='".$_REQUEST['fis']."' ORDER BY fechanoti" , $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idfiscal']."'", $conexion);
//                            $res[$i]['f'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxFechNot':
//                if($objNot->buscar("SELECT * FROM notificacion WHERE fechanoti BETWEEN '".$_REQUEST['fe1']."' AND '".$_REQUEST['fe2']."' ORDER BY fechanoti", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idfiscal']."'", $conexion);
//                            $res[$i]['f'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxEstNot':
//                if($objNot->buscar("SELECT * FROM notificacion WHERE estadonoti='".$_REQUEST['est']."' ORDER BY fechanoti", $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idfiscal']."'", $conexion);
//                            $res[$i]['f'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'modNotificacion':
//                $noti = explode('-', $_REQUEST['ids']);
////                print_r($noti);
//                $e = 0;
//                foreach ($noti as $detalle) {
//                    list($cod,$val) = explode('/', $detalle);
//                    $sql = "UPDATE notificacion SET estadonoti='".$val."' WHERE idnotificacion='".$cod."'";
//                    if(!$objNot->modificar($sql, $conexion)){
//                        ++$e;
//                    }
//                }
//                if($e == count($noti)){
//                    $res = 1;
//                }else{
//                    $res = 0;
//                }
////                $res = $e.'  '.count($noti);
//                break;
//            case 'buscarxOperViv':
//                $sql = "SELECT * FROM usuario WHERE cedulausu='".$_REQUEST['ced']."'";
//                if($objUsu->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM vivienda WHERE idusuario='".$fila['idusuario']."' ORDER BY fechavivienda";
//                    if($objViv->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0;$i < count($res);$i++){
//                                $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                                $res[$i]['c'] = $conexion->devolver_recordset();
//                                $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                                $res[$i]['p'] = $conexion->devolver_recordset();
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxFechV':
//                $sql = "SELECT * FROM vivienda WHERE fechavivienda BETWEEN '".$_REQUEST['fe1']."' AND '".$_REQUEST['fe2']."' ORDER BY fechavivienda";
//                if($objViv->buscar($sql, $conexion)){
//                    if($conexion->registros > 0){
//                        $i = 0;
//                        do{
//                            $res[$i] = $conexion->devolver_recordset();
//                            $i++;
//                        }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        for($i = 0;$i < count($res);$i++){
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                            $res[$i]['c'] = $conexion->devolver_recordset();
//                            $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                            $res[$i]['p'] = $conexion->devolver_recordset();
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxOperTie':
//                $sql = "SELECT * FROM usuario WHERE cedulausu='".$_REQUEST['ced']."'";
//                if($objUsu->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM tierra WHERE idusuario='".$fila['idusuario']."' ORDER BY fectierra";
//                    if($objTie->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0;$i < count($res);$i++){
//                                $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['per_idpersona']."'", $conexion);
//                                $res[$i]['c'] = $conexion->devolver_recordset();
//                                $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                                $res[$i]['p'] = $conexion->devolver_recordset();
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'buscarxOperCon':
//                $sql = "SELECT * FROM usuario WHERE cedulausu='".$_REQUEST['ced']."'";
//                if($objUsu->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM consulta WHERE idusuario='".$fila['idusuario']."' ORDER BY fecconsulta";
//                    if($objCon->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0;$i < count($res);$i++){
//                                $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idpersona']."'", $conexion);
//                                $res[$i]['p'] = $conexion->devolver_recordset();
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }                
//                break;
//            case 'buscarxOperNot':
//                $sql = "SELECT * FROM usuario WHERE cedulausu='".$_REQUEST['ced']."'";
//                if($objUsu->buscar($sql, $conexion)){
//                    $fila = $conexion->devolver_recordset();
//                    $sql = "SELECT * FROM notificacion WHERE idusuario='".$fila['idusuario']."' ORDER BY fechanoti";
//                    if($objNot->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $i = 0;
//                            do{
//                                $res[$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            for($i = 0;$i < count($res);$i++){
//                                $objPer->buscar("SELECT * FROM persona WHERE idpersona='".$res[$i]['idfiscal']."'", $conexion);
//                            $res[$i]['f'] = $conexion->devolver_recordset();
//                            }
//                        }else{
//                            $res = 0;
//                        }
//                    }else{
//                        $res = 0;
//                    }
//                }else{
//                    $res = 0;
//                }       
//                break;
//            case 'modViv':
//                if($_REQUEST['cod'] != ''){
//                    $sql = "SELECT * FROM vivienda WHERE idvivienda='".$_REQUEST['cod']."'";
//                    if($objCor->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $res['vi'] = $conexion->devolver_recordset();
//                            $sql = "SELECT * FROM persona WHERE idpersona = '".$res['vi']['idpersona']."'";
//                            $objCor->buscar($sql, $conexion);
//                            $res['pe'] = $conexion->devolver_recordset();
//                            if($res['vi']['per_idpersona'] != 0){
//                                $sql = "SELECT * FROM persona WHERE idpersona = '".$res['vi']['per_idpersona']."'";
//                                $objCor->buscar($sql, $conexion);
//                                $res['co'] = $conexion->devolver_recordset();
//                            }else{
//                                $res['co'] = 0;
//                            }
////                            $o = strlen($res['vi']['idparroquia']);
//                            if(strlen($res['vi']['idparroquia']) == 7){
//                                $idmun = substr($res['vi']['idparroquia'], 0, 4);
//                            }else{
//                                $idmun = substr($res['vi']['idparroquia'], 0, 5);
//                            }
//                            $sql = "SELECT * FROM parroquia WHERE idmunicipio = '".$idmun."'";
//                            $objCor->buscar($sql, $conexion);
//                            $i = 0;
//                            do{
//                                $res['pa'][$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            
//                            $sql = "SELECT * FROM municipio WHERE idestado = '19'";
//                            $objCor->buscar($sql, $conexion);
//                            $i = 0;
//                            do{
//                                $res['mu'][$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            
//                        }else{
//                            $res = 0;
//                        }
//                    }
//                }else{
//                    $res = 0;
//                }
////                print_r($res);
//                break;
//            case 'modTie':
//                if($_REQUEST['cod'] != ''){
//                    $sql = "SELECT * FROM tierra WHERE idtierra='".$_REQUEST['cod']."'";
//                    if($objTie->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $res['tie'] = $conexion->devolver_recordset();
//                            $sql = "SELECT * FROM persona WHERE idpersona = '".$res['tie']['idpersona']."'";
//                            $objCor->buscar($sql, $conexion);
//                            $res['pe'] = $conexion->devolver_recordset();
//                            if($res['tie']['per_idpersona'] != 0){
//                                $sql = "SELECT * FROM persona WHERE idpersona = '".$res['tie']['per_idpersona']."'";
//                                $objCor->buscar($sql, $conexion);
//                                $res['co'] = $conexion->devolver_recordset();
//                            }else{
//                                $res['co'] = 0;
//                            }
//                            if(strlen($res['tie']['idparroquia']) == 7){
//                                $idmun = substr($res['tie']['idparroquia'], 0, 4);
//                            }else{
//                                $idmun = substr($res['tie']['idparroquia'], 0, 5);
//                            }
//                            $sql = "SELECT * FROM parroquia WHERE idmunicipio = '".$idmun."'";
//                            $objCor->buscar($sql, $conexion);
//                            $i = 0;
//                            do{
//                                $res['pa'][$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                            
//                            $sql = "SELECT * FROM municipio WHERE idestado = '19'";
//                            $objCor->buscar($sql, $conexion);
//                            $i = 0;
//                            do{
//                                $res['mu'][$i] = $conexion->devolver_recordset();
//                                $i++;
//                            }while(($conexion->siguiente()) && ($i != $conexion->registros));
//                        }else{
//                            $res = 0;
//                        }
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'modCon':
//                if($_REQUEST['cod'] != ''){
//                    $sql = "SELECT * FROM consulta WHERE idconsulta='".$_REQUEST['cod']."'";
//                    if($objCon->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $res['con'] = $conexion->devolver_recordset();
//                            $sql = "SELECT * FROM persona WHERE idpersona = '".$res['con']['idpersona']."'";
//                            $objCon->buscar($sql, $conexion);
//                            $res['pe'] = $conexion->devolver_recordset();
//                        }else{
//                            $res = 0;
//                        }
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
//            case 'modNot':
//                if($_REQUEST['cod'] != ''){
//                    $sql = "SELECT * FROM notificacion WHERE idnotificacion='".$_REQUEST['cod']."'";
//                    if($objNot->buscar($sql, $conexion)){
//                        if($conexion->registros > 0){
//                            $res['not'] = $conexion->devolver_recordset();
//                            $sql = "SELECT * FROM persona WHERE idpersona = '".$res['not']['idpersona']."'";
//                            $objCon->buscar($sql, $conexion);
//                            $res['pe'] = $conexion->devolver_recordset();
//                        }else{
//                            $res = 0;
//                        }
//                    }
//                }else{
//                    $res = 0;
//                }
//                break;
    }
//    print_r($res);
    $json = new Services_JSON();
    $resp = $json->encode($res);
    
    echo html_entity_decode($resp,ENT_QUOTES,'UTF-8');