<?php
session_start();
if (isset($_SESSION["cod_usu"])) {

    require_once "../../backend/clase/company.class.php";
    require_once "../../backend/clase/exportar.class.php";
    require_once "../../backend/clase/funciones_api.class.php";
    $obj_exportar = new exportar;
    $obj_funciones_api = new funciones_api;

    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();

    if ($_GET['server1'] != '' && $_GET['server2'] != '') {
        $obj_exportar->cod_router1 = $_GET['server1'];
        $obj_exportar->cod_router2 = $_GET['server2'];
        $obj_exportar->asignar_valor();

        $obj_exportar->puntero = $obj_exportar->serverEnv();
        $server1 = $obj_exportar->extraer_dato();
        $ip_api = $server1['ip_router'];
        $lo_api = $server1['user_router'];
        $pa_api = $server1['pass_router'];
        $po_api = $server1['puerto_router'];
        $bl_api = $server1['blacklist_router'];

        $obj_exportar->puntero = $obj_exportar->serverRec();
        $server2 = $obj_exportar->extraer_dato();
        $ip_api2 = $server2['ip_router'];
        $lo_api2 = $server2['user_router'];
        $pa_api2 = $server2['pass_router'];
        $po_api2 = $server2['puerto_router'];
        $bl_api2 = $server2['blacklist_router'];

        //echo $server2['nombre_server'];

    }

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
                                <h5 class="m-b-10">Exportar</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div style="display:grid;grid-template-columns:3fr 1fr;align-items:baseline;">
                                    <h6 class="m-0 font-weight-bold text-primary">De Un Router A Otro Router</h6>
                                    <a href="#" onclick="addRules();" class="btn btn-info" title="Agrega las rules necesarias para el correcto funcionamiento del sistema">Añadir Reglas Obligatorias</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="servers">
                                        <div><strong>De:</strong><select class="form-control" name="" id="serUno">
                                                <option value="">->Seleccione un Server<-- </option>

                                                        <?php $obj_exportar->puntero = $obj_exportar->routers();
                                                        while (($exp = $obj_exportar->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $exp['cod_router']; ?>"><?php echo $exp['nom_router']; ?></option>
                                            <?php } ?>

                                            </select></div>



                                        <div><strong>A:</strong><select class="form-control" name="" id="serDos">
                                                <option value="">->Seleccione un Server<-- </option>

                                                        <?php $obj_exportar->puntero = $obj_exportar->routers();
                                                        while (($exp = $obj_exportar->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $exp['cod_router']; ?>"><?php echo $exp['nom_router']; ?></option>
                                            <?php } ?>

                                            </select></div>
                                    </div>

                                    <br>

                                    <div><button class="btn btn-primary btn-block" onclick="mandarServer();">Aceptar</button></div>

                                    <br>

                                    <?php if ($_GET['server1'] != "" && $_GET['server2'] != "") { ?>

                                        <div class="exportaciones">


                                            <div class="exp-seg">
                                                <div>
                                                    <strong>Pasar los Segmentos existentes</strong> <a href="#" onclick="mostrar('1')"><strong>Ver...<i class="fa fa-eye" aria-hidden="true"></i></strong></a> <i class="fa fa-times" id="cross1" style="color:red;cursor:pointer;display:none;" onclick="esconder('1');" aria-hidden="true"></i><br />
                                                    <a href="export.php?server1=<?php echo $_GET['server1']; ?>&server2=<?php echo $_GET['server2']; ?>&exportar=1" class="btn btn-success bl">Exportar Segmentos</a>
                                                </div>
                                                <div class="table-responsive" id="table1" style="display:none;">
                                                    <table id="example1" class="table no-margin table-responsive table-content table-hover">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th>ID#</th>
                                                                <th>Segmento</th>
                                                                <th>Network</th>
                                                                <th>Comentario</th>
                                                                <th>Interface</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $obj_exportar->puntero = $obj_exportar->SEG();
                                                            while (($seg = $obj_exportar->extraer_dato()) > 0) {
                                                            ?>
                                                                <tr class="sl-tr">
                                                                    <td><?php echo $seg["cod_seg_ip"]; ?> </td>
                                                                    <td><?php echo $segmento = $seg["seg_ip"]; ?></td>
                                                                    <td><?php $net = explode('.', $seg["seg_ip"]); ?>
                                                                        <?php echo $complete = $net[0] . "." . $net[1] . "." . $net[2] . ".0"; ?>
                                                                    </td>
                                                                    <td><?php echo $com = $seg["com_seg_ip"]; ?> </td>
                                                                    <td><?php echo $int = $seg["int_seg_ip"]; ?> </td>
                                                                </tr>

                                                                <?php if ($_GET["exportar"] == 1) {

                                                                    $obj_funciones_api->ip = $segmento;
                                                                    $obj_funciones_api->net = $complete;
                                                                    $obj_funciones_api->com = $com;
                                                                    $obj_funciones_api->int = $int;

                                                                    $obj_funciones_api->ip_router_api = $ip_api2;
                                                                    $obj_funciones_api->login_api = $lo_api2;
                                                                    $obj_funciones_api->password_api = $pa_api2;
                                                                    $obj_funciones_api->port_api = $po_api2;
                                                                    $obj_funciones_api->blacklist_api = $bl_api2;

                                                                    $obj_funciones_api->asignar_valor_api();
                                                                    $obj_funciones_api->connect();
                                                                    $obj_funciones_api->export_seg();
                                                                } ?>



                                                            <?php }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="exp-seg">
                                                <div>
                                                    <strong>Pasar los Queue existentes</strong><a href="#" onclick="mostrar('2')"><strong>Ver...<i class="fa fa-eye" aria-hidden="true"></i></strong></a> <i class="fa fa-times" id="cross2" style="color:red;cursor:pointer;display:none;" onclick="esconder('2');" aria-hidden="true"></i><br /><br />
                                                    <a href="export.php?server1=<?php echo $_GET['server1']; ?>&server2=<?php echo $_GET['server2']; ?>&exportar=2" class="btn btn-success bl">Exportar Queue Simple</a>
                                                </div>
                                                <div class="table-responsive" id="table2" style="display:none;">
                                                    <table id="example2" class="table no-margin table-responsive table-content table-hover">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th>Name</th>
                                                                <th>Target</th>
                                                                <th>Plan Subida</th>
                                                                <th>Plan Bajada</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $obj_exportar->puntero = $obj_exportar->IP();
                                                            while (($queue = $obj_exportar->extraer_dato()) > 0) {
                                                            ?>
                                                                <tr class="sl-tr">
                                                                    <td><?php echo $cliente = "Contrato N " . $queue["num_contrato"] . " " . $queue["nom_cli"]; ?> </td>
                                                                    <td><?php echo $ip = $queue["ip_contrato"]; ?></td>
                                                                    <td><?php echo $plan = $queue["vel_sub_plan"] . $queue["tx"]; ?> </td>
                                                                    <td><?php echo $plan2 = $queue["vel_des_plan"] . $queue["rx"]; ?> </td>
                                                                </tr>

                                                                <?php if ($_GET["exportar"] == 2) {
                                                                    // se pone un echo asi para ver el echo dentro de la funcion echo "se ejecuta";
                                                                    $obj_funciones_api->cliente = $cliente;
                                                                    $obj_funciones_api->ip = $ip;
                                                                    $obj_funciones_api->plan = $plan;
                                                                    $obj_funciones_api->plan2 = $plan2;

                                                                    $obj_funciones_api->ip_router_api = $ip_api2;
                                                                    $obj_funciones_api->login_api = $lo_api2;
                                                                    $obj_funciones_api->password_api = $pa_api2;
                                                                    $obj_funciones_api->port_api = $po_api2;
                                                                    $obj_funciones_api->blacklist_api = $bl_api2;

                                                                    $obj_funciones_api->asignar_valor_api();
                                                                    $obj_funciones_api->connect();
                                                                    $obj_funciones_api->export_queue();
                                                                } ?>

                                                            <?php }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="exp-seg">
                                                <div>
                                                    <strong>Pasar los ARP existentes</strong><a href="#" onclick="mostrar('3')"><strong>Ver...<i class="fa fa-eye" aria-hidden="true"></i></strong></a> <i class="fa fa-times" id="cross3" style="color:red;cursor:pointer;display:none;" onclick="esconder('3');" aria-hidden="true"></i><br /><br />
                                                    <a href="export.php?server1=<?php echo $_GET['server1']; ?>&server2=<?php echo $_GET['server2']; ?>&exportar=3" class="btn btn-success bl">Exportar ARP</a>
                                                </div>
                                                <div class="table-responsive" id="table3" style="display:none;">
                                                    <table id="example3" class="table no-margin table-responsive table-content table-hover">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th>Name</th>
                                                                <th>IP</th>
                                                                <th>MAC</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $obj_exportar->puntero = $obj_exportar->IP();
                                                            while (($arp = $obj_exportar->extraer_dato()) > 0) {
                                                            ?>
                                                                <tr class="sl-tr">
                                                                    <td><?php echo $cliente = "Contrato N " . $arp["num_contrato"] . " " . $arp["nom_cli"]; ?> </td>
                                                                    <td><?php echo $ip = $arp["ip_contrato"]; ?></td>
                                                                    <td><?php echo $mac = $arp["mac_det_con"]; ?> </td>
                                                                </tr>

                                                                <?php if ($_GET["exportar"] == 3) {
                                                                    // se pone un echo asi para ver el echo dentro de la funcion echo "se ejecuta";
                                                                    $obj_funciones_api->cliente = $cliente;
                                                                    $obj_funciones_api->ip = $ip;
                                                                    $obj_funciones_api->mac = $mac;

                                                                    $obj_funciones_api->ip_router_api = $ip_api2;
                                                                    $obj_funciones_api->login_api = $lo_api2;
                                                                    $obj_funciones_api->password_api = $pa_api2;
                                                                    $obj_funciones_api->port_api = $po_api2;
                                                                    $obj_funciones_api->blacklist_api = $bl_api2;

                                                                    $obj_funciones_api->asignar_valor_api();
                                                                    $obj_funciones_api->connect();
                                                                    $obj_funciones_api->export_arp();
                                                                } ?>

                                                            <?php }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="exp-seg">
                                                <div>
                                                    <strong>Pasar los ACTIVOS existentes</strong><a href="#" onclick="mostrar('4')"><strong>Ver...<i class="fa fa-eye" aria-hidden="true"></i></strong></a> <i class="fa fa-times" id="cross4" style="color:red;cursor:pointer;display:none;" onclick="esconder('4');" aria-hidden="true"></i><br /><br />
                                                    <a href="export.php?server1=<?php echo $_GET['server1']; ?>&server2=<?php echo $_GET['server2']; ?>&exportar=4" class="btn btn-success bl">Exportar Whitelist</a>
                                                </div>
                                                <div class="table-responsive" id="table4" style="display:none;">
                                                    <table id="example4" class="table no-margin table-responsive table-content table-hover">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th>ID#</th>
                                                                <th>Segmento</th>
                                                                <th>Comentario</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $obj_exportar->puntero = $obj_exportar->BLIST();
                                                            while (($sus = $obj_exportar->extraer_dato()) > 0) {
                                                            ?>
                                                                <tr class="sl-tr">
                                                                    <td><?php echo $cliente = "Contrato N " . $sus["num_contrato"] . " " . $sus["nom_cli"]; ?> </td>
                                                                    <td><?php echo $ip = $sus["ip_contrato"]; ?></td>
                                                                    <td><?php echo $list = $sus["whitelist_router"]; ?> </td>
                                                                </tr>

                                                                <?php if ($_GET["exportar"] == 4) {
                                                                    // se pone un echo asi para ver el echo dentro de la funcion echo "se ejecuta";
                                                                    $obj_funciones_api->cliente = $cliente;
                                                                    $obj_funciones_api->ip = $ip;
                                                                    $obj_funciones_api->list = $list;

                                                                    $obj_funciones_api->ip_router_api = $ip_api2;
                                                                    $obj_funciones_api->login_api = $lo_api2;
                                                                    $obj_funciones_api->password_api = $pa_api2;
                                                                    $obj_funciones_api->port_api = $po_api2;
                                                                    $obj_funciones_api->blacklist_api = $bl_api2;
                                                                    $obj_funciones_api->whitelist_api = $wl_api2;

                                                                    $obj_funciones_api->asignar_valor_api();
                                                                    $obj_funciones_api->connect();
                                                                    $obj_funciones_api->export_whitelist();
                                                                } ?>
                                                            <?php }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>



                                        </div>
                                        <!---------exportaciones------->

                                    <?php } ?>

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
            const addRules = () => {
                Swal.fire({
                    title: 'Selecciona el router destino?',
                    html: '<select name="" id="swal-input1" class="swal2-input">' + '<?php $obj_exportar->puntero = $obj_exportar->routers(); while (($exp = $obj_exportar->extraer_dato()) > 0) { ?>
                          <option value="<?php echo $exp["cod_router"]; ?>"><?php echo $exp["nom_router"]; ?></option><?php } ?>'+'</select>',
                    focusConfirm: false,
                    preConfirm: () => {
                        let router = document.getElementById('swal-input1').value;


                        Swal.fire('¡¡Reglas Creadas!!', 'Revisa tu lista de reglas', 'success');
                        $.ajax({
                            data: "&&accion=addRules",
                            url: "../../backend/controlador/seg_ip/seg_ip.php?rou="+router,
                            type: "POST",
                            success: function(response) {
                                console.log(response);
                            }
                        });
                    }
                })
            }
        </script>

        <script>
            const mandarServer = () => {
                let server1 = $('#serUno').val();
                let server2 = $('#serDos').val();

                if (server1 != "" && server2 != "") {
                    location.href = './export.php?server1=' + server1 + "&server2=" + server2;
                } else {
                    Swal.fire(
                        'Selecciona Los Dos Servers',
                        'Debes seleccionar el server que envia y el que recibe',
                        'warning'
                    )
                }
            }
        </script>

        <script>
            $("#serUno").val('<?php echo $_GET['server1']; ?>');
            $("#serDos").val('<?php echo $_GET['server2']; ?>');
        </script>

        <script>
            const mostrar = (n) => {
                $("#table" + n).show('slow');
                $("#cross" + n).show('slow');
            }

            const esconder = (n) => {
                $("#table" + n).hide('slow');
                $("#cross" + n).hide('slow');
            }
        </script>

</body>

</html>

<?php
} else {
    header("location: ../../index.php?val=3");
}
?>