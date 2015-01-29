var ids = '';
function guardarPerm(tipo){
    var per = document.getElementById('ilstpersonal');
    var desde = document.getElementById('fecharg1');
    var hasta = document.getElementById('fecharg2');
    var des = document.getElementById('itxtdescrip');
    var permi = document.getElementById('ilstpermiso');
    
    if(per.value != -1){
        if(permi.value != -1){
            if(compararFechas2(desde.value,hasta.value)){
                if(des.value != ''){
                    AjaxRequest.post(
                        {
                            'parameters':{'opcion':'guardarPerm','persona':per.value,'desde':desde.value,'hasta':hasta.value,'des':des.value,'permi':permi.value},
                            'url':'../Operaciones.php',
                            'onSuccess':function(req){
                                var resp = eval("(" + req.responseText + ")");
                                if(resp == 1){
                                    limpiarFormPerm();
                                    clase = "exito";
                                    cad[0] = "Registro guardado exisotamente";
                                }else{
                                    clase = "error";
                                    cad[0] = "No se pudo guarda el registro";
                                }
                                claseError('#contmsj2',cad,clase);
                            }
                        }
                    )
                }else{
                    cad[0] = "Debe ingresar una descripcion para el permiso";
                    claseError('#contmsj2',cad,'error');
                }
            }else{
                cad[0] = "Error en fechas. La fecha inicial debe ser mayor o igual a la final, verifique";
                claseError('#contmsj2',cad,'error');
            }
        }else{
            cad[0] = "Debe seleccionar un tipo de permiso, verifique";
            claseError('#contmsj2',cad,'error');
        }
        
    }else{
        cad[0] = "Debe seleccionar una persona para asignar el permiso";
        claseError('#contmsj2',cad,'error');
    }
}
//
////var idPer = '';
//var idNot = new Array();
//var jObject='';

//var mod = '';
//function numRegistroNot(){
//    AjaxRequest.post(
//        {
//            'parameters':{'opcion':'maxRegNot'},
//            'url':'../Operaciones.php',
//            'onSuccess':function(req){
//                var resp = eval("(" + req.responseText + ")");
//                $("#itxtcodigoNot").text(resp);
//                $("#itxtfechaNot").text(fechaActual());
//            }
//        }
//    )
//}
//
//
//function accionPerNot(event,tipo){
//    if(event.keyCode == 13){
//        buscarPerNot(tipo);
//    }
//}
//function buscarPerNot(tipo){
//    var doc = xGetElementById('itxtnrodocumento');
//    var nom = xGetElementById('itxtnombre');
//    var ape = xGetElementById('itxtapellido');
//    var con = xGetElementById('itxtnotificacion');
//    $("#contmsj2").empty("");
//    nom.value = "";
//    ape.value = "";
//    if(doc.value != ''){
//        if(validaNumRif(doc)){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarPer','doc':doc.value,'tipo':tipo},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                        var resp = eval("(" + req.responseText + ")");
//                        if(resp != 2){
//                            nom.disabled = true;
//                            ape.disabled = true;
//                            nom.value = resp['nombreper'];
//                            ape.value = resp['apellidoper'];
//                            idPer = resp['idpersona'];
//                            con.focus();
//                        }else{
//                            idPer = '';
//                            nom.disabled = false;
//                            ape.disabled = false;
//                            nom.focus();
//                        }
//                    }
//                }
//            )
//        }else{
//            cad[0] = "Formato de documento incorrecto";
//            cad[1] = "El formato del RIF debe ser vV, eE, jJ, gG, seguido de nueve dígitos numéricos, en caso de la Cédula debe contener de 6 a 8 dígitos numéricos";
//            claseError('#contmsj2',cad,'error');
//        }
//    }else{
//        cad[0] = "Debe ingresar un R.I.F ó una Cédula para buscar";
//        claseError('#contmsj2',cad,'error');
//    }
//}
//
//function guardarNot(){
//    var docTit = xGetElementById('itxtnrodocumento');
//    var nomTit = xGetElementById('itxtnombre');
//    var apeTit = xGetElementById('itxtapellido');
//    var con = xGetElementById('itxtnotificacion');
//    var fis = xGetElementById('ilstfiscal');
//    
//    AjaxRequest.post(
//        {
//            'parameters':{'opcion':'guardarNot','docTit':docTit.value,'nomTit':nomTit.value,'apeTit':apeTit.value,'con':con.value,'idPer':idPer,'idFis':fis.value},
//            'url':'../Operaciones.php',
//            'onSuccess':function(req){
//                var resp = eval("(" + req.responseText + ")");
//                if(resp == 1){
//                    limpiarFormNot();
//                    clase = "exito";
//                    cad[0] = "Registro guardado exisotamente";
//                    numRegistroNot();
//                }else{
//                    clase = "error";
//                    cad[0] = "No se pudo guarda el registro";
//                }
//                claseError('#contmsj',cad,clase);
//            }
//        }
//    ) 
//}
function limpiarFormPerm(){
    var per = document.getElementById('ilstpersonal');
    var desde = document.getElementById('fecharg1');
    var hasta = document.getElementById('fecharg2');
    var des = document.getElementById('itxtdescrip');
    ids = '';
    desde.value = '';
    hasta.value = '';
    des.value = '';
    
    per.value = -1;
    
    $("a#guardar").attr("onclick","valForm('formPermiso','guardarPerm(\'g\')');");
    per.focus();
}

