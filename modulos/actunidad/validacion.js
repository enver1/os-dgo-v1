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
  {	  if (validate_combo(idDgoProcSuper,'Proceso Supervision')==false)

					{idDgoProcSuper.focus();return false;}
	  if (validate_combo(idDgpUnidad,'Unidad')==false)

					{idDgpUnidad.focus();return false;}
	  if (validate_required(descDgoActUnidad,'Descripcion')==false)

					{descDgoActUnidad.focus();return false;}
	  if (validate_required(recursoHumano,'Recurso Humano')==false)

					{recursoHumano.focus();return false;}
	  if (validate_required(recursoMaterial,'Recurso Material')==false)

					{recursoMaterial.focus();return false;}
	  if (validate_required(recursoFinanciero,'Recurso Financiero')==false)

					{recursoFinanciero.focus();return false;}
	  /*if (validate_fecha(fechaInicio,'Fecha Inicio')==false)

					{fechaInicio.focus();return false;}
	  if (validate_fecha_registro(fechaInicio,fechaHoy,'mayor','Fecha Inicio')==false)

					{fechaFin.focus();return false;}
	  if (validate_fecha(fechaFin,'Fecha Final')==false)

					{fechaFin.focus();return false;}
	  if (validate_fecha_registro(fechaFin,fechaHoy,'mayor','Fecha Final')==false)

					{fechaFin.focus();return false;}*/

  }
	return true;
}

