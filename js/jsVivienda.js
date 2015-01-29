var idPer = '';
var idPerCo = '';
var ids = '';
var mod = '';
function numRegistroViv(){
    AjaxRequest.post(
        {
            'parameters':{'opcion':'maxRegViv'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                var resp = eval("(" + req.responseText + ")");
                $("#itxtcodigoViv").text(resp);
                $("#itxtfechaViv").text(fechaActual());
            }
        }
    )
    cargarMunicipios(1);
}

function cargarMunicipios(destino){
    if(destino == 1){
        estado = 'ilstestado';
        municipio = 'ilstmunicipio';
        parroquia = 'ilstparroquia';
    }else{
        estado = 'ilstestadorep';
        municipio = 'ilstmunicipiorep';
        parroquia = 'ilstparroquiarep';
    }
    var est = xGetElementById(estado);
    var mun = xGetElementById(municipio);
    var par = xGetElementById(parroquia);
    limpiarListaToda(par);
    mun.disabled = false;
    par.disabled = true;
    if(est.value != -1){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarMun','codEstado':est.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        crearListaMunViv(mun,req.responseText);
                    }
                }
            )
    }else{
        limpiarListaToda(mun);
        limpiarListaToda(par);
        mun.disabled = true;
        par.disabled = true;
    }
}
function crearListaMunViv(objLista,cont){
    contenido = eval("("+cont+")");
    cant = contenido.length;
    eliminarHijosLista(objLista);
    if(cant > 0){
        num='';
        objLista.options[0] = new Option ('SELECCIONE...','-1',"defaultSelected");
        y=0;
        for(var i=1; i<=cant; i++){
            objLista.options[i] = new Option(html_entity_decode(contenido[y]['nombremunicipio'],'ENT_QUOTES').toUpperCase(),contenido[y]['idmunicipio']);
            y++;
        }
    }else{
        alert('No existen Municipios para este Estado');
    }
    
}

