<?php
session_start();

if (isset($_SESSION["cod_usu"])) {
  require_once("../../backend/clase/factura.class.php");

  $obj_factura = new factura;
  $obj_factura->cod_fac = $_POST["id"];
  $obj_factura->asignar_valor();
  $obj_factura->puntero = $obj_factura->porFactura();
  $fac = $obj_factura->extraer_dato();

?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Editar Factura #<?php echo $fac['num_factura'] ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div><strong>Monto Total</strong><input type="text" class="form-control" value="<?php echo $fac['mon_fac']; ?>" id="mon_tot"></div>
        <br>
        <div><strong>Monto Deducible</strong><input type="text" class="form-control" value="<?php echo $fac['mon_ded_fac']; ?>" id="mon_ded"></div>
        <br>
        <strong>Mes y Año</strong>
        <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:10px;">
          <select name="" id="mes_fac" class="form-control">
            <option value="<?php echo $fac['mes_fac']; ?>"> ---><?php echo $fac['mes_fac']; ?><--- </option>
            <option value="1">1 - Enero</option>
            <option value="2">2 - Febrero</option>
            <option value="3">3 - Marzo</option>
            <option value="4">4 - Abril</option>
            <option value="5">5 - Mayo</option>
            <option value="6">6 - Junio</option>
            <option value="7">7 - Julio</option>
            <option value="8">8 - Agosto</option>
            <option value="9">9 - Septiembre</option>
            <option value="10">10 - Octubre</option>
            <option value="11">11 - Noviembre</option>
            <option value="12">12 - Diciembre</option>
          </select>

          <select name="" id="ano_fac" class="form-control">
            <option value="<?php echo $fac['ano_fac']; ?>"> ---><?php echo $fac['ano_fac']; ?><--- </option>
                <?php
                $year = date('Y') + 5;
                for ($i = 2000; $i <= $year; $i++) { ?>
            <option value='<?php echo $i ?>'><?php echo $i ?></option>
          <?php } ?>

          </select>
        </div>

        <br>

        <div>
          <strong>Descripción</strong>
          <textarea class="form-control" rows="5" id="des_fac" style="resize:none;"><?php echo $fac['des_fac']; ?></textarea>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="actualizarFactura();">Editar Factura</button>
      </div>
    </div>

  </div>

  <script>
    const actualizarFactura = () => {
      cod_fac = '<?php echo $_POST['id'] ?>';
      mon_tot = $('#mon_tot').val();
      mon_ded = $('#mon_ded').val();
      mes_fac = $('#mes_fac').val();
      ano_fac = $('#ano_fac').val();
      des_fac = $('#des_fac').val();

      dataString = "cod_fac=" + cod_fac + "&&mes_fac=" + mes_fac + "&&ano_fac=" + ano_fac + "&&mon_fac=" + mon_tot + "&&mon_ded_fac=" + mon_ded + "&&des_fac=" + des_fac + "&&accion=actualizarFactura";
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
              'Se modifico la factura',
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