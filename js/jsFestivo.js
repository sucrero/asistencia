var id = '';
//var clase = '';
//var cad = new Array();
function guardarFes(){
    var des = xGetElementById('itxtdescrip');
    var fec = xGetElementById('fecharg1');
    if(des.value != ''){
        if(fec.value != ''){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'guardarFes','des':des.value,'fec':fec.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        var resp = eval("(" + req.responseText + ")");
                        if(resp == 1){
                            limpiarFormFes('formFestivo');
                            clase = "exito";
                            cad[0] = "Registro guardado exisotamente";
                            claseError('#contmsjFes',cad,clase);
                        }else if(resp == 0){
                            clase = "error";
                            cad[0] = "No se pudo guarda el registro";
                            claseError('#contmsjFes',cad,clase);
                        }else{
                            clase = "error";
                            cad[0] = "Existe otro Dia Festivo con la misma fecha, verifique";
                            claseError('#contmsjFes',cad,clase);
                        }
                        
                    }
                }
            ) 
        }else{
            clase = "error";
            cad[0] = "De ingresar una fecha, verifique";
            claseError('#contmsjFes',cad,clase);
        }
    }else{
        clase = "error";
        cad[0] = "Debe ingresar una descripcion, verifique";
        claseError('#contmsjFes',cad,clase);
    }
}
function limpiarFormFes(){
    var des = xGetElementById('itxtdescrip');
    var fec = xGetElementById('fecharg1');
    des.value = '';
    fec.value = fechaActual();
    id = '';
    $("a#guardar").attr("onclick","valForm('formFestivo','guardarFes()');");
    des.focus();
}

function cargarTodosFes(){
    var des = xGetElementById('itxtdesc');
    des.value = '';
    des.focus();
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarTodosFes'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 crearTablaFes(req.responseText,-1,-1);
            }
        }
    )
    $("#myModal").modal({                           
        "backdrop" : "static",
        "keyboard" : true,
        "show" : true // this parameter ensures the modal is shown immediately
    });
}

function crearTablaFes(req,tipo,param){
    resp = eval("(" + req + ")");
    ids = '';
    $("#contFes").empty();
    if(resp != 0){
        for(var i = 0;i < resp.length; i++){
            if(i % 2 == 0){
                clase = "info";
            }else{
                clase = "";
            }
            $("#contFes").append($("<tr>")
                    .css("cursor", "pointer")
                    .addClass(clase)
                    .append($("<td>")
                        .attr("style", "text-align: center; font-weight: bold;")
                        .text(i+1)
                    )
                    .append($("<td>")
                        .attr("valign", "middle")
                        .text(capitalizar(resp[i]['descfest']))
                    )
                    .append($("<td>")
                        .text(resp[i]['fecha'].substr(8, 2)+'/'+resp[i]['fecha'].substr(5, 2)+'/'+resp[i]['fecha'].substr(0, 4))
                    )
                    .append($("<td>")
                       .attr("style", "text-align: center;")
                       .append($(document.createElement('i')).attr({
                           onclick: 'cargarFes('+JSON.stringify(resp[i])+');',
                           class: 'icon-edit'
                       })
                       .attr("data-dismiss","modal")
                       )
                    )
                    .append($("<td>")
                       .attr("style", "text-align: center;")
                       .append($(document.createElement('input')).attr({
                           name: 'eli_ch[]',
                           value: resp[i]['idfestivo'],
                           type: 'checkbox'
                       })

                       )
                    )
                    .attr("title","Festivos")
                    .attr("id","festivo")
                 );
        }
        $("a#imprimirFes").attr("onclick","window.open('reporte_fes.php?parametro="+param+"&tipo="+tipo+"','reportefes','_blank');")
                .removeClass("disabled");
        $("a#eliminarFes").removeClass("disabled");
    }else{
        $("a#imprimirFes").addClass("disabled")
                .attr("onclick","");
        $("a#imprimirFes").addClass("disabled")
                .removeAttr("onclick");
        $("#contFes").append($("<tr>")
                      .addClass("error alert-error")
                      .append($("<td>")
                         .attr("colspan","7")
                         .append($("<h5>")
                             .text("No existen registros para mostrar")
                         )
                      )
                      .attr("title","No existen registros para mostrar")
                      .attr("id","tierra")
         );
    }
}