function cargarParroquias(destino){
    if(destino == 1){
        municipio = 'ilstmunicipio';
        parroquia = 'ilstparroquia';
    }else{
        municipio = 'ilstmunicipiorep';
        parroquia = 'ilstparroquiarep';
    }
    var mun = xGetElementById(municipio);
    var par = xGetElementById(parroquia);
    limpiarListaToda(par);
    par.disabled = false;
    if(mun.value != -1){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'buscarPar','codMunicipio':mun.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    crearListaParViv(par,req.responseText);
                }
            }
        )
    }else{
        limpiarListaToda(par);
        par.disabled = true;
    }
}
function crearListaParViv(objLista,cont){
    
    contenido = eval("("+cont+")");
    cant = contenido.length;
    eliminarHijosLista(objLista);
    if(cant > 0){
        num='';
        objLista.options[0] = new Option ('SELECCIONE...','-1',"defaultSelected");
        y=0;
        for(var i=1; i<=cant; i++){
            objLista.options[i] = new Option(html_entity_decode(contenido[y]['nombreparroquia'],'ENT_QUOTES').toUpperCase(),contenido[y]['idparroquia']);
            y++;
        }
    }else{
        alert('No existen Parroquias para este Municipio');
        limpiarListaToda(par);
        par.disabled = true;
    }
}
function accionPerViv(event,tipo){
    if(event.keyCode == 13){
        buscarPerViv(tipo);
    }
}
function buscarPerViv(tipo){
    if(tipo == 'TITULAR'){
        var doc = xGetElementById('itxtnrodocumento');
        var nom = xGetElementById('itxtnombre');
        var ape = xGetElementById('itxtapellido');
    }else{
        var doc = xGetElementById('txtnrodocumentoco');
        var nom = xGetElementById('txtnombreco');
        var ape = xGetElementById('txtapellidoco');
    }
    
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
                            nom.disabled = true;
                            ape.disabled = true;
                            nom.value = resp['nombreper'];
                            ape.value = resp['apellidoper'];
                            if(tipo == 'TITULAR'){
                                idPer = resp['idpersona'];
                            }else{
                                idPerCo = resp['idpersona'];
                            }
                            
                        }else{
                            if(tipo == 'TITULAR'){
                                idPer = '';
                            }else{
                                idPerCo = '';
                            }
                            nom.disabled = false;
                            ape.disabled = false;
                            nom.focus();                            
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

function guardarViv(){
    var docTit = xGetElementById('itxtnrodocumento');
    var nomTit = xGetElementById('itxtnombre');
    var apeTit = xGetElementById('itxtapellido');
    var docCot = xGetElementById('txtnrodocumentoco');
    var nomCot = xGetElementById('txtnombreco');
    var apeCot = xGetElementById('txtapellidoco');
    var fecReg = xGetElementById('itxtfecreg');
    var numDoc = xGetElementById('itxtnrodoc');
    var numTom = xGetElementById('itxtnrotomo');
    var par = xGetElementById('ilstparroquia');
    var ciu = xGetElementById('itxtciudad');
    var zonPos = xGetElementById('itxtzonapostal');
    var fecAdq = xGetElementById('itxtfechaadq');
    var sec = xGetElementById('itxtsector');
    var tip = xGetElementById('ilsttipoinm').options[xGetElementById('ilsttipoinm').selectedIndex ].text;
    var nroCas = xGetElementById('itxtcasa');
    var valInm = xGetElementById('itxtvalinmu');
    var valMej = xGetElementById('itxtvalmejoras');
    
    AjaxRequest.post(
        {
            'parameters':{'opcion':'guardarViv','docTit':docTit.value,'nomTit':nomTit.value,'apeTit':apeTit.value,'docCot':docCot.value,
                          'nomCot':nomCot.value,'apeCot':apeCot.value,'fecReg':fecReg.value,'numDoc':numDoc.value,
                          'numTom':numTom.value,'par':par.value,'ciu':ciu.value,'zonPos':zonPos.value,
                          'fecAdq':fecAdq.value,'sec':sec.value,'tip':tip,'nroCas':nroCas.value,'valInm':valInm.value,'valMej':valMej.value,
                          'idPer':idPer,'idPerCo':idPerCo},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                var resp = eval("(" + req.responseText + ")");
                if(resp == 1){
                    limpiarFormViv('formVivienda');
                    clase = "exito";
                    cad[0] = "Registro guardado exisotamente";
                    numRegistroViv();
                }else{
                    clase = "error";
                    cad[0] = "No se pudo guarda el registro";
                }
                claseError('#contmsj',cad,clase);
            }
        }
    ) 
}
function limpiarFormViv(){
    var objForm = xGetElementById('formVivienda');
    var objFoco = xGetElementById('itxtnrodocumento');
    var nroElement = objForm.length;
    for(i=0;i<nroElement;i++){
        if(objForm.elements[i].type == 'text' || objForm.elements[i].type == 'textarea' || objForm.elements[i].type == 'password'){
            objForm.elements[i].value = "";
        }else if(objForm.elements[i].type == 'select-one'){
            if(objForm.elements[i].id != 'ilstestado'){
                objForm.elements[i].value = -1;
            }
        }
    }
    $("a#guardar").attr("onclick","valForm('formVivienda','guardarViv(\'g\')');");
    ids = '';
    objFoco.disabled = false;
    objFoco.focus();
}

function cargarTodosViv(){
    AjaxRequest.post(
        {
            'parameters':{'opcion':'buscarTodosViv'},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 crearTablaViv(req.responseText,-1,-1);
            }
        }
    )
    $("#myModal").modal({                           
        "backdrop" : "static",
        "keyboard" : true,
        "show" : true // this parameter ensures the modal is shown immediately
    });
}

