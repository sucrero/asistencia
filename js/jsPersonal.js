var idPer = '';
var cedPer = '';
var ids = '';
var mod = '';

function accionPerCon(event,tipo){
    if(event.keyCode == 13){
        buscarPerCon(tipo);
    }
}
function buscarPer(){ //fina
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var cor = xGetElementById('txtemail');
    var tel = xGetElementById('txttelefono');
    var car = xGetElementById('ilstcargo');
    var hor = xGetElementById('ilsthorario');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var sta = xGetElementById('ilststatus');
    $("#contmsj2").empty("");
    nom.value = "";
    ape.value = "";
    cor.value = "";
    tel.value = "";
    if(doc.value != ''){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarPer','doc':doc.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        var resp = eval("(" + req.responseText + ")");
                        if(resp != 2){
                            clase = "error";
                            cad[0] = "Cedula registrada, verifique";
                            claseError('#contmsj2',cad,clase);
                            doc.value = '';
                            doc.focus();
                        }else{
                            nom.disabled = false;
                            ape.disabled = false;
                            cor.disabled = false;
                            tel.disabled = false;
                            car.disabled = false;
                            hor.disabled = false;
                            dep.disabled = false;
                            con.disabled = false;
                            sta.disabled = false;
                            nom.focus();
                        }
                    }
                }
            )
        
    }else{
        cad[0] = "Debe ingresar una Cédula para buscar";
        claseError('#contmsj2',cad,'error');
    }
}

function guardarPer(){//fina
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var cor = xGetElementById('txtemail');
    var tel = xGetElementById('txttelefono');
    var car = xGetElementById('ilstcargo');
    var hor = xGetElementById('ilsthorario');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var sta = xGetElementById('ilststatus');
    if(val_Email('txtemail')){
        if(valTelf('txttelefono')){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'guardarPer','doc':doc.value,'nom':nom.value,'ape':ape.value,'cor':cor.value,'tel':tel.value,'car':car.value,'idPer':idPer,'hor':hor.value,'dep':dep.value,'con':con.value,'sta':sta.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        var resp = eval("(" + req.responseText + ")");
                        if(resp == 1){
                            limpiarFormPer();
                            clase = "exito";
                            cad[0] = "Registro guardado exitosamente";
                            claseError('#contmsj',cad,clase);
                        }else{
                            clase = "error";
                            cad[0] = "No se pudo guarda el registro";
                            claseError('#contmsj',cad,clase);
                        }

                    }
                }
            ) 
        }else{
            clase = "error";
            cad[0] = "Formato de telefono invalido. Debe contener 11 digitos numericos, verifique";
            claseError('#contmsj',cad,clase);
        }
    }else{
        clase = "error";
        cad[0] = "Formato de correo invalido, verifique";
        claseError('#contmsj',cad,clase);
    }
}
function limpiarFormPer(){//fina
    var objForm = xGetElementById('formPersonal');
    var objFoco = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var cor = xGetElementById('txtemail');
    var tel = xGetElementById('txttelefono');
    var car = xGetElementById('ilstcargo');
    var hor = xGetElementById('ilsthorario');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var sta = xGetElementById('ilststatus');
    var nroElement = objForm.length;
    for(i=0;i<nroElement;i++){
        if(objForm.elements[i].type == 'text' || objForm.elements[i].type == 'textarea' || objForm.elements[i].type == 'password'){
            objForm.elements[i].value = "";
        }
    }
    car.value = -1;
    dep.value = -1;
    hor.value = -1;
    con.value = -1;
    sta.value = -1;
//    $("a#guardar").attr("onclick","valForm('formConsulta','guardarPer(\'g\')');");
    $("a#guardar").attr("onclick","valForm('formPersonal','guardarPer()');");
    $("a#btnbuscarper").attr("onclick","buscarPer();")
                .removeClass("disabled");
    idPer = '';
    nom.disabled = true;
    ape.disabled = true;
    cor.disabled = true;
    tel.disabled = true;
    car.disabled = true;
    hor.disabled = true;
    dep.disabled = true;
    con.disabled = true;
    sta.disabled = true;
    objFoco.disabled = false;
    objFoco.focus();
}

function cargarTodosPer(){//fina
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarTodosPer'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 crearTablaPer(req.responseText,-1,-1);
            }
        }
    )
    $("#myModal").modal({                           
        "backdrop" : "static",
        "keyboard" : true,
        "show" : true // this parameter ensures the modal is shown immediately
    });
}

