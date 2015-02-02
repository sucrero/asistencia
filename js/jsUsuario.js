var codusu = '';
var cad = new Array();
var idPer = '';
var tipo = '';
//var usuario = new Array();
function guardarUsuPv(){//fina
    var ced = xGetElementById('itxtcedula');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var cor = xGetElementById('txtemail');
    var tel = xGetElementById('txttelefono');
    var car = xGetElementById('ilstcargo');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var usu = xGetElementById('itxtlogin');
    var cla = xGetElementById('itxtclave');
    var rec = xGetElementById('itxtreclave');
    var tip = xGetElementById('ilsttipo');
    if(val_Email('txtemail')){
        if(valTelf('txttelefono')){
            if(cla.value == rec.value){
                AjaxRequest.post(
                    {
                        'parameters':{'opcion':'guardarUsuPv','ced':ced.value,'nom':nom.value,'ape':ape.value,'cor':cor.value,'tel':tel.value,'car':car.value,'dep':dep.value,'con':con.value,'usu':usu.value,'cla':cla.value,'rec':rec.value,'tip':tip.value},
                        'url':'../Operaciones.php',
                        'onSuccess':function(req){
                            var resp = eval("(" + req.responseText + ")");
                            if(resp == 1){
                                $("#myModal").modal({                           
                                    "backdrop" : "static",
                                    "keyboard" : true,
                                    "show" : true // this parameter ensures the modal is shown immediately
                                })
                                 .on('hidden', function(){
                                        ir('vistas/index.php');
                                });
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
                cad[0] = "Las claves no coinciden, verifique";
                claseError('#contmsj',cad,clase);
            }
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

function validarSesion(){//fina
    var usu = xGetElementById('itxtloginu');
    var cla = xGetElementById('itxtclaveu');
    var resp;
    if(usu.value != '' && cla.value != ''){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'validarSesion','usu':usu.value,'cla':cla.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    resp = eval("(" + req.responseText + ")");
                    if(resp != 0 && resp != 2){
                        ir('vistas/index.php');
                    }else if(resp == 2){
                        cad[0] = "Usuario DESHABILITADO";
                        claseError('#contmsj',cad,'error');
                    }else{
                        cad[0] = "Verifique su Usuario y Contraseña";
                        claseError('#contmsj', cad, 'error');
                    }
                }
            }
        )
    }else{
        cad[0] = "Debe ingresar su Usuario y Contraseña";
        claseError('#contmsj',cad,'error');
    }
}
function accionUsu(event){ //FINA
    if(event.keyCode == 13){
        buscarUsu();
    }
}
function buscarUsu(){ //FINA
    var ced = xGetElementById('itxtcedula');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var car = xGetElementById('ilstcargo');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var usu = xGetElementById('itxtlogin');
    var cla = xGetElementById('itxtclave');
    var rec = xGetElementById('itxtreclave');
    var tip = xGetElementById('ilsttipo');
    if(ced.value != ''){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'buscarUsu','ced':ced.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    resp = eval("(" + req.responseText + ")");
                    if(resp == 0){
//                        $("a#guardar").attr("onclick","valForm('formUsuario','guardarUsu(\\'g\\')');");
//                        desbloquearUsu('formUsuario','itxtnombre','itxtcedula');
                        cad[0] = "No existe ningun personal con la cedula ingresada. Para ello debe ingresar al personal y luego crear su usuario";
                        claseError('#contmsj',cad,'error');
                    }else if (resp == 2){
                        cad[0] = "Esta persona posee un usuario asignado";
                        claseError('#contmsj',cad,'error');
                        ced.value = '';
                        ced.focus();
                    }else{
//                        $("a#guardar").attr("onclick","valForm('formUsuario','guardarUsu(\\'m\\')');");
//                        desbloquearUsu('formUsuario','itxtnombre','itxtcedula');
                        $("#contmsj").empty();
                        idPer = resp['idper'];
                        nom.value = resp['nomper'];
                        ape.value = resp['apeper'];
                        car.value = resp['cargo'];
                        dep.value = resp['dependencia'];
                        con.value = resp['condicion'];
                        usu.value = '';
                        cla.value = '';
                        rec.value = '';
                        tip.value = -1; 
                        usu.disabled = false;
                        cla.disabled = false;
                        rec.disabled = false;
                        tip.disabled = false;
                        usu.focus();
                    }
                }
            }
        )
    }else{
        cad[0] = "Debe ingresar una Cédula para buscar";
        claseError('#contmsj',cad,'error');
    }
}
function desbloquearUsu(formu,foco,noborrar){ //FINA
    var objForm = xGetElementById(formu);
    var objFoco = xGetElementById(foco);
    for(i=0; i<objForm.length;i++){
        if(objForm.elements[i].type == 'text' || objForm.elements[i].type == 'password' || objForm.elements[i].type == 'textarea'){
            objForm.elements[i].disabled = false;
            if(objForm.elements[i].id != noborrar)
                objForm.elements[i].value = "";
        }else if(objForm.elements[i].type == 'select-one'){
            if(objForm.elements[i].id != 'lstrecaudos'){
                objForm.elements[i].disabled = false;
            }else{
                objForm.elements[i].disabled = true;
            }
            objForm.elements[i].value = "-1";
        }
    }
    objFoco.focus();
}

function guardarUsu(op){//fino
    var objForm = xGetElementById('formUsuario');
    var ced = xGetElementById('itxtcedula');
    var usu = xGetElementById('itxtlogin');
    var cla = xGetElementById('itxtclave');
    var tip = xGetElementById('ilsttipo');
    var w = true;
    if(op == 'g'){
        var opcion = 'guardarUsu';
    }else{
        if(confirm("Seguro desea modificar este registro?")){
            w = true;
        }else{
            w= false;
        }
        var opcion = 'modificarUsu';
    }
    if(w){
        AjaxRequest.post(
            {
                'parameters':{'opcion':opcion,'ced':ced.value,'idPer':idPer,'usu':usu.value,'cla':cla.value,'tip':tip.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    var resp = eval("(" + req.responseText + ")");
                    var clase = "error";
                    if(resp == 2){
                        cad[0] = "Nombre de Usuario registrado";
                    }else if(resp == 3){
                        cad[0] = "La persona ya tiene un usuario asignado";
                    }else if(resp == 4){
                        cad[0] = "Ocurrió un error al guardar el registro";
                    }else if(resp == 5){
                        cad[0] = "No se pudo conseguir al usuario";
                    }else if(resp == 6){
                        cad[0] = "La Cédula ingresada pertenece a otro usuario";
                    }else if(resp == 8){
                        cad[0] = "Ha ocurrido un error, informe al administrador";
                    }else if(resp == 9){
                        clase = "exito";
                        cad[0] = "Registro modificado exisotamente";
                        limpiarForm('formUsuario','itxtcedula');
                    }else{
                        clase = "exito";
                        cad[0] = "Registro guardado exitosamente";
                        limpiarForm('formUsuario','itxtcedula');
                    }
                    claseError('#contmsj',cad,clase);
                }
            }
        )
    }
}

function cargarUsu(resp){
    var ced = xGetElementById('itxtcedula');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var car = xGetElementById('ilstcargo');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var usu = xGetElementById('itxtlogin');
    var cla = xGetElementById('itxtclave');
    var rec = xGetElementById('itxtreclave');
    var tip = xGetElementById('ilsttipo');
    codusu = resp['idusuario'];
    tipo = resp['tipousu'];
    ced.value = resp['p']['cedper'];
    nom.value = resp['p']['nomper'];
    ape.value = resp['p']['apeper'];
    car.value = resp['p']['cargo'];
    dep.value = resp['p']['dependencia'];
    con.value = resp['p']['condicion'];
    usu.value = resp['nombreusu'];
    cla.value = "****************";
    rec.value = "****************";
    tip.value = resp['tipousu'];
    ced.disabled = true;
    nom.disabled = true;
    ape.disabled = true;
    car.disabled = true;
    dep.disabled = true;
    con.disabled = true;
    usu.disabled = true;
    cla.disabled = true;
    rec.disabled = true;
    tip.disabled = false;
    tip.focus();
    $("#contmsj").empty();
    $("a#btnbuscarusu").addClass("disabled")
            .attr("onclick","")
    $("a#guardar").attr("onclick","valForm('formUsuario','modUsu()');");
}

function modUsu(){
    var tip = xGetElementById('ilsttipo');
    if(codusu != ''){
        if(tip.value != tipo){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'modificarUsu','codusu':codusu,'tip':tip.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        var resp = eval("(" + req.responseText + ")");
                        if(resp == 1){
                            limpiarFormUsu();
                            clase = "exito";
                            cad[0] = "Registro modificado exisotamente";
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
            cad[0] = "No ha modificado ningun dato";
            claseError('#contmsj',cad,clase);
        }
    }else{
        clase = "error";
        cad[0] = "Debe seleccionar un usuario para modificar";
        claseError('#contmsj',cad,clase);
    }
}

function limpiarFormUsu(){//fina
    codusu = '';
    idPer = '';
    tipo = '';
    $("a#guardar").attr("onclick","valForm('formUsuario','guardarUsu(\\'g\\')');");
    $("a#btnbuscarusu").removeClass("disabled")
            .attr("onclick","buscarUsu();");
    var ced = xGetElementById('itxtcedula');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var car = xGetElementById('ilstcargo');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    var usu = xGetElementById('itxtlogin');
    var cla = xGetElementById('itxtclave');
    var rec = xGetElementById('itxtreclave');
    var tip = xGetElementById('ilsttipo');
    ced.value = '';
    nom.value = '';
    ape.value = '';
    car.value = -1;
    dep.value = -1;
    con.value = -1;
    usu.value = '';
    cla.value = '';
    rec.value = '';
    tip.value = -1;
    ced.disabled = false;
    nom.disabled = true;
    ape.disabled = true;
    car.disabled = true;
    dep.disabled = true;
    con.disabled = true;
    usu.disabled = true;
    cla.disabled = true;
    rec.disabled = true;
    tip.disabled = true;
    $("#contmsj").empty();
    ced.focus();
}

function cargarTodosUsu(){//fina
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarTodosUsu'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 crearTablaUsu(req.responseText,-1,-1);
            }
        }
    )
          
    $("#myModal").modal({                           
        "backdrop" : "static",
        "keyboard" : true,
        "show" : true // this parameter ensures the modal is shown immediately
    });
}

