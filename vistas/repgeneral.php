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
                            <option value="1">Enero</option>
                            <option value="2" selected="">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                        <label for="ilstanio">A&ntilde;o:</label>
                        <select id="ilstanio" class="span2" name="Meses"> 
                            <option value="2015" selected="">2015</option>
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
          