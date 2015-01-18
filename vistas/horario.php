<form class="well form-inline" id="formHorario">
                <fieldset>
                  <legend>Registro de Horarios
                  <div class="pull-right">
                    <a class="btn btn-danger" href="index.php">
                        <i class="icon-home icon-white"></i>
                            Inicio
                    </a>
                  </div>
                  </legend>
                    <div id="contmsj2"></div>
                    <div class="span12 control-group">
                        <label for="itxtdescrip">Descripci&oacute;n:</label>
                        <div class="input-append controls">
                            <input id="itxtdescrip" name="Descripci&oacu&oacute;n horario" placeholder="Ingrese una descripci&oacute;n" type="text" maxlength="99" autofocus>
                        </div>
                    </div>
                    <!--<legend><h1><small><input type="checkbox" checked="" value="L" id="dia1" name="eli_dia[]"/> Lunes</small></h1></legend>-->
                    <div class="control-group">
                        <div class="row">
                            <div class="span8 offset2">
                                <div class="span3">
                                    <label class="control-label" for="dp1">Ma&ntilde;ana desde:</label>
                                    <div id="datetimepicker1" class="input-append">
                                        <input data-format="hh:mm:ss" id="time1" type="text" class="span8" value="07:00:00" readonly=""></input>
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                </div>
                                <div class="span3">
                                    <label class="control-label" for="dp2">Ma&ntilde;ana hasta:</label>
                                    <div id="datetimepicker2" class="input-append">
                                        <input data-format="hh:mm:ss"  id="time2" type="text" class="span8" value="12:00:00" readonly=""></input>
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                </div>
                                <div class="span3">
                                    <label class="control-label" for="dp1">Tarde desde:</label>
                                    <div id="datetimepicker3" class="input-append">
                                        <input data-format="hh:mm:ss"  id="time3" type="text" class="span8" value="13:00:00" readonly=""></input>
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                </div>
                                <div class="span3">
                                    <label class="control-label" for="dp2">Tarde hasta:</label>
                                    <div id="datetimepicker4" class="input-append">
                                        <input data-format="hh:mm:ss"  id="time4" type="text" class="span8" value="17:00:00" readonly=""></input>
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div id="contmsj"></div>
            
                    <div class="form-actions">
                        <a class="btn btn-danger" id="guardar" onclick="valForm('formHorario','guardarH(\'g\')');">
                            <i class="icon-ok-sign icon-white"></i>
                                Guardar
                        </a>
                        <a id="openBtn" class="btn btn-danger"  onclick="cargarTodosHor();">
                            <i class="icon-eye-open icon-white"></i>
                                Mostrar
                        </a>
                        <a class="btn btn-danger" id="limpiar" onclick="limpiarFormHor();">
                            <i class="icon-trash icon-white"></i>
                                Limpiar
                        </a>
                    </div>
                </fieldset>
              </form>
               <!--COMIENZO MENSAJE MODAL-->
       <div id="myModal" class="modal hide fade" style="display: none; width: 70%; left: 40%">
            <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Horarios Registrados</h3>
            </div>
            <div class="modal-body">
                <hr>
                <table class="table table-hover table-bordered">
                    <thead style="text-align: center;">
                        <tr>
                            <th>Item</th>
                            <th>Descripci&oacute;n</th>
                            <th>Inicio Ma&ntilde;ana</th>
                            <th>Fin Ma&ntilde;ana</th>
                            <th>Inicio Tarde</th>
                            <th>Fin Tarde</th>
                            <th style="text-align: center">Editar</th>
                            <th style="text-align: center;">Eliminar <input type="checkbox" id="elico" title="Seleccionar todos" onclick="verSel('all');"></th>
                            
                        </tr>
                    </thead>
                    <tbody id="contCor"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" id="eliminarCor" data-toggle="confirmation" data-title="Seguro desea eliminar los registros seleccionados?">
                    <i class="icon-remove icon-white"></i>
                        Eliminar
                </a>
                <a class="btn btn-primary" id="imprimirCor">
                    <i class="icon-print icon-white"></i>
                        Imprimir
                </a>
                <a href="#" id="cerrar" class="btn" data-dismiss="modal">Cerrar</a>
            </div>
        </div>
        <!--FIN MENSAJE MODAL-->
        <script>
//            document.getElementById('itxtnrodocumento').focus();
//            $(function(){
//                        $('#datetimepicker4').datetimepicker({
//                            pickDate: false
//                        });
			
//            });

                
//            $('a[data-toggle="tab"]').on('shown', function (e) {
//                $("#contmsjmodal1").empty();
//                $("#contmsjmodal2").empty();
//                $("#contmsjmodal3").empty();
//                xGetElementById('itxtdoccont').value = "";
//                xGetElementById('itxtcedope').value = "";
//                xGetElementById('dp1').value = fechaActual();
//                xGetElementById('dp2').value = fechaActual();
//                cargarTodosHor();
//            })

//            $('#eliminarCor').confirmation('show');
            $('[data-toggle="confirmation"]').confirmation(
                {
                    
                    "placement" : "top",
                    "btnOkLabel" : '<i class="icon-ok-sign icon-white"></i> Si',
                    "btnOkClass" : "btn-danger",
                    "onConfirm" : function(){eliminarHor();}
                    
                }
            );
//            $('#eliminarCor').confirmation('onComplete',function(){
//                eliminarCor(1,2);
//            });

        </script>
          