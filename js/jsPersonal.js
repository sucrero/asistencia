var idPer = '';
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
//                            doc.disabled = true;
//                            nom.disabled = true;
//                            ape.disabled = true;
//                            cor.disabled = true;
//                            tel.disabled = true;
//                            car.disabled = true;
//                            hor.disabled = true;
//                            dep.disabled = true;
//                            con.disabled = true;
                            doc.value = resp['cedper'];
                            nom.value = resp['nomper'];
                            ape.value = resp['apeper'];
                            cor.value = resp['emailper'];
                            tel.value = resp['telfper'];
                            car.value = resp['cargo'];
                            hor.value = resp['h']['idhor'];
                            dep.value = resp['dependencia'];
                            con.value = resp['condicion'];
                            idPer = resp['idper'];
                            nom.focus();
                        }else{
                            nom.disabled = false;
                            ape.disabled = false;
                            cor.disabled = false;
                            tel.disabled = false;
                            car.disabled = false;
                            hor.disabled = false;
                            dep.disabled = false;
                            con.disabled = false;
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
    if(val_Email('txtemail')){
        if(valTelf('txttelefono')){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'guardarPer','doc':doc.value,'nom':nom.value,'ape':ape.value,'cor':cor.value,'tel':tel.value,'car':car.value,'idPer':idPer,'hor':hor.value,'dep':dep.value,'con':con.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        var resp = eval("(" + req.responseText + ")");
                        if(resp == 1){
                            limpiarFormPer('formPersonal');
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
//    $("a#guardar").attr("onclick","valForm('formConsulta','guardarPer(\'g\')');");
    $("a#guardar").attr("onclick","valForm('formPersonal','guardarPer()');");
    idPer = '';
    nom.disabled = true;
    ape.disabled = true;
    cor.disabled = true;
    tel.disabled = true;
    car.disabled = true;
    hor.disabled = true;
    dep.disabled = true;
    con.disabled = true;
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
                            onclick: 'cargarPer("'+resp[i]['idper']+'");',
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
        $("a#imprimirPer").attr("onclick","window.open('reporte_con.php?parametro="+param+"&tipo="+tipo+"','reportepersonal','_blank');")
                .removeClass("disabled");
        $("a#eliminarPer").removeClass("disabled");
    }else{
        $("a#imprimirPer").addClass("disabled")
                .attr("onclick","");
        $("a#imprimirPer").addClass("disabled")
                .removeAttr("onclick");
        $("#contCon").append($("<tr>")
                      .addClass("error alert-error")
                      .append($("<td>")
                         .attr("colspan","6")
                         .append($("<h5>")
                             .text("No existen registros para mostrar")
                         )
                      )
                      .attr("title","No existen registros para mostrar")
                      .attr("id","consulta")
         );
    }
}

function buscarxTipo(){//fino
    var tipo = xGetElementById('ilsttipobus');
    $("#contmsjmodal1").empty();
    if(tipo.value != -1){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'buscarxTipo','tip':tipo.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    resp = eval("(" + req.responseText + ")");
                    crearTablaPer(req.responseText,1,tipo.value);
                }
            }
        )
    }else{
        cad[0] = "Debe seleccionar un tipo para buscar";
        claseError('#contmsjmodal1',cad,'error');
    }
}

