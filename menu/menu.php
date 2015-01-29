<script type="text/javascript" src="../js/jquery.min.js.js"></script>
<script type="text/javascript" src="../js/ddaccordion.js">
/***********************************************
* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/
</script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='../img/plus.gif' class='statusicon' />", "<img src='../img/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})


</script>
<style type="text/css">

.glossymenu{
margin: 5px 0;
padding: 0;
width: 170px; /*width of menu*/
border: 1px solid #9A9A9A;
border-bottom-width: 0;
}

.glossymenu a.menuitem{
background: black url(../img/glossyback4.gif) repeat-x bottom left;
font: bold 14px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: white;
display: block;
position: relative; /*To help in the anchoring of the ".statusicon" icon image*/
width: auto;
padding: 4px 0;
padding-left: 10px;
text-decoration: none;
}
a{
    cursor: pointer;
}

.glossymenu a.menuitem:visited, .glossymenu .menuitem:active{
color: white;
}

.glossymenu a.menuitem .statusicon{ /*CSS for icon image that gets dynamically added to headers*/
position: absolute;
top: 5px;
right: 5px;
border: none;
}

.glossymenu a.menuitem:hover{
background-image: url(../img/glossyback2.gif);
}

.glossymenu div.submenu{ /*DIV that contains each sub menu*/
background: white;
}

.glossymenu div.submenu ul{ /*UL of each sub menu*/
list-style-type: none;
margin: 0;
padding: 0;
}

.glossymenu div.submenu ul li{
border-bottom: 1px solid blue;
}

.glossymenu div.submenu ul li a{
display: block;
font: normal 13px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: black;
text-decoration: none;
padding: 2px 0;
padding-left: 10px;
}

.glossymenu div.submenu ul li a:hover{
background: #DFDCCB;
colorz: white;
}
.titlemenu{
    font: normal 14px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
    text-align: center;
    font-weight: bold;
	width: 170px; /*width of menu*/
}

</style>
<?php
setlocale(LC_TIME, "es_ES");
echo "<b>Cuman&aacute;&sbquo; ".strftime("%d de %B de %Y")."</b>";
echo '<br>';
echo '<br><b>Bienvenido:</b> '.$_SESSION['cuenta'];
echo '<br><br>';

    
 

        echo '
        <div class="titlemenu">MEN&Uacute;</div>
        <div class="glossymenu">';
//        if($_SESSION['nivel'] == 'ADMINISTRADOR'){
            echo '<a class="menuitem" onclick="cargar_form(\'usuario\',\'contenedor\')">Usuario</a>';
//        }
        echo '
            <a class="menuitem" onclick="cargar_form(\'cambioclave\',\'contenedor\')">Cambio de Contrase&ntilde;a</a>
            <a class="menuitem" onclick="cargar_form(\'permiso\',\'contenedor\')">Permisos</a>
            <a class="menuitem" onclick="cargar_form(\'festivo\',\'contenedor\')">D&iacute;as Festivos</a>
            <a class="menuitem" onclick="cargar_form(\'horario\',\'contenedor\')">Horario</a>
            <a class="menuitem" onclick="cargar_form(\'personal\',\'contenedor\')">Personal</a>
            <a class="menuitem" onclick="cargar_form(\'repgeneral\',\'contenedor\')">Reporte General</a>
            <a class="menuitem" onclick="ir(\'vistas/logout.php\')" style="border-bottom-width: 0">Cerrar Sesi&oacute;n</a>		
            </div>';
 ?>

<!--<a class="menuitem submenuheader" href="http://www.dynamicdrive.com/style/" >CSS Examples</a>
<div class="submenu">
	<ul>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C1/">Horizontal CSS Menus</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C2/">Vertical CSS Menus</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C4/">Image CSS</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C6/">Form CSS</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C5/">DIVs and containers</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C7/">Links & Buttons</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C8/">Other</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/all/">Browse All</a></li>
	</ul>
</div>
<a class="menuitem" href="http://www.javascriptkit.com/jsref/">JavaScript Reference</a>
<a class="menuitem" href="http://www.javascriptkit.com/domref/">DOM Reference</a>
<a class="menuitem submenuheader" href="http://www.cssdrive.com">CSS Drive</a>
<div class="submenu">
	<ul>
	<li><a href="http://www.cssdrive.com">CSS Gallery</a></li>
	<li><a href="http://www.cssdrive.com/index.php/menudesigns/">Menu Gallery</a></li>
	<li><a href="http://www.cssdrive.com/index.php/news/">Web Design News</a></li>
	<li><a href="http://www.cssdrive.com/index.php/examples/">CSS Examples</a></li>
	<li><a href="http://www.cssdrive.com/index.php/main/csscompressor/">CSS Compressor</a></li>
	</ul>
</div>-->