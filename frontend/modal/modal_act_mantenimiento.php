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
        <h3 class="modal-title">Actualizar Mantenimiento</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div><strong>Tecnico:</strong><select name="" class="form-control" id="tec_man">

        <option value=""> -- ¿Quien Realizo El Mantenimiento? -- </option>

        <?php $obj_mantenimiento->puntero = $obj_mantenimiento->listarUsu();
               while (($u = $obj_mantenimiento->extraer_dato()) > 0) { ?>
        <option value="<?php echo $u['cod_usu'];?>"><?php echo $u['nom_usu'];?></option>

        <?php } ?>

        </select></div>

        <br>

        <div><strong>Solución:</strong><input type="text" class="form-control" value="" id="sol_man" placeholder="Mover la antena, arreglar cable...."></div>

        <br>

        <div><strong>Observación:</strong><textarea name="" class="form-control" id="obs_man" rows="3" style="resize:none;" placeholder="Informacion adicional....."></textarea></div>

        <br>

        <div><strong>Imagen <span class="text-secondary"> *Opcional</span></strong>
      <form method="POST" enctype="multipart/form-data">
      <input type="file" class="form-control" id="img_man"></div>
      </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fas fa-times"></i></button>
        <button type="button" class="btn btn-success" onclick="actualizarMan();">Mantenimiento Realizado <i class="fas fa-check"></i></button>
      </div>
    </div>

  </div>

  <script>
    const subirFoto = () => {

      var blobFile = document.getElementById("img_man").files[0];
    //var blobFile = $('#img_man').files[0];
      var formData = new FormData();
      formData.append("archivo", blobFile);

      console.log(formData);

    $.ajax({
       url: "../pages/subirFoto.php",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       success: function(response) {
           console.log(response);
       },
       error: function(jqXHR, textStatus, errorMessage) {
           console.log("No llego nada " + errorMessage); // Opcional
       }
    });
    }


    const actualizarMan = () => {
      let cod_man = '<?php echo $_POST['id']?>';
      let sol_man = $('#sol_man').val();
      let obs_man = $('#obs_man').val();
      let img_man = $('#img_man').val();
      let tec_man = $('#tec_man').val();

      if(img_man != ""){
        subirFoto();
      }

      let ext = img_man.slice(12);
      console.log(ext);

      datas = "mantenimientos_cod_man=" +cod_man+ "&&obs_act_man=" + obs_man + "&&sol_act_man=" + sol_man + "&&img_act_man=" + ext + "&&usuarios_cod_usu=" + tec_man + "&&accion=actualizarMan";

      console.log(datas);

      $.ajax({
        data: datas,
        url: "../../backend/controlador/mantenimiento/mantenimiento.php",
        type: "POST",
        success: function(response) {
          console.log("Editado Exitoso");

          Swal.fire(
            'Mantenimiento Actualizado!',
            '',
            'success'
          )

          window.open("../email/recibo_mantenimiento_listo.php?cod_man="+cod_man);
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