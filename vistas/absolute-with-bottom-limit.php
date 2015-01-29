<?php
    session_start();
    if(!isset($_SESSION['login'])){
        $_SESSION['denegado'] = TRUE;
        echo '<SCRIPT LANGUAGE=javascript>location.href="inicio.php"</SCRIPT>';
    }
    
?>
<!DOCTYPE html>
<html lang="es">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!--<link href="../css/bootstrap-responsive.css" rel="stylesheet">-->
    <link href="../css/datepicker.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
    <script async src="../js/principal.js"></script>
    <script async src="../js/jsUsuario.js"></script>
    <script async src="../js/jsCorrespondencia.js"></script>
    <script async src="../js/jsVivienda.js"></script>
    <script async src="../js/jsTierra.js"></script>
    <script async src="../js/jsConsulta.js"></script>
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
	<head>
		<title>Portamento Demo</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="author" content="Kris Noble" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- just some default styles, nothing important -->
		<link rel="stylesheet" href="demo.css" />
		
		<!-- the important styles are below... -->
		<style>
			#wrapper {overflow: hidden; position:relative; background-color: #51a351;}
			#content {width:486px; margin-right:10px; min-height:1200px; background-color: #0000FF;}
			#sidebar {width:284px; padding:10px; background: #eee; height:400px; position:absolute; right:250 ; top:0;}
						
			#portamento_container {position:absolute; right: -250; top:0;} /* take the absolute positioning of the sidebar */
			#portamento_container #sidebar {}
			#portamento_container #sidebar.fixed {position:fixed; right:auto; top:auto;} /* become fixed position, but reset the top and right values */
		</style>
		
		<!-- looking for the Portamento JS? It's just before </body> -->
		
		<!--  Google Analytics Asynchronous Tracking Code -->
		
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
		<div>
			<header>
				<h1><a href="http://simianstudios.com/portamento/">Portamento</a> Demo</h1>
			</header>
			
			<div id="contendor">
				<div id="content">
					<p>This shows <a href="http://simianstudios.com/portamento/">Portamento</a> at work in a typical absolutely-positioned layout, with the sliding panel restricted to the confines of its wrapper.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
					<p>Bacon ipsum dolor sit amet do t-bone laborum, ad ground round turkey ball tip. Veniam aliqua jowl, duis in t-bone sint tongue fugiat. Pork loin tenderloin ad, veniam chicken meatloaf.</p>
								
				</div>
				
				<div id="sidebar">
					<?php
                                            include_once("../menu/menu.php");
                                        ?>
				</div>
			</div>

			<footer>
				<p>The sliding panel should stop at the red line.</p>
				<p><small>Demo of <a href="http://simianstudios.com/portamento/">Portamento</a> by Kris Noble 2011. Tasty filler text by <a href="http://baconipsum.com">Bacon Ipsum</a>.</small></p>
			</footer>
		</div>
		
            <script src="../js/jquery.min-1-6-1.js"></script>
            <script src="../js/portamento.js"></script>		
		<script>
			$('#sidebar').portamento({wrapper: $('#contendor')});	// set #wrapper as the visual coundary of the panel
		</script>
		<script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript" src="../js/bootstrap.js"></script>
      <script type="text/javascript" src="../js/bootstrap-modal.js"></script>
      <script type="text/javascript" src="../js/bootstrap-tab.js"></script>
      <script src="../js/bootstrap-datepicker.js"></script>
      <script type="text/javascript" src="../js/bootstrap-tooltip.js"></script>
      <script type="text/javascript" src="../js/bootstrap-confirmation.js"></script>
	</body>
</html>