<?php
echo "aqui llego";
 $archivo = $_FILES["archivo"];

$carpetaDestino="../img/logo/";

	$size = $_FILES["archivo"]['size'];
	$type = $_FILES["archivo"]['type'];
	$name =$_FILES["archivo"]['name'];

		if ($archivo !="") {
		echo "Se creo exitosamente";
		echo $destino = $carpetaDestino.$name;
		 copy($img = $_FILES['archivo']['tmp_name'],$destino);
		 $img="../img/logo/".$name;
		
		}else{
            echo "fallo al crear";
        }

?>