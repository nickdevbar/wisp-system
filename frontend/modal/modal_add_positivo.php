<?php
session_start();

if (isset($_SESSION["cod_usu"])) {
  require_once('../../backend/clase/cliente.class.php');

  $obj_cliente = new cliente;

  $obj_cliente->cod_cli = $_POST['id'];
  $obj_cliente->asignar_valor();
  $obj_cliente->puntero = $obj_cliente->persona();
  $cli = $obj_cliente->extraer_dato();

  $obj_cliente->puntero = $obj_cliente->ultimoNumero();
  $ult = $obj_cliente->extraer_dato();

  $nc = $ult['ultimo'] + 1;
?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Crear contrato para <?php echo $cli['nom_cli'];?><i class="fas fa-user"></i></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

       <div class="mt-2"><strong>Fecha Realizado</strong><input type="date" class="form-control" id="rea"></div>

       <div class="mt-2"><strong>Tipo Instalación</strong><select name="" class="form-control" id="tip">
       <option value=""> --Tipo-- </option>
       <?php $obj_cliente->puntero = $obj_cliente->tipo();
              while (($tip = $obj_cliente->extraer_dato()) > 0) { ?>
              <option value="<?php echo $tip['cod_tipo_ins'];?>"> <?php echo $tip['nom_tipo_ins'];?> </option>
              <?php } ?>
       </select></div>

       <div class="mt-2"><strong>Dia de Cobro</strong><select name="" class="form-control" id="dia">
       <option value="<?php echo date('d')?>"> <?php echo date('d')?> </option>
       <option value=""> ---------- </option>
       <?php $obj_cliente->puntero = $obj_cliente->fecha();
              while (($fec = $obj_cliente->extraer_dato()) > 0) { ?>
              <option value="<?php echo $fec['cod_fec_corte'];?>"> <?php echo $fec['dia_fec_corte'];?> </option>
              <?php } ?>
       </select></div>

       <div class="mt-2"><strong>Router</strong><select name="" class="form-control" id="rou">
       <option value=""> --Router-- </option>
       <?php $obj_cliente->puntero = $obj_cliente->routers();
              while (($rou = $obj_cliente->extraer_dato()) > 0) { ?>
              <option value="<?php echo $rou['cod_router'];?>"> <?php echo $rou['nom_router'];?> </option>
              <?php } ?>
       </select></div>

       <div class="mt-2"><strong>Tecnico</strong><select name="" class="form-control" id="tec">
       <option value=""> --Tecnico-- </option>
       <?php $obj_cliente->puntero = $obj_cliente->usuarios();
              while (($usu = $obj_cliente->extraer_dato()) > 0) { ?>
              <option value="<?php echo $usu['cod_usu'];?>"> <?php echo $usu['nom_usu']. " " .$usu['ape_usu'];?> </option>
              <?php } ?>
       </select></div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="addPositivo();">Confirmar <i class="fas fa-check"></i></button>
      </div>
    </div>

  </div>

  <script>
    const addPositivo = () => {
      let cod = '<?php echo $_POST['id']; ?>';
      let rea = $('#rea').val();
      let tip = $('#tip').val();
      let dia = $('#dia').val();
      let rou = $('#rou').val();
      let tec = $('#tec').val();
      let num = '<?php echo $nc?>';

      datas = "clientes_cod_cli=" + cod + "&&num_contrato=" + num + "&&routers_cod_router=" + rou + "&&fecha_corte_cod_fec_corte=" + dia + "&&tipo_instalacion_cod_tipo_ins=" + tip + "&&usuarios_cod_usu=" + tec + "&&accion=addPositivo";

      console.log(datas);

      if (rea == "" || tip == "" || dia == "" || rou == "" || tec == "") {
        Swal.fire(
                'Campos Vacios!!',
                '',
                'warning'
              )
}else{
  Swal.fire({
        title: '¿Deseas Confirmar?',
        text: "Pasara el cliente a Activo y le creara un contrato",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Crear',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            data: datas,
            url: "../../backend/controlador/cliente/cliente.php",
            type: "POST",
            success: function(response) {
              console.log("Creado Exitoso");
              Swal.fire(
                'Agregado!!',
                'Se agrego el cliente a tu lista de clientes activos',
                'success'
              )
              location.href = 'detalle_contratos.php?cod_cli='+cod;
            }
          });
        } else {
          Swal.fire(
            'No se realizo ningun cambio'
          )
        }
      })
}

      



    }
  </script>

<?php
} else {
  header("location: ../index.php");
  exit();
}
?>