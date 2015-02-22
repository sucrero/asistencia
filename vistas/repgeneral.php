<form class="well form-inline" id="formRepGeneral" role="form">
    <fieldset>
        <legend>Reporte General
            <div class="pull-right">
                <a class="btn btn-primary" href="index.php">
                    <i class="icon-home icon-white"></i>
                        Inicio
                </a>
            </div>
        </legend>
        <div id="contmsj2"></div>         
                    
        <!--<legend><h1><small><b>Seleccione las fechas para generar el reporte</b></small></h1></legend>-->

         <div class="control-group">
            <div class="row">
                <div class="span11 offset1">
                    <label class="control-label span2" for="ilstmeses">Mes:</label>
                    <div class="controls">
                        <select id="ilstmeses" class="span3" name="Meses"> 
                            <option value="-1">Seleccione...</option>
                            <?php 
                                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                                for($i = 0;$i < count($meses);$i++){
                                    if($i == (date('n')-1)){
                                        echo '<option value="'.($i+1).'" selected="">'.$meses[$i].'</option>';
                                    }else{
                                        echo '<option value="'.($i+1).'">'.$meses[$i].'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <label for="ilstanio">A&ntilde;o:</label>
                        <select id="ilstanio" class="span2" name="anio"> 
                            <?php
                                $base = 2015;
                                $anio = date("Y");
                                for($i = 0;$i <= ($anio - $base); $i++){
                                    if($anio == date("Y"))
                                        echo '<option value="'.$anio.'" selected="">'.$anio.'</option>';
                                    else
                                        echo '<option value="'.$anio.'">'.$anio.'</option>';
                                    $anio = $anio - 1;
                                }
                            ?>
                            
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="row">
                <div class="span11 offset1">
                    <label class="control-label span2" for="ilstcargo">Cargo:</label>
                    <div class="controls">
                        <select id="ilstcargo" class="span5" name="Tipo de Personal"> 
                            <option value="TODOS" selected="">Todos</option>
                            <option value="ADMINISTRATIVO">Administrativo</option>
                            <option value="DIRECTIVO">Directivo</option>
                            <option value="DOCENTE">Docente</option>
                            <option value="OBRERO">Obrero</option>
                            <option value="MADRE PROCESADORA">Madre Procesadora</option>
                            <option value="VIGILANTE">Vigilante</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="row">
                <div class="span11 offset1">
                    <label class="control-label span2" for="ilstdependencia">Dependencia:</label>
                    <div class="controls">
                        <select id="ilstdependencia" class="span5" name="Tipo de Personal"> 
                            <option value="TODOS" selected="">Todos</option>
                            <option value="ALCALDIA">Alcald&iacute;a</option>
                            <option value="ENCARGADO">Encargado(a)</option>
                            <option value="ESTADAL">Estadal</option>
                            <option value="NACIONAL">Nacional</option>
                            <option value="OTRO">Otro</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
         <div class="control-group">
            <div class="row">
                <div class="span11 offset1">
                    <label class="control-label span2" for="ilstcondicion">Condici&oacute;n:</label>
                    <div class="controls">
                        <select id="ilstcondicion" class="span5" name="Tipo de Personal"> 
                            <option value="TODOS" selected="">Todos</option>
                            <option value="COLABORADOR">Colaborador</option>
                            <option value="INTERINO">Interino</option>
                            <option value="SUPLENTE">Suplente</option>
                            <option value="TITULAR">Titular</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div id="contmsj"></div>
            <div class="form-actions span12">
                <a class="btn btn-primary offset3" id="imprimirTie" onclick="reporteGenAsistencia();">
                    <i class="icon-print icon-white"></i>
                        Imprimir
                </a>
            </div>
                    
    </fieldset>
</form>

        <script>
            $(function(){
                        $('#fecharg1').datepicker();
                        $('#fecharg2').datepicker();
            });
        </script>
          