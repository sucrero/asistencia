<form class="well form-horizontal" id="formFiscal">
                <fieldset>
                  <legend>Registro de Fiscal
                  <div class="pull-right">
                    <a class="btn btn-primary" href="index.php">
                        <i class="icon-home icon-white"></i>
                            Inicio
                    </a>
                  </div>
                  </legend>
                    <div class="control-group">
                        <label class="control-label" for="itxtcedula">C&eacute;dula</label>
                        <div class="controls">
                            <div class="input-append">
                                <input id="itxtcedula" name="C&eacute;dula" onkeyup="accionFis(event);" placeholder="Ingrese una c&eacute;dula" class="span7" maxlength="8" size="75px" type="text" onKeyPress="return numeros(event);" autofocus>
                                <a class="btn btn-primary" id="btnbuscarfis" onclick="buscarFis();">
                                    <i class="icon-search icon-white"></i>
                                </a>
                            </div>
                            <p class="help-block ejemplo">Ejem.: 12345678</p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtnombre">Nombres</label>
                        <div class="controls">
                            <input type="text" class="span7 disabled" placeholder="Ingrese un nombre" disabled="" id="itxtnombre" name="Nombre" onKeyPress="return letras(event);">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtapellido">Apellidos</label>
                        <div class="controls">
                            <input type="text" class="span7 disabled" placeholder="Ingrese un apellido" disabled="" id="itxtapellido" name="Apellido" onKeyPress="return letras(event);">
                        </div>
                    </div>
                    
                    <div id="contmsj"></div>
            
                    <div class="form-actions">
                        <a class="btn btn-primary" id="guardar" onclick="valForm('formFiscal','guardarFis(\'g\')');">
                            <i class="icon-ok-sign icon-white"></i>
                                Guardar
                        </a>
                        <a id="openBtn" class="btn btn-primary"  onclick="cargarTodosFis();">
                            <i class="icon-eye-open icon-white"></i>
                                Mostrar
                        </a>
                        <a class="btn btn-primary" id="limpiar" onclick="limpiarFormFis();">
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
            <h3>Fiscales Registrados</h3>
            </div>
            <div class="modal-body">
                <ul id="tab" class="nav nav-tabs">
                    <li class="">
                        <a>B&uacute;squeda por: </a>
                    </li>
                    <li class="active">
                        <a href="#cedula" data-toggle="tab">C&eacute;dula</a>
                    </li>
                    <li class="">
                        <a href="#nombre" data-toggle="tab">Nombre</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="cedula">
                        <form class="form-horizontal" id="formBusFisCed">
                            <fieldset>
                                <div class="offset4 span4">
                                    <input type="text" name="Cedula" id="itxtdocfis" class="span10 search-query" placeholder="Ingrese la cedula del fiscal">
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal1"></div>
                            <a class="btn btn-primary" id="buscar" onclick="buscarFisxCed();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabFis(1);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nombre">
                        <div id="contmsjmodal2"></div>
                        <form action="#" class="form-search">
                            <label for="nombre">Buscar:</label>
                            <input name="nombre" id="itxtnombrefis" type="text" class="input-xlarge search-query" onkeyup="buscarFisLe(this,event)">
                        </form>
                        
                    </div>

                </div>
                <hr>
                <table class="table table-hover table-bordered">
                    <thead style="text-align: center;">
                        <tr>
                            <th style="width: 10%">Item</th>
                            <th style="width: 20%">C&eacute;dula</th>
                            <th style="width: 50%">Nombre y Apellido</th>
                            <th style="width: 10%; text-align: center;">Editar</th>
                            <th style="width: 10%; text-align: center;">Eliminar <input type="checkbox" id="elico" title="Seleccionar todos" onclick="verSel('all');"></th>
                        </tr>
                    </thead>
                    <tbody id="contFis"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="eliminarFis" data-toggle="confirmation" data-title="Seguro desea eliminar estos registros?">
                    <i class="icon-remove icon-white"></i>
                        Eliminar
                </a>
                <a class="btn btn-primary" id="imprimirFis">
                    <i class="icon-print icon-white"></i>
                        Imprimir
                </a>
                <a href="#" id="cerrar" class="btn" data-dismiss="modal">Cerrar</a>
            </div>
        </div>
        <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtdocfis').focus();
            
            $('a[data-toggle="tab"]').on('shown', function (e) {
                $("#contmsjmodal1").empty();
                $("#contmsjmodal2").empty();
                xGetElementById('itxtdocfis').value = "";
                xGetElementById('itxtnombrefis').value = "";
                cargarTodosFis();
            })

            $('[data-toggle="confirmation"]').confirmation(
                {
                    
                    "placement" : "top",
                    "btnOkLabel" : '<i class="icon-ok-sign icon-white"></i> Si',
                    "btnOkClass" : "btn-primary",
                    "onConfirm" : function(){eliminarFis();}
                    
                }
            );
        </script>
          