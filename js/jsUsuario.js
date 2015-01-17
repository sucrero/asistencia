var codusu = '';
var cad = new Array();
//var usuario = new Array();
function validarSesion(){
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
    if(ced.value != ''){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'buscarUsu','ced':ced.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    resp = eval("(" + req.responseText + ")");
                    if(resp == 0){
                        $("a#guardar").attr("onclick","valForm('formUsuario','guardarUsu(\\'g\\')');");
                        desbloquearUsu('formUsuario','itxtnombre','itxtcedula');
                    }else{
                        $("a#guardar").attr("onclick","valForm('formUsuario','guardarUsu(\\'m\\')');");
                        desbloquearUsu('formUsuario','itxtnombre','itxtcedula');
                        cargarUsu(resp);
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
//    op ==> g = guardar ::: m = modificar
    var objForm = xGetElementById('formUsuario');
    var ced = xGetElementById('itxtcedula');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var usu = xGetElementById('itxtlogin');
    var cla = xGetElementById('itxtclave');
    var tip = xGetElementById('ilsttipo');
//    var idu = xGetElementById('idusu');
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
                'parameters':{'opcion':opcion,'ced':ced.value,'nom':nom.value,'ape':ape.value,'usu':usu.value,'cla':cla.value,'tip':tip.value,'id':codusu},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    var resp = eval("(" + req.responseText + ")");
                    var clase = "error";
                    if(resp == 2){
                        cad[0] = "Nombre de Usuario registrado";
                    }else if(resp == 3){
                        cad[0] = "Cédula de Usuario registrada";
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

function cargarUsu(datos){
    var ced = xGetElementById('itxtcedula');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var usu = xGetElementById('itxtlogin');
    var cla = xGetElementById('itxtclave');
    var rec = xGetElementById('itxtreclave');
    var tip = xGetElementById('ilsttipo');
    codusu = datos['idusuario'];
    ced.value = datos['cedulausu'];
    nom.value = datos['nombusu'];
    ape.value = datos['apeusu'];
    usu.value = datos['nombreusu'];
    cla.value = datos['claveusu'];
    rec.value = datos['claveusu'];
    tip.value = datos['tipousu'];
    usu.disabled = true;
    cla.disabled = true;
    rec.disabled = true;
}

function limpiarFormUsu(){//fina
    codusu = '';
    $("a#guardar").attr("onclick","valForm('formUsuario','guardarUsu(\\'g\\')');");
    limpiarForm('formUsuario','itxtcedula');
}

function cargarTodosUsu(){//fina
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarTodosUsu'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 crearTablaUsu(req.responseText);
            }
        }
    )
          
    $("#myModal").modal({                           
        "backdrop" : "static",
        "keyboard" : true,
        "show" : true // this parameter ensures the modal is shown immediately
    });
//        .on('hidden', function(){
////            desbloquearUsu('formUsuario','itxtnombre','itxtcedula');
//        });
}

function buscarUsuLe(obj,e){
     if(e.keyCode == 13 || e.keyCode == 9)return;
     AjaxRequest.post(
           {
               'parameters':{'opcion':'buscarUsuLe','letras':obj.value},
               'url':'../Operaciones.php',
               'onSuccess':function(req){
                    crearTablaUsu(req.responseText);
                    obj.focus();
               }
           }
       )
}

function crearTablaUsu(req){//fina
    resp = eval("(" + req + ")");
    $("#contUsu").empty();
    if(resp != 0){
        
        $("a#guardar").attr("onclick","valForm('formUsuario','guardarUsu(\\'m\\')');");
        desbloquearUsu('formUsuario','itxtnombre','itxtcedula');
        for(var i = 0;i < resp.length; i++){
            $("#contUsu").append($("<tr>")
                     .css("cursor", "pointer")
                     .addClass("info")
                     .append($("<td>")
                         .text(i+1)
                     )
                     .append($("<td>")
                         .text(resp[i]['nombreusu'])
                     )
                    .append($("<td>")
                         .text(resp[i]['cedulausu'])
                     )
                     .append($("<td>")
                         .text(resp[i]['nombusu']+' '+resp[i]['apeusu'])
                     )
                     .attr("onclick","cargarUsu("+JSON.stringify(resp[i])+")")
                     .attr("data-dismiss", "modal")
                     .attr("title","Haga click para cargar los datos de este registro")
                     .attr("id","usuario")
                 );
        }
    }else{
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