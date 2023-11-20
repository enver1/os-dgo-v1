// JavaScript Document
/* CAMBIAR  al final de este archivo la funcion validate(thisform) con los campos a validar*/
/* 	validate_required(campo,mensaje) campo tipo string de minimo 3 caracteres obligatorio
		validate_fecha(campo,mensaje) valida fechas correctas
		validate_enteros(campo,mensaje,valor_minimo,valor_maximo) valida un entero dentro de un rango
		validate_combo(campo,mensaje) valida que un combo sea seleccionado un valor
		validate_cedula(campo,mensaje valida el ingreso de 10 caracteres numericos
		validate_hora(campo) valida el ingreso de la hora en formato hh:mm desde las 00:00 hasta las 23:59
*/

function validate_fecha(fecha){
	if (fecha != undefined && fecha.value != "" ){
		if (!/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test(fecha.value)){
			alert("formato de fecha no valido (aaaa-mm-dd)");
			return false;
		}
		var anio  =  parseInt(fecha.value.substring(0,4),10);
		var mes  =  parseInt(fecha.value.substring(5,7),10);
		var dia =  parseInt(fecha.value.substring(8),10);
	switch(mes){
		case 1:
		case 3:
		case 5:
		case 7:
		case 8:
		case 10:
		case 12:
			numDias=31;
			break;
		case 4: case 6: case 9: case 11:
			numDias=30;
			break;
		case 2:
			if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
			break;
		default:
			alert("Fecha introducida erroneas");
			return false;
	}
 
		if (dia>numDias || dia==0){
			alert("Fecha introducida erronea");
			return false;
		}
		return true;
	}
	else
		{alert("Fecha introducida erronea");return false;}
}

function comprobarSiBisisesto(anio){
if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
	return true;
	}
else {
	return false;
	}
}

function validate_hora(hora){
	if (hora != undefined && hora.value != "" ){
		if (!/^[0-9]{2}:[0-9]{2}$/.test(hora.value)){
			alert("formato de Hora no valido (hh:mm)");
			return false;
		}
		var horas  =  parseInt(hora.value.substring(0,2),10);
		var minus  =  parseInt(hora.value.substring(3,5),10);
		if (horas>23 || minus>59){
			alert("Hora introducida erronea");
			return false;
		}
		return true;
	}
	else
		{alert("Hora introducida erronea");return false;}
}


function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt+' no puede estar en blanco');return false;
    }
  else
    {
		if(value.length<3)
		{
			alert(alerttxt+' debe tener al menos 3 caracteres');return false;
			}
		else
		{
		    return true;
		}
    }
  }
}

function validate_enteros(field,alerttxt,minimo,maximo)
{
with (field)
  {
	var checkOK = "1234567890.";
	var checkStr = field.value;
	var allValid = true;
	for (i = 0; i < checkStr.length; i++)
	{
		ch = checkStr.charAt(i);
		for (j = 0; j < checkOK.length; j++)
		if (ch == checkOK.charAt(j))
		break;
		if (j == checkOK.length)
		{
			allValid = false;
			break;
		}
	}
	if (!allValid)
	{
	alert(alerttxt+" escriba numeros enteros sin decimales");
	field.focus();
	return (false);
	}
	if (parseInt(value)<minimo || parseInt(value)>maximo)
	{
		alert(alerttxt+" escriba un numero entre "+minimo+" y "+maximo);
		return (false);
	}
	}
}

function validate_cedula(field,alerttxt)
{
with (field)
  {
	var checkOK = "1234567890";
	var checkStr = field.value;
	var allValid = true;
	for (i = 0; i < checkStr.length; i++)
	{
		ch = checkStr.charAt(i);
		for (j = 0; j < checkOK.length; j++)
		if (ch == checkOK.charAt(j))
		break;
		if (j == checkOK.length)
		{
			allValid = false;
			break;
		}
	}
	if (!allValid)
	{
	alert(alerttxt+" escriba solo numeros");
	focus();
	return (false);
	}

  	if (checkStr.length!=10)
	{
		alert(alerttxt+" debe tener 10 digitos");
		return (false);
	}
	}
}

function validate_combo(field,alerttxt)
{
	
with (field)
  {
  if (value=="0" || value=="" || value==" ")
    {
    alert('Seleccione un valor en el campo '+alerttxt);return false;
    }
  else
    {
	    return true;
    }
  }
}

/* Esta funcion es para CAMBIAR*/
function validate(thisform)
{
with (thisform)
  {
	  if (validate_required(descripcion,"La Descripcion")==false)
	  {descripcion.focus();return false;}
  }
	return true;
}

