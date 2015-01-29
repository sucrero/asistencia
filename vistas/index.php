<?php
    session_start();
    if(!isset($_SESSION['login'])){
        $_SESSION['denegado'] = TRUE;
        echo '<SCRIPT LANGUAGE=javascript>location.href="inicio.php"</SCRIPT>';
    }
    
?>
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
    <!--<link href="../css/bootstrap-responsive.css" rel="stylesheet">-->
    <link href="../css/datepicker.css" rel="stylesheet">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
    <script async src="../js/principal.js"></script>
    <script async src="../js/jsUsuario.js"></script>
    <script async src="../js/jsPersonal.js"></script>
    <script async src="../js/jsFestivo.js"></script>
    <script async src="../js/jsHorario.js"></script>
    <script async src="../js/jsPermiso.js"></script>
    <script async src="../js/AjaxRequest.js"></script>
    <script async src="../js/ajax.js"></script>
    <script async src="../js/ajax-dynamic-content.js"></script>
    <script async src="../js/x.js"></script>
    <script async src="../js/manipularDom.js"></script>
    
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
            <img src="../img/cintillo_nacional.jpg" alt="cintilloizq">
        </div>
        <div class="span3" align="right">
            <img src="../img/logo_rigth.jpg" alt="cintilloder">
        </div>
    </div>
      
    <div class="container-fluid">
        <div id="sidebar">
            <div class="row-fluid">
                <div class="span4">
                    <?php
                        include_once("../menu/menu.php");
                    ?>
                </div><!--/span-->
                <div class="span6" id="contenedor">

                </div>
            <div class="span2"></div>
          </div><!--/row-->
      </div>
      <input id="idusu" hidden>
      <hr>
      <footer>
        <p><?php include 'pie.html'; ?></p>
      </footer>
      <script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript" src="../js/bootstrap.js"></script>
      <script type="text/javascript" src="../js/bootstrap-modal.js"></script>
      <script type="text/javascript" src="../js/bootstrap-tab.js"></script>
      <script src="../js/bootstrap-datepicker.js"></script>
      <script src="../js/bootstrap-datetimepicker.min.js"></script>
      <script type="text/javascript" src="../js/bootstrap-tooltip.js"></script>
      <script type="text/javascript" src="../js/bootstrap-confirmation.js"></script>
      
    </div><!--/.fluid-container-->
    
  </body>
</html>