function confirmar_eliminar(objeto,texto){
var confirmacion=confirm(texto);
if (confirmacion){
	objeto.href += '&vf_confirmado=1';
	return 1;
}
this.focus()
return false;
}

function existe_algo_chequeado(texto){
// verifica si algun checkboxes  deltro del formulario est� seleccionado, ojo!!! si existen checkboxes
// con otra funcionalidad distinta de la que se est� verificando.
	for (var i=0;i < document.forms[0].elements.length;i++)
        		{
        			var e = document.forms[0].elements[i];
        			if (e.type == "checkbox")
            			{   
            				if (e.checked == true) return true; 
		      	}
	}
}



function confirmar_eliminar_boton(objeto,texto){
var confirmacion;
if (existe_algo_chequeado(' es un checkbox????') == true){ 
	confirmacion=confirm(texto);
	if (confirmacion){
		return true;
	}
}
else{
	alert('Verifique!!!!, no ha seleccionado ning�n elemento')
}
this.focus()
return false;
}
