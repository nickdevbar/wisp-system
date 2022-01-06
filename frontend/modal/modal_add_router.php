<?php
session_start();

if (isset($_SESSION["cod_usu"])) {

?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Agregar Un Router</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
          <div class="form-group">
            <label for="exampleInputEmail1">Nombre del Router:</label>
            <input type="text" placeholder="Server 1" class="form-control" id="nom" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">User:</label>
            <input type="text" placeholder="root" class="form-control" id="use" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Pass:</label>
            <input type="text" placeholder="root" class="form-control" id="pas" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">IP Router:</label>
            <input type="text" placeholder="192.168.0.0" class="form-control" id="ipr" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Puerto Router:</label>
            <input type="text" placeholder="0000" class="form-control" id="pur" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Puerto Graf:</label>
            <input type="text" placeholder="80" class="form-control" id="pug" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Blacklist:</label>
            <input type="text" placeholder="INACTIVOS" class="form-control" id="bla" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Whitelist:</label>
            <input type="text" placeholder="Activos" class="form-control" id="whi" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="addRouter();">Crear</button>
        </div>
      </div>

    </div>

    <script>
      const addRouter = () => {
        let nom = $('#nom').val();
        let use = $('#use').val();
        let pas = $('#pas').val();
        let ipr = $('#ipr').val();
        let pur = $('#pur').val();
        let pug = $('#pug').val();
        let bla = $('#bla').val();
        let whi = $('#whi').val();

        datas = "nom_router=" + nom + "&&user_router=" + use + "&&pass_router=" + pas + "&&ip_router=" + ipr + "&&puerto_router=" + pur + "&&puerto_graf=" + pug + "&&blacklist_router=" + bla + "&&whitelist_router=" + whi + "&&accion=addRouter";

        console.log(datas);

        if (nom == "" || use == "" || pas == "" || ipr == "" || pur == "" || pug == "" || bla == "" || whi == "") {
          Swal.fire(
            'Debes llenar los campos!',
            'Escribe todos los datos para poder agregar un plan!',
            'warning'
          )
        } else {
          $.ajax({
            data: datas,
            url: "../../backend/controlador/funciones/funciones.php",
            type: "POST",
            success: function(response) {
              console.log("Editado Exitoso");
              location.reload();
            }
          });
        }

      }
    </script>

  <?php
} else {
  header("location: ../index.php");
  exit();
}
  ?>