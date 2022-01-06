<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/plan.class.php");

    $obj_plan = new plan;

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

        <link href="../assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">



    </head>

    <body class="">
        <div class="modal" id="edit_segmento" tabindex="-1" role="dialog" aria-hidden="true"></div>

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
                                    <h5 class="m-b-10">Segmentos IP</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <!-- [ Main Content ] start -->
                <div class="card shadow mb-4">

                    <div>
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold font text-primary">Crear Segmentos</h5>
                        </div>
                        <div class="card-body">

                            <strong>Gateway(Puerta de Enlace)</strong>
                            <div class="gat half">
                                <input type="text" class="form-control" id="gat1" placeholder="192">
                                <input type="text" class="form-control" id="gat2" placeholder="168">
                                <input type="text" class="form-control" id="gat3" placeholder="1">
                                <input type="text" class="form-control" id="gat4" placeholder="1">
                                <h4>/</h4>
                                <input type="text" class="form-control" id="gat5" placeholder="24">
                            </div>

                            <div class="half">
                                <div><strong>Comentario</strong>
                                    <input type="text" id="com_seg" class="form-control" placeholder="Info del Segmento">
                                </div>

                                <div><strong>Router</strong>
                                    <select name="" class="form-control" id="ser_seg" onchange="cargarInterfaces();">
                                        <option value="">---Selecione---</option>
                                        <?php $obj_plan->puntero = $obj_plan->routers();
                                        while (($rou = $obj_plan->extraer_dato()) > 0) { ?>
                                            <option value="<?php echo $rou['cod_router']; ?>"><?php echo $rou['nom_router']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div id="interface"></div>

                                <br>

                                <div class="right"><button onclick="insertarSegmento();" class="btn btn-success">Agregar Segmento</button></div>
                            </div>


                        </div>
                    </div>


                    <div class="card-header">
                        <h6 class="m-0">Lista De Segmentos</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Segmento</th>
                                        <th>Comentario</th>
                                        <th>Interfaz</th>
                                        <th>Router</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $obj_plan->puntero = $obj_plan->segmentos();
                                    while (($arreglo = $obj_plan->extraer_dato()) > 0) { ?>
                                        <tr>
                                            <td><?php echo $arreglo['seg_ip']; ?></td>
                                            <td><?php echo $arreglo['com_seg_ip']; ?></td>
                                            <td><?php echo $arreglo['int_seg_ip']; ?></td>
                                            <td><?php echo $arreglo['nom_router']; ?></td>
                                            <td>
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_segmento" onclick="carga_ajax('<?php echo $arreglo['cod_seg_ip']; ?>','edit_segmento','../modal/modal_edit_segmento.php');" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                                                <a href="#" onclick="eliminarSegmento(<?php echo $arreglo['cod_seg_ip']; ?>);" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div>
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Crear IP´s</h5>
                        </div>
                        <div class="card-body">

                            <div class="half mb-3"><strong>Router de los Segmentos</strong>
                                <select name="" class="form-control" id="rou" onchange="pasarRouter();">
                                    <option value="">---Selecione---</option>
                                    <?php $obj_plan->puntero = $obj_plan->routers();
                                    while (($seg = $obj_plan->extraer_dato()) > 0) { ?>
                                        <option value="<?php echo $seg['cod_router']; ?>"><?php echo $seg['nom_router']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div id="segmentos"></div>

                            <div class="half">
                                <div class="right"><button class="btn btn-success" onclick="generarCiclo();">Generar IP´s</button></div>

                                <div id="progress" class="progress mt-2">
                                    <div id="bar" class="progress-bar" role="progressbar" style="width:0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card-header">
                        <h6 class="m-0">Lista De IP´s Disponibles</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $obj_plan->puntero = $obj_plan->ipDisponible();
                                    while (($ip = $obj_plan->extraer_dato()) > 0) {
                                        $i = $i + 1;
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $ip['ip_contrato']; ?></td>
                                        </tr>
                                    <?php }
                                    ?>

                                </tbody>
                            </table>
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

        <script src="../assets/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Apex Chart -->
        <script src="../assets/js/plugins/apexcharts.min.js"></script>


        <!-- custom-chart js -->
        <script src="../assets/js/pages/dashboard-main.js"></script>

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
                $('#dataTable2').DataTable();
                $('#dataTable3').DataTable();
                $('#dataTable4').DataTable();
                $('#dataTable5').DataTable();
            });
        </script>

        <!-- Codigo de Funcionamiento -->
        <script>
            const cargarInterfaces = () => {
                let router = $("#ser_seg").val();
                console.log(router);

                $.ajax({
                    data: "cod_router=" + router,
                    url: "./interfaces.php",
                    type: "POST",
                    success: function(response) {
                        console.log(response);
                        $('#interface').html(response);
                    }
                });
            }
        </script>

        <script>
            const pasarRouter = () => {
                let router = $("#rou").val();
                console.log(router);

                $.ajax({
                    data: "cod_router=" + router,
                    url: "./l_segmentos.php",
                    type: "POST",
                    success: function(response) {
                        console.log(response);
                        $('#segmentos').html(response);
                    }
                });
            }
        </script>

        <script>
            const eliminarSegmento = (id) => {
                console.log(id);

                Swal.fire({
                    title: '¿Deseas Eliminar El Segmento?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: `Si, Borrarlo`,
                    denyButtonText: `No`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        Swal.fire('Segmento Eliminado', '', 'success');
                        $.ajax({
                            data: 'cod_seg_ip=' + id + '&&accion=eliminarSegmento',
                            url: "../../backend/controlador/seg_ip/seg_ip.php",
                            type: "POST",
                            success: function(response) {
                                console.log(response)
                                location.reload();
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('No se realizo ningun cambio', '', 'info');
                    }
                })


            }
        </script>

        <script>
            const ponerSegmento = () => {

                var segmento = document.getElementById("seg");
                var selected = segmento.options[segmento.selectedIndex].text;

                let seg_cor = selected.split('.'); // [ 'free', 'code', 'camp' ]

                $("#cat1").val(seg_cor[0]);
                $("#cat2").val(seg_cor[1]);
                $("#cat3").val(seg_cor[2]);

            }
        </script>

        <script>
            const eliminarSegmento = (id) => {
                console.log(id);

                Swal.fire({
                    title: '¿Deseas Eliminar El Segmento?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: `Si, Borrarlo`,
                    denyButtonText: `No`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        Swal.fire('Segmento Eliminado', '', 'success');
                        $.ajax({
                            data: 'idsegmentos_ip=' + id + '&&accion=eliminarSegmento',
                            url: "../../backend/controlador/seg_ip/seg_ip.php",
                            type: "POST",
                            success: function(response) {
                                console.log(response)
                                location.reload();
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('No se realizo ningun cambio', '', 'info');
                    }
                })


            }
        </script>

        <script>
            const generarCiclo = () => {
                let pri = $("#cat1").val();
                let seg = $("#cat2").val();
                let ter = $("#cat3").val();

                let desde = $("#cat4").val();
                let hasta = $("#cat5").val();
                let id = $("#seg").val();
                //alert(desde + " " + hasta);

                i = parseInt(desde);
                while (i <= hasta) {
                    ipseg = pri + "." + seg + "." + ter + "." + i;

                    dataString = "ip_contrato=" + ipseg + "&&segmentos_ip_cod_seg_ip=" + id + "&&accion=insertarIP";

                    $.ajax({
                        data: dataString,
                        url: "../../backend/controlador/seg_ip/seg_ip.php",
                        type: "POST",
                        success: function(response) {
                            console.log(response);
                        }
                    });

                    $('#bar').attr('style', 'width:' + i + '%;');

                    console.log(pri + "." + seg + "." + ter + "." + i + "// " + dataString);

                    i++;
                }

                $('#bar').attr('style', 'width:100%;');
                Swal.fire(
                    'Se agregaron las IPs',
                    'Verifique en la lista disponible',
                    'success'
                )

            }
        </script>

        <script>
            const insertarSegmento = () => {
                let gat1 = $("#gat1").val();
                let gat2 = $("#gat2").val();
                let gat3 = $("#gat3").val();
                let gat4 = $("#gat4").val();
                let gat5 = $("#gat5").val();
                let com = $("#com_seg").val();
                let ser = $("#ser_seg").val();
                let int = $("#int_seg").val();


                if (com == "" || ser == "" || gat1 == "" || gat2 == "" || gat3 == "" || gat4 == "" || gat5 == "") {
                    Swal.fire(
                        'Llena todos los campos',
                        'Hay campos vacios para poder crear el segmento',
                        'warning'
                    )
                } else {
                    let segmento = gat1 + "." + gat2 + "." + gat3 + "." + gat4 + "/" + gat5;
                    let network = gat1 + "." + gat2 + "." + gat3 + ".0"

                    dataString = "seg_ip=" + segmento + "&&com_seg_ip=" + com + "&&int_seg_ip=" + int + "&&routers_cod_router=" + ser + "&&net=" + network + "&&accion=insertarSegmento";

                    console.log(dataString);
                    $.ajax({
                        data: dataString,
                        url: "../../backend/controlador/seg_ip/seg_ip.php?rou=" + ser,
                        type: "POST",
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire(
                                    'Ya existe este segmento',
                                    'Se encontro un segmento similar',
                                    'warning'
                                )
                            } else {
                                Swal.fire(
                                    'Registro Exitoso',
                                    'Segmento agregado',
                                    'success'
                                )
                                console.log("Registro Exitoso");

                                location.reload();
                            }
                            console.log(response);

                        }
                    });
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