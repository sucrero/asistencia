var ids = '';
var mod = '';
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

function limpiarFormPerm(){
    var per = document.getElementById('ilstpersonal');
    var desde = document.getElementById('fecharg1');
    var hasta = document.getElementById('fecharg2');
    var des = document.getElementById('itxtdescrip');
    var permi = document.getElementById('ilstpermiso');
    ids = '';
    mod = '';
    desde.value = fechaActual();
    hasta.value = fechaActual();
    des.value = '';
    permi.value = -1;
    per.value = -1;
    
    $("a#guardar").attr("onclick","valForm('formPermiso','guardarPerm(\"g\")');");
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
                            onclick: 'cargarPerm('+JSON.stringify(resp[i])+');',
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
                     .attr("title","Permisos")
                     .attr("id","permiso")
                 );
        }
        $("a#imprimirPerm").attr("onclick","window.open('reporte_permiso.php?tipo="+tipo+"&parametro="+param+"','reportepermiso','_blank');")
            .removeClass("disabled");
        $("a#eliminarPerm").removeClass("disabled");
    }else{
        $("a#imprimirPerm").addClass("disabled")
            .attr("onclick","")
            .removeAttr("onclick");
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
    }
}


function buscarRepPer(){
    var lstTipPer = xGetElementById('ilstpermisobus');
    var desde = xGetElementById('dp1');
    var hasta = xGetElementById('dp2');
    if((desde.value != '' && hasta.value != '') || (desde.value == '' && hasta.value == '')){
        $("#contmsjmodal1").empty();
        AjaxRequest.post(
            {
                'parameters':{'opcion':'buscarrepPer','tip':lstTipPer.value,'des':desde.value,'has':hasta.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    crearTablaPerm(req.responseText,1,lstTipPer.value+' '+desde.value+' '+hasta.value);
                }
            }
        )
    }else{
        clase = "error";
        cad[0] = "Ddebe ingresar las 2 fechas o ninguna, verifique";
        claseError('#contmsjmodal1',cad,'error');
    }
 }
 
 function limpiarRepPer(){
    var lstPer = xGetElementById('ilstpermisobus');
    var desdeBus = xGetElementById('dp1');
    var hastaBus = xGetElementById('dp2'); 
    lstPer.value = -2;
    desdeBus.value = '';
    hastaBus.value = '';
 }
 
 function eliminarPerm(){
    $("a#eliminarPerm").confirmation('hide');
    $("#myModal").modal('hide');
    var checkboxValues = "";
    $('input[name="eli_ch[]"]:checked').each(function() {
            checkboxValues += $(this).val() + ",";
    });
    checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
    if(checkboxValues != ''){
        AjaxRequest.post(
        {
            'parameters':{'opcion':'eliminarPerm','param':checkboxValues},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 if(req.responseText == 1){
                    clase = "exito";
                    cad[0] = "Registro(s) eliminado(s) exisotamente";
                    claseError('#contmsj2',cad,clase);  
                 }else{
                    clase = "error";
                    cad[0] = "No se pudo eliminar el registro";
                    claseError('#contmsj2',cad,clase);  
                 }
            }
        })
    }else{
        clase = "error";
        cad[0] = "No se ha seleccionado ningun registro para eliminar";
        claseError('#contmsj2',cad,clase);  
    }
    
 }

function cargarPerm(resp){
//    alert(resp);
    var per = document.getElementById('ilstpersonal');
    var desde = document.getElementById('fecharg1');
    var hasta = document.getElementById('fecharg2');
    var des = document.getElementById('itxtdescrip');
    var permi = document.getElementById('ilstpermiso');
    
    if(resp != ''){
        mod = resp['idperper'];
        per.value = resp['idpersona'];
        desde.value = resp['desde'].substr(8, 2)+'/'+resp['desde'].substr(5, 2)+'/'+resp['desde'].substr(0, 4);
        hasta.value = resp['hasta'].substr(8, 2)+'/'+resp['hasta'].substr(5, 2)+'/'+resp['hasta'].substr(0, 4);
        des.value = resp['descripcionper'];
        permi.value = resp['idpermiso'];
        $("a#guardar").attr("onclick","valForm('formPermiso','modPerm()');");
        
    }else{
        alert('no entro');
    }
}
//
function modPerm(){
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
                            'parameters':{'opcion':'modificarPerm','per':per.value,'desde':desde.value,'hasta':hasta.value,'des':des.value,'permi':permi.value,'cod':mod},
                            'url':'../Operaciones.php',
                            'onSuccess':function(req){
                                var resp = eval("(" + req.responseText + ")");
                                if(resp == 1){
                                    limpiarFormPerm();
                                    clase = "exito";
                                    cad[0] = "Registro modificado exisotamente";
                                }else{
                                    clase = "error";
                                    cad[0] = "No se pudo modificar el registro";
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