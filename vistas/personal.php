<form class="well form-inline" id="formPersonal" role="form">
    <fieldset>
        <legend>Registro de Personal
            <div class="pull-right">
                <a class="btn btn-primary" href="index.php">
                    <i class="icon-home icon-white"></i>
                        Inicio
                </a>
            </div>
        </legend>
        <div id="contmsj2"></div>              
                    
        <div class="span12 control-group">
            <label for="itxtnrodocumento">N&uacute;mero de C&eacute;dula:</label>
            <div class="input-append controls">
                <input id="itxtnrodocumento" name="N&uacute;mero de C&eacute;dula" onKeyPress="return numeros(event);" placeholder="Ingrese la c&eacute;dula"  size="75px" type="text" maxlength="8" autofocus>
                <a class="btn btn-primary" id="btnbuscarper" onclick="buscarPer();">
                    <i class="icon-search icon-white"></i>
                </a>
            </div>
            <p class="help-block ejemplo">Indique el N&uacute;mero de C.I. sin puntos. Ejemplo de la C&eacute;dula: 12345678</p>
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
        
        <div class="control-group">
            <label class="control-label" for="txtemail">Correo Electr&oacute;nico</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">@</span>
                    <input type="text" class="span7 disabled" size="68px" placeholder="Ingrese un correo electr&oacute;nico" disabled="" id="txtemail" name="Correo Electr&oacute;nico">
                </div>
              <p class="help-block">Ejem.: correo@dominio.com</p>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="txttelefono">Tel&eacute;fono</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">#</span>
                    <input type="text" class="span7 disabled" maxlength="11" size="68px" placeholder="Ingrese un tel&eacute;fono" disabled="" id="txttelefono" name="Tel&eacute;fono" onKeyPress="return numeros(event);">
                </div>
              <p class="help-block">Ejem.: 12345678901</p>
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
                <select id="ilstdependencia" disabled="" class="span7" name="Tipo de Personal"> 
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
                <select id="ilstcondicion" disabled="" class="span7" name="Tipo de Personal"> 
                    <option value="-1" selected="">Seleccione...</option>
                    <option value="COLABORADOR">Colaborador</option>
                    <option value="INTERINO">Interino</option>
                    <option value="SUPLENTE">Suplente</option>
                    <option value="TITULAR">Titular</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="ilstpersonal">Tipo de horario:</label>
            <div class="controls">
                <?php
                    include_once '../conexion/conexion.php';
                    include_once '../clases/Horario.php';
                    $objHor = new Horario();
                    $consulta =  $objHor->buscar("SELECT * FROM horario ORDER BY descripcionhor ASC", $conexion);
                    if($conexion){
                        if($consulta){
                           if($conexion->registros > 0){
                              echo'<select id="ilsthorario" name="Fiscal" disabled="" class="span7">';
                              echo '<option value="-1">Seleccione...</option>';
                              $i = 0;
                              do{
                                 $fila = $conexion->devolver_recordset();
                                 echo '<option value="'.$fila['idhor'].'">'.  ucwords(htmlentities(strtolower($fila['descripcionhor']),ENT_QUOTES,'UTF-8')).'</option>';
                                 $i++;
                              }while(($conexion->siguiente())&&($i!=$conexion->registros));

                           }else{
                               echo'<select id="ilsthorario" disabled class="span8">';
                               echo '<option value="-1">No se encontraron registros...</option>';
                           }
                        }else{
                            echo'<select id="ilsthorario" disabled class="span8">';
                            echo '<option value="-1">No se encontraron registros...</option>';
                        }
                        echo'</select>';
                    }
                ?>
            </div>
        </div>
        <div id="contmsj"></div>

            <div class="form-actions">
                <a class="btn btn-primary" id="guardar" onclick="valForm('formPersonal','guardarPer(\'g\')');">
                    <i class="icon-ok-sign icon-white"></i>
                        Guardar
                </a>
                <a id="openBtn" class="btn btn-primary"  onclick="cargarTodosPer();">
                    <i class="icon-eye-open icon-white"></i>
                        Mostrar
                </a>
                <a class="btn btn-primary" id="limpiar" onclick="limpiarFormPer();">
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
            <h3>Personal Registrado</h3>
            </div>
            <div class="modal-body">
                <ul id="tab" class="nav nav-tabs">
                    <li class="">
                        <a>B&uacute;squeda por: </a>
                    </li>
                    <li class="active">
                        <a href="#cargo" data-toggle="tab">Cargo</a>
                    </li>
                    <li class="">
                        <a href="#dependencia" data-toggle="tab">Dependencia</a>
                    </li>
                    <li class="">
                        <a href="#condicion" data-toggle="tab">Condici&oacute;n</a>
                    </li>
                    <li class="">
                        <a href="#cedula" data-toggle="tab">c&eacute;dula</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    
                    <div class="tab-pane fade active in" id="cargo">
                        <form class="form-inline" id="formBusCarg">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="ilsttipobus">Cargo</label>
                                    <div class="controls">
                                        <select id="ilstcargobus" class="span7" name="Tipo de Personal"> 
                                            <option value="-1" selected="">Todos</option>
                                                <option value="ADMINISTRATIVO">Administrativo</option>
                                                <option value="DIRECTIVO">Directivo</option>
                                                <option value="DOCENTE">Docente</option>
                                                <option value="OBRERO">Obrero</option>
                                                <option value="MADRE PROCESADORA">Madre Procesadora</option>
                                                <option value="VIGILANTE">Vigilante</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal1"></div>
                            <a class="btn btn-primary" id="guardar" onclick="buscarPerxCargo();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabPer(1);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="dependencia">
                        <form class="form-inline" id="formBusDep">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="ilstdependenciabus">Dependencia</label>
                                    <div class="controls">
                                        <select id="ilstdependenciabus" class="span7" name="Dependencia de Personal"> 
                                            <option value="-1" selected="">Todos</option>
                                            <option value="ALCALDIA">Alcaldia</option>
                                            <option value="ENCARGADO">Encargado(a)</option>
                                            <option value="ESTADAL">Estadal</option>
                                            <option value="NACIONAL">Nacional</option>
                                            <option value="OTRO">Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal2"></div>
                            <a class="btn btn-primary" id="guardar" onclick="buscarPerxDep();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabPer(2);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="condicion">
                        <form class="form-inline" id="formBusCond">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="ilstcondicionbus">Condici&oacute;n</label>
                                    <div class="controls">
                                        <select id="ilstcondicionbus" class="span7" name="Condicion de Personal"> 
                                            <option value="-1" selected="">Todos</option>
                                            <option value="COLABORADOR">Colaborador</option>
                                            <option value="INTERINO">Interino</option>
                                            <option value="SUPLENTE">Suplente</option>
                                            <option value="TITULAR">Titular</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal3"></div>
                            <a class="btn btn-primary" id="guardar" onclick="buscarPerxCond();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabPer(3);">
                                <i class="icon-trash icon-white"></i>
                                    Limpiar
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="cedula">
                        <form class="form-inline" id="formBusCedu">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="itxtcedbus">C&eacute;dula:</label>
                                    <div class="controls">
                                        <input id="itxtcedbus" name="C&eacute;dula a buscar" placeholder="Ingrese una c&eacute;dula"  size="50px" type="text" maxlength="8" autofocus>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <div class="form-actions">
                            <div id="contmsjmodal3"></div>
                            <a class="btn btn-primary" id="guardar" onclick="buscarPerxCed();">
                                <i class="icon-search icon-white"></i>
                                    Buscar
                            </a>
                            <a class="btn btn-primary" id="limpiar" onclick="limpiarTabPer(4);">
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
                            <th>C&eacute;dula</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Dependencia</th>
                            <th>Condici&oacute;n</th>
                            <th style="text-align: center">Editar</th>
                            <th style="text-align: center;">Eliminar <input type="checkbox" id="elico" title="Seleccionar todos" onclick="verSel('all');"></th>
                        </tr>
                    </thead>
                    <tbody id="contCon"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="eliminarPers" data-toggle="confirmation" data-title="Seguro desea eliminar los registros seleccionados?">
                    <i class="icon-remove icon-white"></i>
                        Eliminar
                </a>
                <a class="btn btn-primary" id="imprimirPers">
                    <i class="icon-print icon-white"></i>
                        Imprimir
                </a>
                <a href="#" id="cerrar" class="btn" data-dismiss="modal">Cerrar</a>
            </div>
        </div>
        <!--FIN MENSAJE MODAL-->
        <script>
            document.getElementById('itxtnrodocumento').focus();
                      
            $('a[data-toggle="tab"]').on('shown', function (e) {
                $("#contmsjmodal1").empty();
                $("#contmsjmodal2").empty();
                $("#contmsjmodal3").empty();
                $("#contmsjmodal4").empty();
//                $("#contmsjmodal4").empty();
                xGetElementById('ilstcargobus').value = -1;
                xGetElementById('ilstdependenciabus').value = -1;
                xGetElementById('ilstcondicionbus').value = -1;
                xGetElementById('itxtcedbus').value = '';
                cargarTodosPer();
            })
            $('[data-toggle="confirmation"]').confirmation(
                {
                    
                    "placement" : "top",
                    "btnOkLabel" : '<i class="icon-ok-sign icon-white"></i> Si',
                    "btnOkClass" : "btn-primary",
                    "onConfirm" : function(){eliminarPer();}
                    
                }
            );
        </script>
          