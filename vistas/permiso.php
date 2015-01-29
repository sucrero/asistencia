<form class="well form-inline" id="formPermiso">
                <fieldset>
                  <legend>Registro de Permiso
                  <div class="pull-right">
                    <a class="btn btn-primary" href="index.php">
                        <i class="icon-home icon-white"></i>
                            Inicio
                    </a>
                  </div>
                  </legend>
                    <div class="control-group">
                        <div class="row">
                            <div class="span8 offset2">
                                <label for="ilstpersonal">Persona:</label>
                                <div class="input-append controls">
                                    <?php
                                        include_once '../conexion/conexion.php';
                                        include_once '../clases/Personal.php';
                                        $objPer = new Personal();
                                        $consulta =  $objPer->buscar("SELECT * FROM personal", $conexion);
                                        if($conexion){
                                            if($consulta){
                                               if($conexion->registros > 0){
                                                  echo'<select id="ilstpersonal" name="Fiscal">';
                                                  echo '<option value="-1">Seleccione...</option>';
                                                  $i = 0;
                                                  do{
                                                     $fila = $conexion->devolver_recordset();
                                                     echo '<option value="'.$fila['idper'].'">'.htmlentities(ucwords(strtolower($fila['nomper'].' '.$fila['apeper'])),ENT_QUOTES,'UTF-8').'</option>';
                                                     $i++;
                                                  }while(($conexion->siguiente())&&($i!=$conexion->registros));

                                               }else{
                                                   echo'<select id="ilstpersonal" disabled class="span8">';
                                                   echo '<option value="-1">No se encontraron registros...</option>';
                                               }
                                            }else{
                                                echo'<select id="ilstpersonal" disabled class="span8">';
                                                echo '<option value="-1">No se encontraron registros...</option>';
                                            }
                                            echo'</select>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="row">
                            <div class="span8 offset2">
                                <label for="ilstpersonal">Tipo de Permiso:</label>
                                <div class="input-append controls">
                                    <?php
                                        include_once '../conexion/conexion.php';
                                        include_once '../clases/Permiso.php';
                                        $objPerm = new Permiso();
                                        $consulta =  $objPerm->buscar("SELECT * FROM permiso", $conexion);
                                        if($conexion){
                                            if($consulta){
                                               if($conexion->registros > 0){
                                                  echo'<select id="ilstpermiso" name="Permiso">';
                                                  echo '<option value="-1">Seleccione...</option>';
                                                  $i = 0;
                                                  do{
                                                     $fila = $conexion->devolver_recordset();
                                                     echo '<option value="'.$fila['idper'].'">'.htmlentities(ucwords(strtolower($fila['descper'])),ENT_QUOTES,'UTF-8').'</option>';
                                                     $i++;
                                                  }while(($conexion->siguiente())&&($i!=$conexion->registros));

                                               }else{
                                                   echo'<select id="ilstpermiso" disabled class="span8">';
                                                   echo '<option value="-1">No se encontraron registros...</option>';
                                               }
                                            }else{
                                                echo'<select id="ilstpermiso" disabled class="span8">';
                                                echo '<option value="-1">No se encontraron registros...</option>';
                                            }
                                            echo'</select>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="row">
                            <div class="span11 offset2">
                                <div class="span3">
                                    <label class="control-label" for="dp1">Desde:</label>
                                    <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="fecharg1"/>
                                </div>
                                <div class="offset1 span3">
                                    <label class="control-label" for="dp2">Hasta:</label>
                                    <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="fecharg2"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="row">
                            <div class="span8 offset2">
                                <label for="itxtdescrip">Descripci&oacute;n del permiso:</label>
                                <div class="input-append controls">
                                    <textarea class="input-xlarge" rows="2" id="itxtdescrip" placeholder="Ingrese la descripci&oacute;n del permiso" name="Descripci&oacute;n"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="contmsj2"></div>
            
                    <div class="form-actions">
                        <a class="btn btn-primary" id="guardar" onclick="valForm('formPermiso','guardarPerm(\'g\')');">
                            <i class="icon-ok-sign icon-white"></i>
                                Guardar
                        </a>
                        <a id="openBtn" class="btn btn-primary"  onclick="cargarTodosPerm();">
                            <i class="icon-eye-open icon-white"></i>
                                Mostrar
                        </a>
                        <a class="btn btn-primary" id="limpiar" onclick="limpiarFormPerm();">
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
            <h3>Permisos Registrados</h3>
            </div>
            <div class="modal-body">
               
                <table class="table table-hover table-bordered">
                    <thead style="text-align: center;">
                        <tr>
                            <th style="text-align: center">Item</th>
                            <th style="text-align: center">C&eacute;dula</th>
                            <th style="text-align: center">Persona</th>
                            <th style="text-align: center">Descripci&oacute;n</th>
                            <th style="text-align: center">Desde</th>
                            <th style="text-align: center">Hasta</th>
                            <th style="text-align: center">Editar</th>
                            <th style="text-align: center;">Eliminar <input type="checkbox" id="elico" title="Seleccionar todos" onclick="verSel('all');"></th>
                            
                        </tr>
                    </thead>
                    <tbody id="contPerm"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="eliminarCor" data-toggle="confirmation" data-title="Seguro desea eliminar los registros seleccionados?">
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
//          document.getElementById('ilstpersonal').focus();
            $(function(){
                        $('#fecharg1').datepicker();
                        $('#fecharg2').datepicker();
            });

                
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
                    "btnOkClass" : "btn-primary",
                    "onConfirm" : function(){eliminarHor();}
                    
                }
            );
//            $('#eliminarCor').confirmation('onComplete',function(){
//                eliminarCor(1,2);
//            });

        </script>
          