function crearTablaViv(req,tipo,param){
    resp = eval("(" + req + ")");
    ids = '';
    $("#contViv").empty();
    if(resp != 0){
        for(var i = 0;i < resp.length; i++){
            if(ids == ''){
                ids = resp[i]['idvivienda'];
            }else{
                ids = ids+','+resp[i]['idvivienda'];
            }
            if(i % 2 == 0){
                clase = "info";
            }else{
                clase = "";
            }
            
            if(typeof (resp[i]['c']['nombreper']) != "undefined" && typeof (resp[i]['c']['apellidoper']) != "undefined"){
                cotitular = capitalizar(resp[i]['c']['nombreper']+' '+resp[i]['c']['apellidoper']);
            }else{
                cotitular = 'No Posee';
            }
            $("#contViv").append($("<tr>")
                     .css("cursor", "pointer")
                     .addClass(clase)
                     .append($("<td>")
                         .attr("style", "text-align: center; font-weight: bold;")
                         .text(i+1)
                     )
                     .append($("<td>")
                         .attr("valign", "middle")
                         .text(capitalizar(resp[i]['p']['nombreper']+' '+resp[i]['p']['apellidoper']))
                     )
                     .append($("<td>")
                         .text(cotitular)
                     )
                    .append($("<td>")
                         .text(capitalizar(resp[i]['sector']))
                     )
                     .append($("<td>")
                         .text(capitalizar(resp[i]['tipovivienda']))
                     )
                     .append($("<td>")
                         .text(resp[i]['fechavivienda'].substr(8, 2)+'/'+resp[i]['fechavivienda'].substr(5, 2)+'/'+resp[i]['fechavivienda'].substr(0, 4))
                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('i')).attr({
                            onclick: 'cargarViv("'+resp[i]['idvivienda']+'");',
                            class: 'icon-edit'
                        })
                        .attr("data-dismiss","modal")
                        )
                     )
                     .append($("<td>")
                        .attr("style", "text-align: center;")
                        .append($(document.createElement('input')).attr({
                            name: 'eli_ch[]',
                            value: resp[i]['idvivienda'],
                            type: 'checkbox'
                        })

                        )
                     )
//                     .attr("onclick","cargarUsu("+JSON.stringify(resp[i])+")")
//                     .attr("data-dismiss", "modal")
                     .attr("title","Viviendas")
                     .attr("id","vivienda")
                 );
        }
        $("a#imprimirViv").attr("onclick","window.open('reporte_vivi.php?parametro="+param+"&tipo="+tipo+"','reportevivi','_blank');")
                .removeClass("disabled");
        $("a#eliminarViv").removeClass("disabled");
    }else{
        $("a#imprimirViv").addClass("disabled")
                .attr("onclick","");
        $("a#eliminarViv").addClass("disabled")
                .removeAttr("onclick");
        $("#contViv").append($("<tr>")
                      .addClass("error alert-error")
                      .append($("<td>")
                         .attr("colspan","8")
                         .append($("<h5>")
                             .text("No existen registros para mostrar")
                         )
                      )
                      .attr("title","No existen registros para mostrar")
                      .attr("id","vivienda")
         );
    }
}

