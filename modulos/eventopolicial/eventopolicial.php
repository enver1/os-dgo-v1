<!-- <script type="text/javascript"> 
	/**
	$(document).ready(function() {
		MostrarListadoFichas();
	});
	*/
	/**
	 * Muestra información de la ficha Ecu 911
	 
	function MostrarFichaEcu(form){
		$.ajax({
			type: "POST",
			url: "modulos/evento115/fichaecu.php",
			//data: $(form).serialize(),
			success: function(result){
				try{
					console.log($('#Evento115Id'));
					$('#Evento115Id').html(result);
				}catch(e){
					console.log(e);
				}
			}
		});
	}*/
	/**
	 * Muestra información de la ficha Ecu 911
	 
	function MostrarListadoFichas(){
		$.ajax({
			type: "POST",
			url: "modulos/evento115/listadofichas.php",
			//data: $(form).serialize(),
			success: function(result){
				try{
					console.log($('#Evento115Id'));
					$('#Evento115Id').html(result);
				}catch(e){
					console.log(e);
				}
			}
		});
	}*/
</script>
<!-- <div id="Evento115Id"></div> -->
<!-- <script type="text/javascript" src="modulos/evento115/script/fichaecu.js"></script> -->