function accionAsisReg(event){
    if(event.keyCode == 13){
        registrar();
    }
}

function registrar(){
    var ced = xGetElementById('itxtcedreg');
    if(ced.value != ''){
        AjaxRequest.post(
            {
                'parameters':{'opcion':'registrarAsis','ced':ced.value},
                'url':'../Operaciones.php',
                'onSuccess':function(req){
                    var resp = eval("(" + req.responseText + ")");
                    if(resp == 1){
                        cad[0] = "Cedula "+ced.value+" registrada exitosamente";
                        claseError('#contmsj4',cad,'exito');
                        ced.value = "";
                        ced.focus();
                    }else if(resp == 2){
                        cad[0] = "Error al registrar";
                        claseError('#contmsj4',cad,'error');
                    }else{
                        cad[0] = "La cedula ingresada no existe";
                        claseError('#contmsj4',cad,'error');
                    }
                }
            }
        )
    }else{
        cad[0] = "Debe ingresar una Cédula";
        claseError('#contmsj4',cad,'error');
    }
}

function login(){
    $("#myModal").modal({                           
        "backdrop" : "static",
        "keyboard" : true,
        "show" : true // this parameter ensures the modal is shown immediately
    });
}

function reporteGenAsistencia(){
    var mes = xGetElementById('ilstmeses');
    var anio = xGetElementById('ilstanio');
    var ced = xGetElementById('itxtcedrep');
    var car = xGetElementById('ilstcargo');
    var dep = xGetElementById('ilstdependencia');
    var con = xGetElementById('ilstcondicion');
    
    if(ced.value == ''){
        ced = -1;
    }else{
        ced = ced.value;
    }
    var param = car.value+' '+dep.value+' '+con.value+' '+mes.value+' '+ced+' '+anio.value;
                window.open('repgralasis.php?parametros='+param,'reportegen','_blank');
            
}