function buscarxContV(){
    var doc = xGetElementById('itxtdoccont');
    $("#contmsjmodal1").empty();
    if(doc.value != ''){
       if(validaNumRif(doc)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarxContV','doc':doc.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                        resp = eval("(" + req.responseText + ")");
                        if(resp == 0){
                            cad[0] = "No existe el Contribuyente con el documento ingresado";
                            claseError('#contmsjmodal1',cad,'error'); 
                        }
                        crearTablaViv(req.responseText,1,doc.value);
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

function buscarxFechV(){
    $("#contmsjmodal2").empty();
    var fe1 = xGetElementById('dp1');
    var fe2 = xGetElementById('dp2');
    if(fe1.value != '' && fe2.value != ''){
        if(compararFechas2(fe1.value,fe2.value)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarxFechV','fe1':fe1.value,'fe2':fe2.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                         crearTablaViv(req.responseText,2,fe1.value+' '+fe2.value);
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

function buscarxUbic(){
    $("#contmsjmodal3").empty();
    var mun = xGetElementById('ilstmunicipiorep');
    var par = xGetElementById('ilstparroquiarep');
    if(mun.value != -1){
        if(par.value != -1){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarxUbic','par':par.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                         crearTablaViv(req.responseText,3,par.value);
                    }
                }
            )
        }else{
            cad[0] = "Debe seleccionar una parroquia";
            claseError('#contmsjmodal3',cad,'error');
        }
    }else{
        cad[0] = "Debe seleccionar un municipio";
        claseError('#contmsjmodal3',cad,'error');
    }
        
}

function buscarxOperViv(){
    $("#contmsjmodal4").empty();
    var ced = xGetElementById('itxtcedope');
    if(ced.value != ''){
        if(validarNumero(ced)){
            AjaxRequest.post(
                {
                    'parameters':{'opcion':'buscarxOperViv','ced':ced.value},
                    'url':'../Operaciones.php',
                    'onSuccess':function(req){
                         crearTablaViv(req.responseText,4,ced.value);
                    }
                }
            )
        }else{
            cad[0] = "Formato de documento incorrecto";
            cad[1] = "El formato de la Cédula debe contener de 6 a 8 dígitos numéricos";
            claseError('#contmsjmodal4',cad,'error');
        }
    }else{
        cad[0] = "Debe ingresar un R.I.F ó una Cédula para buscar";
        claseError('#contmsjmodal4',cad,'error');
    }
}

function limpiarTabViv(op){
    if(op == 1){
        var doc = xGetElementById('itxtdoccont');
        doc.value = '';
        doc.focus();
    }else if(op == 2){
        var fe1 = xGetElementById('dp1');
        var fe2 = xGetElementById('dp2');
        fe1.value = fe2.value = fechaActual();
    }else if(op == 3){
        var mun = xGetElementById('ilstmunicipiorep');
        var par = xGetElementById('ilstparroquiarep');
        mun.value = par.value = -1;
        par.disabled = true;
        mun.focus();
    }else{
        var ced = xGetElementById('itxtcedope');
        ced.value = '';
        ced.focus();
    }
    cargarTodosViv();
}

function eliminarViv(){
    
    $("a#eliminarViv").confirmation('hide');
    $("#myModal").modal('hide');
    var checkboxValues = "";
    $('input[name="eli_ch[]"]:checked').each(function() {
            checkboxValues += $(this).val() + ",";
    });
    checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
    if(checkboxValues != ''){
        AjaxRequest.post(
        {
            'parameters':{'opcion':'eliminarViv','param':checkboxValues},
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

function cargarViv(codigo){
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var docCot = xGetElementById('txtnrodocumentoco');
    var nomCot = xGetElementById('txtnombreco');
    var apeCot = xGetElementById('txtapellidoco');
    var fecReg = xGetElementById('itxtfecreg');
    var nroDoc = xGetElementById('itxtnrodoc');
    var nroTom = xGetElementById('itxtnrotomo');
    var mun = xGetElementById('ilstmunicipio');
    var par = xGetElementById('ilstparroquia');
    var ciu = xGetElementById('itxtciudad');
    var zon = xGetElementById('itxtzonapostal');
    var fecAdq = xGetElementById('itxtfechaadq');
    var sec = xGetElementById('itxtsector');
    var tipInm = xGetElementById('ilsttipoinm');
    var nroCas = xGetElementById('itxtcasa');
    var valInm = xGetElementById('itxtvalinmu');
    var valMej = xGetElementById('itxtvalmejoras');
    if(codigo != ''){
        mod = codigo;
        AjaxRequest.post(
            {
                'parameters':{'opcion':'modViv','cod':codigo},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    resp = eval("(" + req.responseText + ")");
                    if(resp != 0){
                        $("#itxtcodigo").text(resp['vi']['idvivienda']);
                        if(resp['pe']['cedulaper'] != ''){
                            doc.value = resp['pe']['cedulaper'];
                        }else{
                            doc.value = resp['pe']['rifper'];
                        }
                        nom.value = resp['pe']['nombreper'];
                        ape.value = resp['pe']['apellidoper'];
                        
                        if(resp['co'] != 0){
                            if(resp['co']['cedulaper'] != ''){
                                docCot.value = resp['co']['cedulaper'];
                            }else{
                                docCot.value = resp['co']['rifper'];
                            }
                            nomCot.value = resp['co']['nombreper'];
                            apeCot.value = resp['co']['apellidoper'];
                        }else{
                            docCot.value = '';
                            nomCot.value = '';
                            apeCot.value = '';
                        }
                        fecReg.value = resp['vi']['fecregistro'].substr(8,2)+'/'+resp['vi']['fecregistro'].substr(5,2)+'/'+resp['vi']['fecregistro'].substr(0,4);
                        nroDoc.value = resp['vi']['documentovivienda'];
                        nroTom.value = resp['vi']['tomovivienda'];
                        
                        idpar = resp['vi']['idparroquia'];
                        if(idpar.length == 7){
                            idmun = idpar.substr(0,4);
                        }else{
                            idmun = idpar.substr(0,5);
                        }
                        crearListaMunViv(mun,JSON.stringify(resp['mu']));
                        mun.value = idmun;
                        
                        crearListaParViv(par,JSON.stringify(resp['pa']));
                        par.value = resp['vi']['idparroquia'];
                        
                        zon.value = resp['vi']['zonapostal'];
                        fecAdq.value = resp['vi']['fecadquisicion'].substr(8,2)+'/'+resp['vi']['fecadquisicion'].substr(5,2)+'/'+resp['vi']['fecadquisicion'].substr(0,4);
                        sec.value = resp['vi']['sector'];
                        tipInm.value = resp['vi']['tipovivienda'].toUpperCase();
                        nroCas.value = resp['vi']['nrovivienda'];
                        valInm.value = resp['vi']['valorinmueble'];
                        valMej.value = resp['vi']['valormejora'];
                        ciu.value = 'Cumana';
                        idPer = resp['vi']['idpersona'];
                        idPerCo = resp['vi']['per_idpersona'];
                    }
                    $("a#guardar").attr("onclick","valForm('formVivienda','modificarViv()');");
                    
                }
            }
        )
    }else{
        alert('no entro');
    }
}

function modificarViv(){
    var doc = xGetElementById('itxtnrodocumento');
    var nom = xGetElementById('itxtnombre');
    var ape = xGetElementById('itxtapellido');
    var docCot = xGetElementById('txtnrodocumentoco');
    var nomCot = xGetElementById('txtnombreco');
    var apeCot = xGetElementById('txtapellidoco');
    var fecReg = xGetElementById('itxtfecreg');
    var nroDoc = xGetElementById('itxtnrodoc');
    var nroTom = xGetElementById('itxtnrotomo');
    var par = xGetElementById('ilstparroquia');
    var ciu = xGetElementById('itxtciudad');
    var zon = xGetElementById('itxtzonapostal');
    var fecAdq = xGetElementById('itxtfechaadq');
    var sec = xGetElementById('itxtsector');
    var tipInm = xGetElementById('ilsttipoinm').options[xGetElementById('ilsttipoinm').selectedIndex ].text;
    var nroCas = xGetElementById('itxtcasa');
    var valInm = xGetElementById('itxtvalinmu');
    var valMej = xGetElementById('itxtvalmejoras');
    AjaxRequest.post(
        {
            'parameters':{'opcion':'modificarViv','docTit':doc.value,'nomTit':nom.value,'apeTit':ape.value,'docCot':docCot.value,
                          'nomCot':nomCot.value,'apeCot':apeCot.value,'fecReg':fecReg.value,'numDoc':nroDoc.value,
                          'numTom':nroTom.value,'par':par.value,'ciu':ciu.value,'zonPos':zon.value,
                          'fecAdq':fecAdq.value,'sec':sec.value,'tip':tipInm,'nroCas':nroCas.value,'valInm':valInm.value,'valMej':valMej.value,
                          'idPer':idPer,'idPerCo':idPerCo,'cod':mod},
            'url':'../Operaciones.php',
            'onSuccess':function(req){
                 if(req.responseText == 1){
                    limpiarFormViv();
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