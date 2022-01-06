<?php
session_start();

if (isset($_SESSION["company"])) {

  require_once("../../backend/clase/funciones_api.class.php");
  require_once("../../backend/clase/ips.class.php");
  $obj_api = new funciones_api;
  $obj_ips = new ips;

  $obj_ips->cod_router = $_GET["cod_router"];
  $obj_ips->asignar_valor();
  $obj_ips->puntero = $obj_ips->routerAConectar();
  $ips = $obj_ips->extraer_dato();

  $ip_api = $ips['ip_router'];
  $lo_api = $ips['user_router'];
  $pa_api = $ips['pass_router'];
  $po_api = $ips['puerto_router'];
  $bl_api = $ips['blacklist_router'];
  $wl_api = $ips['whitelist_router'];

  $obj_api->ip_router_api = $ip_api;
  $obj_api->login_api = $lo_api;
  $obj_api->password_api = $pa_api;
  $obj_api->port_api = $po_api;
  $obj_api->blacklist_api = $bl_api;
  $obj_api->whitelist_api = $wl_api;

  $obj_api->connect();

?>
  <html>

  <body>
    <div>
      <strong>Interfaz de Salida </strong>
      <div>
        <select name="interfaceRed" class="form-control" id="int_seg">
          <!-- <option value="LAN">LAN</option> -->
          <?php $obj_api->ls_interfaces(); ?>
        </select>
      </div>
    </div>
  </body>

  </html>
<?php

} else {
  header("location: ../index.php");
  exit();
}
?>