function cargarFes(resp){
    var des = xGetElementById('itxtdescrip');
    var fec = xGetElementById('fecharg1');
    des.value = resp['descfest'];
    fec.value = resp['fecha'].substr(8, 2)+'/'+resp['fecha'].substr(5, 2)+'/'+resp['fecha'].substr(0, 4);
    id = resp['idfestivo'];
    $("a#guardar").attr("onclick","valForm('formFestivo','modificarFes()');");
}

function modificarFes(){
    var des = xGetElementById('itxtdescrip');
    var fec = xGetElementById('fecharg1');
    if(des.value != ''){
        if(fec.value != ''){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'modificarFes','des':des.value,'fec':fec.value,'id':id},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        var resp = eval("(" + req.responseText + ")");
                        if(resp == 1){
                            limpiarFormFes('formFestivo');
                            clase = "exito";
                            cad[0] = "Registro modificado exisotamente";
                        }else{
                            clase = "error";
                            cad[0] = "No se pudo modificar el registro";
                        }
                        claseError('#contmsjFes',cad,clase);
                    }
                }
            ) 
        }else{
            clase = "error";
            cad[0] = "De ingresar una fecha, verifique";
            claseError('#contmsjFes',cad,clase);
        }
    }else{
        clase = "error";
        cad[0] = "Debe ingresar una descripcion, verifique";
        claseError('#contmsjFes',cad,clase);
    }
}

function eliminarFes(){
    $("#contmsjFes").empty("");
    $("a#eliminarFes").confirmation('hide');
    $("#myModal").modal('hide');
    var checkboxValues = "";
    $('input[name="eli_ch[]"]:checked').each(function() {
            checkboxValues += $(this).val() + ",";
    });
    
    checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
    if(checkboxValues != ''){
        AjaxRequest.post(
        {
            'parameters':{'opcion':'eliminarFes','param':checkboxValues},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 if(req.responseText == 1){
                    clase = "exito";
                    cad[0] = "Registro(s) eliminado(s) exisotamente";
                    claseError('#contmsjFes',cad,clase);  
                 }else{
                    clase = "error";
                    cad[0] = "No se pudo eliminar el registro";
                    claseError('#contmsjFes',cad,clase);  
                 }
            }
        })
    }else{
        clase = "error";
        cad[0] = "No se ha seleccionado ningun registro para eliminar";
        claseError('#contmsjFes',cad,clase); 
    }
 }

function buscarxFechFes(){
    $("#contmsjmodal2").empty();
    var fe1 = xGetElementById('dp1');
    var fe2 = xGetElementById('dp2');
    if(fe1.value != '' && fe2.value != ''){
        if(compararFechas2(fe1.value,fe2.value)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarxFechFes','fe1':fe1.value,'fe2':fe2.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                         crearTablaFes(req.responseText,2,fe1.value+' '+fe2.value);
                    }
                }
            )
        }else{
            cad[0] = "La fecha de inicio debe ser mayor a la final";
            claseError('#contmsjmodal2',cad,'error');
        }
    }else{
        cad[0] = "Debe ingresar las fechas para poder buscar";
        claseError('#contmsjmodal2',cad,'error');
    }
}

function buscarxPalFes(){
    $("#contmsjmodal2").empty();
    var palabra = xGetElementById('itxtdesc');
    if(palabra.value != ''){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'buscarxPalFes','pal':palabra.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                     crearTablaFes(req.responseText,1,palabra.value);
                }
            }
        )
    }else{
        cad[0] = "Debe ingresar una palabra para buscar";
        claseError('#contmsjmodal3',cad,'error');
    }
        
}

function limpiarTabFes(op){
    if(op == 1){
        var des = xGetElementById('itxtdesc');
        des.value = '';
        des.focus();
    }else if(op == 2){
        var fe1 = xGetElementById('dp1');
        var fe2 = xGetElementById('dp2');
        fe1.value = fe2.value = fechaActual();
    }
    cargarTodosFes();
}