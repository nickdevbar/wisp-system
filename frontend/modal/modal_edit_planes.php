<?php
session_start();

if (isset($_SESSION["cod_usu"])) {
  require_once('../../backend/clase/plan.class.php');
  $obj_plan = new plan; 
  $obj_plan->cod_plan = $_POST["id"];
  $obj_plan->asignar_valor();
  $obj_plan->puntero = $obj_plan->lisPLan();
  $plan = $obj_plan->extraer_dato();
  

?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Editar el plan <?php echo $plan["nom_plan"];?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
          <div class="form-group">
            <label for="exampleInputEmail1">Nombre del Plan:</label>
            <input type="text" placeholder="/ Megas " class="form-control" value="<?php echo $plan['nom_plan'];?>" placeholder="Precio del Plan" id="nom" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Precio del Plan:</label>
            <input type="text" placeholder="Sin puntos ni comas" class="form-control" value="<?php echo $plan['pre_plan'];?>" placeholder="Precio del Plan" id="pre" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Velocidad Subida:</label>
            <input type="text" placeholder="3" class="form-control" value="<?php echo $plan['vel_sub_plan'];?>" placeholder="Precio del Plan" id="sub" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Velocidad Descarga:</label>
            <input type="text" autocomplete="false" value="<?php echo $plan['vel_des_plan'];?>" placeholder="3" class="form-control" id="des">
          </div>


        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="editPlan();">Guardar Cambios <i class="fas fa-save"></i></button>
        </div>
      </div>

    </div>

    <script>
      const editPlan = () => {
        let cod = '<?php echo $_POST['id'];?>'
        let nom = $('#nom').val();
        let pre = $('#pre').val();
        let sub = $('#sub').val();
        let des = $('#des').val();

        datas = "cod_plan=" + cod +"&&nom_plan=" + nom + "&&pre_plan=" + pre + "&&vel_sub_plan=" + sub + "&&vel_des_plan=" + des + "&&accion=editPlan";

        console.log(datas);

        if (nom != "" || pre != "" || sub != "" || des != "") {
          $.ajax({
            data: datas,
            url: "../../backend/controlador/funciones/funciones.php",
            type: "POST",
            success: function(response) {
              console.log("Editado Exitoso");
              location.reload();
            }
          });
        } else {
          Swal.fire(
            'Debes llenar los campos!',
            'Escribe todos los datos para poder agregar un plan!',
            'warning'
          )
        }



      }
    </script>

  <?php
} else {
  header("location: ../index.php");
  exit();
}
  ?>