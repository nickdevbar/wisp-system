<?php
session_start();

if (isset($_SESSION["cod_usu"])) {

  require_once('../../backend/clase/plan.class.php');
  $obj_plan = new plan; 
  $obj_plan->cod_router = $_POST["id"];
  $obj_plan->asignar_valor();
  $obj_plan->puntero = $obj_plan->lisRouter();
  $rou = $obj_plan->extraer_dato();

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
            <input type="text" placeholder="Server 1" class="form-control"  value="<?php echo $rou['nom_router'];?>" id="nom" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">User:</label>
            <input type="text" placeholder="root" class="form-control"  value="<?php echo $rou['user_router'];?>" id="use" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Pass:</label>
            <input type="text" placeholder="root" class="form-control"  value="<?php echo $rou['pass_router'];?>" id="pas" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">IP Router:</label>
            <input type="text" placeholder="192.168.0.0" class="form-control"  value="<?php echo $rou['ip_router'];?>" id="ipr" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Puerto Router:</label>
            <input type="text" placeholder="0000" class="form-control"  value="<?php echo $rou['puerto_router'];?>" id="pur" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Puerto Graf:</label>
            <input type="text" placeholder="80" class="form-control" value="<?php echo $rou['puerto_graf'];?>"  id="pug" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Blacklist:</label>
            <input type="text" placeholder="INACTIVOS" class="form-control"  value="<?php echo $rou['blacklist_router'];?>" id="bla" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Whitelist:</label>
            <input type="text" placeholder="Activos" class="form-control" id="whi" value="<?php echo $rou['whitelist_router'];?>" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="editRouter();" >Guardar Cambios <i class="fas fa-save"></i></button>
        </div>
      </div>

    </div>

    <script>
      const editRouter = () => {
        let cod = '<?php echo $_POST['id']?>';
        let nom = $('#nom').val();
        let use = $('#use').val();
        let pas = $('#pas').val();
        let ipr = $('#ipr').val();
        let pur = $('#pur').val();
        let pug = $('#pug').val();
        let bla = $('#bla').val();
        let whi = $('#whi').val();

        datas = "cod_router=" + cod + "&&nom_router=" + nom + "&&user_router=" + use + "&&pass_router=" + pas + "&&ip_router=" + ipr + "&&puerto_router=" + pur + "&&puerto_graf=" + pug + "&&blacklist_router=" + bla + "&&whitelist_router=" + whi + "&&accion=editRouter";

        console.log(datas);

        if (nom == "" || use == "" || pas == "" || ipr == "" || pur == "" || pug == "" || bla == "") {
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