function cargarTodosPerm(){
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarTodosPerm'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                crearTablaPerm(req.responseText,-1,-1); 
            }
        }
    )
    $("#myModal").modal({                           
        "backdrop" : "static",
        "keyboard" : true,
        "show" : true // this parameter ensures the modal is shown immediately
    });
}

function crearTablaPerm(req,tipo,param){
    resp = eval("(" + req + ")");
    ids = '';
    capa = "#contPerm";
    $(capa).empty();
    if(resp != 0){
        for(var i = 0;i < resp.length; i++){

            if(i % 2 == 0){
                clase = "info";
            }else{
                clase = "";
            }
            
//            alert(capa);
            $(capa).append($("<tr>")
                     .css("cursor", "pointer")
                     .addClass(clase)
                     .append($("<td>")
                         .attr("style", "text-align: center; font-weight: bold; vertical-align: middle;")
                         .text(i+1)
                     )
                     .append($("<td>")
                         .attr("valign", "middle")
                         .text(resp[i]['p']['cedper'])
                         .attr("style", "vertical-align: middle;")
                     )
                     .append($("<td>")
                         .text(capitalizar(resp[i]['p']['nomper']+' '+resp[i]['p']['apeper']))
                         .attr("style", "vertical-align: middle;")
                     )
                     .append($("<td>")
                         .attr("valign", "middle")
                         .text(capitalizar(resp[i]['descripcionper']))
                         .attr("style", "vertical-align: middle;")
                     )
                     .append($("<td>")
                         .text(resp[i]['desde'].substr(8, 2)+'/'+resp[i]['desde'].substr(5, 2)+'/'+resp[i]['desde'].substr(0, 4))
                         .attr("style", "text-align: center; vertical-align: middle;")
                    )
                     .append($("<td>")
                         .text(resp[i]['hasta'].substr(8, 2)+'/'+resp[i]['hasta'].substr(5, 2)+'/'+resp[i]['hasta'].substr(0, 4))
                         .attr("style", "text-align: center; vertical-align: middle;")
                    )       
                    .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('i')).attr({
                            onclick: 'cargarPer("'+resp[i]['idperper']+'");',
                            class: 'icon-edit'
                        })
                        .attr("data-dismiss","modal")
                        )
                     )
                    .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('input')).attr({
                            name: 'eli_ch[]',
                            value: resp[i]['idperper'],
                            type: 'checkbox'
                        })

                        )
                     )
//                     .attr("onclick","cargarUsu("+JSON.stringify(resp[i])+")")
//                     .attr("data-dismiss", "modal")
                     .attr("title","Permisos")
                     .attr("id","permiso")
                 );
        }
            $("a#imprimirPerm").attr("onclick","window.open('reporte_not.php?tipo="+tipo+"&parametro="+param+"','reportenotifi','_blank');")
                    .removeClass("disabled");
