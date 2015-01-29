

function guardarH(tipo){
    var des = document.getElementById('itxtdescrip');
    if(des.value != ''){
        var desdeM = document.getElementById('time1').value;
        var hastaM = document.getElementById('time2').value;
//        var desdeT = document.getElementById('time3').value;
//        var hastaT = document.getElementById('time4').value;
        if((desdeM < hastaM)){
//            if((hastaM < desdeT) && (hastaM < hastaT)){
//                if(desdeT < hastaT){
                    AjaxRequest.post(
                        {
                            'parameters':{'opcion':'guardarH','des':des.value,'desdeM':desdeM,'hastaM':hastaM},
                            'url':'../Operaciones.php',
                            'onSuccess':function(req){
                                resp = eval("(" + req.responseText + ")");
                                if(resp == 1){
                                    cad[0] = "Registro guardado exitosamente";
                                    claseError('#contmsj',cad,'exito');
                                    limpiarFormHor();
                                }else{
                                    cad[0] = "Error al guardar el registro";
                                    claseError('#contmsj',cad,'error');
                                }
                            }
                        }
                    )
//                }else{
//                    cad[0] = "Error en las horas, verifique";
//                }
//            }else{
//                cad[0] = "Error en las horas, verifique";
//            }
        }else{
            cad[0] = "Error en las horas, verifique";
        }
    }else{
        cad[0] = "Debe ingresar una descripcion, verifique";
    }
    claseError('#contmsj',cad,'error');
}

function limpiarFormHor(){
    var des = document.getElementById('itxtdescrip');
    var desdeM = document.getElementById('time1');
    var hastaM = document.getElementById('time2');
//    var desdeT = document.getElementById('time3');
//    var hastaT = document.getElementById('time4');
    des.value = '';
    desdeM.value = '07:00:00';
    hastaM.value = '12:00:00';
//    desdeT.value = '13:00:00';
//    hastaT.value = '17:00:00';
    des.focus();
}

