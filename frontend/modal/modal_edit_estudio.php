<?php
session_start();

if (isset($_SESSION["cod_usu"])) {

  require_once('../../backend/clase/cliente.class.php');

  $obj_cliente = new cliente;

  $obj_cliente->cod_cli = $_POST['id'];
  $obj_cliente->asignar_valor();
  $obj_cliente->puntero = $obj_cliente->estudioEdit();
  $cli = $obj_cliente->extraer_dato();
  
?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Editar Estudio de <?php echo $cli['nom_cli']?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
        <strong>Cedula:</strong>
                                    <div style="display:grid;grid-template-columns:1fr 2fr;grid-gap:10px;align-items:baseline;">
                                        <select name="" id="tip" class="form-control" onchange="verificarCedula();">
                                            <option value="<?php echo $cli['tipo_cli'];?>"> --><?php echo $cli['tipo_cli'];?><-- </option>

                                            <option value="V-">V-</option>
                                            <option value="J-">J-</option>
                                            <option value="G-">G-</option>
                                            <option value="E-">E-</option>
                                        </select>
                                        <input type="text" id="ced" placeholder="123456789" value="<?php echo $cli['ced_cli'];?>" class="form-control" onkeyup="verificarCedula();">
                                    </div>
                                    <div id="info" style="text-align:right;"></div>

                                    <div><strong>Nombre y Apellidos:</strong><input type="text" id="nom" value="<?php echo $cli['nom_cli'];?>" placeholder="Aleks Syntek" class="form-control"></div>
                                    <div><strong>Telefono</strong><input type="text" id="tel" placeholder="0000-000-0000" value="<?php echo $cli['tel_cli'];?>" class="form-control"></div>
                                    <div><strong>Segundo Telefono</strong><input type="text" id="tel2" placeholder="0276-000-0000" value="<?php echo $cli['tel2_cli'];?>" class="form-control"></div>
                                    <div><strong>Email</strong><input type="text" id="ema" value="<?php echo $cli['ema_cli'];?>" placeholder="correo@gmail.com" class="form-control"></div>

                                    <br>
                                    <h5 class="text-primary">Ubicación.</h5>

                                    <div><strong>Dirección</strong> <textarea autocomplete="nope" id="dir" style="resize:none;" placeholder="Av. Venezuela" class="form-control"><?php echo $cli['dir_cli'];?></textarea></div>
                                    <div><strong>Punto de Referencia</strong> <textarea id="pun" style="resize:none;" placeholder="Cerca de..." class="form-control"><?php echo $cli['pun_ref_cli'];?></textarea></div>
                                    <div><strong>Sector:</strong>
                                        <select name="" id="sec" class="form-control">
                                            <option value="<?php echo $cli['sector_cod_sector'];?>">---<?php echo $cli['nom_sector'];?>---</option>

                                            <?php $obj_cliente->puntero = $obj_cliente->sector();
                                            while (($sec = $obj_cliente->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $sec['cod_sector']; ?>"><?php echo $sec['nom_sector']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="actualizar();">Guardar Cambios <i class="fas fa-save"></i></button>
      </div>
    </div>

  </div>

  <script>
    const actualizar = () => {
                let cod = '<?php echo $_POST['id']?>';
                let tip = $('#tip').val();
                let ced = $('#ced').val();
                let nom = $('#nom').val();
                let tel = $('#tel').val();
                let tel2 = $('#tel2').val();
                let ema = $('#ema').val();
                let dir = $('#dir').val();
                let pun = $('#pun').val();
                let sec = $('#sec').val();

                dataString = "cod_cli=" + cod + "&&tipo_cli=" + tip + "&&ced_cli=" + ced + "&&nom_cli=" + nom + "&&tel_cli=" + tel + "&&tel2_cli=" + tel2 + "&&ema_cli=" + ema + "&&dir_cli=" + dir + "&&pun_ref_cli=" + pun + "&&sector_cod_sector=" + sec + "&&accion=editarEstudio";
                console.log(dataString);

                if (tip == "" || ced == "" || nom == "" || tel == "" || tel2 == "" || ema == "" || dir == "" || pun == "" || sec == "") {
                    Swal.fire(
                        'Campos Vacios!',
                        '',
                        'warning'
                    )
                } else {
                    $.ajax({
                        data: dataString,
                        url: "../../backend/controlador/cliente/cliente.php",
                        type: "POST",
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Editado con exito!!',
                                '',
                                'success'
                            )

                            location.reload();
                           
                        }
                    });
                }

            }

    /**********************************************************/
    const verificarCedula = () => {
          tip = $('#tip').val();
          ced = $('#ced').val();

          dataString = 'tipo_cli=' + tip + '&&ced_cli=' + ced + '&&accion=listarCedula';
          console.log(dataString);

          $.ajax({
            type: "POST",
            url: "../../backend/controlador/cliente/cliente.php",
            data: dataString,
            success: function(r) {
              console.log(r);

              if (r == 1) {
                $("#info").css("color", "#e74a3b");
                $("#but").hide("slow");
                $("#info").html('Esta cedula ya esta registrada <i class="fa fa-times" aria-hidden="true"></i>');
              } else {
                if (ced == "") {
                  $("#info").html('');
                  $("#but").show("slow");
                } else {
                  $("#info").css("color", "#1cc88a");
                  $("#but").show("slow");
                  $("#info").html('Esta cedula esta disponible <i class="fa fa-check" aria-hidden="true"></i>');
                }
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