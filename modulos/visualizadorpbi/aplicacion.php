<?php
if(isset($_SESSION["usuarioAuditar"])){
    $url = "https://app.powerbi.com/view?r=eyJrIjoiODgyNGFkNzctM2VmNS00OTJmLWIwZTgtOTgyYTFiYWU3M2ExIiwidCI6IjQ5Njg0MTQ5LWVlYzEtNGQ3NS04ODA1LWMwZDQ0MzAxNGE5NyIsImMiOjF9&pageName=ReportSection714aa15700d45338e1c7";
    ?>
    <input type="button" value="Visualizador Power BI" class="boton_general" style='width:250px' onclick="javascript:window.open('<?=$url?>','','width=1024,height=720,left=50,top=50,toolbar=no, location=no, status=no, directories=no, scrollbars=no, menubar=no'); return false" />
    <?php
}else{
    echo "USUARIO NO LOGEADO";
}