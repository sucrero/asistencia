<script>numRegistroViv();</script>
<form class="well form-horizontal" id="formVivienda">
                <fieldset>
                  <legend>Registro de Vivienda
                  <div class="pull-right">
                    <a class="btn btn-primary" href="index.php">
                        <i class="icon-home icon-white"></i>
                            Inicio
                    </a>
                  </div>
                  </legend>
                    <div class="control-group">
                        <label class="control-label" for="nroregistro">Registro Nro.</label>
                        <div class="controls">
                            <div class="input-append" id="numregistrocor">
                                <span class="input-small uneditable-input" id="itxtcodigo"></span>
                            </div>
                        </div>
                        <div class="controls">
                            <div class="input-append" id="numregistrocor">
                                <span class="input-small uneditable-input" id="itxtcodigo"></span>
                            </div>
                        </div>
                        
                    </div>
                    <legend><h5>PROPIETARIO(S) INCLUIDO(S) EN EL REGISTRO DE VIVIENDA PRINCIPAL</h5></legend>
                    <div class="control-group">
                        <label class="control-label" for="itxtnrodocumento">R.I.F. &oacute; C.I.</label>
                        <div class="controls">
                            <div class="input-append">
                                <input id="itxtnrodocumento" name="R.I.F.  &oacute;  C.I." onkeyup="accionPer(event);" placeholder="Ingrese el R.I.F. &oacute; C.I." class="span7" size="75px" type="text" maxlength="10" autofocus>
                                <a class="btn btn-primary" id="btnbuscarper" onclick="buscarPer();">
                                    <i class="icon-search icon-white"></i>
                                </a>
                            </div>
                            <p class="help-block ejemplo">Indique el Número de CI o RIF, sin guiones, ni puntos. En caso de RIF debe completar un máximo de 10 caracteres. Ejemplo de la Cédula: 12345678, Ejemplo del RIF: V123456789.</p>
                        </div>
                    </div>
                    <div id="contmsj2"></div>
                    <div class="control-group">
                        <label class="control-label" for="itxtnombre">Nombres</label>
                        <div class="controls">
                            <input type="text" class="span7 disabled" placeholder="Ingrese un nombre" disabled="" id="itxtnombre" name="Nombres" onKeyPress="return letras(event);">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtapellido">Apellidos</label>
                        <div class="controls">
                            <input type="text" class="span7 disabled" placeholder="Ingrese un apellido" disabled="" id="itxtapellido" name="Apellidos" onKeyPress="return letras(event);">
                        </div>
                    </div>
                    <legend><h5>Datos del Co-Propietario (Solo si el contribuyente es Poseedor)</h5></legend>
                    <div class="control-group">
                        <label class="control-label" for="itxtnrodocumento">R.I.F. &oacute; C.I.</label>
                        <div class="controls">
                            <div class="input-append">
                                <input id="itxtnrodocumento" name="R.I.F.  &oacute;  C.I." onkeyup="accionPer(event);" placeholder="Ingrese el R.I.F. &oacute; C.I." class="span7" size="75px" type="text" maxlength="10" autofocus>
                                <a class="btn btn-primary" id="btnbuscarper" onclick="buscarPer();">
                                    <i class="icon-search icon-white"></i>
                                </a>
                            </div>
                            <p class="help-block ejemplo">Indique el Número de CI o RIF, sin guiones, ni puntos. En caso de RIF debe completar un máximo de 10 caracteres. Ejemplo de la Cédula: 12345678, Ejemplo del RIF: V123456789.</p>
                        </div>
                    </div>
                    <div id="contmsj2"></div>
                    <div class="control-group">
                        <label class="control-label" for="itxtnombre">Nombres</label>
                        <div class="controls">
                            <input type="text" class="span7 disabled" placeholder="Ingrese un nombre" disabled="" id="itxtnombre" name="Nombres" onKeyPress="return letras(event);">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtapellido">Apellidos</label>
                        <div class="controls">
                            <input type="text" class="span7 disabled" placeholder="Ingrese un apellido" disabled="" id="itxtapellido" name="Apellidos" onKeyPress="return letras(event);">
                        </div>
                    </div>
                    <legend><h5>Datos del Registro</h5></legend>
                    <div class="control-group">
                        <label class="control-label" for="ilsttipo">Registro Nro. </label>
                        <div class="controls">
                            <select id="ilsttipo" class="span7" name="Tipo Correspondencia" onchange="actTipoSol();"> 
                                <option value="-1" selected="">Seleccione...</option>
                                <option value="CONSIGNACION">Consignaci&oacute;n</option>
                                <option value="SOLICITUD">Solicitud</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="lstrecaudos">Tipo Solicitud</label>
                        <div class="controls">
                            <select id="lstrecaudos" disabled="" class="span7" name="Tipo Solicitud"> 
                                <option value="-1" selected="">Seleccione...</option>
                                <option>Cambio de Domicilio</option>
                                <option>Inscripcion como Contribuyente Formal</option>
                                <option>Exenciones y Exoneraciones</option>
                                <option>Prescripci&oacute;n</option>
                                <option>Interposici&oacute;n de Consultas</option>
                                <option>Situaci&oacute;n Fiscal</option>
                                <option>Agentes de Retenci&oacute;n de IVA </option>
                                <option>Personas Jur&iacute;dicas </option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtasunto">Asunto</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <textarea class="input-xlarge" name="Asunto" id="itxtasunto" rows="3" style="width: 292px; height: 76px;"></textarea>
                            </div>
                        </div>
                        
                    </div>
                    <div id="contmsj"></div>
            
                    <div class="form-actions">
                        <a class="btn btn-primary" id="guardar" onclick="valForm('formCorrespondencia','guardarCor(\'g\')');">
                            <i class="icon-ok-sign icon-white"></i>
                                Guardar
                        </a>
                        <a id="openBtn" class="btn btn-primary"  onclick="cargarTodosCor();">
                            <i class="icon-eye-open icon-white"></i>
                                Mostrar
                        </a>
                        <a class="btn btn-primary" id="limpiar" onclick="limpiarFormCor();">
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
                            <a class="btn btn-primary" id="guardar" onclick="buscarxCont();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabCor(1);">
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
                            <a class="btn btn-primary" id="guardar" onclick="buscarxFech();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabCor(2);">
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
                            <a class="btn btn-primary" id="guardar" onclick="buscarxOper();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabCor(3);">
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
                        </tr>
                    </thead>
                    <tbody id="contCor"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" id="imprimirCor" onclick="imprimirCor();">
                    <i class="icon-print icon-white"></i>
                        Imprimir
                </a>
                <a href="#" id="cerrar" class="btn btn-primary" data-dismiss="modal">Cerrar</a>
            </div>
        </div>
        <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtnrodocumento').focus();
            $(function(){
			$('#dp1').datepicker();
                        $('#dp2').datepicker();
            });
            $('a[data-toggle="tab"]').on('shown', function (e) {
                xGetElementById('itxtdoccont').value = "";
                xGetElementById('itxtcedope').value = "";
                xGetElementById('dp1').value = fechaActual();
                xGetElementById('dp2').value = fechaActual();
                cargarTodosCor();
            })
        </script>
          