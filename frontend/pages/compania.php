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
                                <h5 class="m-b-10">Compañia</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="card shadow">
                            <div class="card-body">

                                <div class="company__section">

                                    <div>
                                        <div style="text-align:center;"><img src="../assets/images/logos/<?php echo $emprise['logo_company']; ?>" style="border:2px solid #4e73df;padding:10px;border-radius:30px;" id="logo" width="30%" alt=""></div>
                                        <input type="file" class="form-control" id="file" onchange="vistaPrevia();">
                                    </div>

                                    <div>
                                        <strong>RIF.</strong>
                                        <div style="display:grid;grid-template-columns:1fr 2fr;grid-gap:20px;">

                                            <select name="" id="tip" class="form-control">
                                                <option value="<?php echo $emprise['tipo_company']; ?>"> --><?php echo $emprise['tipo_company']; ?><-- </option>

                                                <option value="J-">J-</option>
                                                <option value="V-">V-</option>
                                                <option value="G-">G-</option>
                                                <option value="E-">E-</option>
                                            </select>

                                            <input type="text" value="<?php echo $emprise['rif_company']; ?>" placeholder="RIF" id="rif" class="form-control">
                                        </div>


                                        <strong>Telefono.</strong> <input type="text" value="<?php echo $emprise['tel_company']; ?>" placeholder="Telefono" id="tel" class="form-control">

                                        <strong>Instagram.</strong> <input type="text" value="<?php echo $emprise['instagram_company']; ?>" id="ins" placeholder="@Instagram" class="form-control">
                                    </div>
                                </div>

                                <div><strong>Nombre.</strong> <input type="text" id="nom" value="<?php echo $emprise['razon_social']; ?>" placeholder="Razon Social" class="form-control"></div><br>
                                <div><strong>Dirección.</strong> <textarea style="resize:none;" id="dir" type="text" placeholder="Dirección" class="form-control"><?php echo $emprise['dir_company']; ?></textarea></div><br>
                                <div><strong>Em@il.</strong> <input type="text" id="ema" value="<?php echo $emprise['ema_company']; ?>" placeholder="Em@il" class="form-control"></div><br>
                                <div><strong>Pagina.</strong> <input type="text" id="pag" value="<?php echo $emprise['fanpage_company']; ?>" placeholder="FanPage" class="form-control"></div>

                                <br>

                                <div style="text-align:right;"><button onclick="guardarDatos();" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Información</button></div>



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
            const guardarDatos = () => {
                let log = $('#file').val();

                if (log == "") {
                    log = '<?php echo $emprise['logo_company'] ?>';
                } else {
                    subirFoto();
                    log = log.slice(12);
                }

                let cod = '<?php echo $emprise['cod_company']; ?>';
                let tip = $('#tip').val();
                let rif = $('#rif').val();
                let tel = $('#tel').val();
                let ins = $('#ins').val();
                let nom = $('#nom').val();
                let dir = $('#dir').val();
                let ema = $('#ema').val();
                let pag = $('#pag').val();

                dataString = "cod_company=" + cod + "&&razon_social=" + nom + "&&tipo_company=" + tip + "&&rif_company=" + rif + "&&dir_company=" + dir + "&&tel_company=" + tel + "&&ema_company=" + ema + "&&fanpage_company=" + pag + "&&instagram_company=" + ins + "&&logo_company=" + log + "&&accion=modificar";
                console.log(dataString);

                $.ajax({
                    data: dataString,
                    url: "../../backend/controlador/company/company.php",
                    type: "POST",
                    success: function(response) {
                        console.log("Editado Exitoso");
                        Swal.fire(
                            'Editado Exitoso!',
                            '',
                            'success'
                        )
                    }
                });
            }

            const subirFoto = () => {

                var blobFile = document.getElementById("file").files[0];
                //var blobFile = $('#img_man').files[0];
                var formData = new FormData();
                formData.append("archivo", blobFile);

                console.log(formData);

                $.ajax({
                    url: "./subirFotoLogo.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(jqXHR, textStatus, errorMessage) {
                        console.log("No llego nada " + errorMessage); // Opcional
                    }
                });
            }

            const vistaPrevia = () => {
                const $seleccionArchivos = document.querySelector("#file"),
                    $imagenPrevisualizacion = document.querySelector("#logo");

                // Los archivos seleccionados, pueden ser muchos o uno
                const archivos = $seleccionArchivos.files;
                // Si no hay archivos salimos de la función y quitamos la imagen
                if (!archivos || !archivos.length) {
                    $imagenPrevisualizacion.src = "";
                    return;
                }

                // Ahora tomamos el primer archivo, el cual vamos a previsualizar
                const primerArchivo = archivos[0];
                // Lo convertimos a un objeto de tipo objectURL
                const objectURL = URL.createObjectURL(primerArchivo);
                // Y a la fuente de la imagen le ponemos el objectURL
                $imagenPrevisualizacion.src = objectURL;
            }
        </script>

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>