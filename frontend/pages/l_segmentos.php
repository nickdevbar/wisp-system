<?php
session_start();

if (isset($_SESSION["company"])) {

  require_once("../../backend/clase/ips.class.php");
  $obj_ips = new ips;
  $obj_ips->cod_router = $_POST["cod_router"];
  $obj_ips->asignar_valor();

?>
  <html>
  <link href="../css/stylos.css" rel="stylesheet">
  <body>
    <div>

      <div class="half"><strong>Segmento a utilizar</strong>
        <select name="" class="form-control" id="seg" onchange="ponerSegmento();">
          <option value="">---Selecione---</option>
          <?php  $obj_ips->puntero = $obj_ips->segmentosxRouter();
          while (($seg = $obj_ips->extraer_dato()) > 0) {  ?>
            <option value="<?php echo $seg['cod_seg_ip']; ?>"><?php echo $seg['seg_ip'] . " - " . $seg['com_seg_ip']; ?></option>
          <?php } ?>
        </select>
      </div>

      <strong>IP</strong>
      <div class="gat2 half">
        <input type="text" id="cat1" class="form-control" placeholder="192" disabled>
        <input type="text" id="cat2" class="form-control" placeholder="168" disabled>
        <input type="text" id="cat3" class="form-control" placeholder="1" disabled>
        <h6 class="right">Desde:</h6>
        <input type="text" id="cat4" class="form-control" placeholder="10">
        <h6 class="right">Hasta:</h6>
        <input type="text" id="cat5" class="form-control" placeholder="254">
      </div>

      <br>

      

    </div>
  </body>

  </html>
<?php

} else {
  header("location: ../index.php");
  exit();
}
?>