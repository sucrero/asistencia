var cad = new Array();
var idPer = '';
var ids = '';
var mod = '';
var corEliminar = new Array();
function numRegistro(){
    AjaxRequest.post(
        {
            'parameters':{'opcion':'maxRegCor'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                var resp = eval("(" + req.responseText + ")");
                $("#itxtcodigo").text(resp);
            }
        }
    )
}
function accionPer(event,tipo){
    if(event.keyCode == 13){
        buscarPer(tipo);
    }
}

function actTipoSol(){
    var tipCor = xGetElementById('ilsttipo');
    var tipSol = xGetElementById('lstrecaudos');
    if(tipCor.value == 'SOLICITUD'){
        tipSol.disabled = false;
    }else{
        tipSol.value = -1;
        tipSol.disabled = true;
    }
}
function buscarPer(tipo){
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var tipCor = xGetElementById('ilsttipo');
    var tipSol = xGetElementById('lstrecaudos');
    var asu = xGetElementById('itxtasunto');
    $("#contmsj2").empty("");
    nom.value = "";
    ape.value = "";
    if(doc.value != ''){
        if(validaNumRif(doc)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarPer','doc':doc.value,'tipo':tipo},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        var resp = eval("(" + req.responseText + ")");
                        if(resp != 2){
                            idPer = resp['idpersona'];
                            nom.value = resp['nombreper'];
                            ape.value = resp['apellidoper'];
                        }else{
                            idPer = '';
                            nom.disabled = false;
                            ape.disabled = false;
                            nom.focus();
//                            desbloquearUsu('formCorrespondencia','itxtnombre','itxtnrodocumento');
                        }
                    }
                }
            )
        }else{
            cad[0] = "Formato de documento incorrecto";
            cad[1] = "El formato del RIF debe ser vV, eE, jJ, gG, seguido de nueve dígitos numéricos, en caso de la Cédula debe contener de 6 a 8 dígitos numéricos";
            claseError('#contmsj2',cad,'error');
        }
    }else{
        cad[0] = "Debe ingresar un R.I.F ó una Cédula para buscar";
        claseError('#contmsj2',cad,'error');
    }
}

function guardarCor(){
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var tip = xGetElementById('ilsttipo').options[xGetElementById('ilsttipo').selectedIndex ].text;
    var rec = xGetElementById('lstrecaudos').options[xGetElementById('lstrecaudos').selectedIndex ].text;
    var asu = xGetElementById('itxtasunto');
    if(tip.toUpperCase() == 'CONSIGNACIÓN'){
        rec = 'No aplica';
        w = true;
    }else{
        if(rec.toUpperCase() == 'SELECCIONE...'){
            w = false;
        }else{
            w = true;
        }
    }
    if(w){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'guardarCor','doc':doc.value,'nom':nom.value,'ape':ape.value,'tip':tip,'rec':rec,'asu':asu.value,'idPer':idPer},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    var resp = eval("(" + req.responseText + ")");
                    if(resp == 1){
                        limpiarForm('formCorrespondencia', 'itxtnrodocumento');
                        clase = "exito";
                        cad[0] = "Registro guardado exisotamente";
                        numRegistro();
                    }else if(resp == 2){
                        clase = "error";
                        cad[0] = "No se pudo guarda el registro";
                    }else{
                        clase = "error";
                        cad[0] = "No se pudo gurdar al contribuyente";
                    }
                    claseError('#contmsj',cad,clase);
                }
            }
        )
    }else{
        cad[0] = "Debe seleccionar un Tipo Solicitud";
        claseError('#contmsj',cad,'error');
    }
//    alert(rec.toUpperCase());
}

