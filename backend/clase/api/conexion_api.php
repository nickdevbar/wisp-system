<?php
if(!session_id())
session_start();

if (isset($_SESSION['idusuarios'])){

require_once("api_mt.php");



$API = new routeros_api;



////////////////////// conexion con servidor+

if($API->connect()){




    if($API){ echo "Conectado"; }
    else{ echo "No Hay Servidores Registrados"; }

    }else{
    echo "<script>";
    echo "alert('No Existen Servidores Activos');";  
    echo "window.location = '../pages/l_servidores.php';";
    echo "</script>";  }

}else {
  header("location: ../../index.php");
  exit();
}
?>