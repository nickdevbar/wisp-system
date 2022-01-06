<?php
session_start();

if (isset($_SESSION["cod_usu"])) {
  require_once("../../backend/clase/mantenimiento.class.php");

  $obj_mantenimiento = new mantenimiento;

?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Registrar Mantenimiento </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
          <strong>Seleccione El Motivo.</strong>
          <select id="mot_man" class="form-control">
            <option value="">--Seleccione una opción--</option>

            <?php $obj_mantenimiento->puntero = $obj_mantenimiento->fallas();
            while (($falla = $obj_mantenimiento->extraer_dato()) > 0) { ?>
              <option value="<?php echo $falla['cod_fallas']; ?>"><?php echo $falla['nom_fallas']; ?></option>
            <?php } ?>
          </select>
        </div>
        <br>
        <div>
          <strong>Detalles de la falla.</strong>
          <textarea name="" id="det_man" cols="30" rows="6" style="resize:none;" class="form-control"></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crearMan();">Crear Factura</button>
      </div>
    </div>

  </div>

  <script>
    const crearMan = () => {
      let cod_con = '<?php echo $_POST['id']; ?>';
      let cod_fal = $('#mot_man').val();
      let det_man = $('#det_man').val();;

      datas = "obs_man=" + det_man + "&&cod_fallas=" + cod_fal + "&&cod_contratos=" + cod_con + "&&accion=crearMan";

      console.log(datas);

      $.ajax({
        data: datas,
        url: "../../backend/controlador/mantenimiento/mantenimiento.php",
        type: "POST",
        success: function(response) {
          console.log("Editado Exitoso");

          Swal.fire(
            'Mantenimiento Registrado!',
            '',
            'success'
          )

          window.open("../email/recibo_mantenimiento.php?contrato="+cod_con);
          location.reload();
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