function cargarTodosCor(){
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarTodosCor'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 crearTablaCor(req.responseText,-1,-1);
            }
        }
    )
    $("#myModal").modal({                           
            "backdrop" : "static",
            "keyboard" : true,
            "show" : true // this parameter ensures the modal is shown immediately
        });
}
function crearTablaCor(req,tipo,param){
    resp = eval("(" + req + ")");
    ids = '';
    $("#contCor").empty();
    if(resp != 0){

        for(var i = 0;i < resp.length; i++){
            if(ids == ''){
                ids = resp[i]['idcorrespondencia'];
            }else{
                ids = ids+','+resp[i]['idcorrespondencia'];
            }
            if(i % 2 == 0){
                clase = "info";
            }else{
                clase = "";
            }
            $("#contCor").append($("<tr>")
//                     .attr("onclick","cargarMod('"+resp[i]['idcorrespondencia']+"');")
                     .css("cursor", "pointer")
                     .addClass(clase)
                     .append($("<td>")
                         .attr("style", "text-align: center; font-weight: bold;")
                         .text(i+1)
                     )
                     .append($("<td>")
                         .attr("valign", "middle")
                         .text(capitalizar(resp[i]['u']['nombusu']+' '+resp[i]['u']['apellidousu']))
                     )
                     .append($("<td>")
                         .text(capitalizar(resp[i]['p']['nombreper']+' '+resp[i]['p']['apellidoper']))
                     )
                    .append($("<td>")
                         .text(capitalizar(resp[i]['tipocorres']))
                     )
                     .append($("<td>")
                         .text(capitalizar(resp[i]['recaudoscorres']))
                     )
                     .append($("<td>")
                         .text(capitalizar(resp[i]['asuntocorres']))
                     )
                     .append($("<td>")
                         .text(resp[i]['feccorres'].substr(8, 2)+'/'+resp[i]['feccorres'].substr(5, 2)+'/'+resp[i]['feccorres'].substr(0, 4))
                     )
                    .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('i')).attr({
                            onclick: 'cargarMod("'+resp[i]['idcorrespondencia']+'");',
                            class: 'icon-edit'
                        })
                        .attr("data-dismiss","modal")
                        )
                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('input')).attr({
                            name: 'eli_ch[]',
                            value: resp[i]['idcorrespondencia'],
                            type: 'checkbox'
                        })

                        )
                     )
                     
//             <i class="icon-edit" onclick=""></i>
//                     .attr("onclick","cargarUsu("+JSON.stringify(resp[i])+")")
//                     .attr("data-dismiss", "modal")
                     .attr("title","Correspondencias")
                     .attr("id","correspondencia")
                 );
        }
        $("a#imprimirCor").attr("onclick","window.open('reporte_corres.php?parametro="+param+"&tipo="+tipo+"','reportecorres','_blank');")
                .removeClass("disabled");
        $("a#eliminarCor").removeClass("disabled");
//        $("a#eliminarCor").attr("onclick","eliminarCor("+param+","+tipo+");")
//                .removeClass("disabled")
//                .attr("data-dismiss","modal");
        
    }else{
        $("a#imprimirCor").addClass("disabled")
                .removeAttr("onclick");
        $("a#eliminarCor").addClass("disabled")
                .removeAttr("onclick");
        $("#contCor").append($("<tr>")
                      .addClass("error alert-error")
                      .append($("<td>")
                         .attr("colspan","9")
                         .append($("<h5>")
                             .text("No existen registros para mostrar")
                         )
                      )
                      .attr("title","No existen registros para mostrar")
                      .attr("id","correspondencia")
         );
    }
}


function onfecha(){
    $(function() {
    $('#dp2').datetimepicker({
      language: 'en',
      pick12HourFormat: true
    });
  });
}

function buscarxCont(){
    $("#contmsjmodal1").empty();
    var doc = xGetElementById('itxtdoccont');
    if(doc.value != ''){
       if(validaNumRif(doc)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarxCont','doc':doc.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        resp = eval("(" + req.responseText + ")");
                        if(resp == 0){
                            cad[0] = "No existe el Contribuyente con el documento ingresado";
                            claseError('#contmsjmodal1',cad,'error'); 
                        }
                        crearTablaCor(req.responseText,1,doc.value);
                    }
                }
            )
        }else{
            cad[0] = "Formato de documento incorrecto";
            cad[1] = "El formato del RIF debe ser vV, eE, jJ, gG, seguido de nueve dígitos numéricos, en caso de la Cédula debe contener de 6 a 8 dígitos numéricos";
            claseError('#contmsjmodal1',cad,'error');
        } 
    }else{
        cad[0] = "Debe ingresar un R.I.F ó una Cédula para buscar";
        claseError('#contmsjmodal1',cad,'error');
    }
}

function buscarxFech(){
    $("#contmsjmodal2").empty();
    var fe1 = xGetElementById('dp1');
    var fe2 = xGetElementById('dp2');
    if(fe1.value != '' && fe2.value != ''){
        if(compararFechas2(fe1.value,fe2.value)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarxFech','fe1':fe1.value,'fe2':fe2.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                         crearTablaCor(req.responseText,2,fe1.value+' '+fe2.value);
                    }
                }
            )
        }else{
            cad[0] = "La fecha de inicio debe ser mayor a la final";
            claseError('#contmsjmodal2',cad,'error');
        }
    }else{
        cad[0] = "Debe ingresar las dos fechas para poder buscar";
        claseError('#contmsjmodal2',cad,'error');
    }
}

