// JavaScript Document
/* CAMBIAR  la funcion validate(thisform) con los campos a validar*/
/* 		validate_required(campo,mensaje) campo tipo string de minimo 3 caracteres obligatorio
		validate_requiredmax(campo,mensaje,MaximoNumeroDeCaracteres) campo tipo string con max char
		validate_fecha(campo,mensaje) valida fechas correctas
		validate_enteros(campo,mensaje,valor_minimo,valor_maximo) valida un entero dentro de un rango
		validate_decimales(campo,mensaje,valor_minimo,valor_maximo) valida un entero o decimal dentro de un rango, si no
		se desea controlar rangos, los valores deben ir en null.
		validate_combo(campo,mensaje) valida que un combo sea seleccionado un valor
		validate_cedula(campo,mensaje valida el ingreso de 10 caracteres numericos
		validate_hora(campo) valida el ingreso de la hora en formato hh:mm desde las 00:00 hasta las 23:59
		validate_letras(campo,mensaje), valida el ingreso únicamente de letras
	    validate_fecha_registro(campo,fechaHoy,comparador,mensaje) Compara la fecha ingresada con la fechaHoy y Valida que la fecha ingresada cumpla la codición del comparador 
*/
function validate(thisform)
{
with (thisform)
  {	  if (validate_required(descDgoCargo,'Descripcion')==false)

					{descDgoCargo.focus();return false;}

  }
	return true;
}

