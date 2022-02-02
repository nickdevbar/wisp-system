<?php
session_start();
if (isset($_SESSION["cod_usu"])) {
    
    require_once("../../backend/clase/company.class.php");
    require_once("../../backend/clase/cliente.class.php");
    require_once("../../backend/clase/funciones_api.class.php");

    $obj_api = new funciones_api;



    $obj_cliente = new cliente;

    $obj_cliente->cod_contratos = $_GET['contrato'];
    $obj_cliente->asignar_valor();
    $obj_cliente->puntero = $obj_cliente->perfil_cliente();
    $cliente = $obj_cliente->extraer_dato();

    $obj_cliente->puntero = $obj_cliente->manPendiente();
    $mantenimiento = $obj_cliente->extraer_dato();

    echo $cliente['estatus_cliente_cod_est_cli'];

    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();

    /****************************************/
  
    $obj_api->ip_contrato = $cliente['ip_contrato'];
 
    $obj_api->ip_router_api = $cliente['ip_router'];

    $obj_api->login_api = $cliente['user_router'];

    $obj_api->password_api = $cliente['pass_router'];
  
    $obj_api->port_api = $cliente['puerto_router'];
    
    $obj_api->interfaz_api = 'LAN';
    
    $obj_api->blacklist_api =  $cliente['blacklist_router'];
    
    $obj_api->whitelist_api =  $cliente['whitelist_router'];
    $obj_api->connect();
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

    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- DataTables -->
    <link href="../assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


<!-- MODALES CON SWEETALERT -->

    <style>
            .swal2-popup {
                width: 60% !important;
            }

            @media screen and (min-width:240px) and (max-width:960px) {
                .swal2-popup {
                    width: 100% !important;
                }
            }
        </style>



</head>

<body class="">
            <div class="modal" id="add_factura" tabindex="-1" role="dialog" aria-hidden="true"></div>
            <div class="modal" id="edit_factura" tabindex="-1" role="dialog" aria-hidden="true"></div>
            <div class="modal" id="edit_factura_paga" tabindex="-1" role="dialog" aria-hidden="true"></div>
            <div class="modal" id="add_mantenimiento" tabindex="-1" role="dialog" aria-hidden="true"></div>
        
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
                                <h4 class="h4 mb-0">Perfil Del Cliente</h4>
                                <h4 class="h4 mb-0 text-danger">Contrato N <?php echo $cliente['num_contrato']; ?></h4>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="client-data responsive">
                            <div class="card mb-4 py-0 border-left-primary">
                                <div class="card-body">
                                    <h4 class="h6 mb-0 font-weight-bold">Datos Del Cliente</h4>
                                    <hr>
                                    <strong>Cedula:</strong>
                                    <div style="display:grid;grid-template-columns:0.5fr 2fr;grid-gap:10px;" class="responsive"><select disabled name="" id="tip" class="form-control">
                                            <option value="<?php echo $cliente['tipo_cli']; ?>"> --><?php echo $cliente['tipo_cli']; ?><-- </option>
                                            <option value=""> ------------------------------- </option>
                                            <option value="V-"> V- </option>
                                            <option value="J-"> J- </option>
                                            <option value="G-"> G- </option>
                                            <option value="E-"> E- </option>
                                        </select><input disabled class="form-control" type="text" value="<?php echo $cliente['ced_cli']; ?>" id="ced" placeholder="Documento"></div>

                                    <div><strong>Nombre:</strong><input disabled class="form-control" id="nom" type="text" value="<?php echo $cliente['nom_cli']; ?>" placeholder="Nombre Y Apellido"></div>

                                    <div><strong>Em@il:</strong><input disabled class="form-control" id="ema" type="text" value="<?php echo $cliente['ema_cli']; ?>" placeholder="correo@gmail.com"></div>

                                    <strong>Telefonos:</strong>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:10px;" class="responsive">
                                        <input class="form-control" disabled type="text" placeholder="+58" id="te1" value="<?php echo $cliente['tel_cli']; ?>">
                                        <input class="form-control" disabled type="text" placeholder="+57" id="te2" value="<?php echo $cliente['tel2_cli']; ?>">
                                    </div>

                                    <div><strong>Sector:</strong><select disabled name="" id="sec" class="form-control">
                                            <option value="<?php echo $cliente['cod_sector']; ?>"> --><?php echo $cliente['nom_sector']; ?><-- </option>

                                                    <?php $obj_cliente->puntero = $obj_cliente->sector();
                                                    while (($sec = $obj_cliente->extraer_dato()) > 0) { ?>
                                            <option value="<?php echo $sec['cod_sector']; ?>"> <?php echo $sec['nom_sector']; ?> </option>
                                        <?php } ?>

                                        </select></div>
                                    <div><strong>Dirección:</strong><textarea disabled name="" id="dir" class="form-control" placeholder="Av, Calle, Ubicación" style="resize:none;" rows="2"><?php echo $cliente['dir_cli']; ?></textarea></div>
                                    <div><strong>Punto De Referencia:</strong><textarea disabled name="" id="pun" class="form-control" placeholder="Por Tales...." style="resize:none;" rows="3"><?php echo $cliente['pun_ref_cli']; ?></textarea></div>
                                    <br>
                                    <div class="client-buttons" style="display:grid;grid-template-columns:1fr 1fr;grid-gap:10px;">
                                        <button class="btn btn-outline-warning" onclick="editarDatos();"><i class="fas fa-pen"></i> Editar</button>
                                        <button class="btn btn-outline-success" onclick="guardarDatos();" disabled id="gua"><i class="fas fa-save"></i> Guardar Cambio</button>
                                    </div>

                                </div>
                            </div>

                            <div class="card mb-4 py-0 border-left-info">
                                <div class="card-body">
                                    <h4 class="h6 mb-0 font-weight-bold">Datos Del Contrato</h4>
                                    <hr>
                                    <div>
                                        <strong class="text-danger">Estatus Del Contrato: </strong><?php echo $cliente['nom_est']; ?><a href="../reportes/contrato/contrato.php?contrato=<?php echo $cliente['num_contrato']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-print"></i></a>
                                        <hr>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>Tipo de Instalación</strong>
                                            <select name="" id="ins" class="form-control">
                                                <option value="<?php echo $cliente['cod_tipo_ins']; ?>"> --><?php echo $cliente['nom_tipo_ins']; ?><-- </option>

                                                        <?php $obj_cliente->puntero = $obj_cliente->tipo();
                                                        while (($tip = $obj_cliente->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $tip['cod_tipo_ins']; ?>"><?php echo $tip['nom_tipo_ins']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>Fecha de Pago</strong>

                                            <select name="" id="dia" class="form-control">
                                                <option value="<?php echo $cliente['cod_fec_corte']; ?>"> --><?php echo $cliente['dia_fec_corte']; ?><-- </option>

                                                        <?php $obj_cliente->puntero = $obj_cliente->fecha();
                                                        while (($fec = $obj_cliente->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $fec['cod_fec_corte']; ?>"><?php echo $fec['dia_fec_corte']; ?></option>

                                            <?php } ?>
                                            </select>
                                        </div>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>Fecha Instalación</strong>
                                            <p><?php echo $obj_cliente->formatearFechaPrimero($cliente['fec_contrato']); ?></p>
                                        </div>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>Dirección IP</strong>
                                            <select name="" id="ip" class="form-control browser" onchange="mostrarBoton();">
                                                <option value="<?php echo $cliente['cod_ip']; ?>">--><?php echo $cliente['ip_contrato']; ?><--   </option>
                                                <option value=""> ------------------------------- </option>

                                                <?php $obj_cliente->puntero = $obj_cliente->ipes();
                                                while (($ipes = $obj_cliente->extraer_dato()) > 0) { ?>
                                                    <option value="<?php echo $ipes['cod_ip']; ?>"><?php echo $ipes['ip_contrato']; ?></option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                        <button style="display:none;" onclick="editarIP();" class="btn btn-success btn-block" id="cambiarIP">Guardar Cambio De IP <i class="fas fa-save"></i></button>

                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>IP Server</strong>
                                            <a href="http://<?php echo $cliente['ip_contrato']; ?>" target="_blank"><?php $obj_api->print_queue(); ?></a>
                                        </div>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>MAC</strong>
                                            <input type="text" class="form-control" id="mac" value="<?php echo $cliente['mac_det_con']; ?>">
                                        </div>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>MAC Server</strong>
                                            <b><?php $obj_api->print_arp(); ?></b>
                                        </div>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>Plan</strong>
                                            <select name="" class="form-control" id="pla">
                                                <option value="<?php echo $cliente['cod_plan']; ?>"> --><?php echo $cliente['nom_plan']; ?><-- </option>

                                                        <?php $obj_cliente->puntero = $obj_cliente->plan();
                                                        while (($pla = $obj_cliente->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $pla['cod_plan']; ?>"><?php echo $pla['nom_plan']; ?></option>

                                            <?php } ?>
                                            </select>
                                        </div>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>Tecnico</strong>
                                            <b><?php echo $cliente['nom_usu'] . " " . $cliente['ape_usu']; ?></b>
                                        </div>
                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>Estatus</strong>
                                            <div>
                                                <?php $obj_api->query_whitelist(); ?>
                                            </div>
                                        </div>

                                        <div class="contrato-cards" style="display:grid;grid-template-columns:1fr 2fr;"><strong>Router</strong>
                                            <div>
                                                <select name="" id="router" class="form-control" onchange="mostrarBotonRouter();">
                                                    <option value="<?php echo $cliente['cod_router'];?>"> ---<?php echo $cliente['nom_router'];?>---</option>
                                                    <option value=""> ------</option>

                                                    <?php $obj_cliente->puntero = $obj_cliente->routers();
                                                        while (($rou = $obj_cliente->extraer_dato()) > 0) { ?>
                                                <option value="<?php echo $rou['cod_router']; ?>"><?php echo $rou['nom_router']; ?></option>

                                            <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button style="display:none;" onclick="editarRouter();" class="btn btn-success btn-block" id="cambiarRouter">Guardar Cambio De Router <i class="fas fa-save"></i></button>

                                        <br>
                                        <div class="client-buttons responsive" style="display:grid;grid-auto-flow:column;grid-gap:10px;">
                                            <button class="btn btn-success" onclick="editarContrato();"><i class="fas fa-save"></i> Actualizar</button>
                                            <?php if ($cliente['estatus_clientes_cod_est_cli'] == '1') { ?>
                                                <button class="btn btn-danger" onclick="desactivarContrato();"><i class="fas fa-user-slash"></i> Desactivar</button>
                                            <?php } else { ?>
                                                <button class="btn btn-primary" onclick="activarContrato();"><i class="fas fa-user-check"></i> Activar</button>
                                            <?php } ?>



                                            <?php if ($mantenimiento['pendiente'] > 0) { ?>
                                                <button class="btn btn-secondary" disabled><i class="far fa-clock"></i> Mantenimiento Pendiente</button>
                                            <?php } else { ?>
                                                <a class="btn btn-warning" href="javascript:void(0);" data-toggle="modal" data-target="#add_mantenimiento" onclick="carga_ajax('<?php echo $cliente['cod_contratos']; ?>','add_mantenimiento','../modal/modal_add_mantenimiento.php');"><i class="fas fa-wrench"></i> Registrar Mantenimiento</a>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
            
                <!-- table card-1 end -->

                <div class="client-fac">
                            <div class="card mb-4 py-0 border-left-warning">
                                <div class="card-body">
                                    <h4 class="h6 mb-0 font-weight-bold">Facturas Del Cliente</h4>
                                    <hr>

                                    <p>Facturas Pendientes:</p>

                                    <?php $obj_cliente->puntero = $obj_cliente->factura_pendiente();
                                    while (($arr = $obj_cliente->extraer_dato()) > 0) { ?>
                                        <div class="card" style="display:grid;grid-template-columns:2fr 0.5fr 0.5fr 0.5fr;grid-gap:10px;align-items:baseline;">
                                            <a data-toggle="collapse" href="#collapseExample<?php echo $arr["cod_fac"]; ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <h5 class="card-title text-primary"><?php echo "Factura #" . $arr['num_factura'] . " Monto Total: $" . $obj_cliente->pesos($arr['mon_fac']); ?></h5>
                                            </a>
                                            <a href="./registrar_pago.php?contrato=<?php echo $_GET['contrato'] ?>&cod_fac=<?php echo $arr['cod_fac']; ?>" class="btn btn-outline-success"><i class="fas fa-dollar-sign"></i> Pagar</a>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_factura" onclick="carga_ajax('<?php echo $arr['cod_fac']; ?>','edit_factura','../modal/modal_edit_factura.php');" class="btn btn-outline-info"><i class="fas fa-pencil-alt"></i> Editar</a>
                                            <button class="btn btn-outline-danger" onclick="eliminarFactura(<?php echo $arr['cod_fac']; ?>);"><i class="far fa-trash-alt"></i> Eliminar</button>


                                            <div class="collapse" id="collapseExample<?php echo $arr["cod_fac"]; ?>">
                                                <div class="card-body">
                                                    <h6 class="h6 font-weight-bold">ID: <?php echo $arr["cod_fac"]; ?></h6>
                                                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $arr['des_fac']; ?></h6>
                                                    <p class="card-text">Mes: <?php echo $arr['mes_fac']; ?> - Año: <?php echo $arr['ano_fac']; ?></p>
                                                    <p class="card-text">Total: <?php echo $obj_cliente->pesos($arr['mon_fac']); ?></p>
                                                    <p class="card-text">Deducible: <?php echo $obj_cliente->pesos($arr['mon_ded_fac']); ?></p>
                                                    <p class="card-text">Creación: <?php echo $obj_cliente->formatearSoloFecha($arr['fec_cre_fac']); ?></p>

                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                    <?php } ?>

                                    <div>
                                        <h6 class="h6 font-weight-bold">Opciones:</h6>
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#add_factura" onclick="carga_ajax('<?php echo $cliente['cod_contratos']; ?>','add_factura','../modal/modal_add_factura.php');" class="btn btn-info">Crear Factura <i class="fas fa-file-invoice-dollar"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>

                <!-- table card-2 start -->

                <div class="client-graf">
                            <div class="card mb-4 py-0 border-left-success">
                                <div class="card-body">
                                    <h4 class="h6 mb-0 font-weight-bold">Monitoreo En Tiempo Real</h4>
                                    <hr>
                                    <div class="grafica">
                                        <?php
                                        echo $cli = "Contrato N" . " " . $cliente["num_contrato"] . " " . $cliente["nom_cli"];
                                        $con = $cliente["cod_contratos"];

                                        require_once("./grafica_tiempo_real.php");
                                        ?>
                                    </div>
                                    <div class="both-graphs">
                                        <div class="graph1">
                                            <strong>Consumo Diaria </strong>
                                            <img class="graph" src="http://<?php echo $cliente["ip_router"] . ":" . $cliente["puerto_graf"]; ?>/graphs/queue/<?php echo "Contrato N" . " " . $cliente["num_contrato"] . " " . $cliente['nom_cli']; ?>/daily.gif" class="img-responsive" /><br />
                                        </div>
                                        <div class="graph2">
                                            <strong>Consumo Semanal</strong>
                                            <img class="graph" src="http://<?php echo $cliente["ip_router"] . ":" . $cliente["puerto_graf"]; ?>/graphs/queue/<?php echo "Contrato N" . " " . $cliente["num_contrato"] . " " . $cliente["nom_cli"]; ?>/weekly.gif" class="img-responsive" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                <!-- Widget primary-success card end -->

                <div class="client-historico">
                            <div class="card mb-4 py-0 border-left-dark">
                                <div class="card-body">
                                    <h4 class="h6 mb-0 font-weight-bold">Historicos Del Cliente</h4>
                                    <hr>

                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" id="tab_1" href="#tb1" data-toggle="tab" role="tab" aria-controls="1" aria-selected="true">Facturas Pagas</a></li>
                                            <li class="nav-item"><a class="nav-link" id="tab_2" href="#tb2" data-toggle="tab" role="tab" aria-controls="2" aria-selected="false">Mantenimientos Realizados</a></li>
                                            <li class="nav-item"><a class="nav-link" id="tab_3" href="#tb3" data-toggle="tab" role="tab" aria-controls="3" aria-selected="false">Cambios En El Perfil</a></li>
                                        </ul>
                                    </div>

                                    <div class="tab-content" id="myTabContent">

                                        <div class="tab-pane fade show active" id="tb1" role="tabpanel" aria-labelledby="tab_1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>N. Factura</th>
                                                            <th>Monto</th>
                                                            <th>Observación</th>
                                                            <th>Mes</th>
                                                            <th>Año</th>
                                                            <th>Forma Pago</th>
                                                            <th>Estatus</th>
                                                            <th>Fecha</th>
                                                            <th>Opción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $obj_cliente->puntero = $obj_cliente->factura_paga();
                                                        while (($fp = $obj_cliente->extraer_dato()) > 0) { ?>
                                                            <tr>
                                                                <td>#<?php echo $fp['num_factura']; ?></td>
                                                                <td>$<?php echo $obj_cliente->pesos($fp['mon_pag_fac']); ?></td>
                                                                <td><?php echo $fp['des_fac'] . " // " . $fp['obs_pag_fac']; ?></td>
                                                                <td><?php echo $fp['mes_fac']; ?></td>
                                                                <td><?php echo $fp['ano_fac']; ?></td>
                                                                <td><?php echo $fp['nom_for_pag']; ?></td>
                                                                <td><?php echo $fp['nom_est_con']; ?></td>
                                                                <td><?php echo $obj_cliente->formatearFechaPrimero($fp['fec_pag_fac']); ?></td>
                                                                <td>

                                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_factura_paga" onclick="carga_ajax('<?php echo $fp['factura_cod_fac']; ?>','edit_factura_paga','../modal/modal_edit_factura_paga.php');" class="btn btn-sm btn-primary" title="Editar Factura"><i class="fas fa-pen"></i></a>
                                                                    <a href="../email/recibo_pago.php?cod_contratos=<?php echo $_GET['contrato'] ?>&cod_fac=<?php echo $fp['factura_cod_fac'] ?>" class="btn btn-sm btn-warning" title="Ver Reporte"><i class="fas fa-envelope"></i></a>

                                                                </td>


                                                            </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="tb2" role="tabpanel" aria-labelledby="tab_2">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Cod#</th>
                                                            <th>Falla</th>
                                                            <th>Solución</th>
                                                            <th>Observación</th>
                                                            <th>Solicitado</th>
                                                            <th>Realizado</th>
                                                            <th>Tecnico</th>
                                                            <th>Evidencia</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $obj_cliente->puntero = $obj_cliente->mantenimientos();
                                                        while (($m = $obj_cliente->extraer_dato()) > 0) { ?>
                                                            <tr>
                                                                <td>#<?php echo $m['cod_man']; ?></td>
                                                                <td><?php echo $m['nom_fallas']; ?></td>
                                                                <td><?php echo $m['sol_act_man']; ?></td>
                                                                <td><?php echo $m['obs_act_man']; ?></td>
                                                                <td><?php echo $obj_cliente->formatearFechaPrimero($m['fec_man']); ?></td>
                                                                <td><?php echo $obj_cliente->formatearFechaPrimero($m['fec_act_man']); ?></td>
                                                                <td><?php echo $m['nom_usu'] . " " . $m['ape_usu']; ?></td>
                                                                <td><a href="#" title="<?php echo $m['img_act_man']; ?>" onclick="mostrarMantenimiento('<?php echo $m['img_act_man']; ?>');" class="btn btn-sm btn-success" title="Ver Imagen"><i class="fas fa-image"></i></a></td>
                                                            </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="tb3" role="tabpanel" aria-labelledby="tab_3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Usuario</th>
                                                            <th>Fecha</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $obj_cliente->puntero = $obj_cliente->auditoria();
                                                        while (($a = $obj_cliente->extraer_dato()) > 0) { ?>
                                                            <tr>
                                                                <td>#<?php echo $a['cod_aud']; ?></td>
                                                                <td><?php echo $a['des_aud']; ?></td>
                                                                <td><?php echo $a['nom_usu'] . " " . $a['ape_usu']; ?></td>
                                                                <td><?php echo $obj_cliente->formatearFechaPrimero($a['fec_aud']); ?></td>
                                                            </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

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

    <!-- SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.browser').select2();
            });
        </script>

    <!-- Codigo de Funcionamiento -->

    <script>
            const mostrarBoton = () => {
                let ip1 = $('#ip').val();
                let ip2 = '<?php echo $cliente['cod_ip'];?>';

                if( ip1 == ip2 || ip1 == "" ){
                    $('#cambiarIP').hide('slow');
                }else{
                    $('#cambiarIP').show('slow');
                }
            }

            const mostrarBotonRouter = () => {
                let rou1 = $('#router').val();
                let rou2 = '<?php echo $cliente['cod_router'];?>';

                if( rou1 == rou2 || rou1 == "" ){
                    $('#cambiarRouter').hide('slow');
                }else{
                    $('#cambiarRouter').show('slow');
                }
            }

            const editarRouter = () => {
                let rou = $('#router').val();
                
                let contrato = '<?php echo $_GET['contrato'];?>';

                let completa2 = '<?php echo $cliente['nom_router'];?>';
                let completa1 = $('#router option:selected').text();

                let mensaje = "Se cambio de router de: "+completa2+" A: "+completa1;

                console.log(mensaje);

                dataString = "cod_contratos="+contrato+"&&routers_cod_router="+rou+"&&des_aud="+mensaje+"&&accion=editarRouter";

                $.ajax({
                            type: "POST",
                            url: "../../backend/controlador/cliente/cliente.php",
                            data: dataString,
                            success: function(r) {
                                Swal.fire(
                                    'Router Cambiado!',
                                    '',
                                    'success'
                                )
                                location.reload();
                            }
                        });
            }

            const editarIP = () => {
                let ip1 = $('#ip').val();
                let ip2 = '<?php echo $cliente['cod_ip'];?>';

                let completa1 = $('#ip option:selected').text();
                let completa2 = '<?php echo $cliente['ip_contrato'];?>';

                let contrato = '<?php echo $_GET['contrato'];?>';

                let mensaje = "Se cambio la IP de: "+completa2+" A: "+completa1;

                console.log(mensaje);

                dataString = "cod_contratos="+contrato+"&&old_ip="+completa2+"&&new_ip="+completa1+"&&neu="+ip1+"&&old="+ip2+"&&des_aud="+mensaje+"&&accion=editarIP";

                $.ajax({
                            type: "POST",
                            url: "../../backend/controlador/cliente/cliente.php?rou=<?php echo $cliente['cod_router'];?>",
                            data: dataString,
                            success: function(r) {
                                Swal.fire(
                                    'IP Cambiada!',
                                    '',
                                    'success'
                                )
                                location.reload();
                            }
                        });
            }
            /*---------------------Funciones de perfil cliente---------------------------*/

            const eliminarFactura = (cod) => {
                let con = '<?php echo $_GET['contrato']; ?>'

                Swal.fire({
                    title: '¿Desea Eliminar La Factura?',
                    html: '<strong> Motivo Para Eliminar La Factura:</strong><textarea id="swal-input1" class="swal2-input" placeholder="Falsa Factura, No corresponde......." style="width:80%;resize:none;height:150px;"></textarea>',
                    focusConfirm: false,
                    confirmButtonColor: '#E74C3C',
                    confirmButtonText: 'Eliminar La Factura',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        let mot = document.getElementById('swal-input1').value;
                        let mensaje = "Se Elimino La Factura Por: " + mot;

                        dataString = "cod_fac=" + cod + "&&des_aud=" + mensaje + "&&contratos_cod_contratos=" + con + "&&accion=eliminarFactura";
                        console.log(dataString);
                        $.ajax({
                            type: "POST",
                            url: "../../backend/controlador/factura/factura.php",
                            data: dataString,
                            success: function(r) {
                                Swal.fire(
                                    'Eliminada!',
                                    '',
                                    'success'
                                )
                                location.reload();

                            }
                        });

                    }
                })

            }

            /*--------------------------------------------------------------------------*/
            const mostrarMantenimiento = (foto) => {

                if (foto != "") {
                    Swal.fire({
                        title: '',
                        text: '',
                        imageUrl: '../assets/images/mantenimiento/' + foto,
                        imageWidth: 5000,
                        imageHeight: 500,
                        imageAlt: 'Custom image',
                    })
                } else {
                    Swal.fire(
                        '¡Este Mantenimiento No Tiene Imagen!',
                        '',
                        'info'
                    )
                }

            }
            /*----------------------------------------------------------------------*/

            const desactivarContrato = () => {
                let cod = '<?php echo $cliente['cod_cli']; ?>';
                let con = '<?php echo $cliente['cod_contratos']; ?>';
                let ipc = '<?php echo $cliente['ip_contrato']; ?>';

                Swal.fire({
                    title: 'Motivo Para Desactivarlo',
                    html: '<textarea id="swal-input1" class="swal2-input" placeholder="Suspension, No mas uso del servicio...." style="width:80%;resize:none;height:150px;"></textarea>',
                    focusConfirm: false,
                    confirmButtonColor: '#E74C3C',
                    confirmButtonText: 'Desactivar',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        let mot = document.getElementById('swal-input1').value;
                        let mensaje = "Se Desactivo el servicio por: " + mot;

                        dataString = "cod_cli=" + cod + "&&des_aud=" + mensaje + "&&contratos_cod_contratos=" + con + "&&ip_contrato=" + ipc + "&&accion=desactivarContrato";
                        console.log(dataString);
                        $.ajax({
                            type: "POST",
                            url: "../../backend/controlador/cliente/cliente.php?rou=<?php echo $cliente['cod_router']?>",
                            data: dataString,
                            success: function(r) {
                                Swal.fire(
                                    'Desactivado!',
                                    '',
                                    'success'
                                )
                                location.reload();

                            }
                        });

                    }
                })
            }

            const activarContrato = () => {
                let cod = '<?php echo $cliente['cod_cli']; ?>';
                Swal.fire({
                    title: 'Deseas Activar De Nuevo El Contrato?',
                    text: "",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Activar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: "cod_cli=" + cod + "&&accion=activarContrato",
                            url: "../../backend/controlador/cliente/cliente.php",
                            type: "POST",
                            success: function(response) {
                                console.log("Editado Exitoso");
                                console.log(response);
                                Swal.fire(
                                    'Activado!',
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




            /*----------------------------------------------------------------------------*/
            const editarDatos = () => {
                $('#tip').removeAttr('disabled');
                $('#ced').removeAttr('disabled');
                $('#nom').removeAttr('disabled');
                $('#ema').removeAttr('disabled');
                $('#te1').removeAttr('disabled');
                $('#te2').removeAttr('disabled');
                $('#sec').removeAttr('disabled');
                $('#dir').removeAttr('disabled');
                $('#pun').removeAttr('disabled');
                $('#gua').removeAttr('disabled');

                $('#gua').attr('class', 'btn btn-success');
            }

            const guardarDatos = () => {
                let cod = '<?php echo $cliente['cod_cli']; ?>';
                let tip = $('#tip').val();
                let ced = $('#ced').val();
                let nom = $('#nom').val();
                let ema = $('#ema').val();
                let te1 = $('#te1').val();
                let te2 = $('#te2').val();
                let sec = $('#sec').val();
                let dir = $('#dir').val();
                let pun = $('#pun').val();

                datas = "ip_contrato=<?php echo $cliente['ip_contrato']; ?>" + "&&contrato=<?php echo $cliente['cod_contratos']; ?>" + "&&cod_cli=" + cod + "&&nom_cli=" + nom + "&&tel_cli=" + te1 + "&&tel2_cli=" + te2 + "&&ema_cli=" + ema + "&&tipo_cli=" + tip + "&&ced_cli=" + ced + "&&dir_cli=" + dir + "&&pun_ref_cli=" + pun + "&&sector_cod_sec=" + sec + "&&accion=editar";
                console.log(datas);

                if (cod == "" || tip == "" || ced == "" || nom == "" || ema == "" || te1 == "" || te2 == "" || sec == "" || dir == "" || pun == "") {
                    Swal.fire(
                        'Campos Vacios!',
                        'Debes llenar todos los campos!',
                        'warning'
                    )
                } else {
                    $.ajax({
                        data: datas,
                        url: "../../backend/controlador/cliente/cliente.php?rou=<?php echo $cliente['cod_router']; ?>",
                        type: "POST",
                        success: function(response) {
                            console.log("Editado Exitoso");
                            Swal.fire(
                                'Actualización Exitosa!',
                                '',
                                'success'
                            )
                            location.reload();
                        }
                    });
                }
            }

            /*---------------------------------------------------*/

            const editarContrato = () => {

                let cod = '<?php echo $cliente['cod_contratos']; ?>';
                let ins = $('#ins').val();
                let dia = $('#dia').val();
                let mac = $('#mac').val();
                let pla = $('#pla').val();

                datas = "nom=<?php echo $cliente['nom_cli']; ?>" + "&&ip_contrato=<?php echo $cliente['ip_contrato']; ?>" + "&&contrato=" + cod + "&&fecha_corte=" + dia + "&&tipo_instalacion=" + ins + "&&mac=" + mac + "&&planes=" + pla + "&&accion=editaContrato";

                console.log(datas);

                if (ins == "" || dia == "" || ip == "" || mac == "" || pla == "") {
                    Swal.fire(
                        'Campos Vacios!',
                        '',
                        'warning'
                    )
                } else {

                    Swal.fire({
                        title: 'Deseas Realizar Los Cambios?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Guardar',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                data: datas,
                                url: "../../backend/controlador/cliente/cliente.php?rou=<?php echo $cliente['cod_router']; ?>",
                                type: "POST",
                                success: function(response) {
                                    console.log("Editado Exitoso");
                                    console.log(response);
                                    Swal.fire(
                                        'Actualización Exitosa!',
                                        '',
                                        'success'
                                    )
                                }
                            });

                            auditoriaContrato(ins, dia, mac, pla);

                        } else {
                            Swal.fire(
                                'No se realizo ningun cambio',
                                '',
                                'info'
                            )
                        }
                    })
                }
            }

            auditoriaContrato = (tipo, fecha, mac, plan) => {
                let old_tip = '<?php echo $cliente['cod_tipo_ins'] ?>';
                let old_dia = '<?php echo $cliente['cod_fec_corte'] ?>';
                let old_mac = '<?php echo $cliente['mac_det_con'] ?>';
                let old_pla = '<?php echo $cliente['planes_cod_plan'] ?>';
                let instalacion = '';
                let dia_corte = '';
                let mac_det = '';
                let planes = '';

                //console.log(old_tip+" "+old_dia+" "+old_mac+" "+old_pla);

                if (old_tip != tipo) {
                    instalacion = 'Tipo Instalación-><?php echo $cliente['nom_tipo_ins'] ?>//';
                }

                if (old_dia != fecha) {
                    dia_corte = 'Fecha Corte-><?php echo $cliente['dia_fec_corte'] ?>//';
                }

                if (old_mac != mac) {
                    mac_det = 'MAC-><?php echo $cliente['mac_det_con'] ?>//';
                }

                if (old_pla != plan) {
                    planes = 'Plan-><?php echo $cliente['nom_plan'] ?>//';
                }

                mensaje = 'Se modifico el contrato, valores antes: ' + instalacion + dia_corte + mac_det + planes;
                console.log(mensaje);

                entry = "des_aud=" + mensaje + "&&contratos_cod_contratos=<?php echo $cliente['cod_contratos']; ?>&&accion=auditoriaContrato";
                console.log(entry);
                $.ajax({
                    data: entry,
                    url: "../../backend/controlador/cliente/cliente.php",
                    type: "POST",
                    success: function(response) {
                        console.log("Editado Exitoso");
                        //location.reload();
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