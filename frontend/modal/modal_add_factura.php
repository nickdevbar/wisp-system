<?php
session_start();

if (isset($_SESSION["cod_usu"])) {
  require_once("../../backend/clase/factura.class.php");

  $obj_factura = new factura;
  $obj_factura->cod_contratos = $_POST["id"];
  $obj_factura->asignar_valor();

  $obj_factura->puntero = $obj_factura->cliente();
  $act = $obj_factura->extraer_dato();

  $obj_factura->puntero = $obj_factura->ultimaFactura();
  $u = $obj_factura->extraer_dato();

  $obj_factura->puntero = $obj_factura->contarAnio();
  $m = $obj_factura->extraer_dato();

  if ($m['meses'] == 12) {
    $anio = date('Y') + 1;
    $obj_factura->anio = $anio;
    $obj_factura->asignar_valor();
  } else {
    $anio = date("Y");
    $obj_factura->anio = $anio;
    $obj_factura->asignar_valor();
  }

  $obj_factura->puntero = $obj_factura->consultarUltima();
  $ult = $obj_factura->extraer_dato();

  $mes_fac = $ult["mes_fac"] + 1;




?>
  <!--modal-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Crear Factura</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">

        <div>
          <strong>Seleccione el Mes.</strong>
          <select id="mes_fac" class="form-control">
            <?php
            //Obtengo la fecha con un formato determinado para poder separarlo por parte  
            $fsis = date("Y m d");
            //Arreglo con los nombres de los meses
            $mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            //Voy separando en variables las partes de la fecha ke me interesan
            list($sano, $smes, $sdia) = explode(" ", $fsis);

            //echo "<option value=1>".$anio." ".$smes." ".$sdia."</option>";

            //Recorro el arreglo de nombres de meses y voy creando los options correspondientes
            for ($i = $mes_fac; $i <= count($mes); $i++) {
              //Inicializo la etiqueta del option
              echo "<option value=\"";
              if ($i < 10) {
                echo "$i";
              } else {
                echo "$i";
              }
              echo "\"";
              //Si coincide el mes de la iteracion con el actual lo pongo seleccionado
              /* if($smes == $i){
                    echo" selected"; 
                }  */
              //Establezco como valor a mostrar el nombre del mes correspondiente a la iteración actual
              echo ">" . $mes[$i - 1] . "
                - $anio</option>\n";
              //Y cierro la etiqueta del option
            }
            //Cierro la etiqueta del select    
            ?>
          </select>
        </div>
        <br>
        <div>
          <strong>Plan De Navegación</strong>
          <select id="pla_fac" class="form-control" disabled>
            <option value="<?php echo $act['cod_plan'] ?>">--><?php echo $act['nom_plan'] ?><-- </option>
                

          </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crearFactura();">Crear Factura</button>
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