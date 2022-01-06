<?php
session_start();

if (isset($_SESSION["cod_usu"])) {

  require_once("../../backend/clase/funciones.class.php");
  $obj_funciones = new funciones;
  
?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Agregar Usuario</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
        <div class="form-group">
                     <label for="exampleInputEmail1">Nombres:</label>
                     <input type="text" placeholder="Alejandro " class="form-control" placeholder="Precio del Plan" id="nombre" required>
                   </div>
                   <div class="form-group">
                     <label for="exampleInputEmail1">Apellidos:</label>
                     <input type="text" placeholder="Guzman" class="form-control" placeholder="Precio del Plan"  id="apelli" required>
                   </div>
                   <div class="form-group">
                     <label for="exampleInputEmail1">Teléfono:</label>
                     <input type="text" placeholder="000-000-0000" class="form-control" placeholder="Precio del Plan"  id="telefo" required>
                   </div>
                   <div class="form-group">
                     <label for="exampleInputEmail1">User:</label>
                     <input type="text" autocomplete="false" placeholder="user" class="form-control" placeholder="Precio del Plan" id="user">
                   </div>
                   <div class="form-group">
                     <label for="exampleInputEmail1">Pass:</label>
                     <input type="password" autocomplete="new-password" placeholder="12345678" class="form-control" placeholder="Precio del Plan" id="pass">
                   </div>
                   <div class="form-group">
                     <label for="exampleInputEmail1">Cargo:</label>
                     <select name="" id="nivel" class="form-control">
                       <option value=""> -->Cargo a elegir<-- </option>

                           <?php
                            $obj_funciones->puntero = $obj_funciones->roles();
                            while (($nivel = $obj_funciones->extraer_dato()) > 0) { ?>
                       <option value="<?php echo $nivel['cod_rol']; ?>"><?php echo $nivel['nom_rol']; ?></option>
                     <?php  } ?>
                     </select>
                   </div>  
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="addUsuario();">Crear Usuario</button>
      </div>
    </div>

  </div>

  <script>
       const addUsuario = () => {
         let nom = $("#nombre").val();
         let ape = $("#apelli").val();
         let tel = $("#telefo").val();
         let use = $("#user").val();
         let pas = $("#pass").val();
         let niv = $("#nivel").val();

         if (nom != "" && ape != "" && tel != "" && use != "" && pas != "") {

           console.log(nom + "/" + ape + "/" + tel + "/" + use + "/" + pas + "/" + niv);

           dataString = "nom_usu=" + nom + "&&ape_usu=" + ape + "&&usu_user=" + use + "&&usu_pass=" + pas + "&&roles_cod_rol=" + niv + "&&tel_usu=" + tel + "&&accion=addUsuario";

           $.ajax({
             data: dataString,
             url: "../../backend/controlador/funciones/funciones.php",
             type: "POST",
             success: function(response) {
               console.log("Registro Exitoso");
               console.log(response);

               location.reload();
             }
           });
         } else {

           Swal.fire(
             'Debes llenar los campos!',
             'Escribe todos los datos para poder registrar a un ususario!',
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