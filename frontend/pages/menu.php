<?php

session_start();
if (isset($_SESSION["cod_usu"])) {

	require_once("../../backend/clase/company.class.php");
	require_once("../../backend/clase/grupo_menu.class.php");
	$obj_grupo = new grupo_menu;
	$obj_grupo2 = new grupo_menu;

	$obj_company = new company;

	$obj_company->cod_company = $_SESSION["company"];
	$obj_company->asignar_valor();
	$obj_company->puntero = $obj_company->listar();
	$emprise = $obj_company->extraer_dato();

	$obj_grupo->puntero = $obj_grupo->existenRouters();
	$server = $obj_grupo->extraer_dato();

	$server['existe'];

?>

	<nav class="pcoded-navbar  ">

		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div ">

				<div class="">



					<ul class="nav pcoded-inner-navbar ">


						<li class="nav-item">
							<a href="./index.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Inicio</span></a>
						</li>

						<?php if ($server['existe'] != 0) {
							$obj_grupo->puntero = $obj_grupo->listar();
							while (($grupo = $obj_grupo->extraer_dato()) > 0) {
						?>

								<li class="nav-item pcoded-hasmenu">
									<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="<?php echo $grupo["ico_gru_men"]; ?>"></i></span><span class="pcoded-mtext"><?php echo $grupo["nom_gru_men"]; ?></span></a>
									<ul class="pcoded-submenu">

										<?php
										$obj_grupo2->grupo_menu_cod_gru_men = $grupo["cod_gru_men"];
										$obj_grupo2->asignar_valor();
										$obj_grupo2->puntero = $obj_grupo2->listar_menu();
										while (($menu = $obj_grupo2->extraer_dato()) > 0) {
										?>

											<li><a href="<?php echo $menu["rut_men_link"]; ?>"><?php echo $menu["nom_men_link"]; ?></a></li>

										<?php } ?>

									</ul>
								</li>

							<?php }
								} else {
							?>

							<?php
            				$obj_grupo->puntero = $obj_grupo->soloServer();
            				while (($grupo = $obj_grupo->extraer_dato()) > 0) {
            				?>

							<li class="nav-item pcoded-hasmenu">
								<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="<?php echo $grupo["ico_gru_men"]; ?>"></i></span><span class="pcoded-mtext"><?php echo $grupo["nom_gru_men"]; ?></span></a>
								<ul class="pcoded-submenu">

									<?php
									$obj_grupo2->grupo_menu_cod_gru_men = $grupo["cod_gru_men"];
									$obj_grupo2->asignar_valor();
									$obj_grupo2->puntero = $obj_grupo2->listar_menu();
									while (($menu = $obj_grupo2->extraer_dato()) > 0) {
									?>

										<li><a href="<?php echo $menu["rut_men_link"]; ?>"><?php echo $menu["nom_men_link"]; ?></a></li>

									<?php } ?>

								</ul>
							</li>


						<?php }
						} ?>



					</ul>

					<hr style="border-bottom:1px solid #ccc;">
				</div>
			</div>
	</nav>

<?php
} else {
	echo "Error al cargar el menu!!!";
}
?>