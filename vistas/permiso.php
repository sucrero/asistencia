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
                            <div class="span10 offset2">
                                <div class="span3">
                                    <label for="ilstpersonal">Persona:</label>
                                </div>
                                
                                <div class="input-append controls span9">
                                    <?php
                                        include_once '../conexion/conexion.php';
                                        include_once '../clases/Personal.php';
                                        $objPer = new Personal();
                                        $consulta =  $objPer->buscar("SELECT * FROM personal", $conexion);
                                        if($conexion){
                                            if($consulta){
                                               if($conexion->registros > 0){
                                                  echo'<select id="ilstpersonal" name="Fiscal"  class="span7">';
                                                  echo '<option value="-1">Seleccione...</option>';
                                                  $i = 0;
                                                  do{
                                                     $fila = $conexion->devolver_recordset();
                                                     echo '<option value="'.$fila['idper'].'">'.$fila['cedper'].' - '.htmlentities(ucwords(strtolower($fila['nomper'].' '.$fila['apeper'])),ENT_QUOTES,'UTF-8').'</option>';
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
                            <div class="span10 offset2">
                                <div class="span3">
                                    <label for="ilstpersonal">Tipo de Permiso:</label>
                                </div>
                                <div class="input-append controls span9">
                                    <?php
                                        include_once '../conexion/conexion.php';
                                        include_once '../clases/Permiso.php';
                                        $objPerm = new Permiso();
                                        $consulta =  $objPerm->buscar("SELECT * FROM permiso", $conexion);
                                        if($conexion){
                                            if($consulta){
                                               if($conexion->registros > 0){
                                                  echo'<select id="ilstpermiso" name="Permiso"  class="span7">';
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
                            <div class="span10 offset2">
                                <div class="span1">
                                    <label class="control-label" for="dp1">Desde:</label>
                                </div>
                                <div class="span3"> 
                                    <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="fecharg1"/>
                                </div>
                                <div class="span1">
                                    <label class="control-label" for="dp2">Hasta:</label>
                                </div>
                                <div class="span3">
                                    <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="fecharg2"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="row">
                            <div class="span10 offset2">
                                <div class="span3">
                                    <label for="itxtdescrip">Descripci&oacute;n del permiso:</label>
                                </div>
                                <div class="span6">
                                    <textarea class="span10" rows="2" id="itxtdescrip" placeholder="Ingrese la descripci&oacute;n del permiso" name="Descripci&oacute;n"></textarea>
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
                <ul id="tab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#reporte" data-toggle="tab">B&uacute;squeda: </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="reporte">
                        <form class="form-inline" id="formBusPermi">
                            <fieldset>
                                <div class="control-group">
                                    <div class="row">
                                        <div class="offset1 span7">
                                            <label class="control-label" for="ilstpermisobus">Tipo Permiso:</label>
                                            <!--<div class="controls">-->
                                                <?php
                                                    include_once '../conexion/conexion.php';
                                                    include_once '../clases/Permiso.php';
                                                    $objPerm = new Permiso();
                                                    $consulta =  $objPerm->buscar("SELECT * FROM permiso", $conexion);
                                                    if($conexion){
                                                        if($consulta){
                                                           if($conexion->registros > 0){
                                                              echo'<select id="ilstpermisobus" name="Permiso" class="span5">';
                                                              echo '<option value="-2">Todos</option>';
                                                              $i = 0;
                                                              do{
                                                                 $fila = $conexion->devolver_recordset();
                                                                 echo '<option value="'.$fila['idper'].'">'.htmlentities(ucwords(strtolower($fila['descper'])),ENT_QUOTES,'UTF-8').'</option>';
                                                                 $i++;
                                                              }while(($conexion->siguiente())&&($i!=$conexion->registros));

                                                           }else{
                                                               echo'<select id="ilstpermisobus" disabled class="span8">';
                                                               echo '<option value="-1">No se encontraron registros...</option>';
                                                           }
                                                        }else{
                                                            echo'<select id="ilstpermisobus" disabled class="span8">';
                                                            echo '<option value="-1">No se encontraron registros...</option>';
                                                        }
                                                        echo'</select>';
                                                    }
                                                ?>
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="row">
                                        <div class="offset1 span2">
                                            <label class="control-label" for="dp1">Desde:</label>
                                            <input type="text" class="span8" value="" data-date-format="dd/mm/yyyy" id="dp1"/>
                                        </div>
                                        <div class="span2">
                                            <label class="control-label" for="dp2">Hasta:</label>
                                            <input type="text" class="span8" value="" data-date-format="dd/mm/yyyy" id="dp2"/>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    
                    <div class="form-actions">
                        <div id="contmsjmodal1"></div>
                        <a class="btn btn-primary" id="buscarPer" onclick="buscarRepPer();">
                            <i class="icon-search icon-white"></i>
                                Buscar
                        </a>
                        <a class="btn btn-primary" id="limpiar" onclick="limpiarRepPer();">
                            <i class="icon-trash icon-white"></i>
                                Limpiar
                        </a>
                    </div>
                </div>
                <hr>
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
                <a class="btn btn-primary" id="eliminarPerm" data-toggle="confirmation" data-title="Seguro desea eliminar los registros seleccionados?">
                    <i class="icon-remove icon-white"></i>
                        Eliminar
                </a>
                <a class="btn btn-primary" id="imprimirPerm">
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
                $('#dp1').datepicker();
                $('#dp2').datepicker();
            });
//            tabe = document.getElementById('tab');
                
            $('a[data-toggle="tab"]').on('shown', function (e) {
                
                $("#contmsjmodal1").empty();
                xGetElementById('ilstpermisobus').value = -1;
                xGetElementById('dp1').value = fechaActual();
                xGetElementById('dp2').value = fechaActual();
//                alert("hola = "+tabe.class);
                cargarTodosPerm();
            })
            
            
            
//            $('a[href="permiso"]').click(function (e) {
//                $("a#buscarPer").attr("onclick","qqqqqqqqqqqqqqqqqqqqqq");
//            })
//            
//            $('a[href="fecha"]').click(function (e) {
//                $("a#buscarPer").attr("onclick","fdfvfdvfd");
//            })

//            $('#eliminarCor').confirmation('show');
            $('[data-toggle="confirmation"]').confirmation(
                {
                    
                    "placement" : "top",
                    "btnOkLabel" : '<i class="icon-ok-sign icon-white"></i> Si',
                    "btnOkClass" : "btn-primary",
                    "onConfirm" : function(){eliminarPerm();}
                    
                }
            );

        </script>
          