<?php
session_start();

if (isset($_SESSION["cod_usu"])) {
  
?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Estudio Positivo</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
          

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crearFactura();">Crear</button>
      </div>
    </div>

  </div>

  <script>
    const crearFactura = () => {
      let fec_cor = '<?php echo $act['fecha_corte_cod_fec_corte']; ?>';
      let cod_pla = '<?php echo $act['cod_plan'] ?>';
      let mon_fac = '<?php echo $act['pre_plan'] ?>';
      let cod_con = '<?php echo $_POST['id']; ?>';
      let ult = <?php echo $u['num_factura'] + 1 ?>;
      let anio = '<?php echo $anio; ?>';

      let nmes = $('#mes_fac').val();
      let mes = $('#mes_fac option:selected').text();
      let onlymes = mes.split("-");
      let des_fac = '<?php echo $act['nom_plan'] ?> - ' + onlymes[0];

      datas = "mes_fac=" + nmes + "&&ano_fac=" + anio + "&&mon_fac=" + mon_fac + "&&des_fac=" + des_fac + "&&fecha_corte=" + fec_cor + "&&cod_contratos=" + cod_con + "&&cod_plan=" + cod_pla + "&&num_factura=" + ult + "&&accion=crearFactura";

      console.log(datas);

      Swal.fire({
        title: 'Deseas Crear La Factura?',
        text: "",
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
            url: "../../backend/controlador/factura/factura.php",
            type: "POST",
            success: function(response) {
              console.log("Creado Exitoso");
              Swal.fire(
                'Creada!!',
                'Se creo la factura',
                'success'
              )
              location.reload();
            }
          });
        } else {
          Swal.fire(
            'No se realizo ningun cambio'
          )
        }
      })



    }
  </script>

<?php
} else {
  header("location: ../index.php");
  exit();
}
?>