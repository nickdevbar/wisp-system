<?php
echo "aqui llego";
 $archivo = $_FILES["archivo"];

$carpetaDestino="../img/mantenimiento/";

	$size = $_FILES["archivo"]['size'];
	$type = $_FILES["archivo"]['type'];
	$name =$_FILES["archivo"]['name'];

		if ($archivo !="") {
		echo "Se creo exitosamente";
		echo $destino = $carpetaDestino.$name;
		 copy($img = $_FILES['archivo']['tmp_name'],$destino);
		 $img="../img/mantenimientos/".$name;
		
		}else{
            echo "fallo al crear";
        }

?>