//
////
//function buscarFis(){
//    var ced = xGetElementById('itxtcedula');
//    if(ced.value != ''){
//        AjaxRequest.post(
//            {
//                'parameters':{'opcion':'buscarFis','ced':ced.value},
//                'url':'../Operaciones.php',
//                'onSuccess':function(req){
//                    resp = eval("(" + req.responseText + ")");
//                    if(resp == 0){
//                        $("a#guardar").attr("onclick","valForm('formFiscal','guardarFis(\\'g\\')');");
//                        desbloquearFis();
//                    }else{
//                        cad[0] = "Cédula registrada, verifique";
//                        claseError('#contmsj',cad,'error');
//                    }
//                }
//            }
//        )
//    }else{
//        cad[0] = "Debe ingresar una Cédula para buscar";
//        claseError('#contmsj',cad,'error');
//    }
//}
//function desbloquearFis(){
//    var nom = xGetElementById('itxtnombre');
//    var ape = xGetElementById('itxtapellido');
//    nom.value = '';
//    ape.value = '';
//    nom.disabled = false;
//    ape.disabled = false;
//    nom.focus();
//}
//
//function guardarFis(op){
////    op ==> g = guardar ::: m = modificar
//    
//    var ced = xGetElementById('itxtcedula');
//    var nom = xGetElementById('itxtnombre');
//    var ape = xGetElementById('itxtapellido');
//    
//    
//    var w = true;
//    if(op == 'g'){
//        var opcion = 'guardarFis';
//    }else{
////        if(confirm("Seguro desea modificar este registro?")){
////            w = true;
////        }else{
////            w= false;
////        }
//        var opcion = 'modificarFis';
//    }
//    if(w){
//        AjaxRequest.post(
//            {
//                'parameters':{'opcion':opcion,'ced':ced.value,'nom':nom.value,'ape':ape.value,'idfis':codfis},
//                'url':'../Operaciones.php',
//                'onSuccess':function(req){
//                    var resp = eval("(" + req.responseText + ")");
//                    var clase = "error";
//                    if(resp == 1){
//                        clase = "exito";
//                        cad[0] = "Registro guardado exitosamente";
//                        limpiarForm('formFiscal','itxtcedula');
//                    }else if(resp == 2){
//                        cad[0] = "Ocurrió un error al guardar el registro";
//                    }else if(resp == 3){
//                        cad[0] = "Cedula registrada, verifique";
//                    }else if(resp == 4){
//                        clase = "exito";
//                        cad[0] = "Registro modificado exisotamente";
//                        limpiarForm('formFiscal','itxtcedula');
//                    }else if(resp == 5){
//                        cad[0] = "Ha ocurrido un error, informe al administrador";
//                    }else{
//                        cad[0] = "No se pudo conseguir al usuario";
//                    }
//                    claseError('#contmsj',cad,clase);
//                }
//            }
//        )
//    }
//}
//
//function limpiarFormUsu(){
//    codfis = '';
//    $("a#guardar").attr("onclick","valForm('formFiscal','guardarFis(\\'g\\')');");
//    limpiarForm('formFiscal','itxtcedula');
//}
//
function cargarTodosHor(){
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarTodosHor'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 crearTablaHor(req.responseText,-1,-1);
            }
        }
    )
          
    $("#myModal").modal({                           
        "backdrop" : "static",
        "keyboard" : true,
        "show" : true // this parameter ensures the modal is shown immediately
    });
}
//
//function buscarFisLe(obj,e){
//     if(e.keyCode == 13 || e.keyCode == 9)return;
//     AjaxRequest.post(
//           {
//               'parameters':{'opcion':'buscarFisLe','letras':obj.value},
//               'url':'../Operaciones.php',
//               'onSuccess':function(req){
//                    crearTablaFis(req.responseText,1,obj.value);
//                    obj.focus();
//               }
//           }
//       )
//}
//
//function buscarFisxCed(){
//    $("#contmsjmodal1").empty();
//    var ced = xGetElementById('itxtdocfis');
//    if(ced.value != ''){
//        if(validarNumero(ced)){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarFisxCed','ced':ced.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                         crearTablaFis(req.responseText,2,ced.value);
//                    }
//                }
//            )
//        }else{
//            cad[0] = "Formato de documento incorrecto";
//            cad[1] = "El formato de la Cédula debe contener de 6 a 8 dígitos numéricos";
//            claseError('#contmsjmodal1',cad,'error');
//        }
//    }else{
//        cad[0] = "Debe ingresar una Cédula para buscar";
//        claseError('#contmsjmodal1',cad,'error');
//    }
//     
//}
//
function crearTablaHor(req,tipo,param){
    ids = '';
    resp = eval("(" + req + ")");
    $("#contCor").empty();
    if(resp != 0){
        
//        $("a#guardar").attr("onclick","valForm('formFiscal','guardarFis(\\'m\\')');");
//        desbloquearFis();
        for(var i = 0;i < resp.length; i++){
//            if(ids == ''){
//                ids = resp[i]['idpersona'];
//            }else{
//                ids = ids+','+resp[i]['idpersona'];
//            }
            if(i % 2 == 0){
                clase = "info";
            }else{
                clase = "";
            }
            $("#contCor").append($("<tr>")
                     .css("cursor", "pointer")
                     .addClass(clase)
                     .append($("<td>")
                         .text(i+1)
                     )
                     .append($("<td>")
                         .text(capitalizar(resp[i]['descripcionhor']))
                     )
                     .append($("<td>")
                         .text(resp[i]['horentrada'])
                     )
                     .append($("<td>")
                         .text(resp[i]['horasalida'])
                     )
//                     .append($("<td>")
//                         .text(resp[i]['horainitar'])
//                     )
//                     .append($("<td>")
//                         .text(resp[i]['horafintar'])
//                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('i')).attr({
                            onclick: 'cargarHor('+JSON.stringify(resp[i])+');',
                            class: 'icon-edit'
                        })
                        .attr("data-dismiss","modal")
                        )
                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('input')).attr({
                            name: 'eli_ch[]',
                            value: resp[i]['idhor'],
                            type: 'checkbox'
                        })

                        )
                     )
