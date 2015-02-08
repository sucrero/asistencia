var id = '';
var desc = '';
function guardarH(){//fina
    var des = document.getElementById('itxtdescrip');
    if(des.value != ''){
        var desdeM = document.getElementById('time1').value;
        var hastaM = document.getElementById('time2').value;
        if((desdeM < hastaM)){
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
                        }else if(resp ==0){
                            cad[0] = "Error al guardar el registro";
                            claseError('#contmsj',cad,'error');
                        }else{
                            cad[0] = "Ya existe un registro con el mismo nombre, verifique";
                            claseError('#contmsj',cad,'error');
                        }
                    }
                }
            )
        }else{
            cad[0] = "Error en las horas, verifique";
            claseError('#contmsj',cad,'error');
        }
    }else{
        cad[0] = "Debe ingresar una descripcion, verifique";
        claseError('#contmsj',cad,'error');
    }
}

function limpiarFormHor(){//fina
    var des = document.getElementById('itxtdescrip');
    var desdeM = document.getElementById('time1');
    var hastaM = document.getElementById('time2');
    des.value = '';
    desdeM.value = '07:00:00';
    hastaM.value = '12:00:00';
    des.focus();
    id = '';
    desc = '';
}

function cargarTodosHor(){//fina
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
        $("a#imprimirHor").attr("onclick","window.open('reporte_horario.php?parametro="+param+"&tipo="+tipo+"','reportehorario','_blank');")
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
//    alert(checkboxValues);
    if(checkboxValues != ''){
        AjaxRequest.post(
        {
            'parameters':{'opcion':'eliminarHor','param':checkboxValues},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 if(req.responseText == 1){
                    clase = "exito";
                    cad[0] = "Registro(s) eliminado(s) exisotamente";
                    claseError('#contmsj',cad,clase); 
                 }else if(req.responseText == 2){
                    clase = "exito";
                    cad[0] = "No se eliminaron todos los registros, algunos poseen registros asociados";
                    claseError('#contmsj',cad,clase); 
                 }else if(req.responseText == 0){
                    clase = "error";
                    cad[0] = "No se elimino ningun registro, poseen registros asociados";
                    claseError('#contmsj',cad,clase); 
                 }else{
                    clase = "error";
                    cad[0] = "No se ha seleccionado ningun registro para eliminar";
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
    des.value = datos['descripcionhor'];
    desdeM.value = datos['horentrada'];
    hastaM.value = datos['horasalida'];
    des.focus();
    id = datos['idhor'];
    desc = datos['descripcionhor'];
    $("a#guardar").attr("onclick","valForm('formHorario','modificarH()');");
}

function modificarH(){
    var des = document.getElementById('itxtdescrip');
    if(des.value != ''){
        var desdeM = document.getElementById('time1').value;
        var hastaM = document.getElementById('time2').value;
        if((desdeM < hastaM)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'modificarH','des':des.value,'desdeM':desdeM,'hastaM':hastaM,'id':id,'desc':desc},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        resp = eval("(" + req.responseText + ")");
                        if(resp == 1){
                            cad[0] = "Registro modificado exitosamente";
                            claseError('#contmsj',cad,'exito');
                            limpiarFormHor();
                        }else{
                            cad[0] = "Ya existe un registro con el mismo nombre, verifique";
                            claseError('#contmsj',cad,'error');
                        }
                    }
                }
            )
        }else{
            cad[0] = "Error en las horas, verifique";
            claseError('#contmsj',cad,'error');
        }
    }else{
        cad[0] = "Debe ingresar una descripcion, verifique";
        claseError('#contmsj',cad,'error');
    }
}