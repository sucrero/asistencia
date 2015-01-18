//var id = '';
//var idPerCo = '';
//var ids = '';
//var mod = '';


//function cargarMunicipios(destino){
//    if(destino == 1){
//        estado = 'ilstestado';
//        municipio = 'ilstmunicipio';
//        parroquia = 'ilstparroquia';
//    }else{
//        estado = 'ilstestadorep';
//        municipio = 'ilstmunicipiorep';
//        parroquia = 'ilstparroquiarep';
//    }
//    var est = xGetElementById(estado);
//    var mun = xGetElementById(municipio);
//    var par = xGetElementById(parroquia);
//    limpiarListaToda(par);
//    mun.disabled = false;
//    par.disabled = true;
//    if(est.value != -1){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarMun','codEstado':est.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                        crearListaMunTie(mun,req.responseText);
//                    }
//                }
//            )
//    }else{
//        limpiarListaToda(mun);
//        limpiarListaToda(par);
//        mun.disabled = true;
//        par.disabled = true;
//    }
//}
//function crearListaMunTie(objLista,cont){
//    contenido = eval("("+cont+")");
//    cant = contenido.length;
//    eliminarHijosLista(objLista);
//    if(cant > 0){
//        num='';
//        objLista.options[0] = new Option ('SELECCIONE...','-1',"defaultSelected");
//        y=0;
//        for(var i=1; i<=cant; i++){
//            objLista.options[i] = new Option(html_entity_decode(contenido[y]['nombremunicipio'],'ENT_QUOTES').toUpperCase(),contenido[y]['idmunicipio']);
//            y++;
//        }
//    }else{
//        alert('No existen Municipios para este Estado');
//    }
//    
//}

//function cargarParroquias(destino){
//    if(destino == 1){
//        municipio = 'ilstmunicipio';
//        parroquia = 'ilstparroquia';
//    }else{
//        municipio = 'ilstmunicipiorep';
//        parroquia = 'ilstparroquiarep';
//    }
//    var mun = xGetElementById(municipio);
//    var par = xGetElementById(parroquia);
//    limpiarListaToda(par);
//    par.disabled = false;
//    if(mun.value != -1){
//        AjaxRequest.post(
//            {
//                'parameters':{'opcion':'buscarPar','codMunicipio':mun.value},
//                'url':'../Operaciones.php',
//                'onSuccess':function(req){
//                    crearListaParTie(par,req.responseText);
//                }
//            }
//        )
//    }else{
//        limpiarListaToda(par);
//        par.disabled = true;
//    }
//}
//function crearListaParTie(objLista,cont){
//    
//    contenido = eval("("+cont+")");
//    cant = contenido.length;
//    eliminarHijosLista(objLista);
//    if(cant > 0){
//        num='';
//        objLista.options[0] = new Option ('SELECCIONE...','-1',"defaultSelected");
//        y=0;
//        for(var i=1; i<=cant; i++){
//            objLista.options[i] = new Option(html_entity_decode(contenido[y]['nombreparroquia'],'ENT_QUOTES').toUpperCase(),contenido[y]['idparroquia']);
//            y++;
//        }
//    }else{
//        alert('No existen Parroquias para este Municipio');
//        limpiarListaToda(par);
//        par.disabled = true;
//    }
//}
//function accionPerTie(event,tipo){
//    if(event.keyCode == 13){
//        buscarPerTie(tipo);
//    }
//}
//function buscarPerTie(tipo){
//    if(tipo == 'TITULAR'){
//        var doc = xGetElementById('itxtnrodocumento');
//        var nom = xGetElementById('itxtnombre');
//        var ape = xGetElementById('itxtapellido');
//    }else{
//        var doc = xGetElementById('txtnrodocumentoco');
//        var nom = xGetElementById('txtnombreco');
//        var ape = xGetElementById('txtapellidoco');
//    }
//    
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
//                            if(tipo == 'TITULAR'){
//                                idPer = resp['idpersona'];
//                            }else{
//                                idPerCo = resp['idpersona'];
//                            }
//                        }else{
//                            if(tipo == 'TITULAR'){
//                                idPer = '';
//                            }else{
//                                idPerCo = '';
//                            }
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

