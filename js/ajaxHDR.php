<?php /* carga la informacion en el formulario cuando se hace click en un elemento de la grilla, recibe como parametro el id del registro*/ ?>
<script>
function editar(c){
	var urlt = 'integrantesforma.php?id=<?php echo $_GET['id'] ?>&c='+c;  
//	$('#formulario').html('<p><img src="../../../funciones/paginacion/images/ajax-loader.gif" /></p>');        
//	$('#formulario').load( urlt );
// 	$("html, body").animate({ scrollTop: 0 }, "slow");
	window.location.href=urlt;
}
function borrarIntegrante(id) {
//var result = '';
//		$.ajax({
//		type: "GET",
//				url: "../hdr/borrar/borraIntegrante.php?id=" + id,
//				data: values,
//				async: false,
//				success: function(response){
//				result = eval(response);
//						});
//		}
	}

</script>