//function buscarUsuLe(obj,e){
//     if(e.keyCode == 13 || e.keyCode == 9)return;
//     AjaxRequest.post(
//           {
//               'parameters':{'opcion':'buscarUsuLe','letras':obj.value},
//               'url':'../Operaciones.php',
//               'onSuccess':function(req){
//                    crearTablaUsu(req.responseText);
//                    obj.focus();
//               }
//           }
//       )
//}

function crearTablaUsu(req,tipo,param){//fina
    resp = eval("(" + req + ")");
    $("#contUsu").empty();
    if(resp != 0){
        $("a#guardar").attr("onclick","valForm('formUsuario','guardarUsu(\\'m\\')');");
//        desbloquearUsu('formUsuario','itxtnombre','itxtcedula');
        for(var i = 0;i < resp.length; i++){
            usu = resp[i]['nombreusu'];
            if(i % 2 == 0){
                clase = "info";
            }else{
                clase = "";
            }
            $("#contUsu").append($("<tr>")
                     .css("cursor", "pointer")
                     .addClass(clase)
                     .append($("<td>")
                        .attr("style", "text-align: center; font-weight: bold;")
                        .text(i+1)
                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                        .text(usu.toLowerCase())
                     )
                    .append($("<td>")
                        .attr("style", "text-align: right;")
                        .text(formato_numero(resp[i]['p']['cedper'],0,'','.'))
                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                         .text(capitalizar(resp[i]['p']['nomper']+' '+resp[i]['p']['apeper']))
                     )
                    .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('i')).attr({
                            onclick: 'cargarUsu('+JSON.stringify(resp[i])+');',
                            class: 'icon-edit'
                        })
                        .attr("data-dismiss","modal")
                        )
                    )
                    .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('input')).attr({
                            name: 'eli_ch[]',
                            value: resp[i]['idusuario'],
                            type: 'checkbox'
                        })

                        )
                     )
                     .attr("title","Usuarios")
                     .attr("id","usuario")
                 );
        }
        $("a#imprimirUsu").attr("onclick","window.open('reporte_usuario.php?tipo="+tipo+"&parametro="+param+"','reportepermiso','_blank');")
            .removeClass("disabled");
        $("a#eliminarUsu").removeClass("disabled");
    }else{
        $("a#imprimirUsu").addClass("disabled")
                .attr("onclick","");
        $("a#imprimirUsu").addClass("disabled")
                .removeAttr("onclick");
        $("#contUsu").append($("<tr>")
                      .addClass("error alert-error")
                      .append($("<td>")
                         .attr("colspan","4")
                         .append($("<h5>")
                             .text("No existen registros para mostrar")
                         )
                      )
                      .attr("title","No existen registros para mostrar")
                      .attr("id","usuario")
         );
    }
}

