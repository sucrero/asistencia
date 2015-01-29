//------------------------------------------------------------------------------------------------------------
//formatos para varios tipos de campos
var usuario = /^[abcdefghijklmnopqrstuvwxyz0123456789]{1,14}$/
var pregunta = /^[abcdefghijklmnopqrstuvwxyz0123456789 ]{1,25}$/
var letras = /^[a-zA-Z]$/
var number = /^[0-9]{0,}$/
var decimal = /^[1-9]+[0-9]{1,}\.+[0-9]{2}$/
var rif = /^[jJ|vV|gG|eE|pP]{1}[0-9]{9}$/
var letrasval = /^[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]{1,}$/ 
var alfanumerico = /^[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789|-]{1,}$/
//----------------------------------------------------------------------------------------------

function eventoEnterDocumento(evt) {
    var nav4 = window.Event ? true : false;
    // NOTE: Enter = 13, '0' = 48, '9' = 57, 'j' = 106, 'J' =74	, 'g'= 103, 
    //       'G'=71, 'e'=101, 'E'=69, 'p'=112, 'P'=80, 'v'=118, 'V'=86, Borrar=8, Suprimir=0 
    var key = nav4 ? evt.which : evt.keyCode;	
    return ((key == 74) || (key ==106) || 
            (key == 71) || (key ==103) ||
            (key == 69) || (key ==101) ||
            (key == 80) || (key ==112) ||
            (key == 86) || (key ==118) ||
            (key >= 48 && key <= 57) || (key == 8) || (key == 0));
}

function validarFormulario1(){
    var formulario = document.registroBean
    
    if  (document.forms[0].elements["tipoDocumento.codigo"].value == ""){       
        alert ('Seleccione el Tipo de Documento para proceder a registrarse');   
        document.forms[0].elements["tipoDocumento.codigo"].focus();
    } 
    if  (document.forms[0].elements["pregunta2.codigo"].value == ""){     
        alert ('Debe seleccionar la nacionalidad');
        document.forms[0].elements["pregunta2.codigo"].focus();
    } 
    with (formulario){
        if (numeroDocumento.value == '') {
            alert('Coloque un numero de Documento valido');
            numeroDocumento.focus();
        }
        if (pregunta1.value == '') {
            alert('Debe colocar la fecha de nacimiento o fallecimiento (en caso de sucesión)');
            pregunta1.focus();
        }
        if (usuario.value == '') {
            alert('Por Favor coloque el usuario');
            usuario.focus();
        }
        if (clave.value == '') {
            alert('Por Favor coloque la clave');
            clave.focus();
        } 
        if (clave1.value == '') {
            alert('Por Favor re-escriba la clave');
            clave1.focus();
        }else{
            if  (clave1.value != clave.value){        
                alert ('Las claves no coinciden');   
                clave1.focus();
            } 
        }
        if (pregunta.value == '') {
            alert('Por Favor coloque la pregunta');
            pregunta.focus();
        } 
        if (respuesta.value == '') {
            alert('Por Favor coloque la respuesta');
            respuesta.focus();
        }
        if ((correo.value == '') || (!verifyMailAddress(correo.value))) {
            alert('Por Favor coloque el Correo correctamente');
            correo.focus();
        }
    }
}

function hay_numero(car) { 
    var numeros = "0123456789";
    return numeros.indexOf(car) >=0;
} 

function  recargar() {
    contextPath = document.getElementById("contextPath").value;
    document.forms[0].action = contextPath + '/loadregistro.do';     
    document.forms[0].submit();
}

function Revisa(conjunto, cadena){
    return conjunto.test(cadena)
}

function verifyMailAddress(value) {
	var reMail = /^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/;
	return reMail.test(value);
}  

function validarUsuario(Login,Mensaje) {
    if (Login.value!='' && !Revisa(usuario,Login.value)){ 
        alert(Mensaje); 
        Login.focus();
        Login.value="";
    }
}

function validarClave(clave,Mensaje) {
    var haynumero = false;
    var claveval = clave.value;
    
    if (clave.value!='' && !Revisa(usuario,clave.value)){ 
        alert(Mensaje);     
        clave.focus();   
        clave.value = "";
    }else{
        if (clave.value!='') {
            for(var i=0; i<claveval.length; i++){
                if (hay_numero(claveval.charAt(i))){
                    haynumero=true;         
                }
            }
            if (haynumero == false){
                alert('La clave de usuario debe contener al menos un caracter numérico');              
                clave.focus(); 
                clave.value = "";
            }
        }
    }
    return haynumero;
}

function validarpregunta(Login,Mensaje) {
    if (Login.value!='' && !Revisa(pregunta,Login.value)){ 
        alert(Mensaje); 
        Login.focus();
        Login.value="";
    }
}

function validar(valor) {     
    if  (document.forms[0].elements["tipoDocumento.codigo"].value == "2"){       
        validarRif(valor);
    }else validarNumero(valor); 
}

