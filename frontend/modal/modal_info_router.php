<?php
session_start();

if (isset($_SESSION["cod_usu"])) {

  require_once('../../backend/clase/company.class.php');
  require_once('../../backend/clase/funciones_api.class.php');

  $obj_api = new funciones_api;

  $obj_com = new company;
  $obj_com->cod_router = $_POST["id"];
  $obj_com->asignar_valor();
  $obj_com->puntero = $obj_com->routerInfo();
  $rou = $obj_com->extraer_dato();

  $obj_api->ip_router_api = $rou['ip_router'];
  $obj_api->login_api = $rou['user_router'];
  $obj_api->password_api = $rou['pass_router'];
  $obj_api->port_api = $rou['puerto_router'];
  $obj_api->interfaz_api = 'LAN';

  $obj_api->connect();

?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Información y Estatus</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
          <?php $obj_api->showInfo();
          ?>
        </div>




      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>


<?php
} else {
  header("location: ../index.php");
  exit();
}
?>