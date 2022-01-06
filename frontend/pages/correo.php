<?php
session_start();

if (isset($_SESSION["cod_usu"])) {

    require_once("../../backend/clase/company.class.php");
    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();

    $obj_company->puntero = $obj_company->email();
    $correo = $obj_company->extraer_dato();
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
                                <h5 class="m-b-10">Correos Automaticos</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div>

                            <div class="card shadow mb-4">
                                <?php if ($correo['cod_con_ema'] > 0) { ?>
                                    <div class="card-body">
                                        <div class="center">
                                            <div class="half ema-info">
                                                <div class="ema-item">
                                                    Nombre. <input type="text" id="nom" value="<?php echo $correo['nom_con_ema']; ?>" disabled class="form-control font-weight-bold">
                                                </div>
                                                <div class="ema-item">
                                                    Email. <input type="text" id="ema" value="<?php echo $correo['ema_con_ema']; ?>" disabled class="form-control font-weight-bold">
                                                </div>
                                                <div class="ema-item">
                                                    Contraseña.<input type="text" id="con" value="<?php echo $correo['pas_con_ema']; ?>" disabled class="form-control font-weight-bold">
                                                </div>
                                                <div class="ema-item">
                                                    Server.<input type="text" id="ser" value="<?php echo $correo['host_con_ema']; ?>" disabled class="form-control font-weight-bold">
                                                </div>

                                                <div class="ema-item">
                                                    Puerto.<input type="text" id="pue" value="<?php echo $correo['pue_con_ema']; ?>" disabled class="form-control font-weight-bold">
                                                </div>

                                            </div>


                                            <div style="display:flex;justify-content: flex-end;gap:7px; margin-top:8px;">
                                                <div><button class="btn btn-success" id="gua" onclick="guardar(<?php echo $correo['cod_con_ema']; ?>)" disabled>Guardar <i class="fas fa-save"></i></button></div>
                                                <div><button class="btn btn-outline-primary" onclick="editar()">Editar el correo <i class="fas fa-pen"></i></button></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="card-body">
                                        <div class="center">
                                            <div class="half ema-info">
                                                <div class="ema-item">
                                                    Nombre. <input type="text" id="nom" value="" placeholder="Correo Empresa" class="form-control font-weight-bold">
                                                </div>
                                                <div class="ema-item">
                                                    Email. <input type="text" id="con" value="" placeholder="empresa@gmail.com" class="form-control font-weight-bold">
                                                </div>
                                                <div class="ema-item">
                                                    Contraseña. <input type="text" id="ema" value="" placeholder="empresa123" class="form-control font-weight-bold">
                                                </div>

                                                <div class="ema-item">
                                                    Server.<input type="text" id="ser" value="" placeholder="smtp@gmail.com" class="form-control font-weight-bold">
                                                </div>

                                                <div class="ema-item">
                                                    Puerto.<input type="text" id="pue" value="" placeholder="587" class="form-control font-weight-bold">
                                                </div>
                                            </div>



                                            <div class="text-right mt-8"><button class="btn btn-outline-success" onclick="agregar();">Agregar Cuenta <i class="fas fa-plus"></i></button></div>
                                        </div>
                                    </div>
                                <?php } ?>
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
    <!-- Apex Chart -->
    <script src="../assets/js/plugins/apexcharts.min.js"></script>
    <!-- custom-chart js -->
    <script src="../assets/js/pages/dashboard-main.js"></script>

    <!-- Functional Code -->

    <script>
            const editar = () => {
                nom = $('#nom').removeAttr('disabled');
                ema = $('#ema').removeAttr('disabled');
                con = $('#con').removeAttr('disabled');
                ser = $('#ser').removeAttr('disabled');
                pue = $('#pue').removeAttr('disabled');
                gua = $('#gua').removeAttr('disabled');
            }

            const guardar = (id) => {
                nom = $('#nom').val();
                ema = $('#ema').val();
                con = $('#con').val();
                ser = $('#ser').val();
                pue = $('#pue').val();

                datas = "cod_con_ema=" + id + "&&nom_con_ema=" + nom + "&&ema_con_ema=" + ema + "&&pas_con_ema=" + con + "&&host_con_ema=" + ser + "&&pue_con_ema=" + pue + "&&accion=editCorreo";

                console.log(datas);

                if (nom == "" || ema == "" || con == "" || ser == "" || pue == "") {
                    Swal.fire(
                        'Debes llenar los campos!',
                        'Escribe todos los datos para poder editar el correo!',
                        'warning'
                    )
                } else {
                    $.ajax({
                        data: datas,
                        url: "../../backend/controlador/company/company.php",
                        type: "POST",
                        success: function(response) {
                            console.log("Editado Exitoso");
                            location.reload();
                            Swal.fire(
                        'Editado Correctamente',
                        '',
                        'success'
                    )
                        }
                    });
                }

            }

            const agregar = () => {
                nom = $('#nom').val();
                ema = $('#ema').val();
                con = $('#con').val();
                ser = $('#ser').val();
                pue = $('#pue').val();

                datas = "nom_con_ema=" + nom + "&&ema_con_ema=" + ema + "&&pas_con_ema=" + con + "&&host_con_ema=" + ser + "&&pue_con_ema=" + pue + "&&accion=addCorreo";

                console.log(datas);

                if (nom == "" || ema == "" || con == "" || ser == "" || pue == "") {
                    Swal.fire(
                        'Debes llenar los campos!',
                        'Escribe todos los datos para poder editar el correo!',
                        'warning'
                    )
                } else {
                    $.ajax({
                        data: datas,
                        url: "../../backend/controlador/company/company.php",
                        type: "POST",
                        success: function(response) {
                            console.log("Editado Exitoso");
                            location.reload();
                            Swal.fire(
                        'Agregado Correctamente',
                        '',
                        'success'
                    )
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