function validarRif(text){
    if(!text.value == null || !text.value == ""){
        if(!Revisa(rif,text.value)){
            alert("El formato del RIF debe ser vV o eE seguido de nueve digitos numericos");
            text.value="";
            document.forms[0].elements["numeroDocumento"].focus();
        }
    } 
}

function validarNumero(valor) {       
    var ok = true;
    if  (!Revisa(number,valor.value)) {
        alert (' El Numero de Documento debe ser un valor numerico ');
        valor.value = "";
        document.forms[0].elements["numeroDocumento"].focus();
        ok =  false;
    }
    return ok;
}

function verAyuda(item){
    var objDiv = document.getElementById(item);
    objDiv.style.visibility = "visible";
} 

function ocultarAyuda(item){
    var objDiv = document.getElementById(item);
    objDiv.style.visibility = "hidden";
}

function validarFormulario5(){
    document.getElementById("theTable").innerHTML = "";
    document.getElementById("theText").innerHTML = "";
    document.getElementById("botonaceptar").style.display = 'none';

    contextPath = document.getElementById("contextPath").value;
    var formulario = document.registroBean
    var ok = true;
    if  (document.forms[0].elements["tipoDocumento.codigo"].value == ""){       
        alert ('Seleccione el Tipo de Documento para proceder a registrarse');   
        document.forms[0].elements["tipoDocumento.codigo"].focus();
        ok = false;
    } 
    if  (document.forms[0].elements["pregunta2.codigo"].value == ""){     
        alert ('Debe seleccionar la nacionalidad');
        document.forms[0].elements["pregunta2.codigo"].focus();
        ok = false;
    } 
    if  (document.forms[0].elements["numeroDocumento"].value == ""){       
        alert('Coloque un numero de Documento valido');
        document.forms[0].elements["numeroDocumento"].focus();
        ok = false;
    } 
    if  (document.forms[0].elements["pregunta1"].value == ""){          
        alert('Debe colocar la fecha de nacimiento o fallecimiento (en caso de sucesión)');
        document.forms[0].elements["pregunta1"].focus();
        ok = false;
    }
    if (ok)  retrieveURL(contextPath); 
    
    function retrieveURL(contextPath) {  
        var url = contextPath + '/registro.do';
        var tipo = document.forms[0].elements["tipoDocumento.codigo"].value;     
        var num = document.forms[0].elements["numeroDocumento"].value;  
        var fecha = document.forms[0].elements["pregunta1"].value;       
        var nac = document.forms[0].elements["pregunta2.codigo"].value;       
        url = url + '?tipodoc=' +tipo + '&numdoc=' +num+ '&preg1=' +fecha + '&preg2=' +nac+'&sid='+Math.random();
        
        if (window.XMLHttpRequest) { // Non-IE browsers
            req = new XMLHttpRequest();
            req.onreadystatechange = processStateChange;
            try {
                req.open("GET", url, true);
            }catch (e) {
                alert(e);
            }
            req.send(null);
        }else{
            if (window.ActiveXObject) { // IE
                req = new ActiveXObject("Microsoft.XMLHTTP")  ; // INTERNET EXPLORER
                if (req) {
                    req.onreadystatechange = processStateChange;               
                    req.open("GET", url, true);       
                    req.send();
                }
            }else alert('Se sugiere usar Internet Explorer u otro navegador que soporte Ajax para poder usar la aplicacion');
        }
    } 
    
    function processStateChange() {      
        document.getElementById("theTable").innerHTML  = 'Espere verificando los datos del Contribuyente ....';
        if (req.readyState == 4) { // Complete        
            if (req.status == 200) { // OK response
                document.getElementById("theTable").innerHTML = req.responseText;   
            }   
        }
    }
}

function borrardatosreg(){
    document.forms[0].elements["tipoDocumento.codigo"].value = "";     
    document.forms[0].elements["numeroDocumento"].value = "";  
    document.forms[0].elements["pregunta1"].value = "";      
    document.getElementById("theTable").innerHTML = "";
    document.getElementById("theText").innerHTML = "";
    document.getElementById("botonaceptar").style.display = 'none';
}

