<!-- Prototype y Scriptaculous-->
<script type="text/javascript">
	$(document).ready(function() {
		MostrarListadoFichas();
	});
	/**
	 * Muestra información de la ficha Ecu 911
	 */
	function MostrarFichaEcu(codigo){
		$.ajax({
			type: "POST",
			url: "modulos/evento115/fichaecu.php",
			data: {Evento: codigo},
			success: function(result){
				try{
					//console.log($('#Evento115Id'));
					$('#Evento115Id').html(result);
				}catch(e){
					console.log(e);
				}
			}
		});
	}
	/**
	 * Muestra información de la ficha Ecu 911
	 */
	function MostrarListadoFichas(){
		$.ajax({
			type: "POST",
			url: "modulos/evento115/listadofichas.php",
			success: function(result){
				try{
					$('#Evento115Id').html(result);
				}catch(e){
					console.log(e);
				}
			}
		});
	}
</script>
<div id="Evento115Id"></div>
<script type="text/javascript" src="modulos/evento115/script/fichaecu.js"></script>