function guardarFes(){
    var des = xGetElementById('itxtdescrip');
    var fec = xGetElementById('fecharg1');
    
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
                }else{
                    clase = "error";
                    cad[0] = "No se pudo guarda el registro";
                }
                claseError('#contmsj',cad,clase);
            }
        }
    ) 
}
function limpiarFormFes(){
    var des = xGetElementById('itxtdescrip');
    var fec = xGetElementById('fecharg1');
    des.value = '';
    fec.value = '';
    $("a#guardar").attr("onclick","valForm('formFestivo','guardarFes(\'g\')');");
    des.focus();
}

function cargarTodosFes(){
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
    $("#contTie").empty();
    if(resp != 0){
        for(var i = 0;i < resp.length; i++){
//            if(ids == ''){
//                ids = resp[i]['idtierra'];
//            }else{
//                ids = ids+','+resp[i]['idtierra'];
//            }
            if(i % 2 == 0){
                clase = "info";
            }else{
                clase = "";
            }
            
//            if(typeof (resp[i]['c']['nombreper']) != "undefined" && typeof (resp[i]['c']['apellidoper']) != "undefined"){
//                cotitular = capitalizar(resp[i]['c']['nombreper']+' '+resp[i]['c']['apellidoper']);
//            }else{
//                cotitular = 'No Posee';
//            }
            
            $("#contTie").append($("<tr>")
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
                            onclick: 'cargarFes("'+resp[i]['idfestivo']+'");',
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
//                     .attr("onclick","cargarUsu("+JSON.stringify(resp[i])+")")
//                     .attr("data-dismiss", "modal")
                     .attr("title","Festivos")
                     .attr("id","festivo")
                 );
        }
        $("a#imprimirFes").attr("onclick","window.open('reporte_tie.php?parametro="+param+"&tipo="+tipo+"','reportefes','_blank');")
                .removeClass("disabled");
        $("a#eliminarFes").removeClass("disabled");
    }else{
        $("a#imprimirFes").addClass("disabled")
                .attr("onclick","");
        $("a#imprimirFes").addClass("disabled")
                .removeAttr("onclick");
        $("#contTie").append($("<tr>")
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

//function buscarxContT(){
//    var doc = xGetElementById('itxtdoccont');
//    $("#contmsjmodal1").empty();
//    if(doc.value != ''){
//       if(validaNumRif(doc)){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarxContT','doc':doc.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                        resp = eval("(" + req.responseText + ")");
//                        if(resp == 0){
//                            cad[0] = "No existe el Contribuyente con el documento ingresado";
//                            claseError('#contmsjmodal1',cad,'error'); 
//                        }
//                        crearTablaTie(req.responseText,1,doc.value);
//                    }
//                }
//            )
//        }else{
//            cad[0] = "Formato de documento incorrecto";
//            cad[1] = "El formato del RIF debe ser vV, eE, jJ, gG, seguido de nueve dígitos numéricos, en caso de la Cédula debe contener de 6 a 8 dígitos numéricos";
//            claseError('#contmsjmodal1',cad,'error');
//        } 
//    }else{
//        cad[0] = "Debe ingresar un R.I.F ó una Cédula para buscar";
//        claseError('#contmsjmodal1',cad,'error');
//    }
//}

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
        cad[0] = "Debe ingresar un las fechas para poder buscar";
        claseError('#contmsjmodal2',cad,'error');
    }
}

function buscarxPalFes(){
    
    $("#contmsjmodal2").empty();
    var palabra = xGetElementById('itxtdesc');
//    alert('holaaa '+palabra.value);
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

//function buscarxUbicT(){
//    $("#contmsjmodal3").empty();
//    var mun = xGetElementById('ilstmunicipiorep');
//    var par = xGetElementById('ilstparroquiarep');
//    if(mun.value != -1){
//        if(par.value != -1){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarxUbicT','par':par.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                         crearTablaTie(req.responseText,3,par.value);
//                    }
//                }
//            )
//        }else{
//            cad[0] = "Debe seleccionar una parroquia";
//            claseError('#contmsjmodal3',cad,'error');
//        }
//    }else{
//        cad[0] = "Debe seleccionar un municipio";
//        claseError('#contmsjmodal3',cad,'error');
//    }
//        
//}
//
//function buscarxOperTie(){
//    $("#contmsjmodal4").empty();
//    var ced = xGetElementById('itxtcedope');
//    if(ced.value != ''){
//        if(validarNumero(ced)){
//            AjaxRequest.post(
//                {
//                    'parameters':{'opcion':'buscarxOperTie','ced':ced.value},
//                    'url':'../Operaciones.php',
//                    'onSuccess':function(req){
//                         crearTablaTie(req.responseText,4,ced.value);
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

//function imprimirRepGen(){
//    var f1 = xGetElementById('fecharg1');
//    var f2 = xGetElementById('fecharg2');
//    if(f1.value != ''){
//        if(f2.value != ''){
//            if(compararFechas2(f1.value,f2.value)){
//                window.open('reporte_general.php?f1="'+f1.value+'"&f2="'+f2.value+'"','reportegen','_blank');
//            }else{
//                cad[0] = "La fecha de inicio debe ser mayor a la final";
//                claseError('#contmsj',cad,'error');
//            }
//        }else{
//            cad[0] = "Debe ingresar una fecha hasta";
//            claseError('#contmsj',cad,'error');
//        }
//    }else{
//        cad[0] = "Debe ingresar una fecha desde";
//        claseError('#contmsj',cad,'error');
//    }
//    
//}

function eliminarFes(){//fina
    
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

//function cargarTie(codigo){
//    var doc = xGetElementById('itxtnrodocumento');
//    var nom = xGetElementById('itxtnombre');
//    var ape = xGetElementById('itxtapellido');
//    var docCot = xGetElementById('txtnrodocumentoco');
//    var nomCot = xGetElementById('txtnombreco');
//    var apeCot = xGetElementById('txtapellidoco');
//    var fecReg = xGetElementById('itxtfecreg');
//    var tipDoc = xGetElementById('ilsttipodocumento');
//    var nroFol = xGetElementById('itxtfolio');
//    var nroTom = xGetElementById('itxttomo');
//    var nroPro = xGetElementById('itxtprotocolo');
//    var ciu = xGetElementById('itxtciudad');
//    var mun = xGetElementById('ilstmunicipio');
//    var par = xGetElementById('ilstparroquia');
//    var ptoRef = xGetElementById('itxtptoreferencia');
//    var linNor = xGetElementById('itxtnorte');
//    var linSur = xGetElementById('itxtsur');
//    var linEst = xGetElementById('itxteste');
//    var linOes = xGetElementById('itxtoeste');
//    var uso = xGetElementById('ilstuso');
//    var cla = xGetElementById('ilstclase');
//    var rub = xGetElementById('itxtrubro');
//    var ext = xGetElementById('itxtextension');
//    var hec = xGetElementById('itxthectareas');
//    
//    if(codigo != ''){
//        mod = codigo;
//        AjaxRequest.post(
//            {
//                'parameters':{'opcion':'modTie','cod':codigo},
//                'url':'../Operaciones.php',
//                'onSuccess':function(req){
//                    resp = eval("(" + req.responseText + ")");
//                    if(resp != 0){
//                        $("#itxtcodigoTie").text(resp['tie']['idtierra']);
//                        if(resp['pe']['cedulaper'] != ''){
//                            doc.value = resp['pe']['cedulaper'];
//                        }else{
//                            doc.value = resp['pe']['rifper'];
//                        }
//                        nom.value = resp['pe']['nombreper'];
//                        ape.value = resp['pe']['apellidoper'];
//                        
//                        if(resp['co'] != 0){
//                            if(resp['co']['cedulaper'] != ''){
//                                docCot.value = resp['co']['cedulaper'];
//                            }else{
//                                docCot.value = resp['co']['rifper'];
//                            }
//                            nomCot.value = resp['co']['nombreper'];
//                            apeCot.value = resp['co']['apellidoper'];
//                        }else{
//                            docCot.value = '';
//                            nomCot.value = '';
//                            apeCot.value = '';
//                        }
//                        
//                        fecReg.value = resp['tie']['fecregistrotierra'].substr(8,2)+'/'+resp['tie']['fecregistrotierra'].substr(5,2)+'/'+resp['tie']['fecregistrotierra'].substr(0,4);
//                        tipDoc.value = resp['tie']['tipodoctierra'];
//                        
//                        nroFol.value = resp['tie']['foliotierra'];
//                        nroTom.value = resp['tie']['tomotierra'];
//                        nroPro.value = resp['tie']['protocolo'];
//                        ciu.value = resp['tie']['ciudadtierra'];
//                        
//                        
//                        idpar = resp['tie']['idparroquia'];
//                        if(idpar.length == 7){
//                            idmun = idpar.substr(0,4);
//                        }else{
//                            idmun = idpar.substr(0,5);
//                        }
//                        crearListaMunTie(mun,JSON.stringify(resp['mu']));
//                        mun.value = idmun;
//                        
//                        crearListaParTie(par,JSON.stringify(resp['pa']));
//                        par.value = resp['tie']['idparroquia'];
//                        
//                        ptoRef.value = resp['tie']['ptoreftierra'];
//                        linNor.value = resp['tie']['nortetierra'];
//                        linSur.value = resp['tie']['surtierra'];
//                        linEst.value = resp['tie']['estetierra'];
//                        linOes.value = resp['tie']['oestetierra'];
//                        uso.value = resp['tie']['usotierra'];
//                        cla.value = resp['tie']['clasetierra'];
//                        rub.value = resp['tie']['rubrotierra'];
//                        ext.value = resp['tie']['extensiontierra'];
//                        hec.value = resp['tie']['hectarreastierra'];
//                    }
//                    $("a#guardar").attr("onclick","valForm('formTierra','modificarTie()');");
//                    
//                }
//            }
//        )
//    }else{
//        alert('no entro');
//    }
//}
//
//function modificarTie(){
//    var docTit = xGetElementById('itxtnrodocumento');
//    var nomTit = xGetElementById('itxtnombre');
//    var apeTit = xGetElementById('itxtapellido');
//    var docCot = xGetElementById('txtnrodocumentoco');
//    var nomCot = xGetElementById('txtnombreco');
//    var apeCot = xGetElementById('txtapellidoco');
//    var fecReg = xGetElementById('itxtfecreg');
//    var tipDoc = xGetElementById('ilsttipodocumento');
//    var numFolio = xGetElementById('itxtfolio');
//    var numTom = xGetElementById('itxttomo');
//    var numPro = xGetElementById('itxtprotocolo');
//    var ciu = xGetElementById('itxtciudad')
//    var par = xGetElementById('ilstparroquia');
//    var ptoRef = xGetElementById('itxtptoreferencia');
//    var linNor = xGetElementById('itxtnorte');
//    var linSur = xGetElementById('itxtsur');
//    var linEst = xGetElementById('itxteste');
//    var linOes = xGetElementById('itxtoeste');
//    var uso = xGetElementById('ilstuso');
//    var cla = xGetElementById('ilstclase');
//    var rub = xGetElementById('itxtrubro');
//    var ext = xGetElementById('itxtextension');
//    var hec = xGetElementById('itxthectareas');
//    
//    AjaxRequest.post(
//        {
//            'parameters':{'opcion':'modificarTie','docTit':docTit.value,'nomTit':nomTit.value,'apeTit':apeTit.value,'docCot':docCot.value,'idPer':idPer,'idPerCo':idPerCo,
//                          'nomCot':nomCot.value,'apeCot':apeCot.value,'fecReg':fecReg.value,'tipDoc':tipDoc.value,'numFolio':numFolio.value,
//                          'numTom':numTom.value,'numPro':numPro.value,'ciu':ciu.value,'par':par.value,'ptoRef':ptoRef.value,'linNor':linNor.value,'linSur':linSur.value,
//                          'linEst':linEst.value,'linOes':linOes.value,'uso':uso.value,'cla':cla.value,'rub':rub.value,'ext':ext.value,'hec':hec.value,'cod':mod},
//            'url':'../Operaciones.php',
//            'onSuccess':function(req){
//                var resp = eval("(" + req.responseText + ")");
//                if(resp == 1){
//                    limpiarFormTie('formTierra');
//                    clase = "exito";
//                    cad[0] = "Registro modificado exisotamente";
//                    numRegistroTie();
//                }else{
//                    clase = "error";
//                    cad[0] = "No se pudo modificar el registro";
//                }
//                claseError('#contmsj',cad,clase);
//            }
//        }
//    ) 
//}