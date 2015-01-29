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
                    
        <legend><h1><small><b>Seleccione las fechas para generar el reporte</b></small></h1></legend>

        <div class="control-group">
            <div class="row">
                <div class="span11 offset1">
                    <div class="offset2 span3">
                        <label class="control-label" for="dp1">Desde:</label>
                        <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="fecharg1"/>
                    </div>
                    <div class="offset2 span3">
                        <label class="control-label" for="dp2">Hasta:</label>
                        <input type="text" class="span8" value="<?php echo date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy" id="fecharg2"/>
                    </div>
                </div>
            </div>
        </div>

        <div id="contmsj"></div>
            <div class="form-actions span12">
                <a class="btn btn-primary offset3" id="imprimirTie" onclick="imprimirRepGen();">
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
          