//            $("a#cambiarEst").attr("onclick","cargar_form(\'cambio_estado\',\'contenedor\')")
//                    .attr("data-dismiss","modal")
//                    .removeClass("disabled");
            $("a#eliminarPerm").removeClass("disabled");
    }else{

            $("a#imprimirPerm").addClass("disabled")
                .attr("onclick","");
            $("a#imprimirPerm").addClass("disabled")
                .removeAttr("onclick")
//            $("a#cambiarEst").addClass("disabled")
//                    .removeAttr("onclick")
//                    .removeAttr("href")
//                    .removeAttr("data-dismiss")
            $(capa).append($("<tr>")
                          .addClass("error alert-error")
                          .append($("<td>")
                             .attr("colspan","8")
                             .append($("<h5>")
                                 .text("No existen registros para mostrar")
                             )
                          )
                          .attr("title","No existen registros para mostrar")
                          .attr("id","permiso")
             );
//        }
    }
}

//function buscarxFisNot(op){
//    var lstFis = xGetElementById('ilstfiscalbus');
//    $("#contmsjmodal1").empty();
//    if(lstFis.value != -1){
//         AjaxRequest.post(
//             {
//                 'parameters':{'opcion':'buscarxFisNot','fis':lstFis.value},
//                 'url':'../Operaciones.php',
//                 'onSuccess':function(req){
//                     if(op == 1){
//                         crearTablaNotCam(req.responseText,1,lstFis.value);
//                     }else{
//                         crearTablaNot(req.responseText,1,lstFis.value);
//                     }
//                 }
//             }
//         )
//     }else{
//         cad[0] = "Debe seleccionar un Fiscal para buscar";
//         claseError('#contmsjmodal1',cad,'error');
//     }
// }
//
//function buscarxFechNot(op){
//    $("#contmsjmodal2").empty();
//    var fe1 = xGetElementById('dp1');
//    var fe2 = xGetElementById('dp2');
//    if(fe1.value != '' && fe2.value != ''){
//        if (compararFechas2(fe1.value,fe2.value)){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarxFechNot','fe1':fe1.value,'fe2':fe2.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                        if(op == 1){
//                             crearTablaNotCam(req.responseText,2,fe1.value+' '+fe2.value);
//                         }else{
//                            crearTablaNot(req.responseText,2,fe1.value+' '+fe2.value);
//                        }
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
//function buscarxEstNot(op){
//    $("#contmsjmodal3").empty();
//    var lstEst = xGetElementById('ilstestado');
//    if(lstEst.value != -1){
//        AjaxRequest.post(
//            {
//                'parameters':{'opcion':'buscarxEstNot','est':lstEst.value},
//                'url':'../Operaciones.php',
//                'onSuccess':function(req){
//                    if(op == 1){
//                         crearTablaNotCam(req.responseText,3,lstEst.value);
//                    }else{
//                        crearTablaNot(req.responseText,3,lstEst.value);
//                    }
//                }
//            }
//        )
//    }else{
//        cad[0] = "Debe seleccionar un estado para buscar";
//        claseError('#contmsjmodal3',cad,'error');
//    }
//        
//}
//
//function buscarxOperNot(op){
//    $("#contmsjmodal4").empty();
//    var ced = xGetElementById('itxtcedope');
//    if(ced.value != ''){
//        if(validarNumero(ced)){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarxOperNot','ced':ced.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                        if(op == 1){
//                            crearTablaNotCam(req.responseText,4,ced.value);
//                        }else{
//                            crearTablaNot(req.responseText,4,ced.value);
//                        }
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
//
//function limpiarTabNot(op){
//    if(op == 1){
//        var lstFis = xGetElementById('ilstfiscalbus');
//        lstFis.value = -1;
//        $("#contmsjmodal1").empty();
//        lstFis.focus();
//    }else if(op == 2){
//        var fe1 = xGetElementById('dp1');
//        var fe2 = xGetElementById('dp2');
//        $("#contmsjmodal2").empty();
//        fe1.value = fe2.value = fechaActual();
//    }else if(op == 3){
//        var lstEst = xGetElementById('ilstestado');
//        lstEst.value = -1;
//        $("#contmsjmodal3").empty();
//        lstEst.focus();
//    }else{
//        var ced = xGetElementById('itxtcedope');
//        ced.value = '';
//        $("#contmsjmodal4").empty();
//        ced.focus();
//    }
//    cargarTodosNoti(0);
//}
//
//function crearTablaNotCam(req,tipo,param){
//    resp = eval("(" + req + ")");
//    capa = "#contNotEst";
//    $(capa).empty();
//    if(resp != 0){
//    var opciones = {
//        'ASIGNADA' : 'Asignada (A)',
//        'ENTREGADA' : 'Entregada (E)',
//        'NOENTREGADA' : 'No Entregada (NE)'
//    };
//    var seleccion;
//        for(var i = 0;i < resp.length; i++){
//            if(i % 2 == 0){
//                clase = "info";
//            }else{
//                clase = "";
//            }
//            var idSelect = 'status'+resp[i]['idnotificacion'];
//            seleccion = resp[i]['estadonoti'];
//            
//                $(capa).append($("<tr>")
//                     .css("cursor", "pointer")
//                     .addClass(clase)
//                     .append($("<td>")
//                         .attr("style", "text-align: center; font-weight: bold; vertical-align: middle;")
//                         .text(i+1)
//                     )
//                     .append($("<td>")
//                         .attr("valign", "middle")
//                         .text(capitalizar(resp[i]['descripcionnoti']))
//                         .attr("style", "vertical-align: middle;")
//                     )
//                     .append($("<td>")
//                         .text(resp[i]['fechanoti'].substr(8, 2)+'/'+resp[i]['fechanoti'].substr(5, 2)+'/'+resp[i]['fechanoti'].substr(0, 4))
//                         .attr("style", "text-align: center; vertical-align: middle;")
//                    )
//                     .append($("<td>")
//                         .text(resp[i]['f']['nombreper']+' '+resp[i]['f']['apellidoper'])
//                         .attr("style", "vertical-align: middle;")
//                     )
//                     
//                    .append($("<td>")
//                        .attr("style", "vertical-align: middle;")
//                        .append($("<select id='"+idSelect+"'>")
//                            .attr("style", "width: 110px")
//                            .attr("onChange", "addId('"+idSelect+"')")
//                       )
//                   )
//                     .attr("data-dismiss", "modal")
//                     .attr("title","Notificaciones")
//                     .attr("id","notificacion")
//                 );
//                
//                var select = $('#'+idSelect);
//                if(select.prop){
//                    var options = select.prop('options');
//                }else{
//                    var options = select.attr('options');
//                }
//                $('option',select).remove();
//                
//                $.each(opciones, function (val, text){
//                    options[options.length] = new Option(text, val);
//                });
//                select.val(seleccion);
//
//        }
//    }else{
//        $(capa).append($("<tr>")
//                      .addClass("error alert-error")
//                      .append($("<td>")
//                         .attr("colspan","7")
//                         .append($("<h5>")
//                             .text("No existen registros para mostrar")
//                         )
//                      )
//                      .attr("title","No existen registros para mostrar")
//                      .attr("id","notificacion")
//         );
//    }
//}
//
//function addId(id){
////    alert('id: '+id+'    valor: '+$('#'+id).val());
//    var num = idNot.length;
//    var cod = id.substr(6)
//    var band = 0;
//    var ind = 0;
//    for(i = 0; i < num; i++){
//        if(cod == idNot[i]['num']){
//            idNot[i]['val'] = $('#'+id).val();
//            band = 1;
//        }
//    }
//    if(band == 0){
//        if(num == 0){
//            indice = 0;
//        }else{
//            indice = num++;
//        }
//        idNot[indice] = new Array(2);
//        idNot[indice]['val'] = $('#'+id).val();
//        idNot[indice]['num'] = cod;
//    }
//    jObject='';
//    for(i in idNot){
//        if (jObject == ''){
//            jObject = idNot[i]['num']+'/'+idNot[i]['val'];
//        }else{
//            jObject = jObject +'-'+ idNot[i]['num']+'/'+idNot[i]['val'];
//        }
//        
//    }
//    
//}
//
//function modNoti(){
//    AjaxRequest.post(
//        {
//            'parameters':{'opcion':'modNotificacion','ids':jObject},
//            'url':'../Operaciones.php',
//            'onSuccess':function(req){
//                if(req.responseText == 1){
//                    clase = "exito";
//                    cad[0] = "Registro(s) modificado(s) exisotamente";
//                }else{
//                    clase = "error";
//                    cad[0] = "Hubo un error al modificar el(los) registro(s)";
//                }
//                claseError('#contmsj',cad,clase);
//            }
//        }
//    )
//}
//
//function eliminarNot(){
//    
//    $("a#eliminarNot").confirmation('hide');
//    $("#myModal").modal('hide');
//    var checkboxValues = "";
//    $('input[name="eli_ch[]"]:checked').each(function() {
//            checkboxValues += $(this).val() + ",";
//    });
//    checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
//    if(checkboxValues != ''){
//        AjaxRequest.post(
//        {
//            'parameters':{'opcion':'eliminarNot','param':checkboxValues},
//            'url':'../Operaciones.php',
//            'onSuccess':function(req){
//                 if(req.responseText == 1){
//                    clase = "exito";
//                    cad[0] = "Registro(s) eliminado(s) exisotamente";
//                 }else{
//                    clase = "error";
//                    cad[0] = "No se pudo eliminar el registro";
//                 }
//            }
//        })
//    }else{
//        clase = "error";
//        cad[0] = "No se ha seleccionado ningun registro para eliminar";
//    }
//    claseError('#contmsj',cad,clase);  
//}
//
//function cargarNot(codigo){
//    var docTit = xGetElementById('itxtnrodocumento');
//    var nomTit = xGetElementById('itxtnombre');
//    var apeTit = xGetElementById('itxtapellido');
//    var con = xGetElementById('itxtnotificacion');
//    var fis = xGetElementById('ilstfiscal');
//    
//    if(codigo != ''){
//        mod = codigo;
//        AjaxRequest.post(
//            {
//                'parameters':{'opcion':'modNot','cod':codigo},
//                'url':'../Operaciones.php',
//                'onSuccess':function(req){
//                    resp = eval("(" + req.responseText + ")");
//                    if(resp != 0){
//                        $("#itxtcodigoNot").text(resp['not']['idnotificacion']);
//                        if(resp['not']['cedulaper'] != ''){
//                            docTit.value = resp['pe']['cedulaper'];
//                        }else{
//                            docTit.value = resp['pe']['rifper'];
//                        }
//                        nomTit.value = resp['pe']['nombreper'];
//                        apeTit.value = resp['pe']['apellidoper'];
//                        con.value = resp['not']['descripcionnoti'];
//                        fis.value = resp['not']['idfiscal'];
//                    }
//                    $("a#guardar").attr("onclick","valForm('formNotificacion','modificarNot()');");
//                }
//            }
//        )
//    }else{
//        alert('no entro');
//    }
//}
//
//function modificarNot(){
//    var docTit = xGetElementById('itxtnrodocumento');
//    var nomTit = xGetElementById('itxtnombre');
//    var apeTit = xGetElementById('itxtapellido');
//    var con = xGetElementById('itxtnotificacion');
//    var fis = xGetElementById('ilstfiscal');
//    
//    AjaxRequest.post(
//        {
//            'parameters':{'opcion':'modificarNot','docTit':docTit.value,'nomTit':nomTit.value,'apeTit':apeTit.value,'con':con.value,'idPer':idPer,'idFis':fis.value,'cod':mod},
//            'url':'../Operaciones.php',
//            'onSuccess':function(req){
//                var resp = eval("(" + req.responseText + ")");
//                if(resp == 1){
//                    limpiarFormNot();
//                    clase = "exito";
//                    cad[0] = "Registro modificado exisotamente";
//                    numRegistroNot();
//                }else{
//                    clase = "error";
//                    cad[0] = "No se pudo modificar el registro";
//                }
//                claseError('#contmsj',cad,clase);
//            }
//        }
//    ) 
//}