<?php
session_start();

if (isset($_SESSION["cod_usu"])) {

    require_once("../../backend/clase/company.class.php");
    /* require_once("../../backend/clase/grupo_menu.class.php");
    $obj_grupo = new grupo_menu;
    $obj_grupo2 = new grupo_menu; */

    $obj_company = new company;

    $obj_company->cod_company = $_SESSION["company"];
    $obj_company->asignar_valor();
    $obj_company->puntero = $obj_company->listar();
    $emprise = $obj_company->extraer_dato();

    /* $obj_grupo->puntero = $obj_grupo->existenRouters();
    $server = $obj_grupo->extraer_dato(); */

    //echo $server['existe']; 

?>
<style>
    @media screen and (min-width:240px) and (max-width:960px) {
    .com-img {
        width: 20% !important;
    }
}
</style>
    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark" style="border-bottom:1px solid #ccc;">


        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            <a href="#!" class="b-brand">
                <!-- ========   change your logo hear   ============ -->

                
                    
                    <img class="com-img " src="../assets/images/logos/<?php echo $emprise['logo_company'] ?>" alt="" style="padding:10px;border-radius:20px;" width="30%">
                   <h5 class="text-white mt-2"><?php echo $emprise['razon_social'] ?></h5>
                   
                
            </a>
            <a href="#!" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">

            <ul class="navbar-nav ml-auto">

                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="../assets/images/user/undraw_profile.svg" class="img-radius" alt="User-Profile-Image">
                                <span><?php echo $_SESSION['nom_usu']?></span>

                            </div>
                            <ul class="pro-body">
                                <li><a href="./users.php" class="dropdown-item"><i class="feather icon-user"></i> Ajustes</a></li>
                                <hr>
                                <li><a href="../../backend/controlador/sesion/sesion.php?accion=cerrar" class="dud-logout" title="Logout">
                                        <i class="feather icon-log-out"></i>
                                        Cerrar Sesion
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>


    </header>

<?php
} else {
    echo "Error al cargar el menu!!!";
}
?>