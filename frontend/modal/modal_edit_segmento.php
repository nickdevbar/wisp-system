<?php
session_start();

if (isset($_SESSION["cod_usu"])) {
  require_once("../../backend/clase/ips.class.php");
  require_once("../../backend/clase/funciones_api.class.php");

  $obj_ips = new ips;
  $obj_api = new funciones_api;
  $obj_ips->cod_seg_ip = $_POST["id"];
  $obj_ips->asignar_valor();
  $obj_ips->puntero = $obj_ips->infoSegmento();
  $nom = $obj_ips->extraer_dato();

  $obj_ips->cod_router = $nom["routers_cod_router"];
  $obj_ips->asignar_valor();
  $obj_ips->puntero = $obj_ips->routerAConectar();
  $rou = $obj_ips->extraer_dato();

  $ip_api = $rou['ip_router'];
  $lo_api = $rou['user_router'];
  $pa_api = $rou['pass_router'];
  $po_api = $rou['puerto_router'];
  $bl_api = $rou['blacklist_router'];
  $wl_api = $rou['whitelist_router'];

  $obj_api->ip_router_api = $ip_api;
  $obj_api->login_api = $lo_api;
  $obj_api->password_api = $pa_api;
  $obj_api->port_api = $po_api;
  $obj_api->interfaz_api = $in_api;
  $obj_api->blacklist_api = $bl_api;
  $obj_api->whitelist_api = $wl_api;

  $obj_api->connect();

?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Editar Segmento - <?php echo $nom['seg_ip']; ?> </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
        <div>
          <strong>Segmento</strong>
          <input type="text" id="segmento" class="form-control" value="<?php echo $nom['seg_ip']; ?>">
          <input type="hidden" id="old_segmento" class="form-control" value="<?php echo $nom['seg_ip']; ?>">
        </div>

        <br>

        <div>
          <strong>Comentario</strong>
          <input type="text" id="comentario" class="form-control" value="<?php echo $nom['com_seg_ip']; ?>">
        </div>

        <br>

        <div>
          <strong>Interfaz de Salida </strong>
          <select name="interfaceRed" class="form-control" id="inter">
            <option value="<?php echo $nom['int_seg_ip']; ?>"><?php echo $nom['int_seg_ip']; ?></option>
            <option value="">--------</option>
            <!-- <option value="LAN">LAN</option> -->
            <?php $obj_api->ls_interfaces(); ?>
          </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editarSeg(<?php echo $_POST['id'];?>);">Guardar Cambios <i class="fas fa-save"></i></button>
      </div>
    </div>

  </div>

  <script>
    const editarSeg = (id) => {
      seg = $('#segmento').val();
      com = $('#comentario').val();
      old = $('#old_segmento').val();
      int = $('#inter').val();
      rou ='<?php echo $nom['routers_cod_router']?>'
      
      dataString = "cod_seg_ip=" + id + "&&seg_ip=" + seg + "&&com_seg_ip=" + com + "&&int_seg_ip=" + int +"&&old_seg=" + old +  "&&accion=cambiarSeg"
      console.log(dataString);
      console.log(rou);

      Swal.fire({
        title: '¿Deseas Actualizar el Segmento?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: `Si, Cambiarlo`,
        denyButtonText: `No`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          Swal.fire('Segmento cambiado', '', 'success');
          console.log(dataString);
           $.ajax({
            data: dataString,
            url: "../../backend/controlador/seg_ip/seg_ip.php?rou="+rou,
            type: "POST",
            success: function(response) {
              console.log(response);
              location.reload();
            }
          }); 
        } else if (result.isDenied) {
          Swal.fire('No se realizo ningun cambio', '', 'info');
        }
      })

    }
  </script>

  

<?php
} else {
  header("location: ../index.php");
  exit();
}
?>