//function buscarxFechCon(){
//    $("#contmsjmodal2").empty();
//    var fe1 = xGetElementById('dp1');
//    var fe2 = xGetElementById('dp2');
//    if(fe1.value != '' && fe2.value != ''){
//        if(compararFechas2(fe1.value,fe2.value)){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarxFechCon','fe1':fe1.value,'fe2':fe2.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                         crearTablaCon(req.responseText,2,fe1.value+' '+fe2.value);
//                    }
//                }
//            )
//        }else{
//            cad[0] = "La fecha de inicio debe ser mayor a la final";
//            claseError('#contmsjmodal2',cad,'error');
//        }
//    }else{
//        cad[0] = "Debe ingresar un las fechas para poder buscar";
//        claseError('#contmsjmodal2',cad,'error');
//    }
//}
//
//function buscarxPalabra(){
//    $("#contmsjmodal3").empty();
//    var pal = xGetElementById('itxtpalabrabus');
//    if(pal.value != ''){
//        AjaxRequest.post(
//            {
//                'parameters':{'opcion':'buscarxPalabra','pal':pal.value},
//                'url':'../Operaciones.php',
//                'onSuccess':function(req){
//                     crearTablaCon(req.responseText,3,pal.value);
//                }
//            }
//        )
//    }else{
//        cad[0] = "Debe ingresar una palabra para buscar";
//        claseError('#contmsjmodal3',cad,'error');
//    }
//        
//}
//
//function buscarxOperCon(){
//    $("#contmsjmodal4").empty();
//    var ced = xGetElementById('itxtcedope');
//    if(ced.value != ''){
//        if(validarNumero(ced)){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarxOperCon','ced':ced.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                         crearTablaCon(req.responseText,4,ced.value);
//                    }
//                }
//            )
//        }else{
//            cad[0] = "Formato de documento incorrecto";
//            cad[1] = "El formato de la Cédula debe contener de 6 a 8 dígitos numéricos";
//            claseError('#contmsjmodal4',cad,'error');
//        }
//    }else{
//        cad[0] = "Debe ingresar un R.I.F ó una Cédula para buscar";
//        claseError('#contmsjmodal4',cad,'error');
//    }
//}

function limpiarTabPer(op){
    if(op == 1){
        var tipo = xGetElementById('ilsttipobus');
        tipo.value = -1;
        tipo.focus();
    }
//    else if(op == 2){
//        var fe1 = xGetElementById('dp1');
//        var fe2 = xGetElementById('dp2');
//        fe1.value = fe2.value = fechaActual();
//    }else if(op == 3){
//        var pal = xGetElementById('itxtpalabrabus');
//        pal.value = '';
//        pal.focus();
//    }else{
//        var ced = xGetElementById('itxtcedope');
//        ced.value = '';
//        ced.focus();
//    }
    cargarTodosPer();
}

function eliminarPer(){//fino
    
    $("a#eliminarPer").confirmation('hide');
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
                    cad[0] = "Registro(s) eliminado(s) exisotamente";
                 }else{
                    clase = "error";
                    cad[0] = "No se pudo eliminar el registro";
                 }
            }
        })
    }else{
        clase = "error";
        cad[0] = "No se ha seleccionado ningun registro para eliminar";
    }
    claseError('#contmsj',cad,clase);  
}

function cargarPer(codigo){
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var cor = xGetElementById('txtemail');
    var tel = xGetElementById('txttelefono');
    var car = xGetElementById('ilstcargo');
    var hor = xGetElementById('ilsthorario');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    
    if(codigo != ''){
        mod = codigo;
        AjaxRequest.post(
            {
                'parameters':{'opcion':'buscarPerMod','cod':codigo},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    resp = eval("(" + req.responseText + ")");
                    if(resp != 0){
                        nom.value = resp['nomper'];
                        ape.value = resp['apeper'];
                        cor.value = resp['emailper'];
                        tel.value = resp['telfper'];
                        car.value = resp['cargo'];
                        hor.value = resp['h']['idhor'];
                        dep.value = resp['dependencia'];
                        con.value = resp['condicion'];
                    }
                    $("a#guardar").attr("onclick","valForm('formPersonal','modificarPer()');");
                }
            }
        )
    }else{
        alert('no entro');
    }
}

//function modificarCon(){
//    var docTit = xGetElementById('itxtnrodocumento');
//    var nomTit = xGetElementById('itxtnombre');
//    var apeTit = xGetElementById('itxtapellido');
//    var con = xGetElementById('itxtconsulta');
//    
//    AjaxRequest.post(
//        {
//            'parameters':{'opcion':'modificarCon','docTit':docTit.value,'nomTit':nomTit.value,'apeTit':apeTit.value,'con':con.value,'idPer':idPer,'cod':mod},
//            'url':'../Operaciones.php',
//            'onSuccess':function(req){
//                var resp = eval("(" + req.responseText + ")");
//                if(resp == 1){
//                    limpiarFormCon('formConsulta');
//                    clase = "exito";
//                    cad[0] = "Registro modificado exitosamente";
//                    numRegistroCon();
//                }else{
//                    clase = "error";
//                    cad[0] = "No se pudo modificar el registro";
//                }
//                claseError('#contmsj',cad,clase);
//            }
//        }
//    ) 
//}