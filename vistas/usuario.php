<form class="well form-horizontal" id="formUsuario">
                <fieldset>
                  <legend>Registro de Usuario
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
                                <input id="itxtcedula" name="C&eacute;dula" onkeyup="accionUsu(event);" placeholder="Ingrese una c&eacute;dula" class="span7" maxlength="8" size="75px" type="text" onKeyPress="return numeros(event);" autofocus>
                                <a class="btn btn-primary" id="btnbuscarusu" onclick="buscarUsu();">
                                    <i class="icon-search icon-white"></i>
                                </a>
                            </div>
                            <p class="help-block">Ejem.: 12345678</p>
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
                    
                    <div class="control-group">
                      <label class="control-label" for="ilstcargo">Cargo</label>
                      <div class="controls">
                          <select id="ilstcargo" disabled="" class="span7" name="Tipo de Personal"> 
                              <option value="-1" selected="">Seleccione...</option>
                                <option value="ADMINISTRATIVO">Administrativo</option>
                                <option value="DIRECTIVO">Directivo</option>
                                <option value="DOCENTE">Docente</option>
                                <option value="OBRERO">Obrero</option>
                                <option value="MADRE PROCESADORA">Madre Procesadora</option>
                                <option value="VIGILANTE">Vigilante</option>
                          </select>
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="ilstdependencia">Dependencia</label>
                      <div class="controls">
                          <select id="ilstdependencia" disabled="" class="span7" name="Dependencia"> 
                             <option value="-1" selected="">Seleccione...</option>
                    <option value="ALCALDIA">Alcaldia</option>
                    <option value="ENCARGADO">Encargado(a)</option>
                    <option value="ESTADAL">Estadal</option>
                    <option value="NACIONAL">Nacional</option>
                    <option value="OTRO">Otro</option>
                          </select>
                      </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label" for="ilstcondicion">Condici&oacute;n</label>
                      <div class="controls">
                          <select id="ilstcondicion" disabled="" class="span7" name="Condicion"> 
                               <option value="-1" selected="">Seleccione...</option>
                    <option value="COLABORADOR">Colaborador</option>
                    <option value="INTERINO">Interino</option>
                    <option value="SUPLENTE">Suplente</option>
                    <option value="TITULAR">Titular</option>
                          </select>
                      </div>
                    </div>
                    <hr class="btn-primary">
                    <div class="control-group">
                        <label class="control-label" for="itxtlogin">Nombre de Usuario</label>
                        <div class="controls">
                            <input type="text" class="span7 disabled" placeholder="Ingrese un nombre de usuario" disabled="" id="itxtlogin" name="Nombre de Usuario">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtclave">Contrase&ntilde;a</label>
                        <div class="controls">
                            <input type="password" class="span7 disabled" placeholder="Ingrese una contrase&ntilde;a" disabled="" id="itxtclave" name="Contrase&ntilde;a">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtreclave">Valide su Contrase&ntilde;a</label>
                        <div class="controls">
                            <input type="password" class="span7 disabled" placeholder="Valide su contrase&ntilde;a" disabled="" id="itxtreclave" name="Validaci&oacute;n de Contrase&ntilde;a">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="ilsttipo">Tipo de Usuario</label>
                        <div class="controls">
                            <select id="ilsttipo" disabled="" class="span7" name="Tipo de Usuario"> 
                                <option value="-1" selected="">Seleccione...</option>
                                <option value="ADMINISTRADOR">Administrador</option>
                                <option value="OPERADOR">Operador</option>
                            </select>
                        </div>
                    </div>
                    <div id="contmsj"></div>
            
                    <div class="form-actions">
                        <a class="btn btn-primary" id="guardar" onclick="valForm('formUsuario','guardarUsu(\'g\')');">
                            <i class="icon-ok-sign icon-white"></i>
                                Guardar
                        </a>
                        <a id="openBtn" class="btn btn-primary"  onclick="cargarTodosUsu();">
                            <i class="icon-eye-open icon-white"></i>
                                Mostrar
                        </a>
                        <a class="btn btn-primary" id="limpiar" onclick="limpiarFormUsu();">
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
                <h3>Usuarios Registrados</h3>
            </div>
            <div class="modal-body">
                <ul id="tab" class="nav nav-tabs">
                    <li class="">
                        <a>B&uacute;squeda por: </a>
                    </li>
                    <li class="active">
                        <a href="#cedula" data-toggle="tab">C&eacute;dula</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="cedula">
                        <form class="form-inline" id="formBusUsu">
                            <fieldset>
                                <div class="control-group">
                                    <div class="row">
                                        <div class="offset1 span7">
                                            <label class="control-label" for="itxtcedbus">C&eacute;dula de Identidad:</label>
                                            <!--<div class="controls">-->
                                                <input id="itxtcedbus" name="C&eacute;dula a buscar" placeholder="Ingrese una c&eacute;dula"  size="50px" type="text" maxlength="8" autofocus>
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    
                    <div class="form-actions">
                        <div id="contmsjmodal1"></div>
                        <a class="btn btn-primary" id="buscarPer" onclick="buscarRepUsu();">
                            <i class="icon-search icon-white"></i>
                                Buscar
                        </a>
                        <a class="btn btn-primary" id="limpiar" onclick="limpiarRepUsu();">
                            <i class="icon-trash icon-white"></i>
                                Limpiar
                        </a>
                    </div>
                </div>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center">Item</th>
                            <th style="text-align: center">Usuario</th>
                            <th style="text-align: center">C&eacute;dula</th>
                            <th style="text-align: center">Nombre Completo</th>
                            <th style="text-align: center">Editar</th>
                            <th style="text-align: center;">Eliminar <input type="checkbox" id="elico" title="Seleccionar todos" onclick="verSel('all');"></th>
                        </tr>
                    </thead>
                    <tbody id="contUsu"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="eliminarUsu" data-toggle="confirmation" data-title="Seguro desea eliminar los registros seleccionados?">
                    <i class="icon-remove icon-white"></i>
                        Eliminar
                </a>
                <a class="btn btn-primary" id="imprimirUsu">
                    <i class="icon-print icon-white"></i>
                        Imprimir
                </a>
                <a href="#" id="cerrar" class="btn" data-dismiss="modal">Cerrar</a>
            </div>
            </div>
        <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtcedula').focus();
            $('[data-toggle="confirmation"]').confirmation(
                {
                    "placement" : "top",
                    "btnOkLabel" : '<i class="icon-ok-sign icon-white"></i> Si',
                    "btnOkClass" : "btn-primary",
                    "onConfirm" : function(){eliminarUsu();}
                }
            );
        </script>
          