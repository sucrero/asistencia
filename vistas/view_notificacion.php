<form class="well form-inline" id="formNotificacion" role="form">
    <fieldset>
        <legend>Notificaciones Registradas
            <div class="pull-right">
                <a class="btn btn-primary" href="index.php">
                    <i class="icon-home icon-white"></i>
                        Inicio
                </a>
            </div>
        </legend>
                
        <legend><h1><small><b>Datos de la Notificaci&oacute;n</b></small></h1></legend>
                    
        <div class="span12 control-group">
            <label for="itxtnrodocumento">R.I.F. &oacute; C.I.</label>
            <div class="input-append controls">
                <input id="itxtnrodocumento" name="R.I.F.  &oacute;  C.I." onkeyup="accionPerNot(event,'TITULAR');" placeholder="Ingrese el R.I.F. &oacute; C.I."  size="75px" type="text" maxlength="10" autofocus>
                <a class="btn btn-primary" id="btnbuscarper" onclick="buscarPerNot('TITULAR');">
                    <i class="icon-search icon-white"></i>
                </a>
            </div>
            <p class="help-block ejemplo">Indique el Número de CI o RIF, sin guiones, ni puntos. En caso de RIF debe completar un máximo de 10 caracteres. Ejemplo de la Cédula: 12345678, Ejemplo del RIF: V123456789.</p>
        </div>
                    
        <div class="span12 control-group">
            <div class="span6">
                <label for="itxtnombre">Nombres</label>
                <input type="text" class="span7 disabled" disabled="" placeholder="Ingrese un nombre" id="itxtnombre" name="Nombres" onKeyPress="return letras(event);">
            </div>
            <div class="span6">
                <label for="itxtapellido">Apellidos</label>
                <input type="text" class="span7 disabled" disabled="" placeholder="Ingrese un apellido" id="itxtapellido" name="Apellidos" onKeyPress="return letras(event);">
            </div>
        </div>
                    
        <legend><h1><small><b>Detalle de la Notificaci&oacute;n</b></small></h1></legend>

        <div class="control-group">
            <div class="row">
                <div class="span11 offset1">
                    <label for="itxtnotificacion">Descripci&oacute;n de la Notificaci&oacute;n</label><br>
                    <textarea class="input-xxlarge" rows="3" id="itxtnotificacion" placeholder="Ingrese la descripci&oacute;n de la notificaci&oacute;n" name="Descripci&oacute;n"></textarea>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="span11 offset1">
                <label class="control-label" for="lstfiscal">Fiscal Asignado</label>
                <?php
                    include_once '../conexion/conexion.php';
                    include_once '../clases/Persona.php';
                    $objPer = new Persona();
                    $consulta =  $objPer->buscar("SELECT * FROM persona WHERE tipoper='FISCAL'", $conexion);
                    if($conexion)
                    {
                        if($consulta){
                           if($conexion->registros > 0){
                              echo'<select id="ilstfiscal" class="span8" name="Fiscal">';
                              echo '<option value="-1">Seleccione...</option>';
                              do{
                                 $fila = $conexion->devolver_recordset();
                                 echo '<option value="'.$fila['idpersona'].'">'.htmlentities(strtoupper($fila['nombreper'].' '.$fila['apellidoper']),ENT_QUOTES,'UTF-8').'</option>';
                                 $i++;
                              }while(($conexion->siguiente())&&($i!=$conexion->registros));

                           }else{
                               echo'<select id="ilstfiscal" disabled class="span8">';
                               echo '<option value="-1">No se encontraron registros...</option>';
                           }
                        }else{
                            echo'<select id="ilstfiscal" disabled class="span8">';
                            echo '<option value="-1">No se encontraron registros...</option>';
                        }
                        echo'</select>';
                    }
                ?>
                </div>
            </div>
        </div>

        <div id="contmsj"></div>

            <div class="form-actions">
                <a class="btn btn-primary" id="guardar" onclick="valForm('formNotificacion','guardarNot(\'g\')');">
                    <i class="icon-ok-sign icon-white"></i>
                        Guardar
                </a>
                <a id="openBtn" class="btn btn-primary"  onclick="cargarTodosNot();">
                    <i class="icon-eye-open icon-white"></i>
                        Mostrar
                </a>
                <a class="btn btn-primary" id="limpiar" onclick="limpiarFormNot();">
                    <i class="icon-trash icon-white"></i>
                        Limpiar
                </a>
            </div>
                    
    </fieldset>
