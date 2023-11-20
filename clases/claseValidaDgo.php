<?php 
/**
* 
*/
class ValidaDgo
{
	/* Metodo que valida la fecha */	
	public function validate_fecha($value)
	{
		$expRegFecha = "/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/";

		if (!empty($value) && preg_match($expRegFecha, $value)) {
			return true;
		}else{
			return false;
		}
	}


	public function validate_sha1($value)
	{
		if ($value!='da39a3ee5e6b4b0d3255bfef95601890afd80709') {
			return true;
		} else {
			return false;
		}
	}


	public function valida_cedula($cedula){

		$expre="/^[0-9]{10}$/";
		if(preg_match($expre, $cedula)){
			return true;

		}
		else{
				return false;
		}



	}

	public function valida_Dactilar($codigo){

	$expre="/^[A|I|E|V]{1}+[0-9]{4}+[A|I|E|V]{1}+[0-9]{4}$/";


	if(preg_match($expre,$codigo)){
			return true;

		}
		else{
				return false;
		}


	}

	public function valida_email($email){

		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email))
	  {
	    return true;
	  }
	  return false;

	}

	public function valida_telf($cel){
		$expre="/^[0-9]{10}$/";

		if(preg_match($expre, $cel)){
				return true;

			}
			else{
					return false;
			}
	}
}

 ?>