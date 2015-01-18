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
                        <a class="btn btn-danger" id="guardar" onclick="valForm('formHorario','verificarHoras(\'g\')');">
                            <i class="icon-ok-sign icon-white"></i>
                                Guardar
                        </a>
                        <a id="openBtn" class="btn btn-danger"  onclick="cargarTodosCor();">
                            <i class="icon-eye-open icon-white"></i>
                                Mostrar
                        </a>
                        <a class="btn btn-danger" id="limpiar" onclick="limpiarFormCor();">
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
            <h3>Correspondencias Registradas</h3>
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
                        <a href="#operador" data-toggle="tab">Operador</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="contribuyente">
                        <form class="form-horizontal" id="formBusCorDocCont">
                            <fieldset>
                                <div class="offset4 span4">
                                    <input type="text" name="Documento Contribuyente" id="itxtdoccont" class="span10 search-query" placeholder="Ingrese el R.I.F. &oacute; C.I.">
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal1"></div>
                            <a class="btn btn-danger" id="guardar" onclick="buscarxCont();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-danger" id="limpiar" onclick="limpiarTabCor(1);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fecha">
                        <form class="form-inline" id="formBusCorFec">
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
                            <a class="btn btn-danger" id="guardar" onclick="buscarxFech();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-danger" id="limpiar" onclick="limpiarTabCor(2);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="operador">
                        <form class="form-horizontal" id="formBusCorCedOpe">
                            <fieldset>
                                <div class="offset4 span4">
                                    <input type="text" name="Cédula Operador" id="itxtcedope" class="span10 search-query" onKeyPress="return numeros(event);" placeholder="Ingrese una C&eacute;dula">
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal3"></div>
                            <a class="btn btn-danger" id="guardar" onclick="buscarxOper();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-danger" id="limpiar" onclick="limpiarTabCor(3);">
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
                            <th>Operador</th>
                            <th>Contribuyente</th>
                            <th>Tipo</th>
                            <th>Tipo Solicitud</th>
                            <th>Asunto</th>
                            <th>Fecha</th>
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

                $(function() {
                    $('#datetimepicker1').datetimepicker({pickDate: false});
                    $('#datetimepicker2').datetimepicker({pickDate: false});
                    $('#datetimepicker3').datetimepicker({pickDate: false});
                    $('#datetimepicker4').datetimepicker({pickDate: false});
                    $('#datetimepicker5').datetimepicker({pickDate: false});
                    $('#datetimepicker6').datetimepicker({pickDate: false});
                    $('#datetimepicker7').datetimepicker({pickDate: false});
                    $('#datetimepicker8').datetimepicker({pickDate: false});
                    $('#datetimepicker9').datetimepicker({pickDate: false});
                    $('#datetimepicker10').datetimepicker({pickDate: false});
                    $('#datetimepicker11').datetimepicker({pickDate: false});
                    $('#datetimepicker12').datetimepicker({pickDate: false});
                    $('#datetimepicker13').datetimepicker({pickDate: false});
                    $('#datetimepicker14').datetimepicker({pickDate: false});
                    $('#datetimepicker15').datetimepicker({pickDate: false});
                    $('#datetimepicker16').datetimepicker({pickDate: false});
                    $('#datetimepicker17').datetimepicker({pickDate: false});
                    $('#datetimepicker18').datetimepicker({pickDate: false});
                    $('#datetimepicker19').datetimepicker({pickDate: false});
                    $('#datetimepicker20').datetimepicker({pickDate: false});
                    $('#datetimepicker21').datetimepicker({pickDate: false});
                    $('#datetimepicker22').datetimepicker({pickDate: false});
                    $('#datetimepicker23').datetimepicker({pickDate: false});
                    $('#datetimepicker24').datetimepicker({pickDate: false});
                    $('#datetimepicker25').datetimepicker({pickDate: false});
                    $('#datetimepicker26').datetimepicker({pickDate: false});
                    $('#datetimepicker27').datetimepicker({pickDate: false});
                    $('#datetimepicker28').datetimepicker({pickDate: false});
                  });
            $('a[data-toggle="tab"]').on('shown', function (e) {
                $("#contmsjmodal1").empty();
                $("#contmsjmodal2").empty();
                $("#contmsjmodal3").empty();
                xGetElementById('itxtdoccont').value = "";
                xGetElementById('itxtcedope').value = "";
                xGetElementById('dp1').value = fechaActual();
                xGetElementById('dp2').value = fechaActual();
                cargarTodosHor();
            })

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
          