function buscarxOper(){
    $("#contmsjmodal3").empty();
    var ced = xGetElementById('itxtcedope');
    if(ced.value != ''){
        if(validarNumero(ced)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarxOper','ced':ced.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                         crearTablaCor(req.responseText,3,ced.value);
                    }
                }
            )
        }else{
            cad[0] = "Formato de documento incorrecto";
            cad[1] = "El formato del RIF debe ser vV, eE, jJ, gG, seguido de nueve dígitos numéricos, en caso de la Cédula debe contener de 6 a 8 dígitos numéricos";
            claseError('#contmsjmodal3',cad,'error');
        }
    }else{
        cad[0] = "Debe ingresar un R.I.F ó una Cédula para buscar";
        claseError('#contmsjmodal3',cad,'error');
    }
}

function limpiarTabCor(op){
    if(op == 1){
        var doc = xGetElementById('itxtdoccont');
        doc.value = '';
        doc.focus();
    }else if(op == 2){
        var fe1 = xGetElementById('dp1');
        var fe2 = xGetElementById('dp2');
        fe1.value = fe2.value = fechaActual();
    }else{
        var ced = xGetElementById('itxtcedope');
        ced.value = '';
        ced.focus();
    }
    cargarTodosCor();
}

function cargarMod(codigo){
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var tip = xGetElementById('ilsttipo');
    var rec = xGetElementById('lstrecaudos');
    var asu = xGetElementById('itxtasunto');
    if(codigo != ''){
        mod = codigo;
        AjaxRequest.post(
            {
                'parameters':{'opcion':'modCor','cod':codigo},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    resp = eval("(" + req.responseText + ")");
                    $("#itxtcodigo").text(resp['idcorrespondencia']);
                    if(resp['cedulaper'] != ''){
                        doc.value = resp['cedulaper'];
                    }else{
                        doc.value = resp['rifper'];
                    }
                    nom.value = resp['nombreper'];
                    ape.value = resp['apellidoper'];
                    if(resp['tipocorres'] == 'solicitud'){
                        tipo = 'SOLICITUD';
                        rec.disabled = false;
                    }else{
                        tipo = 'CONSIGNACION';
                        rec.value = -1;
                        rec.disabled = true;
                    }
                    tip.value = tipo;
                     
                    recaudos = resp['recaudoscorres'].replace(/\s/g,'');
                    var acentos = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";
                    var original = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";
                    for (var i = 0; i < acentos.length; i++) {
                        recaudos = recaudos.replace(acentos.charAt(i), original.charAt(i));
                    }
                    recaudos = recaudos.toLowerCase();
                    rec.value = recaudos;
                    asu.value = resp['asuntocorres'];
                    
                    $("a#guardar").attr("onclick","valForm('formCorrespondencia','modificarCor()');");
                    
                }
            }
        )
    }else{
        alert('no entro');
    }
}

function modificarCor(){
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var tip = xGetElementById('ilsttipo').options[xGetElementById('ilsttipo').selectedIndex ].text;
    var rec = xGetElementById('lstrecaudos').options[xGetElementById('lstrecaudos').selectedIndex ].text;
    var asu = xGetElementById('itxtasunto');
    if(tip.toUpperCase() == 'CONSIGNACIÓN'){
        rec = 'No aplica';
        w = true;
    }else{
        if(rec.toUpperCase() == 'SELECCIONE...'){
            w = false;
        }else{
            w = true;
        }
    }
    AjaxRequest.post(
        {
            'parameters':{'opcion':'modificarCor','doc':doc.value,'nom':nom.value,'ape':ape.value,'tip':tip,'rec':rec,'asu':asu.value,'idPer':idPer,'cod':mod},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 if(req.responseText == 1){
                    limpiarFormCor();
                    clase = "exito";
                    cad[0] = "Registro modifiicado exisotamente";
                 }else{
                    clase = "error";
                    cad[0] = "No se pudo modificar el registro";
                 }
                 claseError('#contmsj',cad,clase);
            }
        }
    )
}

function limpiarFormCor(){
    numRegistro();
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var tip = xGetElementById('ilsttipo');
    var rec = xGetElementById('lstrecaudos');
    var asu = xGetElementById('itxtasunto');
    ids = '';
    idPer = '';
    mod = '';
    doc.value = '';
    doc.disabled = false;
    nom.value = '';
    ape.value = '';
    tip.value = -1;
    rec.value = -1;
    rec.disabled = true;
    asu.value = '';
    $("a#guardar").attr("onclick","valForm('formCorrespondencia','guardarCor(\'g\')');");
    doc.focus();
}



function eliminarCor(){
    $("a#eliminarCor").confirmation('hide');
    $("#myModal").modal('hide');
    var checkboxValues = "";
    $('input[name="eli_ch[]"]:checked').each(function() {
            checkboxValues += $(this).val() + ",";
    });
    checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
    if(checkboxValues != ''){
        AjaxRequest.post(
        {
            'parameters':{'opcion':'eliminarCor','param':checkboxValues},
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