function cambiarClave(){
    var log = xGetElementById('itxtlogin');
    var act = xGetElementById('itxtclaveactual');
    var cla = xGetElementById('itxtclavenueva');
    var rec = xGetElementById('itxtreclavenueva');
    if(log.value != ''){
        if(act.value != ''){
            if(cla.value != ''){
                if(rec.value != ''){
                    if(cla.value == rec.value){
                        AjaxRequest.post(
                            {
                                'parameters':{'opcion':'cambiarClave','log':log.value,'act':act.value,'cla':cla.value},
                                'url':'../Operaciones.php',
                                'onSuccess':function(req){
                                     var resp = eval("(" + req.responseText + ")");
                                     if(resp == 1){
//                                            limpiarFormCambio();
                                            $("#myModal").modal({                           
                                                "backdrop" : "static",
                                                "keyboard" : true,
                                                "show" : true // this parameter ensures the modal is shown immediately
                                            })
                                             .on('hidden', function(){
                                                    ir('vistas/index.php');
                                            });
                                     }else if(resp == 2){
                                         cad[0] = "No se pudo conectar";
                                         claseError('#contmsj',cad,'error');
                                     }else if(resp == 3){
                                         cad[0] = "No se pudo modificar su contraseña";
                                         claseError('#contmsj',cad,'error');
                                     }else{
                                         cad[0] = "Contraseña actual invalida";
                                         limpiarFormCambio();
                                         claseError('#contmsj',cad,'error');
                                     }
                                }
                            }
                        )
                    }else{
                        cad[0] = "Las contraseñas no coinciden";
                        claseError('#contmsj',cad,'error');
                    }
                    
                }else{
                    cad[0] = "Debe validar su nueva contraseña";
                    claseError('#contmsj',cad,'error');
                }
            }else{
                cad[0] = "Debe ingresar la nueva contraseña";
                claseError('#contmsj',cad,'error');
            }
        }else{
            cad[0] = "Debe ingresar la contraseña actual";
            claseError('#contmsj',cad,'error');
        }
    }else{
        cad[0] = "No existe un nombre de usuario";
        claseError('#contmsj',cad,'error');
    }        
}

function limpiarFormCambio(){
    var act = xGetElementById('itxtclaveactual');
    var cla = xGetElementById('itxtclavenueva');
    var rec = xGetElementById('itxtreclavenueva');
    act.value = '';
    cla.value = '';
    rec.value = '';
    act.focus();
}

function eliminarUsu(){
    $("a#eliminarUsu").confirmation('hide');
    $("#myModal").modal('hide');
    var checkboxValues = "";
    $('input[name="eli_ch[]"]:checked').each(function() {
            checkboxValues += $(this).val() + ",";
    });
    checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
    if(checkboxValues != ''){
        AjaxRequest.post(
        {
            'parameters':{'opcion':'eliminarUsu','param':checkboxValues},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 if(req.responseText == 1){
                    clase = "exito";
                    cad[0] = "Registro(s) eliminado(s) exisotamente";
                    claseError('#contmsj',cad,clase);  
                 }else{
                    clase = "error";
                    cad[0] = "No se pudo eliminar el registro";
                    claseError('#contmsj',cad,clase);  
                 }
            }
        })
    }else{
        clase = "error";
        cad[0] = "No se ha seleccionado ningun registro para eliminar";
        claseError('#contmsj',cad,clase);  
    }
    limpiarFormUsu();
}