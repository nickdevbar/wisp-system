<?php 

//include("config/config.php");
// include ("bd/classDB.php");
// $conexion = Db::getInstance();

require("../api/librerias/api_mt.php");
 
 $l_server = $conexion->ejecutar("SELECT * FROM server WHERE idserver='".$_POST["id"]."'");
    $c_server = mysql_num_rows($l_server);
    $arre_server=mysql_fetch_array($l_server);
   $iprouter_api= $arre_server["ip"];
   $user_api= $arre_server["user"];
    $pass_api=$arre_server["pass"]; 
    $puert_api=$arre_server["puert"];
////////////////////// conexion con servidor+


$API = new routeros_api();
$API->debug = false;
$API->connect($arre_server["ip"], $arre_server["user"], $arre_server["pass"], $arre_server["puert"]);

$ARRAY = $API->comm("/system/resource/print");


   $first = $ARRAY['0'];
$memperc = ($first['free-memory']/$first['total-memory']);
$hddperc = ($first['free-hdd-space']/$first['total-hdd-space']);
$mem = ($memperc*100);
$hdd = ($hddperc*100);
echo $arre_server["nombre_server"];
echo "<table width=550 border=0 align=center>";
echo "<tr><td>Platform, board name and Ros version is:</td><td>" . $first['platform'] . " - " . $first['board-name'] . " - "  . $first['version'] . " - " . $first['architecture-name'] . "</td></tr><br />";
echo "<tr><td>Cpu and available cores:</td><td>" . $first['cpu'] . " at " . $first['cpu-frequency'] . " Mhz with " . $first['cpu-count'] . " core(s) "  . "</td></tr><br />";
echo "<tr><td>Uptime is:</td><td>" . $first['uptime'] . " (hh/mm/ss)" . "</td></tr><br />";
echo "<tr><td>Cpu Load is:</td><td>" . $first['cpu-load'] . " %" . "</td></tr><br />";
echo "<tr><td>Total,free memory and memory % is:</td><td>" . $first['total-memory'] . "Kb - " . $first['free-memory'] . "Kb - " . number_format($mem,3) . "% </td></tr><br />";
echo "<tr><td>Total,free disk and disk % is:</td><td>" . $first['total-hdd-space'] . "Kb - " . $first['free-hdd-space'] . "Kb - " . number_format($hdd,3) . "% </td></tr><br />";
echo "<tr><td>Sectors (write,since reboot,bad blocks):</td><td>" . $first['write-sect-total'] . " - " . $first['write-sect-since-reboot'] . " - " . $first['bad-blocks'] . "% </td></tr><br />";

echo "</table>";


   $API->disconnect();



?>