<!--
<form class="well form-inline" id="formVivienda" role="form">
    
</form>         -->

<form class="well form-inline" id="formVivienda">
    <legend>
        Registro de Vivienda
    </legend>
    
        <div class="control-group">
            <label for="nroregistro">Nro. de Registro</label>
                <div class="input-append" id="numregistrocor">
                    <span class="input-small uneditable-input" id="itxtcodigo"></span>
                </div>
        </div>
    
        <div class="control-group">
            <labelfor="nroregistro">Nro. de Registro</label>
                <div class="input-append" id="numregistrocor">
                    <span class="input-small uneditable-input" id="itxtcodigo"></span>
                </div>
        </div>
    <div class="row"> 
        <div class="control-group offset1 span11 color1">
            <div class="span6">
                <label for="itxtnombre">Nombres</label>
                <input type="text" class="span7 disabled" placeholder="Ingrese un nombre" id="itxtnombre" name="Nombres" onKeyPress="return letras(event);">
            </div>
            <div class="span6">
                <label for="itxtapellido">Apellidos</label>
                <input type="text" class="span7 disabled" placeholder="Ingrese un apellido" id="itxtapellido" name="Apellidos" onKeyPress="return letras(event);">
            </div>
        </div>
    </div>
        <div class="form-actions">
            <a class="btn btn-primary"> 
                <i class="icon-ok-sign icon-white"></i>
                    Guardar
            </a>
            <a class="btn btn-primary"> 
                <i class="icon-ok-sign icon-white"></i>
                    Mostrar
            </a>
        </div>
</form>