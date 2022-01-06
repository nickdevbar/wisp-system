<?php
session_start();

if (isset($_SESSION["cod_usu"])) {
  require_once("../../backend/clase/factura.class.php");

  $obj_factura = new factura;
  $obj_factura->cod_fac = $_POST["id"];
  $obj_factura->asignar_valor();
  $obj_factura->puntero = $obj_factura->facturaPaga();
  $fac = $obj_factura->extraer_dato();

?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Editar Factura #<?php echo $_POST["id"]; ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">
        
        <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:10px;">
        <div>
        <strong>Monto Del Pago</strong>
        <input type="text" class="form-control" value="<?php echo $fac['mon_pag_fac']; ?>" id="mon_pag">
        </div>
        <div>
        <strong>Forma de Pago</strong>
          <select name="" id="for_pag" class="form-control">
            <option value="<?php echo $fac['cod_for_pag']; ?>"> ---><?php echo $fac['nom_for_pag']; ?><--- </option>

            <?php $obj_factura->puntero = $obj_factura->formaPago();
                  while (($fp = $obj_factura->extraer_dato()) > 0) { ?>
            <option value="<?php echo $fp['cod_for_pag']; ?>"> <?php echo $fp['nom_for_pag']; ?> </option>
            <?php } ?>
          </select>
          </div>

        </div>

        <br>

        <div>
          <strong>Motivo Del Cambio</strong>
          <textarea class="form-control" rows="5" id="obs_pag" style="resize:none;">Editado: <?php echo $fac['obs_pag_fac']; ?></textarea>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="actualizarFacturaPaga();">Editar Factura</button>
      </div>
    </div>

  </div>

  <script>
    const actualizarFacturaPaga = () => {
      cod_fac = '<?php echo $_POST['id'] ?>';
      mon_pag = $('#mon_pag').val();
      obs_pag = $('#obs_pag').val();
      for_pag = $('#for_pag').val();

      dataString = "factura_cod_fac=" + cod_fac + "&&obs_pag_fac=" + obs_pag + "&&mon_pag_fac=" + mon_pag + "&&forma_pago_cod_for_pag=" + for_pag + "&&accion=actualizarFacturaPaga";
      console.log(dataString);

      $.ajax({
        data: dataString,
        url: "../../backend/controlador/factura/factura.php",
        type: "POST",
        success: function(response) {
          console.log("Editado Exitoso");
          console.log(response);
          if (response > 0) {
            Swal.fire(
              'Se modifico el pago',
              '',
              'success'
            )

            location.reload();
          }
        }
      });
    }
  </script>


<?php
} else {
  header("location: ../index.php");
  exit();
}
?>