//                     .attr("onclick","cargarFis("+JSON.stringify(resp[i])+")")
//                     .attr("data-dismiss", "modal")
                     .attr("title","Haga click para cargar los datos de este registro")
                     .attr("id","fiscal")
                 );
        }
        $("a#imprimirHor").attr("onclick","window.open('reporte_fiscal.php?parametro="+param+"&tipo="+tipo+"','reportehorario','_blank');")
                .removeClass("disabled");
        $("a#eliminarHor").removeClass("disabled");
    }else{
        $("a#imprimirHor").addClass("disabled")
                .removeAttr("onclick");
        $("a#eliminarHor").addClass("disabled")
                .removeAttr("onclick");
        $("#contCor").append($("<tr>")
                      .addClass("error alert-error")
                      .append($("<td>")
                         .attr("colspan","8")
                         .append($("<h5>")
                             .text("No existen registros para mostrar")
                         )
                      )
                      .attr("title","No existen registros para mostrar")
                      .attr("id","fiscal")
         );
    }
}
//
//function limpiarTabFis(op){
//    if(op == 1){
//        var ced = xGetElementById('itxtdocfis');
//        ced.value = '';
//        ced.focus();
//    }else{
//        var nom = xGetElementById('itxtnombrefis');
//        nom.value = '';
//        nom.focus();
//    }
//    cargarTodosFis();
//}
//
function eliminarHor(){
    
    $("a#eliminarHor").confirmation('hide');
    $("#myModal").modal('hide');
    var checkboxValues = "";
    $('input[name="eli_ch[]"]:checked').each(function() {
            checkboxValues += $(this).val() + ",";
    });
    checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
    if(checkboxValues != ''){
        AjaxRequest.post(
        {
            'parameters':{'opcion':'eliminarHor','param':checkboxValues},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 if(req.responseText == 1){
                    clase = "exito";
                    cad[0] = "Registro(s) eliminado(s) exisotamente";
                 }else if(req.responseText == 0){
                    clase = "error";
                    cad[0] = "No se eliminaron los registros, poseen registros asociados";
                 }else if(req.responseText == 2){
                    clase = "error";
                    cad[0] = "No se eliminaron todos registros, algunos poseen registros asociados";
                 }else{
                    clase = "error";
                    cad[0] = "No se ha seleccionado ningun registro para eliminar";
                 }
            }
        })
    }else{
        clase = "error";
        cad[0] = "No se ha seleccionado ningun registro para eliminar";
    }
    claseError('#contmsj',cad,clase); 
}
//
//function limpiarFormFis(){
//    var ced = xGetElementById('itxtcedula');
//    var nom = xGetElementById('itxtnombre');
//    var ape = xGetElementById('itxtapellido');
//    ids = '';
//    ced.value = '';
//    ced.disabled = false;
//    nom.value = '';
//    ape.value = '';
//    nom.disabled = true;
//    ape.disabled = true;
//    $("a#guardar").attr("onclick","valForm('formFiscal','guardarFis(\\'g\\')');");
//    $("a#imprimirFis").attr("onclick","window.open('reporte_fiscal.php?parametro="+param+"&tipo="+tipo+"','reportefiscal','_blank');")
//                .removeClass("disabled");
//    $("a#eliminarFis").removeClass("disabled");
//    ced.focus();
//}
//
function cargarHor(datos){
     var des = document.getElementById('itxtdescrip');
    var desdeM = document.getElementById('time1');
    var hastaM = document.getElementById('time2');
//    var desdeT = document.getElementById('time3');
//    var hastaT = document.getElementById('time4');
    des.value = datos['descripcionhor'];
    desdeM.value = datos['horentrada'];
    hastaM.value = datos['horasalida'];
//    desdeT.value = datos['horainitar'];
//    hastaT.value = datos['horafintar'];
    des.focus();

    $("a#guardar").attr("onclick","valForm('formHorario','guardarHor(\\'f\\')');");
}