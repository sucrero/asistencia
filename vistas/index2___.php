<?php
//	session_start();
//        include_once '../conexion/conexion.php';
//        include_once '../clases/Usuario.php';
//        include_once '../clases/Comunidad.php';
//        include_once '../clases/Noticia.php';
//        include_once '../clases/Pnf.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ES">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--<meta content="text/html; charset=iso-8859-1" http-equiv=Content-Type> -->
        <link rel="stylesheet" type="text/css" href="../css/menu.css" >
        <link rel="stylesheet" type="text/css" href="../css/principal.css" >
        <script type="text/javascript" src="../js/principal.js"></script>
        <script type="text/javascript" src="../js/ajax.js"></script>
        <script type="text/javascript" src="../js/manipularDom.js"></script>
        <script type="text/javascript" src="../js/x.js"></script>
        <script type="text/javascript" src="../js/sha1.js"></script>
        <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ARCHIVOS CALENDARIO -->
        <script type="text/javascript" src="../js/jscalendar/calendar.js"></script>
        <script type="text/javascript" src="../js/jscalendar/lang/calendar-es.js"></script>
        <script type="text/javascript" src="../js/jscalendar/calendar-setup.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="../js/jscalendar/calendar-blue.css" />
        <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: FIN ARCHIVOS CALENDARIO -->
        <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ARCHIVOS LLER NOTICIA -->
        <script type="text/javascript" src="../js/greybox/AJS.js"></script>
        <script type="text/javascript" src="../js/greybox/AJS_fx.js"></script>
        <script type="text/javascript" src="../js/greybox/gb_scripts.js"></script>
        <link href="../js/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
        <!-- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: FIN ARCHIVOS LEER NOTICIA-->
        
                
	  	 
    <title>::: Inicio :::</title>
    </head>
    <body>
