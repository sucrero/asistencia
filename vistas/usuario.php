<form class="well form-horizontal" id="formUsuario">
                <fieldset>
                  <legend>Registro de Usuario
                  <div class="pull-right">
                    <a class="btn btn-danger" href="index.php">
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
                                <a class="btn btn-danger" id="btnbuscarusu" onclick="buscarUsu();">
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
                    
                    <hr class="btn-danger">
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
                        <a class="btn btn-danger" id="guardar" onclick="valForm('formUsuario','guardarUsu(\'g\')');">
                            <i class="icon-ok-sign icon-white"></i>
                                Guardar
                        </a>
                        <a id="openBtn" class="btn btn-danger"  onclick="cargarTodosUsu();">
                            <i class="icon-eye-open icon-white"></i>
                                Mostrar
                        </a>
                        <a class="btn btn-danger" id="limpiar" onclick="limpiarFormUsu();">
                            <i class="icon-trash icon-white"></i>
                                Limpiar
                        </a>
                    </div>
                </fieldset>
              </form>
               <!--COMIENZO MENSAJE MODAL-->
       <div id="myModal" class="modal hide fade" style="display: none;">
            <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Usuarios Registrados</h3>
            </div>
            <div class="modal-body">
                <form action="#" class="form-search">
                   <label for="nombre">Buscar:</label>
                   <input name="nombre" id="nombre" type="text" class="input-xlarge search-query" onkeyup="buscarUsuLe(this,event)">
               </form>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Usuario</th>
                            <th>C&eacute;dula</th>
                            <th>Nombre Completo</th>
                        </tr>
                    </thead>
                    <tbody id="contUsu"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="#" id="cerrar" class="btn btn-danger" data-dismiss="modal">Cerrar</a>
            </div>
            </div>
        <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtcedula').focus();
    </script>
          