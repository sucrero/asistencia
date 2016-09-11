<form class="well form-horizontal" id="formUsuarioPv">
                <fieldset>
                  <legend>Registro de Usuario por primera vez
                  </legend>
                    <div class="control-group">
                        <label class="control-label" for="itxtcedula">C&eacute;dula</label>
                        <div class="controls">
                            <div class="input-append">
                                <input id="itxtcedula" name="C&eacute;dula" placeholder="Ingrese una c&eacute;dula" class="span7" maxlength="8" size="75px" type="text" onKeyPress="return numeros(event);" autofocus>
                            </div>
                            <p class="help-block">Ejem.: 12345678</p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtnombre">Nombres</label>
                        <div class="controls">
                            <input type="text" class="span7" placeholder="Ingrese un nombre" id="itxtnombre" name="Nombre" onKeyPress="return letras(event);">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtapellido">Apellidos</label>
                        <div class="controls">
                            <input type="text" class="span7" placeholder="Ingrese un apellido" id="itxtapellido" name="Apellido" onKeyPress="return letras(event);">
                        </div>
                    </div>
                    <div class="control-group">
            <label class="control-label" for="txtemail">Correo Electr&oacute;nico</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">@</span>
                    <input type="text" class="span7" size="68px" placeholder="Ingrese un correo electr&oacute;nico" id="txtemail" name="Correo Electr&oacute;nico">
                </div>
                <p class="help-block">Ejem.: correo@dominio.com</p>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="txttelefono">Tel&eacute;fono</label>
              <div class="controls">
                  <div class="input-prepend">
                      <span class="add-on">#</span>
                      <input type="text" class="span7" maxlength="11" size="68px" placeholder="Ingrese un tel&eacute;fono" id="txttelefono" name="Tel&eacute;fono" onKeyPress="return numeros(event);">
                  </div>
                <p class="help-block">Ejem.: 12345678901</p>
              </div>

            </div>
            <div class="control-group">
              <label class="control-label" for="ilstcargo">Cargo</label>
              <div class="controls">
                  <select id="ilstcargo" class="span7" name="Tipo de Personal"> 
                      <option value="-1" selected="">Seleccione...</option>
                      <option value="ADMINISTRATIVO">Administrativo</option>
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
                  <select id="ilstdependencia" class="span7" name="Dependencia"> 
                      <option value="-1" selected="">Seleccione...</option>
                      <option value="ALCALDIA">Alcaldia</option>
                      <option value="ESTADAL">Estadal</option>
                      <option value="NACIONAL">Nacional</option>
                      <option value="OTRO">Otro</option>
                  </select>
              </div>
            </div>
            <div class="control-group">
               <label class="control-label" for="ilstcondicion">Condici&oacute;n</label>
              <div class="controls">
                  <select id="ilstcondicion" class="span7" name="Condicion"> 
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
                            <input type="text" class="span7" placeholder="Ingrese un nombre de usuario" id="itxtlogin" name="Nombre de Usuario">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtclave">Contrase&ntilde;a</label>
                        <div class="controls">
                            <input type="password" class="span7" placeholder="Ingrese una contrase&ntilde;a" id="itxtclave" name="Contrase&ntilde;a">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtreclave">Valide su Contrase&ntilde;a</label>
                        <div class="controls">
                            <input type="password" class="span7" placeholder="Valide su contrase&ntilde;a" id="itxtreclave" name="Validaci&oacute;n de Contrase&ntilde;a">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="ilsttipo">Tipo de Usuario</label>
                        <div class="controls">
                            <select id="ilsttipo" class="span7 disabled" name="Tipo de Usuario" disabled=""> 
                                <option value="ADMINISTRADOR" selected="">Administrador</option>
                            </select>
                        </div>
                    </div>
                    <div id="contmsj"></div>
            
                    <div class="form-actions">
                        <a class="btn btn-primary" id="guardar" onclick="valForm('formUsuarioPv','guardarUsuPv()');">
                            <i class="icon-ok-sign icon-white"></i>
                                Guardar
                        </a>
                        <a class="btn btn-primary" id="limpiar" onclick="limpiarFormUsuPv();">
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
                <h5>Mensaje</h5>
                </div>
                <div class="modal-body alert-success">
                    <!--<div class="alert alert-success">-->
                    <h3>Administrador registrado exitosamente, sera redirigido a la p&aacute;gina de inicio !!!!</h3>
                    <!--</div>-->
                </div>
                <div class="modal-footer">
                    <a href="#" id="cerrar" class="btn btn-primary" data-dismiss="modal">Cerrar</a>
                </div>
            </div>
            <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtcedula').focus();
    </script>
          