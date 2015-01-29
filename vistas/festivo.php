<form class="well form-inline" id="formFestivo" role="form">
    <fieldset>
        <legend>Registro de D&iacute;s Festivos
            <div class="pull-right">
                <a class="btn btn-primary" href="index.php">
                    <i class="icon-home icon-white"></i>
                        Inicio
                </a>
            </div>
        </legend>
        <div id="contmsj2"></div>         
                            
        <div class="control-group">
            <div class="row">
                <div class="offset1 span12">
                    <label for="itxtdescrip">Descripci&oacute;n:</label>
                    <div class="input-append controls">
                        <input id="itxtdescrip" name="D&iacute;a Festivo" placeholder="Ingrese una descripci&oacute;n"  size="75px" type="text" maxlength="90" autofocus>
                    </div>
                </div>
            </div>
        </div>
                    
        <div class="control-group">
            <div class="row">
                <div class="offset1 span12">
                    <label class="control-label" for="dp1">Fecha:</label>
                    <div class="input-append controls">
                        <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="fecharg1"/>
                    </div>
                </div>
            </div>
        </div>

        <div id="contmsj"></div>

            <div class="form-actions">
                <a class="btn btn-primary" id="guardar" onclick="valForm('formFestivo','guardarFes(\'g\')');">
                    <i class="icon-ok-sign icon-white"></i>
                        Guardar
                </a>
                <a id="openBtn" class="btn btn-primary"  onclick="cargarTodosFes();">
                    <i class="icon-eye-open icon-white"></i>
                        Mostrar
                </a>
                <a class="btn btn-primary" id="limpiar" onclick="limpiarFormFes();">
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
            <h3>Tierras Registradas</h3>
            </div>
            <div class="modal-body">
                <ul id="tab" class="nav nav-tabs">
                    <li class="">
                        <a>B&uacute;squeda por: </a>
                    </li>
                    <li class="active">
                        <a href="#palabra" data-toggle="tab">Palabra</a>
                    </li>
                    <li class="">
                        <a href="#fecha" data-toggle="tab">Fecha</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="palabra">
                        <form class="form-horizontal" id="buscarxPalFes">
                            <fieldset>
                                <div class="offset4 span4">
                                    <input type="text" name="Nombre festivo" id="itxtdesc" class="span10 search-query" placeholder="Ingrese una letra">
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal1"></div>
                            <a class="btn btn-primary" id="guardar" onclick="buscarxPalFes();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabFes(1);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fecha">
                        <form class="form-inline" id="formBusFesFec">
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
                            <a class="btn btn-primary" id="guardar" onclick="buscarxFechFes();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabFes(2);">
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
                            <th>Descripci&oacute;n</th>
                            <th>Fecha</th>
                            <th style="text-align: center">Editar</th>
                            <th style="text-align: center;">Eliminar <input type="checkbox" id="elico" title="Seleccionar todos" onclick="verSel('all');"></th>
                        </tr>
                    </thead>
                    <tbody id="contTie"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="eliminarTie" data-toggle="confirmation" data-title="Seguro desea eliminar los registros seleccionados?">
                    <i class="icon-remove icon-white"></i>
                        Eliminar
                </a>
                <a class="btn btn-primary" id="imprimirTie">
                    <i class="icon-print icon-white"></i>
                        Imprimir
                </a>
                <a href="#" id="cerrar" class="btn" data-dismiss="modal">Cerrar</a>
            </div>
        </div>
        <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtdescrip').focus();
            $(function(){
                $('#fecharg1').datepicker();
                $('#dp1').datepicker();
                $('#dp2').datepicker();
            });
                      
            $('a[data-toggle="tab"]').on('shown', function (e) {
                $("#contmsjmodal1").empty();
                $("#contmsjmodal2").empty();
                xGetElementById('itxtdescrip').value = "";
                xGetElementById('dp1').value = fechaActual();
                xGetElementById('dp2').value = fechaActual();
                cargarTodosFes();
            })
            $('[data-toggle="confirmation"]').confirmation(
                {
                    
                    "placement" : "top",
                    "btnOkLabel" : '<i class="icon-ok-sign icon-white"></i> Si',
                    "btnOkClass" : "btn-primary",
                    "onConfirm" : function(){eliminarFes();}
                    
                }
            );
        </script>
          