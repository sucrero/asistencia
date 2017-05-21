<?php
    session_start();
?>
              <form class="well form-horizontal" id="formCambioClave">
                <fieldset>
                    <legend>Cambio de Contrase&ntilde;a
                  <div class="pull-right">
                    <a class="btn btn-primary" href="index.php">
                        <i class="icon-home icon-white"></i>
                            Inicio
                    </a>
                  </div>
                  </legend>
                    <div class="control-group">
                        <label class="control-label" for="itxtlogin">Nombre de Usuario</label>
                        <div class="controls">
                            <input type="text" class="span7 disabled" disabled="" id="itxtlogin" name="Nombre de Usuario" value="<?php echo $_SESSION['login']; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtclaveactual">Contrase&ntilde;a Actual</label>
                        <div class="controls">
                            <input type="password" class="span7" placeholder="Ingrese su contrase&ntilde;a actual" id="itxtclaveactual" name="Contrase&ntilde;a Actual">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtclavenueva">Nueva Contrase&ntilde;a</label>
                        <div class="controls">
                            <input type="password" class="span7" placeholder="Ingrese su nueva contrase&ntilde;a" id="itxtclavenueva" name="Nueva Contrase&ntilde;a">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="itxtreclavenueva">Valide su Nueva Contrase&ntilde;a</label>
                        <div class="controls">
                            <input type="password" class="span7" placeholder="Valide su nueva contrase&ntilde;a" id="itxtreclavenueva" name="Validaci&oacute;n de Nueva Contrase&ntilde;a">
                        </div>
                    </div>
                    <div id="contmsj"></div>
            
                    <div class="form-actions">
                        <a class="btn btn-primary" id="guardar" onclick="valForm('formCambioClave','cambiarClave()');">
                            <i class="icon-refresh icon-white"></i>
                                Cambiar
                        </a>
                        <a class="btn btn-primary" id="limpiar" onclick="limpiarFormCambio();">
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
                <h3>Contrase&ntilde;a modificada con &eacute;xito !!!!</h3>
            </div>
            <div class="modal-footer">
                <a href="#" id="cerrar" class="btn btn-primary" data-dismiss="modal">Cerrar</a>
            </div>
            </div>
        <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtclaveactual').focus();
    </script>
          