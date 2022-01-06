<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php require('../public/title.php') ?></title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/stylos.css">

    <!-- DataTables -->
    <link href="../assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">



</head>

<body class="">
        
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <?php require_once('./menu.php'); ?>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <?php require_once('./topbar.php'); ?>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Nuevo Cliente</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-success">Formulario de Registro</h6>
                            </div>
                            <div class="card-body">
                                <div class="half">
                                    <h5 class="text-primary">Datos.</h5>
                                    <strong>Cedula:</strong>
                                    <div style="display:grid;grid-template-columns:1fr 2fr;grid-gap:10px;align-items:baseline;">
                                        <select name="" id="tip" class="form-control" onchange="verificarCedula();">
                                            <option value="V-">V-</option>
                                            <option value="J-">J-</option>
                                            <option value="G-">G-</option>
                                            <option value="E-">E-</option>
                                        </select>
                                        <input type="text" id="ced" placeholder="123456789" class="form-control" onkeyup="verificarCedula();">
                                    </div>
                                    <div id="info" style="text-align:right;"></div>

                                    <div><strong>Nombre y Apellidos:</strong><input type="text" id="nom" placeholder="Aleks Syntek" class="form-control"></div>
                                    <div><strong>Telefono</strong><input type="text" id="tel" placeholder="0000-000-0000" class="form-control"></div>
                                    <div><strong>Segundo Telefono</strong><input type="text" id="tel2" placeholder="0276-000-0000" class="form-control"></div>
                                    <div><strong>Email</strong><input type="text" id="ema" placeholder="correo@gmail.com" class="form-control"></div>

                                    <br>
                                    <h5 class="text-primary">Ubicación.</h5>

                                    <div><strong>Dirección</strong> <textarea id="dir" style="resize:none;" placeholder="Av. Venezuela" class="form-control"></textarea></div>
                                    <div><strong>Punto de Referencia</strong> <textarea id="pun" style="resize:none;" placeholder="Cerca de..." class="form-control"></textarea></div>
                                    <div><strong>Sector:</strong>
                                        <select name="" id="sec" class="form-control">
                                            <option value="">-----</option>

                                            <?php $obj_company->puntero = $obj_company->sector();
                                            while (($sec = $obj_company->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $sec['cod_sector']; ?>"><?php echo $sec['nom_sector']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>

                                    <br>

                                    <div><button class="btn btn-success btn-block" id="but" onclick="registrarCliente();">Guardar Al Cliente <i class="fas fa-user-plus"></i></button></div>


                                </div>
                            </div>
                        </div>
            
                <!-- table card-1 end -->
                <!-- table card-2 start -->
                
                <!-- Widget primary-success card end -->

                <!-- prject ,team member start -->
                
                
                <!-- prject ,team member start -->
                <!-- seo start -->
               
               
                <!-- seo end -->

                <!-- Latest Customers start -->
                
                
                <!-- Latest Customers end -->
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Warning Section start -->
    <!-- Older IE warning message -->
    <!--[if lt IE 11]>
        <div class="ie-warning">
            <h1>Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade
               <br/>to any of the following web browsers to access this website.
            </p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="../assets/images/browser/chrome.png" alt="Chrome">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="../assets/images/browser/firefox.png" alt="Firefox">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="../assets/images/browser/opera.png" alt="Opera">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="../assets/images/browser/safari.png" alt="Safari">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="../assets/images/browser/ie.png" alt="">
                            <div>IE (11 & above)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
    <![endif]-->
    <!-- Warning Section Ends -->

    <!-- Required Js -->
    <script src="../assets/js/vendor-all.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/pcoded.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../modal/idmodal.js"></script>

    <!-- DataTables -->
    <script src="../assets/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
                $('#dataTable2').DataTable();
                $('#dataTable3').DataTable();
                $('#dataTable4').DataTable();
                $('#dataTable5').DataTable();
            });
        </script>

    <!-- Apex Chart -->
    <script src="../assets/js/plugins/apexcharts.min.js"></script>


    <!-- custom-chart js -->
    <script src="../assets/js/pages/dashboard-main.js"></script>

    <!-- Codigo de Funcionamiento -->

    <script>
            const registrarCliente = () => {
                let tip = $('#tip').val();
                let ced = $('#ced').val();
                let nom = $('#nom').val();
                let tel = $('#tel').val();
                let tel2 = $('#tel2').val();
                let ema = $('#ema').val();
                let dir = $('#dir').val();
                let pun = $('#pun').val();
                let sec = $('#sec').val();

                dataString = "tipo_cli=" + tip + "&&ced_cli=" + ced + "&&nom_cli=" + nom + "&&tel_cli=" + tel + "&&tel2_cli=" + tel2 + "&&ema_cli=" + ema + "&&dir_cli=" + dir + "&&pun_ref_cli=" + pun + "&&sector_cod_sector=" + sec + "&&accion=addCliente";
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
                                'Cliente Agregado!!',
                                'Ahora esta en la lista de clientes en espera para su activación',
                                'success'
                            )
                            $('#tip').val("");
                            $('#ced').val("");
                            $('#nom').val("");
                            $('#tel').val("");
                            $('#ema').val("");
                            $('#dir').val("");
                            $('#pun').val("");
                            $('#sec').val("");
                            $('#tel2').val("");
                        }
                    });
                }

            }


            /****************************************************************/

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

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>