</form>

               <!--COMIENZO MENSAJE MODAL-->
<!--       <div id="myModal" class="modal hide fade" style="display: none; width: 70%; left: 40%">
            <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Notificaciones Registradas</h3>
            </div>
            <div class="modal-body">
                <ul id="tab" class="nav nav-tabs">
                    <li class="">
                        <a>B&uacute;squeda por: </a>
                    </li>
                    <li class="active">
                        <a href="#contribuyente" data-toggle="tab">Contribuyente</a>
                    </li>
                    <li class="">
                        <a href="#fecha" data-toggle="tab">Fecha</a>
                    </li>
                    <li class="">
                        <a href="#palabra" data-toggle="tab">Palabra</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="contribuyente">
                        <form class="form-horizontal" id="formBusNotDocCont">
                            <fieldset>
                                <div class="offset4 span4">
                                    <input type="text" name="Documento Contribuyente" id="itxtdoccont" class="span10 search-query" placeholder="Ingrese el R.I.F. &oacute; C.I.">
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal1"></div>
                            <a class="btn btn-primary" id="guardar" onclick="buscarxContNot();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabNot(1);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fecha">
                        <form class="form-inline" id="formBusNotFec">
                            <fieldset>
                                <div class="offset2 span3">
                                    <label class="control-label" for="dp1">Desde:</label>
                                    <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="dp1"/>
                                </div>
                                <div class="offset2 span3">
                                    <label class="control-label" for="dp2">Hasta:</label>
                                    <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="dp2"/>
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal2"></div>
                            <a class="btn btn-primary" id="guardar" onclick="buscarxFechNot();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabNot(2);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="palabra">
                        <form class="form-horizontal" id="formBusNotPal">
                            <fieldset>

                                <div class="span12 control-group">
                                    <div class="offset4 span4">
                                        <input type="text" name="Palabra de busqueda" id="itxtpalabrabus" class="span10 search-query" placeholder="Ingrese una palabra a buscar">
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal3"></div>
                            <a class="btn btn-primary" id="guardar" onclick="buscarxPalabraNot();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabNot(3);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table table-hover table-bordered">
                    <thead style="text-align: center;">
                        <tr>
                            <th>Item</th>
                            <th>Contribuyente</th>
                            <th>Descripci&oacute;n</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="contNot"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="eliminarNot">
                    <i class="icon-remove icon-white"></i>
                        Eliminar
                </a>
                <a class="btn btn-primary" id="imprimirNot">
                    <i class="icon-print icon-white"></i>
                        Imprimir
                </a>
                <a href="#" id="cerrar" class="btn" data-dismiss="modal">Cerrar</a>
            </div>
        </div>-->
        <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtnrodocumento').focus();
            $(function(){
                        $('#dp1').datepicker();
                        $('#dp2').datepicker();
            });
                      
            $('a[data-toggle="tab"]').on('shown', function (e) {
                $("#contmsjmodal1").empty();
                $("#contmsjmodal2").empty();
                $("#contmsjmodal3").empty();
                xGetElementById('itxtdoccont').value = "";
                xGetElementById('dp1').value = fechaActual();
                xGetElementById('dp2').value = fechaActual();
                xGetElementById('itxtpalabrabus').value = "";
                cargarTodosCon();
            })
        </script>
          