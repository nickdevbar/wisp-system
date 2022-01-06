<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/usuario.class.php");
    $obj_usuario = new usuario;

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



</head>

<body class="">
        <div class="modal" id="add_usuario" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static"></div>
        <div class="modal" id="edit_usuario" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static"></div>
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
                                
                                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h5 class="m-b-10">Usuarios De La Compañia</h5>

                            <a href="javascript:void(0);" data-toggle="modal" data-target="#add_usuario" onclick="carga_ajax('1','add_usuario','../modal/modal_add_usuario.php');" class="d-none d-sm-inline-block btn btn-success shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Agregar Usuario</a>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->

            <div class="card shadow mb-4">
                            
                            <div class="card-body">

                            

                        <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>User</th>
                                                <th>Telefono</th>
                                                <th>Rol</th>
                                                <th>Opción</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $obj_usuario->puntero = $obj_usuario->todes();
                                            while (($arreglo = $obj_usuario->extraer_dato()) > 0) { ?>
                                                <tr>
                                                    <td><?php echo $arreglo['nom_usu']." ".$arreglo['ape_usu']; ?></td>
                                                    <td><?php echo $arreglo['usu_user']; ?></td>
                                                    <td><?php echo $arreglo['tel_usu']; ?></td>
                                                    <td><?php echo $arreglo['nom_rol']; ?></td>
                                                    
                                                    <td>

                                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_usuario" onclick="carga_ajax('<?php echo $arreglo['cod_usu']; ?>','edit_usuario','../modal/modal_edit_usuario.php');" class="btn btn-sm btn-primary" title="Editar"><i class="fas fa-pen"></i></a>
                                                        <a href="#" onclick="eliminarUsuario(<?php echo $arreglo['cod_usu']; ?>);" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                                                        <!-- <a href="" class="btn btn-sm btn-warning" title="Permisos"><i class="fas fa-user-shield"></i></a> -->

                                                    </td>
                                                </tr>
                                            <?php } ?>

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

    <!-- Apex Chart -->
    <script src="../assets/js/plugins/apexcharts.min.js"></script>
    


    <!-- custom-chart js -->
    <script src="../assets/js/pages/dashboard-main.js"></script>

    <!-- Codigo de Funcionamiento -->
    
    <script>
            const eliminarUsuario = (cod) => {
                console.log(cod);
                Swal.fire({
                    title: '¿Seguro que desea eliminar al usuario?',
                    text: "",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, estoy seguro',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: "cod_usu="+cod+"&&accion=deleteUsuario",
                            url: "../../backend/controlador/funciones/funciones.php",
                            type: "POST",
                            success: function(response) {
                                console.log("Creado Exitoso");
                                Swal.fire(
                                    'usuario Eliminado',
                                    '',
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
</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>