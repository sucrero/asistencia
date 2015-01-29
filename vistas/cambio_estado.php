<script>cargarTodosNoti(1);</script>
<form class="well form-inline" id="formCambEstado" role="form">
    <fieldset>
        <legend>Cambio de Estado a Notificaci&oacute;n
            <div class="pull-right">
                <a class="btn btn-primary" href="index.php">
                    <i class="icon-home icon-white"></i>
                        Inicio
                </a>
            </div>
        </legend>
        
        
        <ul id="tab" class="nav nav-tabs">
                    <li class="">
                        <a>B&uacute;squeda por: </a>
                    </li>
                    <li class="active">
                        <a href="#fiscal" data-toggle="tab">Fiscal</a>
                    </li>
                    <li class="">
                        <a href="#fecha" data-toggle="tab">Fecha</a>
                    </li>
                    <li class="">
                        <a href="#estado" data-toggle="tab">Estado</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content tabs-stacked">
                    <div class="tab-pane fade active in" id="fiscal">
                        <form class="form-inline" id="formBusNotFiscal">
                            <fieldset>
                                <div class="span12 control-group">
                                    <div class="offset4 span4 input-group-btn">
                                            <?php
                                                include_once '../conexion/conexion.php';
                                                include_once '../clases/Persona.php';
                                                $objPer = new Persona();
                                                $consulta =  $objPer->buscar("SELECT * FROM persona WHERE tipoper='FISCAL'", $conexion);
                                                if($conexion)
                                                {
                                                    if($consulta){
                                                       if($conexion->registros > 0){
                                                          echo'<select id="ilstfiscalbus" name="Fiscal">';
                                                          echo '<option value="-1">Seleccione...</option>';
                                                          $i = 0;
                                                          do{
                                                             $fila = $conexion->devolver_recordset();
                                                             echo '<option value="'.$fila['idpersona'].'">'.htmlentities(strtoupper($fila['nombreper'].' '.$fila['apellidoper']),ENT_QUOTES,'UTF-8').'</option>';
                                                             $i++;
                                                          }while(($conexion->siguiente())&&($i!=$conexion->registros));

                                                       }else{
                                                           echo'<select id="ilstfiscalbus" disabled class="span8">';
                                                           echo '<option value="-1">No se encontraron registros...</option>';
                                                       }
                                                    }else{
                                                        echo'<select id="ilstfiscalbus" disabled class="span8">';
                                                        echo '<option value="-1">No se encontraron registros...</option>';
                                                    }
                                                    echo'</select>';
                                                }
                                            ?>
                                    </div>
                                    <a class="btn btn-default btn-small" id="guardar" onclick="buscarxFisNot(1);">
                                        <i class="icon-search"></i>
                                            Buscar
                                    </a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="fecha">
                        <form class="form-inline" id="formBusNotFec">
                            <fieldset>
                                <div class="span12 control-group">
                                    <div class="offset3 span3">
                                        <label class="control-label" for="dp1">Desde:</label>
                                        <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="dp1"/>
                                    </div>
                                    <div class="span3">
                                        <label class="control-label" for="dp2">Hasta:</label>
                                        <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="dp2"/>
                                    </div>
                                    <a class="btn btn-default btn-small" id="guardar" onclick="buscarxFechNot(1);">
                                        <i class="icon-search"></i>
                                            Buscar
                                    </a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="estado">
                        <form class="form-horizontal" id="formBusNotEst">
                            <fieldset>
                                <div class="span12 control-group">
                                    <div class="offset4 span4 input-group-btn">
                                        <select id="ilstestado">
                                            <option value="-1">Seleccione...</option>
                                            <option value="ASIGNADA">Asignada (A)</option>
                                            <option value="ENTREGADA">Entregada (E)</option>
                                            <option value="NOENTREGADA">No entregada (NE)</option>
                                        </select>
                                    </div>
                                    <a class="btn btn-default btn-small" id="guardar" onclick="buscarxEstNot(1);">
                                        <i class="icon-search"></i>
                                            Buscar
                                    </a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
        
        
        <table class="table table-hover table-bordered">
            <thead style="text-align: center;">
                <tr>
                    <th style="width: 5%; text-align: center;">Item</th>
                    <th style="width: 50%; text-align: center;">Descripci&oacute;n</th>
                    <th style="width: 10%; text-align: center;">Fecha</th>
                    <th style="width: 30%; text-align: center;">Fiscal</th>
                    <th style="width: 5%; text-align: center;">Estado</th>
                </tr>
            </thead>
            <tbody id="contNotEst"></tbody>
        </table>
        <div id="contmsj"></div>
            <div class="form-actions">
                <a class="btn btn-primary" id="guardar" onclick="modNoti();">
                    <i class="icon-ok-sign icon-white"></i>
                        Guardar
                </a>
                <a id="openBtn" class="btn btn-primary"  onclick="cargar_form('notificacion','contenedor');">
                    <i class="icon-share-alt icon-white"></i>
                        Volver
                </a>
            </div>
                    
    </fieldset>
</form>

        <script>
            document.getElementById('ilstfiscalbus').focus();
            $(function(){
                        $('#dp1').datepicker();
                        $('#dp2').datepicker();
            });
                      
            $('a[data-toggle="tab"]').on('shown', function (e) {
//                $("#contmsjmodal1").empty();
//                $("#contmsjmodal2").empty();
//                $("#contmsjmodal3").empty();
                xGetElementById('ilstfiscalbus').value = -1;
                xGetElementById('dp1').value = fechaActual();
                xGetElementById('dp2').value = fechaActual();
                xGetElementById('ilstestado').value = -1;
                cargarTodosNoti(1);
            })
        </script>
          