function crearTablaPer(req,tipo,param){//fina
    resp = eval("(" + req + ")");
    ids = '';
    $("#contCon").empty();
    if(resp != 0){
        for(var i = 0;i < resp.length; i++){
//            if(ids == ''){
                ids = resp[i]['idper'];
//            }else{
//                ids = ids+','+resp[i]['idconsulta'];
//            }
            if(i % 2 == 0){
                clase = "info";
            }else{
                clase = "";
            }
            $("#contCon").append($("<tr>")
                     .css("cursor", "pointer")
                     .addClass(clase)
                     .append($("<td>")
                         .attr("style", "text-align: center; font-weight: bold;")
                         .text(i+1)
                     )
                     .append($("<td>")
                         .text(resp[i]['cedper'])
                     )
                     .append($("<td>")
                         .attr("valign", "middle")
                         .text(capitalizar(resp[i]['nomper']+' '+resp[i]['apeper']))
                     )
                     
                     .append($("<td>")
                         .text(capitalizar(resp[i]['cargo']))
                     )
                    .append($("<td>")
                         .text(capitalizar(resp[i]['dependencia']))
                     )
                    .append($("<td>")
                         .text(capitalizar(resp[i]['condicion']))
                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('i')).attr({
                            onclick: 'cargarPer('+JSON.stringify(resp[i])+');',
                            class: 'icon-edit'
                        })
                        .attr("data-dismiss","modal")
                        )
                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('input')).attr({
                            name: 'eli_ch[]',
                            value: resp[i]['idper'],
                            type: 'checkbox'
                        })

                        )
                     )
//                     .attr("onclick","cargarUsu("+JSON.stringify(resp[i])+")")
//                     .attr("data-dismiss", "modal")
                     .attr("title","Personal")
                     .attr("id","personal")
                 );
        }
        $("a#imprimirPers").attr("onclick","window.open('reporte_pers.php?parametro="+param+"&tipo="+tipo+"','reportepersonal','_blank');")
                .removeClass("disabled");
        $("a#eliminarPers").removeClass("disabled");
    }else{
        $("a#eliminarPers").addClass("disabled")
                .removeAttr("onclick");
        $("a#imprimirPers").addClass("disabled")
                .removeAttr("onclick");
        $("#contCon").append($("<tr>")
                      .addClass("error alert-error")
                      .append($("<td>")
                         .attr("colspan","8")
                         .append($("<h5>")
                             .text("No existen registros para mostrar")
                         )
                      )
                      .attr("title","No existen registros para mostrar")
                      .attr("id","personal")
         );
    }
}

function buscarPerxCargo(){//fino
    var cargo = xGetElementById('ilstcargobus');
    $("#contmsjmodal1").empty();
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarxCargo','car':cargo.value},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                resp = eval("(" + req.responseText + ")");
                crearTablaPer(req.responseText,1,cargo.value);
            }
        }
    )
}

function buscarPerxDep(){
    var depen = xGetElementById('ilstdependenciabus');
    $("#contmsjmodal2").empty();
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarxDepen','depen':depen.value},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                resp = eval("(" + req.responseText + ")");
                crearTablaPer(req.responseText,2,depen.value);
            }
        }
    )
}

function buscarPerxCond(){
    var cond = xGetElementById('ilstcondicionbus');
    $("#contmsjmodal3").empty();
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarxCond','cond':cond.value},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                resp = eval("(" + req.responseText + ")");
                crearTablaPer(req.responseText,3,cond.value);
            }
        }
    )
}

function buscarPerxCed(){
    var ced = xGetElementById('itxtcedbus');
    $("#contmsjmodal4").empty();
    if(ced.value != ''){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'buscarPerxCed','ced':ced.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    resp = eval("(" + req.responseText + ")");
                    crearTablaPer(req.responseText,4,ced.value);
                }
            }
        )
    }else{
        clase = "error";
        cad[0] = "Debe ingresar una cedula para buscar, verifique";
        claseError('#contmsj',cad,clase);  
    }
    
}

