
function validate(thisform)
{
with (thisform)
  {	
	  if (validate_required(descripcion,'Descripción')==false)
					{descripcion.focus();return false;}
	 /* if (validate_letras(descripcion,'Descripción')==false)
					{descripcion.focus();return false;}*/

  }
	return true;
}

