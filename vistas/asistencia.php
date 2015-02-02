<div class="span4 offset4">
    <form id="asistencia" class="well">
        <fieldset>
            <div id="contmsj4"></div>
            <div id="LiveClockIE" style="text-align: center;"></div>
            <legend style="text-align: center;">Registre su N&uacute;mero de C&eacute;dula</legend>
            <input type="text" name="Cedula" maxlength="8" onkeyup="accionAsisReg(event)" class="input-xlarge offset2" style="text-align: center;" id="itxtcedreg" placeholder="Ingrese su n&uacute;mero de c&eacute;dula" autofocus autocomplete="off">
        </fieldset>
        <div class="form-actions" style="text-align: center;">
            <a class="btn btn-primary btn-large" id="guardar" onclick="registrar();">
                    Registrar
            </a>
        </div>
        <br><a onclick="login();">Login</a>
    </form>
</div>
<script type="text/javascript">show_clock();</script>