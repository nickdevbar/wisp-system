<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/factura.class.php");
    $obj_factura = new factura;
    $obj_factura->cod_fac = $_GET["cod_fac"];
    $obj_factura->asignar_valor();
    $obj_factura->puntero = $obj_factura->porFactura();
    $factura = $obj_factura->extraer_dato();



    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();

    date_default_timezone_set("America/Bogota");
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
                                <h5 class="m-b-10">Registrar Pago De La Factura#<?php echo $_GET['cod_fac'] ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="card">
                            <div class="card-body">

                                <div class="fac_section">
                                    <div class="company">
                                        <div class="com_logo"><img style="width:100%;" src="../assets/images/logos/<?php echo $emprise['logo_company']; ?>" alt=""></div>
                                        <div>
                                            <h5 class="font-weight-bold h5"><?php echo $emprise['razon_social']; ?></h5>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-bold h6"><?php echo $emprise['tipo_company'] . $emprise['rif_company']; ?></h5>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-bold h6"><?php echo $emprise['dir_company']; ?></h5>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-bold h6"><?php echo $emprise['fanpage_company']; ?></h5>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-bold h6"><?php echo $emprise['ema_company']; ?></h5>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-bold h6"><a href="https://wa.me/<?php echo $emprise['tel_company']; ?>"><?php echo $emprise['tel_company']; ?></a></h5>
                                        </div>
                                    </div>

                                    <div class="factura">
                                        <div class="fac_items">
                                            <p>Factura #</p><strong><?php echo $_GET['cod_fac'] ?></strong>
                                        </div>
                                        <div class="fac_items">
                                            <p>Cliente:</p>
                                            <strong>
                                                <a href="./perfil_cliente.php?contrato=<?php echo $factura['cod_contratos'] ?>"><?php echo $factura['nom_cli'] ?></a><br>
                                                Dirección: <?php echo $factura['dir_cli'] ?><br>
                                                Telefono:<?php echo $factura['tel_cli'] ?><br>
                                                Em@il:<?php echo $factura['ema_cli'] ?>



                                            </strong>
                                        </div>
                                        <div class="fac_items">
                                            <p>Fecha:</p><strong><?php echo date('g:i a - j / m / o '); ?></strong>
                                        </div>
                                        <div class="fac_items">
                                            <p>Caja:</p><strong><?php echo $_SESSION['nom_usu'] ." ". $_SESSION['ape_usu'] ?></strong>
                                        </div>
                                        <div class="fac_items">
                                            <p>Metodo De Pago:</p><select name="" class="form-control" id="met">
                                                <option value="">-->Metodo--< </option>
                                                        <?php $obj_factura->puntero = $obj_factura->formaPago();
                                                        while (($fm = $obj_factura->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $fm['cod_for_pag']; ?>"><?php echo $fm['nom_for_pag']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <br>

                                <div class="list">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Info</th>
                                                    <th>Descripción</th>
                                                    <th>Precio</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $factura['des_fac']; ?></td>
                                                    <td><strong><?php echo $obj_factura->pesos($factura['mon_fac']); ?></strong></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Observación</strong></td>
                                                    <td><textarea name="" class="form-control" id="obs" style="resize:none;" rows="2" placeholder="N/A"></textarea></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Monto A Pagar</strong></td>
                                                    <td><input type="text" class="form-control" placeholder="Sin Puntos Ni Comas" id="mon" value="<?php echo $factura['mon_ded_fac']; ?>"></td>
                                                    <td><input type="hidden" id="mon_ded_fac" value="<?php echo $factura['mon_ded_fac']; ?>"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="exit-btn">
                                    <a href="./perfil_cliente.php?contrato=<?php echo $_GET['contrato'] ?>" class="btn btn-danger">Atras</a>
                                    <button class="btn btn-success" onclick="registrarPago();">Registrar Pago</button>
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
            const registrarPago = () => {
                let fac = '<?php echo $_GET['cod_fac']; ?>';
                let con = '<?php echo $_GET['contrato']; ?>';
                let nom = '<?php echo $factura['nom_cli']; ?>';
                let met = $("#met").val();
                let obs = $("#obs").val();
                let mon = $("#mon").val();
                let ded = $("#mon_ded_fac").val();

                datas = "ip_contrato=<?php echo $factura['ip_contrato']?>"+"&&mon_pag_fac=" + mon + "&&mon_ded_fac=" + ded + "&&obs_pag_fac=" + obs + "&&forma_pago_cod_for_pag=" + met + "&&factura_cod_fac=" + fac + "&&contrato=" + con + "&&nombres=" + nom + "&&accion=registrarPago";
                if (met != "" && obs != "" && mon != "") {
                    Swal.fire({
                        title: 'Deseas Registrar El Pago?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Registrar',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                data: datas,
                                url: "../../backend/controlador/factura/factura.php?rou=<?php echo $factura['routers_cod_router'];?>",
                                type: "POST",
                                success: function(response) {
                                    console.log("Pago Exitoso");
                                    console.log(response);
                                    location.href="./recibo_pago.php?contrato=<?php echo $_GET['contrato']; ?>&cod_fac=<?php echo $_GET['cod_fac']; ?>&val=1";
                                }
                            });
                        } else {
                            Swal.fire(
                                'No se registro el pago',
                                '',
                                'info'
                            )
                        }
                    })
                } else {
                    Swal.fire(
                                'Campos Vacios',
                                '',
                                'warning'
                            )
                }

            }
        </script>

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>