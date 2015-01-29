<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>::: Inicio :::</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <meta name="description" content="">
    <meta name="author" content="">-->

    <!-- Le styles -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
    <script src="../js/jsUsuario.js"></script>
    <script src="../js/jsAsistencia.js"></script>
    <script src="../js/AjaxRequest.js"></script>
    <script src="../js/ajax.js"></script>
    <script src="../js/ajax-dynamic-content.js"></script>
    <script src="../js/x.js"></script>
    <script src="../js/manipularDom.js"></script>
    <script src="../js/principal.js"></script>
    <style type="text/css">
      body {
        /*padding-top: 60px;*/
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    </head>

  <body>
    <div class="row-fluid navbar" style="background: #ffffff">
        <div class="span9" align="left">
            <img src="../img/cintillo.jpg" alt="cintilloizq">
        </div>
        <div class="span3" align="right">
            <img src="../img/logo_rigth.jpg" alt="cintilloder">
        </div>
            <img src="../img/banner.jpg" alt="banner" width="100%">
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="container-fluid" id="contenedor">
                    <div class="span4 offset4">
                        <form id="asistencia" class="well">
                            <fieldset>
                                <div id="contmsj"></div>
                                <legend style="text-align: center;">Registre su N&uacute;mero de C&eacute;dula</legend>
                                <input type="text" name="Cedula" onkeyup="accionAsisReg(event)" class="input-xlarge offset2" id="itxtcedreg" placeholder="Ingrese su usuario" autofocus autocomplete="off">
                            </fieldset>
                            <div class="form-actions" style="text-align: center;">
                                <a class="btn btn-primary btn-large" id="guardar" onclick="registrar();">
                                        Registrar
                                </a>
                            </div>
                        </form>
                    </div>
            </div><!--/span-->
        </div><!--/row-->
      <footer>
        <p><?php include 'pie.html'; ?></p>
      </footer>
      <script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript" src="../js/bootstrap.js"></script>
    </div><!--/.fluid-container-->
   
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