function validardatos(){
    document.getElementById("theText").innerHTML = "";
    document.getElementById("botonaceptar").style.display = 'none';


    contextPath = document.getElementById("contextPath").value;
    var formulario = document.forms[1];
    var ok = true;
    with (formulario){
        if (usuario.value == '') {
            alert('Por Favor coloque el usuario');
            usuario.focus();
            ok = false;
        }
        if (clave.value == '') {
            alert('Por Favor coloque la clave');
            clave.focus();
            ok = false;
        } 
        if (clave1.value == '') {
            alert('Por Favor re-escriba la clave');
            clave1.focus();
            ok = false;
        }else{
            if (clave1.value != clave.value){        
                alert ('Las claves no coinciden');   
                clave1.focus();
                ok = false;
            } 
        }
        if (pregunta.value == '') {
            alert('Por Favor coloque la pregunta');
            pregunta.focus();
            ok = false;
        } 
        if (respuesta.value == '') {
            alert('Por Favor coloque la respuesta');
            respuesta.focus();
            ok = false;
        }
        if ((correo.value == '') || (!verifyMailAddress(correo.value))) {
            alert('Correo no valido, por Favor coloque el Correo correctamente');
            correo.focus();
            ok = false;
        }
    }
    if (ok)  registrarURL(contextPath); 
    
    function registrarURL(contextPath) {
        var url = contextPath + '/registrodos.do';
        var user = document.forms[1].elements["usuario"].value;     
        var pass = document.forms[1].elements["clave"].value;  
        var preg = document.forms[1].elements["pregunta"].value;       
        var resp = document.forms[1].elements["respuesta"].value;   
        var email = document.forms[1].elements["correo"].value;   
        url = url + '?usuario=' +user + '&clave=' +pass+ '&pregunta=' +preg + '&respuesta=' +resp+ '&correo=' +email+'&sid='+Math.random();
        
        if (window.XMLHttpRequest) { // Non-IE browsers
            req = new XMLHttpRequest();
            req.onreadystatechange = processStateChange;
            try {
                req.open("GET", url, true);
            }catch (e) {
                alert(e);
            }
            req.send(null);
        }else {
            if (window.ActiveXObject) { // IE
                req = new ActiveXObject("Microsoft.XMLHTTP")  ;
                if (req) {
                    req.onreadystatechange = processStateChange;
                    req.open("GET", url, true);
                    req.send();
                }
            }else alert('Se sugiere usar Internet Explorer u otro navegador que soporte Ajax para poder usar la aplicacion');
        }
    }
    
    function processStateChange() {
        document.getElementById("theText").innerHTML  = 'Espere ... registrando Contribuyente';  
        if (req.readyState == 4) { // Complete  
            document.getElementById("theText").innerHTML = req.responseText;                          
            if(req.responseText.search("El Usuario se ha registrado exitosamente") != -1){
                document.getElementById("theTable").innerHTML = "";
                document.getElementById("botonaceptar").style.display = '';
            }        
        }
    }
}

function borrardatos(){
    document.forms[1].elements["usuario"].value = "";
    document.forms[1].elements["clave"].value = "";  
    document.forms[1].elements["clave1"].value = "";  
    document.forms[1].elements["pregunta"].value = "";       
    document.forms[1].elements["respuesta"].value = "";   
    document.forms[1].elements["correo"].value = "";   
    document.getElementById("theText").innerHTML = "";
}

function validaFecha(campo){
    longitud = campo.value.length;
    if (longitud > 1){
        var dia;
        var mes;
        var ano;
        var e1;
        var e2;
        dia = campo.value.substring(0,2);
        e1  = campo.value.substring(2,3);
        mes = campo.value.substring(3,5);
        e2  = campo.value.substring(5,6);
        ano = campo.value.substring(6,10);
        
        if (!isNumeric(dia) || !isNumeric(mes) || !isNumeric(ano) || e1 != "/" || e2 != "/" )
            alert("La Fecha debe ser de la forma DD/MM/AAAA"); 
        
        if(dia.length != 2 || mes.length != 2 || ano.length != 4) {
            alert("El formato de la fecha es DD/MM/AAAA");
            campo.focus();
        }else{
            if (dia<1 || dia>31){
                alert("El día debe estar comprendido entre 1 y 31"); 
                campo.focus();
            }else{
                if (mes<1 || mes>12) {
                    alert("El mes debe estar comprendido entre 1 y 12"); 
                    campo.focus();
                }
            }
        }
    }
}

function isNumeric(strString){
    var strValidChars = "0123456789.,-";
    var strChar;
    var blnResult = true;
    for (i = 0; i < strString.length && blnResult == true; i++){
        strChar = strString.charAt(i);
        if (strValidChars.indexOf(strChar) == -1){
            blnResult = false;
        }
    }
    return(blnResult);
}

function esNumeroMod(e){
    tecla = (document.all) ? e.keyCode : e.which;
    var opc = false;
    if ((tecla >= 48 && tecla <= 57) || tecla == 9 || tecla == 8 || tecla == 0){
        opc = true;      
    } 
    return opc;        
}

function formatoFecha(fecha, e) {
    if(!esNumeroMod(e)){ 
    }else{ 
        if (fecha.value.length == 2 || fecha.value.length == 5){
            fecha.value = fecha.value + '/';
        }
    }
}

function nuevoRegistro(){
    contextPath = document.getElementById("contextPath").value;
    document.forms[0].action = contextPath + '/loadregistro.do';     
    document.forms[0].submit();
}