function limpiarTabPer(op){
    if(op == 1){
        var tipo = xGetElementById('ilstcargobus');
        tipo.value = -1;
        tipo.focus();
    }else if(op == 2){
        var dep = xGetElementById('ilstdependenciabus');
        dep.value = -1;
        dep.focus();
    }else if(op == 3){
        var cond = xGetElementById('ilstcondicionbus');
        cond.value = -1;
        cond.focus();
    }else{
        var ced = xGetElementById('itxtcedbus');
        ced.value = '';
        ced.focus();
    }
    cargarTodosPer();
}

function eliminarPer(){//fino
    
    $("a#eliminarPers").confirmation('hide');
    $("#myModal").modal('hide');
    var checkboxValues = "";
    $('input[name="eli_ch[]"]:checked').each(function() {
            checkboxValues += $(this).val() + ",";
    });
    checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
    if(checkboxValues != ''){
        AjaxRequest.post(
        {
            'parameters':{'opcion':'eliminarPer','param':checkboxValues},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 if(req.responseText == 1){
                    clase = "exito";
                    cad[0] = "No se eliminaron algunos registros, poseen registros asociados";
                    claseError('#contmsj',cad,clase);  
                }else if(req.responseText == 2){
                    clase = "exito";
                    cad[0] = "Registros eliminados exitosamente";
                    claseError('#contmsj',cad,clase);  
                 }else if(req.responseText == 3){
                    clase = "error";
                    cad[0] = "No se elimino ningun registros, poseen registros asociados";
                    claseError('#contmsj',cad,clase);  
                 }else{
                    clase = "error";
                    cad[0] = "No selecciono ningun registro para eliminar";
                    claseError('#contmsj',cad,clase);
                 }
            }
        })
    }else{
        clase = "error";
        cad[0] = "No se ha seleccionado ningun registro para eliminar";
        claseError('#contmsj',cad,clase);  
    }
}

function cargarPer(datos){//fina
    var ced = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var cor = xGetElementById('txtemail');
    var tel = xGetElementById('txttelefono');
    var car = xGetElementById('ilstcargo');
    var hor = xGetElementById('ilsthorario');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var sta = xGetElementById('ilststatus');
    if(datos != ''){
        idPer = datos['idper'];
        ced.value = cedPer = datos['cedper'];
        nom.value = datos['nomper'];
        ape.value = datos['apeper'];
        cor.value = datos['emailper'];
        tel.value = datos['telfper'];
        car.value = datos['cargo'];
        hor.value = datos['h']['idhor'];
        dep.value = datos['dependencia'];
        con.value = datos['condicion'];
        sta.value = datos['status'];
        nom.disabled = false;
        ape.disabled = false;
        cor.disabled = false;
        tel.disabled = false;
        car.disabled = false;
        hor.disabled = false;
        dep.disabled = false;
        con.disabled = false;
        sta.disabled = false;
        ced.focus();
        $("a#guardar").attr("onclick","valForm('formPersonal','modificarPer()');");
        $("a#btnbuscarper").addClass("disabled")
                .removeAttr("onclick");
    }else{
        clase = "error";
        cad[0] = "Debe seleccionar un registro para editarlo";
        claseError('#contmsj',cad,clase);  
    }
}

function modificarPer(){//fina
    var ced = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var cor = xGetElementById('txtemail');
    var tel = xGetElementById('txttelefono');
    var car = xGetElementById('ilstcargo');
    var hor = xGetElementById('ilsthorario');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var sta = xGetElementById('ilststatus');
    if(val_Email('txtemail')){
        if(valTelf('txttelefono')){
           AjaxRequest.post(
                {
                    'parameters':{'opcion':'modificarPer','ced':ced.value,'nom':nom.value,'ape':ape.value,'cor':cor.value,'tel':tel.value,'car':car.value,'hor':hor.value,'dep':dep.value,'con':con.value,'idPer':idPer,'cedPer':cedPer,'sta':sta.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        var resp = eval("(" + req.responseText + ")");
                        if(resp == 1){
                            limpiarFormPer();
                            clase = "exito";
                            cad[0] = "Registro modificado exitosamente";
                        }else{
                            clase = "error";
                            cad[0] = "No se pudo modificar el registro";
                        }
                        claseError('#contmsj',cad,clase);
                    }
                }
            )  
        }else{
            clase = "error";
            cad[0] = "Formato de telefono invalido. Debe contener 11 digitos numericos, verifique";
            claseError('#contmsj',cad,clase);
        }
    }else{
        clase = "error";
        cad[0] = "Formato de correo invalido, verifique";
        claseError('#contmsj',cad,clase);
    }
}