<div align="center">
    <table align="center" width="100%" height="53" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                    <td  width="68%" height="50"><img src="../img/cintillo.jpg" alt="cintillo"></td>
                    <td width="22%" height="50" align="right"><img src="../img/logo_rigth.jpg" alt="corazon"></td>
                </tr>
                <tr>
                    <td colspan="2" height="5" bgcolor="#ed1427"></td>
                </tr>
            </table>
    </div>
        <table border="0px" width="100%">
            <tr>
                <td colspan="2" height="100px">
                    <table width="100%" border="0px" cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td width="100%" align="left"><?php require 'banner.html'; ?></td>
                        </tr>
                        <tr>
                        	<td colspan="1" align="center">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="400px" width="15%" valign="top">
                     <?php
                     
                         echo '<div id="fecha" align="center">';
                           setlocale(LC_TIME, "es_ES");
                           echo "<b>Cuman&aacute;&sbquo; ".strftime("%d de %B de %Y")."</b>";
                        echo '</div>';
                    include '../menu/menu.php'; 
                    ?>
                </td>
                <td width="85%" style="vertical-align:top">
                <!-- CUERPO -->
                <table width="100%" border="0px" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td align="center" width="100%"></td>
                        </tr>
                        
                    </table>
                    
                    
                <?php
                    $objUsuario = new Usuario();
                    $res = $objUsuario->buscar("SELECT * FROM usuario WHERE idusuario!='0'", $acceso);
                    if($res > 0){
                            echo'<table border="0px" width="100%" cellpadding="0" cellspacing="0"  height="100%">
                                    <tr>
                                            <td width="10%">&nbsp;</td>
                                            <td width="70%" align="center" valign="top">
                                                    <table border="0px" cellpadding="0" cellspacing="0" width="100%" height="100%">
                                                            <tr>
                                                                    <td width="100%">';
                                                            $objNoticia= new Noticia();
                                                            $consulta=$objNoticia->buscar("select * from noticia ORDER BY fechapubli,titularnoticia",$acceso);
                                                            $v = 0;
                                                            if ($acceso)
                                                            {
                                                                    if ($consulta)	
                                                                    {
                                                                            if($acceso->registros>0)
                                                                            {
                                                                                    echo'<marquee direction="up" scrollamount=2 scrolldelay=0 onmouseout=this.start() onmouseover=this.stop()>';
                                                                                    do{
                                                                                            $fila = $acceso->devolver_recordset();
                                                                                            if ($fila['statusnoticia'] == '1')
                                                                                            {
                                                                                                    $v++;
                                                                                                    $texto = $fila['titularnoticia'];
                                                                                                    echo '
                                                                                                                            <font face="Verdana, Arial, Helvetica, sans-serif" size="2px" color="042C66">
                                                                                                                                    <b>&raquo;&nbsp;&nbsp;
                                                                                                                                            '.$texto.'...
                                                                                                                                            <a href="leerNoticia.php?id='.$fila['idnoticia'].'" rel="gb_page_fs[]" title="Descripci&oacute;n de la Noticia">	
                                                                                                                                                  (Leer m&aacute;s)  
                                                                                                                                            </a>
                                                                                                                                    </b>
                                                                                                                            </font><br><br>
                                                                                                                    ';
                                                                                            }
                                                                                                    $i++;
                                                                                    }while(($acceso->siguiente())&&($i!=$acceso->registros));
                                                                                    echo '<br>';
                                                                                    echo '</marquee>';
                                                                                    if ($v == 0)
                                                                                    {
                                                                                            echo'<font face="Verdana, Arial, Helvetica, sans-serif" color=#FF0000 size=3>
                                                                                                            <b>
                                                                                                                    ! No existen Noticias Registradas &iexcl;
                                                                                                            </b>
                                                                                                    </font>';
                                                                                    }
                                                                            }
                                                                    }	
                                                                    else
                                                                    {
                                                                            echo'<font face="Verdana, Arial, Helvetica, sans-serif" color=#FF0000 size=3>
                                                                                            <b>
                                                                                                    ! No existen Noticias Registradas &iexcl;
                                                                                            </b>
                                                                                    </font>';
                                                                    }										 
                                                                }

                                                    echo'	
                                                                    </td>
                                                            </tr>
                                                    </table>
                                        </td>
                                                    <td width="20%" align="left">
                                                        <div align="left"><img src="../img/leyendoNoticia.jpg" alt="noticias"></div></td>
                                    </tr>
                        </table>';
                    }else{
                        echo'<table width="750px" border="0" cellspacing="0" cellpadding="0" align="center" class="bordeyfondogris">                        
                        <tr>
                            <td width="48"px>&nbsp;&nbsp;<img src="../img/agregar_a.png" alt="nuevo" width="32" height="32"></td>
                            <td width="700px"><span class="titulosgrandesAzules">[ Ingrese los Datos del Jefe del PNFI ]</span></td>
                        </tr>
                        <tr>
                            <td class="FondoAzulLetrasBlancaTABLAS" align="center" colspan="2">Datos del Usuario</td>

                        </tr>
                        <tr>
                            <td height="33" colspan="2">
                                <form id="formUsuJefPnf" method="post">
                                    <table width="100%" border="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif">
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
										
                                        <tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>C&Eacute;DULA:</label></td>
                                            <td width="65%" align="left">
                                                <select id="ilstnac" tabindex="10" style="width: 60px" class="mayuscula tooltip" title="Seleccione una nacionalidad">
                                                    <option value="V" selected>V</option>
                                                    <option value="E">E</option>
                                                </select><input id="itxtcedula" onFocus="javascrip:select();" onKeyPress="return numeros(event);" onKeyUp="javascript:valCedula(event);" type="text" tabindex="1" maxlength="8" class="tooltip" title="Ingrese su c&eacute;dula" style="width:240px">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><label><span class="oblig">*</span>NOMBRE:</label></td>
                                            <td align="left"><input id="itxtnombre" onFocus="javascrip:select();" onKeyPress="return letras(event);" type="text" tabindex="2" maxlength="25" style="width:300px" class="mayuscula tooltip" title="Ingrese su nombre" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>APELLIDO:</label></td>
                                            <td width="65%" align="left">
                                                <input id="itxtapellido" onFocus="javascrip:select();" onKeyPress="return letras(event);" type="text" tabindex="3" maxlength="25" style="width:300px" class="mayuscula tooltip" title="Ingrse su apellido" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><label><span class="oblig">*</span>SEXO</label></td>
                                            <td>
                                                <select id="ilstsexo" tabindex="4" style="width: 300px" class="mayuscula tooltip" title="Selecciona el sexo" disabled>
                                                    <option value="-1" selected>SELECCIONE...</option>
                                                    <option value="F">FEMENINO</option>
                                                    <option value="M">MASCULINO</option>
                                                </select></td>
                                          </tr>
                                          <tr>
                                            <td align="right"><label><span class="oblig">*</span>FECHA DE NACIMIENTO</label></td>
                                            <td align="left"><input onChange="" id="idtxtfechaN" onFocus="javascrip:select();" type="text" maxlength="8" style="width:300px" readonly disabled>&nbsp;<input type="button" name="btncalenda" id="btncalenda" value="..." tabindex="5" class="tooltip" title="Click para inhresar su fecha de nacimiento" style="width:30px;" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><label><span class="oblig">*</span>TEL&Eacute;FONO:</label></td>
                                            <td align="left"><input id="itxttelf" onFocus="javascrip:select();" onKeyPress="return numeros(event);" type="text" tabindex="6" maxlength="11" style="width:300px" class="tooltip" title="Ingrese un n&uacute;mero de tel&eacute;fono" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>COMUNIDAD:</label></td>
                                            <td width="65%" align="left">';
                                                $objComuni = new Comunidad();
                                                $consulta = $objComuni->buscar("select * from comunidad", $acceso);
                                                   if($acceso)
                                                    {
                                                        if($consulta){
                                                            if($acceso->registros > 0){
                                                                echo'<select id="ilstComuni" tabindex="9" style="width: 300px" class="mayuscula tooltip" title="Seleccione una comunidad" disabled>';
                                                                echo '<option value="-1">Seleccione...</option>';
                                                                $i=0;
                                                                do{
                                                                        $fila = $acceso->devolver_recordset();
                                                                        echo '<option value="'.$fila['idcomuni'].'">'.strtoupper($fila['nomcomuni']).'</option>';
                                                                        $i++;
                                                                }while(($acceso->siguiente())&&($i!=$acceso->registros));
                                                                echo'</select>';
                                                            }else{
                                                                echo'<select id="ilstComuni" disabled style="width: 300px">';
                                                                echo '<option value="-1">No se encontraron registros...</option></select>';
                                                            }
                                                        }else{
                                                            echo'<select id="ilstComuni" disabled style="width: 300px">';
                                                            echo '<option value="-1">No se encontraron registros...</option></select>';
                                                        }
                                                    }
                                            echo '</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>DIRECCI&Oacute;N:</label></td>
                                            <td width="65%" align="left">
                                                <input id="itxtdireccion" onFocus="javascrip:select();" onKeyPress="" type="text" tabindex="10" maxlength="50" style="width:300px" class="mayuscula tooltip" title="Ingrese una direcci&oacute;n" disabled>
                                            </td>
                                        </tr>
										<tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>CORREO ELECTR&Oacute;NICO:</label></td>
                                            <td width="65%" align="left">
                                                <input id="itxtemail" onFocus="javascrip:select();" type="text" tabindex="13" maxlength="50" style="width:300px" class="mayuscula tooltip" title="Ingrese un correo electr&oacute;nico<br><b>Ejem. sucorreo@dominio.com</b>" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><hr color="#CCCCCC"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><label><span class="oblig">*</span>GRADO DE INSTRUCCI&Oacute;N:</label></td>
                                            <td align="left"><input id="itxtinstruccion" onFocus="javascrip:select();" onKeyPress="return letras(event);" type="text" tabindex="7" maxlength="25" style="width:300px" class="mayuscula tooltip" title="Ïngrese su nivel d einstrucci&oacute;n" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>PROFESI&Oacute;N:</label></td>
                                            <td width="65%" align="left">
                                                <input id="itxtprofesion" onFocus="javascrip:select();" onKeyPress="return letras(event);" type="text" tabindex="8" maxlength="25" style="width:300px" class="mayuscula tooltip" title="Ingrese una profesi&oacute;n" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>PNF:</label></td>
                                            <td width="65%" align="left">';
                                               $objPnf = new Pnf();
                                                $consulta = $objPnf->buscar("select * from pnf", $acceso);
                                                   if($acceso)
                                                    {
                                                        if($consulta){
                                                            if($acceso->registros > 0){
                                                                echo'<select id="ilstPnf" tabindex="11" style="width: 300px" class="mayuscula tooltip" title="Seleccione un PNF" disabled>';
                                                                echo '<option value="-1">Seleccione...</option>';
                                                                $i=0;
                                                                do{
                                                                        $fila = $acceso->devolver_recordset();
                                                                        echo '<option value="'.$fila['idpnf'].'">'.strtoupper($fila['descripcionpnf']).'</option>';
                                                                        $i++;
                                                                }while(($acceso->siguiente())&&($i!=$acceso->registros));
                                                                echo'</select>';
                                                            }else{
                                                                echo'<select id="ilstPnf" disabled style="width: 300px">';
                                                                echo '<option value="-1">No se encontraron registros...</option></select>';
                                                            }
                                                        }else{
                                                            echo'<select id="ilstPnf" disabled style="width: 300px">';
                                                            echo '<option value="-1">No se encontraron registros...</option></select>';
                                                        }
                                                    }
                                            echo '</td>
                                        </tr>
                                        <tr>
                                            <td align="right"><label><span class="oblig">*</span>FECHA INICIO:</label></td>
                                            <td align="left"><input onChange="" id="idtxtfechaIni" onFocus="javascrip:select();" type="text" maxlength="8" style="width:300px" readonly disabled>&nbsp;<input type="button" name="btncalendaIni" id="btncalendaIni" value="..." class="tootip" title="Ingrese un fecha de inicio" tabindex="12" style="width:30px;" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><label><span class="oblig">*</span>FECHA FIN</label></td>
                                            <td align="left"><input onChange="" id="idtxtfechaFin" onFocus="javascrip:select();" type="text" maxlength="8" style="width:300px" readonly disabled>&nbsp;<input type="button" name="btncalendaFin" id="btncalendaFin" value="..." class="tootip" title="Ingrese una fecha de fin" tabindex="13" style="width:30px;" disabled>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td colspan="2"><hr color="#CCCCCC"></td>
                                        </tr>
                                        <tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>LOGIN:</label></td>
                                            <td width="65%" align="left">
                                                <input id="itxtlogin" onFocus="javascrip:select();"  onBlur="javascript:valLogin();" type="text" tabindex="14" maxlength="25" style="width:300px" class="tootip" title="Ingrese un login" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="35%" align="right"><label><span class="oblig">*</span>CLAVE:</label></td>
                                            <td width="65%" align="left">
                                                <input id="itxtclave" onFocus="javascrip:select();" onKeyPress="" type="password" tabindex="15" maxlength="25" style="width:300px" disabled>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="230" border="0" cellpadding="0" cellspacing="0" align="center">
                                      <tr>
                                            <td colspan="2" align="center"><span class="oblig">* Campos requeridos</span></td>
                                        </tr>
                                       
                                        <tr>
                                            <td align="center">
                                                    <a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'guardar\',\'\',\'../img/aplicar_a.png\',1)">
                                                        <img src="../img/aplicar_i.png" alt="guardar" name="guardar" width="32" height="32" border="0" onClick="valForm(\'formUsuJefPnf\',\'guardarUsuJefPnf()\');" title="Guardar">
                                                    </a>
                                          </td>
                                            <td align="center">
                                                    <a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'cancelar\',\'\',\'../img/cancelar_a.png\',1)">
                                                            <img src="../img/cancelar_i.png" alt="cancelar" name="cancelar" width="32" height="32" border="0" title="Limpiar" onClick="limpiar();">
                                                    </a>
                                            </td>

                                        </tr>
                                       
                                    </table>
                                </form>
                                
                            </td>
                      </tr>
                    </table>
                                <script type="text/javascript">
                                Calendar.setup({inputField : "idtxtfechaN",ifFormat : "%d/%m/%Y",button : "btncalenda"});
    Calendar.setup({inputField : "idtxtfechaIni",ifFormat : "%d/%m/%Y",button : "btncalendaIni"});
    Calendar.setup({inputField : "idtxtfechaFin",ifFormat : "%d/%m/%Y",button : "btncalendaFin"});
</script>';
                    }
                ?>
                    
                <!-- FIN CUERPO -->
                </td>
            </tr>
            <tr>
                <td height="150px" colspan="2" align="center">
                  <?php include 'pie.html'; ?>
                </td>
            </tr>
        </table>
        <script type="text/javascript">
    messageObj = new DHTML_modalMessage();	// We only create one object of this class
    messageObj.setShadowOffset(5);	// Large shadow

    function displayMessage(url,ancho,largo)
    {      
        messageObj.setSource(url);
        //setTimeout(func, 1000); 
        messageObj.setCssClassMessageBox(false);
       // messageObj.setSize(750,330);
		   messageObj.setSize(ancho,largo);
        messageObj.setShadowDivVisible(true);	// Enable shadow for these boxes
        messageObj.display();
    }

    function closeMessage()
    {
        messageObj.close();	
    }
</script>
    <script type="text/javascript" src="../js/menu.js"></script>
</body>
</html>
<?php
    if (isset($_SESSION['denegado'])){
           
        if($_SESSION['denegado']){
            echo '<script>alert ("No tiene suficientes privilegios para ver esa página");</script>';
        }
        unset($_SESSION['denegado']);
    }
?>

