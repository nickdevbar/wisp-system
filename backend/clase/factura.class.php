<?php
if (!session_id()) {
    session_start();
}

if (isset($_SESSION['cod_usu'])) {

    require_once "utilidad.class.php";
    require_once "funciones_api.class.php";

    class factura extends utilidad
    {

        public $cod_fac;
        public $contratos_idcontratos;
        public $estatus_contable_idestatus_contable;
        public $fecha_corte_idfecha_corte;
        public $fec_cre_fac;
        public $fec_ven_fac;
        public $mes_fac;
        public $ano_fac;
        public $mon_fac;
        public $usuarios_idusuarios;

        /* DEFINE SI ESTAN PENDIENTES O PAGAS */
        public $estatu;
        public $contrato;
        public $fecha_corte;

        /* DEFINE VARIABLES MODIFICAR FACTURA*/
        public $plan;
        public $cod_det_fac;
        public $des_det_fac;
        public $total_factura;

        /* DEFINE VARIABLES AUDITORIA*/
        public $cod_aud;
        public $des_aud;
        public $fec_aud;

        public $cod_cue_ban;

        /*----------------Nuevas----------------------*/

        public function routerConnect()
        {

            $this->que_dba = "SELECT * FROM routers
			WHERE company_cod_company = '" . $_SESSION['company'] . "'
			AND cod_router = '" . $this->cod_router . "';";
            return $this->ejecutar();

        }

        public function listarDebe()
        {

            $this->que_dba = "SELECT * FROM factura f, contratos c, detalles_contratos dc, planes p, clientes cl 
            WHERE f.estatus_contable_cod_est_con = 1
            AND c.cod_contratos = dc.contratos_cod_contratos
            AND dc.planes_cod_plan = p.cod_plan
            AND cl.cod_cli = c.clientes_cod_cli
            AND f.contratos_cod_contratos = c.cod_contratos
            AND f.company_cod_company = '" . $_SESSION['company'] . "';";
            return $this->ejecutar();

        }

        public function listarDebeTotal()
        {

            $this->que_dba = "SELECT SUM(pre_plan) AS total FROM factura f, contratos c, detalles_contratos dc, planes p, clientes cl WHERE f.estatus_contable_cod_est_con = 1
            AND c.cod_contratos = dc.contratos_cod_contratos
            AND dc.planes_cod_plan = p.cod_plan
            AND cl.cod_cli = c.clientes_cod_cli
            AND f.contratos_cod_contratos = c.cod_contratos
            AND f.company_cod_company = '" . $_SESSION['company'] . "';";
            return $this->ejecutar();

        }

        public function eliminarFactura()
        {

            $this->que_dba = "DELETE FROM factura
			WHERE cod_fac = '" . $this->cod_fac . "';";
            $this->ejecutar();

            $this->que_dba = "INSERT INTO auditoria (
				des_aud,
				fec_aud,
				contratos_cod_contratos,
				usuarios_cod_usu
				)VALUES(
				'" . $this->des_aud . "',
				Now(),
				'" . $this->contratos_cod_contratos . "',
				'" . $_SESSION['cod_usu'] . "'
				)";
            return $this->ejecutar();

        }

        public function cerrarCaja()
        {

            $this->que_dba = "UPDATE factura SET
			estatus_contable_cod_est_con = '3'
			WHERE estatus_contable_cod_est_con = '2'
			AND company_cod_company = '" . $_SESSION['company'] . "';";
            $this->ejecutar();

            $this->que_dba = "INSERT INTO caja_diaria (
				mon_caj_dia,
				obs_caj_dia,
				fec_caj_dia,
				usuarios_cod_usu,
				company_cod_company
				)VALUES(
				'" . $this->mon_caj_dia . "',
				'" . $this->obs_caj_dia . "',
				Now(),
				'" . $_SESSION['cod_usu'] . "',
				'" . $_SESSION['company'] . "'
				)";
            return $this->ejecutar();

        }

        public function actualizarFactura()
        {

            $this->que_dba = "UPDATE factura
			SET
			mes_fac = '" . $this->mes_fac . "',
			ano_fac = '" . $this->ano_fac . "',
			mon_fac = '" . $this->mon_fac . "',
			mon_ded_fac = '" . $this->mon_ded_fac . "',
			des_fac = '" . $this->des_fac . "'
			WHERE cod_fac = '" . $this->cod_fac . "';";

            echo '1';

            return $this->ejecutar();

        }

        public function actualizarFacturaPaga()
        {

            $this->que_dba = "UPDATE pago_factura
			SET
			mon_pag_fac = '" . $this->mon_pag_fac . "',
			obs_pag_fac = '" . $this->obs_pag_fac . "',
			forma_pago_cod_for_pag = '" . $this->forma_pago_cod_for_pag . "'
			WHERE factura_cod_fac = '" . $this->factura_cod_fac . "';";

            echo '1';

            return $this->ejecutar();

        }

        public function porFactura()
        {

            $this->que_dba = "SELECT *
			FROM clientes cl, contratos co, factura fa, planes pl, detalles_contratos dc, ips ip
			WHERE cl.cod_cli = co.clientes_cod_cli
			AND co.cod_contratos = fa.contratos_cod_contratos
			AND co.cod_contratos = dc.contratos_cod_contratos
			AND dc.planes_cod_plan = pl.cod_plan
			AND ip.cod_ip = dc.ips_cod_ip
			AND fa.estatus_contable_cod_est_con='1'
			AND co.company_cod_company = '" . $_SESSION["company"] . "'
			AND fa.cod_fac='" . $this->cod_fac . "';";

            return $this->ejecutar();

        }

        public function todosPagos()
        {

            if ($this->fecha != "") {
                $this->que_dba = "SELECT *
		FROM clientes cl, contratos co, factura fa, pago_factura pf, planes pl, detalles_contratos dc, forma_pago fp
		WHERE cl.cod_cli = co.clientes_cod_cli
		AND co.cod_contratos = fa.contratos_cod_contratos
		AND co.cod_contratos = dc.contratos_cod_contratos
		AND dc.planes_cod_plan = pl.cod_plan
		AND fa.cod_fac = pf.factura_cod_fac
		AND fp.cod_for_pag = pf.forma_pago_cod_for_pag
		AND fa.estatus_contable_cod_est_con BETWEEN '2' AND '3'
		AND cl.estatus_clientes_cod_est_cli ='1'
		AND co.company_cod_company = '" . $_SESSION["company"] . "'
		AND pf.fec_pag_fac LIKE '%" . $this->fecha . "%'
		ORDER BY cod_pag_fac DESC;";
            } else {
                $this->que_dba = "SELECT *
		FROM clientes cl, contratos co, factura fa, pago_factura pf, planes pl, detalles_contratos dc, forma_pago fp
		WHERE cl.cod_cli = co.clientes_cod_cli
		AND co.cod_contratos = fa.contratos_cod_contratos
		AND co.cod_contratos = dc.contratos_cod_contratos
		AND dc.planes_cod_plan = pl.cod_plan
		AND fa.cod_fac = pf.factura_cod_fac
		AND fp.cod_for_pag = pf.forma_pago_cod_for_pag
		AND fa.estatus_contable_cod_est_con BETWEEN '2' AND '3'
		AND cl.estatus_clientes_cod_est_cli ='1'
		AND co.company_cod_company = '" . $_SESSION["company"] . "'
			ORDER BY cod_pag_fac DESC;";
            }

            return $this->ejecutar();

        }

        public function todosCajas()
        {

            if ($this->fecha != "") {
                $this->que_dba = "SELECT * FROM caja_diaria cd, usuarios u
		WHERE cd.usuarios_cod_usu = u.cod_usu
		AND cd.company_cod_company ='" . $_SESSION["company"] . "'
		AND cd.fec_caj_dia LIKE '%" . $this->fecha . "%';";
            } else {
                $this->que_dba = "SELECT * FROM caja_diaria cd, usuarios u
		WHERE cd.usuarios_cod_usu = u.cod_usu
		AND cd.company_cod_company = '" . $_SESSION["company"] . "';";
            }

            return $this->ejecutar();

        }

        public function facturasCaja()
        {

            $this->que_dba = "SELECT *
	FROM clientes cl, contratos co, factura fa, pago_factura pf, planes pl, detalles_contratos dc, forma_pago fp
	WHERE cl.cod_cli = co.clientes_cod_cli
	AND co.cod_contratos = fa.contratos_cod_contratos
	AND co.cod_contratos = dc.contratos_cod_contratos
	AND dc.planes_cod_plan = pl.cod_plan
	AND fa.cod_fac = pf.factura_cod_fac
	AND fp.cod_for_pag = pf.forma_pago_cod_for_pag
	AND fa.estatus_contable_cod_est_con = '2'
	AND cl.estatus_clientes_cod_est_cli ='1'
	AND co.company_cod_company = '" . $_SESSION["company"] . "'
		ORDER BY fec_pag_fac DESC";

            return $this->ejecutar();
        }

        public function caja()
        {
            $this->que_dba = "SELECT COUNT(*) AS total, fp.nom_for_pag, SUM(mon_pag_fac) AS monto
	FROM pago_factura pf, forma_pago fp, factura f
	WHERE pf.forma_pago_cod_for_pag = fp.cod_for_pag
	AND f.cod_fac = pf.factura_cod_fac
	AND f.estatus_contable_cod_est_con = '2'
	AND f.company_cod_company='" . $_SESSION["company"] . "'
	GROUP BY fp.nom_for_pag";

            return $this->ejecutar();
        }

        public function facturaPaga()
        {

            $this->que_dba = "SELECT *
		FROM clientes cl, contratos co, factura fa, planes pl, detalles_contratos dc, pago_factura pf, forma_pago fp
		WHERE cl.cod_cli = co.clientes_cod_cli
		AND co.cod_contratos = fa.contratos_cod_contratos
		AND co.cod_contratos = dc.contratos_cod_contratos
		AND dc.planes_cod_plan = pl.cod_plan
		AND fa.cod_fac = pf.factura_cod_fac
		AND fp.cod_for_pag = pf.forma_pago_cod_for_pag
		AND co.company_cod_company = '" . $_SESSION["company"] . "'
		AND pf.factura_cod_fac='" . $this->cod_fac . "';";

            return $this->ejecutar();

        }

        public function formaPago()
        {

            $this->que_dba = "SELECT * FROM forma_pago";

            return $this->ejecutar();

        }

        public function registrarPago()
        {
            $this->que_dba = "INSERT INTO pago_factura
			(mon_pag_fac,
			obs_pag_fac,
			fec_pag_fac,
			factura_cod_fac,
			forma_pago_cod_for_pag,
			company_cod_company,
			usuarios_cod_usu
			)
			VALUES (
			'" . $this->mon_pag_fac . "',
			'" . $this->obs_pag_fac . "',
			Now(),
			'" . $this->factura_cod_fac . "',
			'" . $this->forma_pago_cod_for_pag . "',
			'" . $_SESSION['company'] . "',
			'" . $_SESSION['cod_usu'] . "'
			); ";
            $this->ejecutar();

            if ($this->mon_pag_fac > $this->mon_ded_fac) { // Pago por si es mayor
                $this->que_dba = "UPDATE factura
				SET
				estatus_contable_cod_est_con = '2',
				mon_ded_fac = '0'
				WHERE cod_fac = '" . $this->factura_cod_fac . "';";

                echo "Es mayor";
                $this->ejecutar();

                $obj_api = new funciones_api;
                $obj_api->ip_contrato = $this->ip_contrato;
                $obj_api->contrato = $this->contrato;
                $obj_api->nombres = $this->nombres;

                $obj_api->ip_router_api = $this->ip_api;
                $obj_api->login_api = $this->lo_api;
                $obj_api->password_api = $this->pa_api;
                $obj_api->port_api = $this->po_api;
                $obj_api->interfaz_api = $this->in_api;
                $obj_api->blacklist_api = $this->bl_api;
                $obj_api->whitelist_api = $this->wl_api;

                $obj_api->asignar_valor_api();
                $obj_api->connect();
                $obj_api->add_whitelist();
            }

            if ($this->mon_pag_fac == $this->mon_ded_fac) { //Pago Completo
                $this->que_dba = "UPDATE factura
				SET
				estatus_contable_cod_est_con = '2',
				mon_ded_fac = '0'
				WHERE cod_fac = '" . $this->factura_cod_fac . "';";

                echo "Es igual";
                $this->ejecutar();

                $obj_api = new funciones_api;
                $obj_api->ip_contrato = $this->ip_contrato;
                $obj_api->contrato = $this->contrato;
                $obj_api->nombres = $this->nombres;

                $obj_api->ip_router_api = $this->ip_api;
                $obj_api->login_api = $this->lo_api;
                $obj_api->password_api = $this->pa_api;
                $obj_api->port_api = $this->po_api;
                $obj_api->interfaz_api = $this->in_api;
                $obj_api->blacklist_api = $this->bl_api;
                $obj_api->whitelist_api = $this->wl_api;

                $obj_api->asignar_valor_api();
                $obj_api->connect();
                $obj_api->add_whitelist();
            }

            if ($this->mon_ded_fac > $this->mon_pag_fac) { //Abono
                $this->que_dba = "UPDATE factura
				SET
				mon_ded_fac = mon_ded_fac - '" . $this->mon_pag_fac . "'
				WHERE cod_fac = '" . $this->factura_cod_fac . "';";

                echo "Es menor";
                $this->ejecutar();
            }

        }

        public function consultarUltima()
        {
            //$ano_fac=date("Y");
            $this->que_dba = "SELECT *
		FROM contratos c,
			detalles_contratos dc,
			factura f,
			planes p
		WHERE
		c.cod_contratos=dc.contratos_cod_contratos
		AND dc.planes_cod_plan = p.cod_plan
		AND c.cod_contratos=f.contratos_cod_contratos
		AND c.company_cod_company =  '" . $_SESSION['company'] . "'
		AND f.ano_fac='" . $this->anio . "'
		AND c.cod_contratos='" . $this->cod_contratos . "'
		ORDER BY f.cod_fac DESC";
            return $this->ejecutar();

        }

        public function ultimaFactura()
        {

            $this->que_dba = "SELECT *
		FROM factura f
		WHERE
		f.company_cod_company = '" . $_SESSION['company'] . "'
		ORDER BY f.num_factura DESC";
            return $this->ejecutar();

        }

        public function contarAnio()
        {
            $ano_fac = date("Y");
            $this->que_dba = "SELECT mes_fac AS meses
	FROM contratos c,
		detalles_contratos dc,
		factura f,
		planes p
	WHERE
	c.cod_contratos=dc.contratos_cod_contratos
	AND dc.planes_cod_plan=p.cod_plan
	AND c.cod_contratos=f.contratos_cod_contratos
	AND c.company_cod_company =  '" . $_SESSION['company'] . "'
	AND f.ano_fac = $ano_fac
	AND c.cod_contratos= '" . $this->cod_contratos . "'
	ORDER BY f.cod_fac DESC";

            return $this->ejecutar();

        }

        public function planes()
        {
            $this->que_dba = "SELECT *
	FROM
	planes p
	WHERE
	p.company_cod_company = '" . $_SESSION['company'] . "';";

            return $this->ejecutar();

        }

        public function cliente()
        {

            $this->que_dba = "SELECT *
	FROM clientes cl, contratos co, planes pl, detalles_contratos dc
	WHERE cl.cod_cli = co.clientes_cod_cli
	AND co.cod_contratos = dc.contratos_cod_contratos
	AND dc.planes_cod_plan = pl.cod_plan
	AND cl.estatus_clientes_cod_est_cli ='1'
	AND co.company_cod_company = '" . $_SESSION['company'] . "'
	AND co.cod_contratos ='" . $this->cod_contratos . "';";

            return $this->ejecutar();
        }

        public function crearFactura()
        {

            $this->que_dba = "INSERT INTO factura
	   (num_factura,
	   fec_cre_fac,
	   mes_fac,
	   ano_fac,
	   mon_fac,
	   mon_ded_fac,
	   des_fac,
	   estatus_contable_cod_est_con,
	   fecha_corte_cod_fec_corte,
	   usuarios_cod_usu,
	   company_cod_company,
	   contratos_cod_contratos,
	   planes_cod_plan)
	   VALUES (
		'" . $this->num_factura . "',
		Now(),
		'" . $this->mes_fac . "',
		'" . $this->ano_fac . "',
		'" . $this->mon_fac . "',
		'" . $this->mon_fac . "',
		'" . $this->des_fac . "',
		'1',
		'" . $this->fecha_corte . "',
		'" . $_SESSION['cod_usu'] . "',
		'" . $_SESSION['company'] . "',
		'" . $this->cod_contratos . "',
		'" . $this->cod_plan . "'
	   ); ";

            return $this->ejecutar();

        }

        /*----------------------------------------------*/

        public function listar()
        {

            $this->que_dba = "SELECT *
				FROM clientes cl, contratos co, factura fa, planes pl, detalles_contratos dc
				WHERE cl.idclientes=co.clientes_idclientes
				AND co.idcontratos=fa.contratos_idcontratos
				AND co.idcontratos =dc.contratos_idcontratos
				AND dc.planes_idplanes=pl.idplanes
				AND co.estatus_idestatus='1'
				AND fa.estatus_contable_idestatus_contable='" . $this->estatu . "';";

            return $this->ejecutar();

        }

        public function consultar()
        {

            $this->que_dba = "SELECT *
			FROM clientes cl, contratos co, factura fa, planes pl, detalles_contratos dc
			WHERE cl.idclientes=co.clientes_idclientes
			AND co.idcontratos=fa.contratos_idcontratos
			AND co.idcontratos =dc.contratos_idcontratos
			AND dc.planes_idplanes=pl.idplanes
			AND fa.estatus_contable_idestatus_contable='9'
			AND co.estatus_idestatus='1'
			AND fa.cod_fac='" . $this->cod_fac . "';";

            return $this->ejecutar();

        }

        public function sumatoria()
        {

            $this->que_dba = "SELECT SUM(mon_fac) AS total_deuda
			FROM factura f, contratos c
			WHERE f.contratos_idcontratos=c.idcontratos
			AND c.estatus_idestatus='1'
			AND f.estatus_contable_idestatus_contable='9';";

            return $this->ejecutar();

        }

        //*************************************************************** */
        public function detalle_factura()
        {

            $this->que_dba = "SELECT *
		FROM  factura fa, detalle_factura df, planes pl
		WHERE fa.cod_fac=df.factura_cod_fac
		AND df.planes_idplanes=pl.idplanes
		AND fa.cod_fac='" . $this->cod_fac . "';";

            return $this->ejecutar();

        }

        /* ESTA FUNCION SE USA PARA CONTAR FACTURAS PENDIENTES EN EL PERFIL DE CLIENTE*/
        public function contar_f_pendiente()
        {

            $this->que_dba = "SELECT COUNT(*) AS total_facturas
		FROM factura
		WHERE estatus_contable_idestatus_contable=9
		AND contratos_idcontratos='" . $this->contrato . "';";

            return $this->ejecutar();

        }

        /* ESTA FUNCION SE USA PARA MOSTRAR FACTURAS PENDIENTES EN EL PERFIL DE CLIENTE*/
        public function consultar_f_pendiente()
        {

            $this->que_dba = "SELECT * FROM factura f, detalle_factura df
		WHERE f.cod_fac=df.factura_cod_fac
		AND f.estatus_contable_idestatus_contable=9
		AND f.contratos_idcontratos='" . $this->contrato . "';";

            return $this->ejecutar();

        }

        /*Eliminado Logico de la factura pendiente*/
        public function eliminar_f_pendiente()
        {

            $this->que_dba = "UPDATE factura
		SET estatus_contable_idestatus_contable = '13'
		WHERE cod_fac = '" . $this->cod_fac . "';";

            return $this->ejecutar();
        }

        /*Inserta la auditoria*/

        public function insertar_auditoria()
        {

            $this->que_dba = "INSERT INTO auditoria (des_aud, fec_aud, contratos_idcontratos, usuarios_idusuarios)
						VALUES (
						'" . $this->des_aud . "',
						Now(),
						'" . $this->contratos_idcontratos . "',
						'" . $_SESSION["idusuarios"] . "'
						);";

            return $this->ejecutar();
        }

        /* ESTA FUNCION MUESTRA LAS FACTURAS EN CAJA DIARIA PARA CERRAR CAJA*/
        public function factura_caja()
        {

            $this->que_dba = "SELECT * FROM factura f, detalle_factura df,pago_factura pf, contratos co,
		clientes cl, forma_pago fp
		WHERE f.cod_fac=df.factura_cod_fac
		AND f.cod_fac= pf.factura_cod_fac
		AND f.estatus_contable_idestatus_contable=10
		AND pf.estatus_contable_idestatus_contable=2
		AND co.clientes_idclientes=cl.idclientes
		AND co.idcontratos=f.contratos_idcontratos
		AND co.estatus_idestatus=1
		AND pf.forma_pago_idforma_pago=fp.idforma_pago
		AND pf.usuarios_idusuarios='" . $_SESSION["idusuarios"] . "';";

            return $this->ejecutar();

        }

        public function factura_caja_transferencia()
        {

            $this->que_dba = "SELECT * FROM factura f, detalle_factura df,pago_factura pf, contratos co,
		clientes cl, forma_pago fp, bancos b
		WHERE f.cod_fac=df.factura_cod_fac
		AND f.cod_fac= pf.factura_cod_fac
		AND f.estatus_contable_idestatus_contable=10
		AND pf.estatus_contable_idestatus_contable=2
		AND co.clientes_idclientes=cl.idclientes
		AND co.idcontratos=f.contratos_idcontratos
		AND co.estatus_idestatus=1
		AND pf.forma_pago_idforma_pago=fp.idforma_pago
		AND b.cod_cue_ban = pf.bancos_cod_cue_ban
		AND b.cod_cue_ban = '" . $this->cod_cue_ban . "'
		AND pf.usuarios_idusuarios='" . $_SESSION["idusuarios"] . "';";

            return $this->ejecutar();

        }

        public function factura_caja_id()
        {

            $this->que_dba = "SELECT * FROM factura f, detalle_factura df,pago_factura pf, contratos co,
		clientes cl, forma_pago fp
		WHERE f.cod_fac=df.factura_cod_fac
		AND f.cod_fac= pf.factura_cod_fac
		AND f.estatus_contable_idestatus_contable=10
		AND pf.estatus_contable_idestatus_contable=2
		AND co.clientes_idclientes=cl.idclientes
		AND co.idcontratos=f.contratos_idcontratos
		AND co.estatus_idestatus=1
		AND pf.forma_pago_idforma_pago=fp.idforma_pago
		AND pf.usuarios_idusuarios='" . $this->idusuarios . "';";

            return $this->ejecutar();

        }

        /* ESTA FUNCION MUESTRA EN CAJA DIARIA PAGOS POR FORMA DE PAGO */
        public function factura_caja_forma_pago()
        {

            $this->que_dba = "SELECT COUNT(*) AS total, fp.forma_pago, SUM(mon_pag_fac) AS monto
			FROM pago_factura pf, forma_pago fp
			WHERE pf.forma_pago_idforma_pago=fp.idforma_pago
			AND pf.estatus_contable_idestatus_contable=2
			AND pf.usuarios_idusuarios='" . $_SESSION["idusuarios"] . "'
			GROUP BY fp.forma_pago;";

            return $this->ejecutar();

        }

        public function factura_caja_forma_pago_id()
        {

            $this->que_dba = "SELECT COUNT(*) AS total, fp.forma_pago, SUM(mon_pag_fac) AS monto
			FROM pago_factura pf, forma_pago fp
			WHERE pf.forma_pago_idforma_pago=fp.idforma_pago
			AND pf.estatus_contable_idestatus_contable=2
			AND pf.usuarios_idusuarios='" . $this->idusuarios . "'
			GROUP BY fp.forma_pago;";

            return $this->ejecutar();

        }

        public function total_pago_panes()
        {

            $this->que_dba = "SELECT SUM(mon_pag_fac) AS monto
			FROM pago_factura pf
			WHERE pf.estatus_contable_idestatus_contable=2
			AND pf.usuarios_idusuarios= '" . $_SESSION["idusuarios"] . "' ;";

            return $this->ejecutar();
        }

        public function total_pago_efectivo()
        {

            $this->que_dba = "SELECT COUNT(*) AS total, SUM(mon_pag_fac) AS monto
			FROM pago_factura pf
			WHERE forma_pago_idforma_pago = 1
			AND pf.estatus_contable_idestatus_contable=2
			AND pf.usuarios_idusuarios= '" . $_SESSION["idusuarios"] . "' ;";

            return $this->ejecutar();
        }

        public function total_pago_efectivo_id()
        {

            $this->que_dba = "SELECT COUNT(*) AS total, SUM(mon_pag_fac) AS monto
			FROM pago_factura pf
			WHERE forma_pago_idforma_pago = 1
			AND pf.estatus_contable_idestatus_contable=2
			AND pf.usuarios_idusuarios= '" . $this->idusuarios . "';";

            return $this->ejecutar();
        }

        /* FACTURA PARA EL RECIBO DE PAGO*/
        public function factura_recibo()
        {

            $this->que_dba = "SELECT *
		FROM  factura fa, detalle_factura df, planes pl, pago_factura pf
		WHERE fa.cod_fac=df.factura_cod_fac
		AND df.planes_idplanes=pl.idplanes
		AND pf.factura_cod_fac=fa.cod_fac
		AND fa.contratos_idcontratos='" . $this->contrato . "'
		AND fa.cod_fac='" . $this->cod_fac . "';";

            return $this->ejecutar();

        }

        /* SUSPENDE USUARIOS CON FACTURAS VENCIDAS */
        public function suspender_api()
        {

            $this->que_dba = "SELECT * FROM clientes cl, contratos c, detalles_contratos dc, ips ip, factura f, fecha_corte fc, server s
		WHERE cl.idclientes=c.clientes_idclientes
		AND c.server_idserver = s.idserver
		AND c.estatus_idestatus=1
		AND c.idcontratos=f.contratos_idcontratos
		AND c.fecha_corte_idfecha_corte=fc.idfecha_corte
		AND c.idcontratos=dc.contratos_idcontratos
		AND dc.ips_idips=ip.idips
		AND f.estatus_contable_idestatus_contable=9
		AND f.mes_fac=MONTH(CURRENT_DATE())
		AND fc.idfecha_corte='" . $this->fecha_corte . "'
		GROUP BY c.idcontratos;";

            return $this->ejecutar();

        }

        public function facturaVenta()
        {

            $this->que_dba = "SELECT * FROM factura_venta
		WHERE mon_ded_fac_ven > 0
		AND contratos_idcontratos ='" . $this->contrato . "';";

            return $this->ejecutar();

        }

        public function detalleFacturaVenta()
        {

            $this->que_dba = "SELECT * FROM factura_venta fv, detalle_factura_venta df, inventario i
WHERE df.inventario_cod_inv = i.cod_inv
AND fv.cod_fac_ven = df.factura_venta_cod_fac_ven
AND df.factura_venta_cod_fac_ven =  '" . $this->cod_fac_ven . "';";

            return $this->ejecutar();

        }

        public function facturaVentaPaga()
        {

            $this->que_dba = "SELECT * FROM factura_venta, usuarios
		WHERE mon_ded_fac_ven = 0
		AND usuarios.idusuarios= factura_venta.usuarios_idusuarios
		AND contratos_idcontratos ='" . $this->contrato . "';";

            return $this->ejecutar();
        }

        public function detalleFacturaPaga()
        {

            $this->que_dba = "SELECT * FROM factura_venta fv, detalle_factura_venta df, inventario i
WHERE df.inventario_cod_inv = i.cod_inv
AND fv.cod_fac_ven = df.factura_venta_cod_fac_ven
AND fv.mon_ded_fac_ven = 0
AND fv.contratos_idcontratos = '" . $this->contrato . "'
AND df.factura_venta_cod_fac_ven =  '" . $this->cod_fac_ven . "';";

            return $this->ejecutar();
        }

        public function calcularTotalVen()
        {

            $this->que_dba = "SELECT SUM(mon_fac_ven) AS total  FROM factura_venta, usuarios
		WHERE usuarios.idusuarios= '1'
		AND usuarios.idusuarios= factura_venta.usuarios_idusuarios
		AND estatus_contable_idestatus_contable =  '9';";

            return $this->ejecutar();
        }

        public function facturaVentaPagaPublic()
        {

            $this->que_dba = "SELECT * FROM factura_venta, usuarios
		WHERE usuarios.idusuarios= '" . $_SESSION['idusuarios'] . "'
		AND usuarios.idusuarios= factura_venta.usuarios_idusuarios
		AND estatus_contable_idestatus_contable = '9'
		AND ISNULL(contratos_idcontratos)";

            return $this->ejecutar();
        }

        public function detalleFacturaPagaPublic()
        {

            $this->que_dba = "SELECT * FROM factura_venta fv, detalle_factura_venta df, inventario i
WHERE df.inventario_cod_inv = i.cod_inv
AND fv.cod_fac_ven = df.factura_venta_cod_fac_ven
AND fv.usuarios_idusuarios= '" . $_SESSION['idusuarios'] . "'
AND df.factura_venta_cod_fac_ven =  '" . $this->cod_fac_ven . "';";

            return $this->ejecutar();
        }
        public function detalleFacVen()
        {

            $this->que_dba = "SELECT * FROM factura_venta fv, detalle_factura_venta df, inventario i
WHERE df.inventario_cod_inv = i.cod_inv
AND fv.cod_fac_ven = df.factura_venta_cod_fac_ven
AND df.factura_venta_cod_fac_ven =  '" . $this->cod_fac_ven . "';";

            return $this->ejecutar();
        }

        /* SUSPENDE USUARIOS CON FACTURAS VENCIDAS */
        public function modificar_factura()
        {

            $proc = explode("-", $this->plan);
            $idplan = $proc["0"];
            $precio = $proc["1"];
            $des = $proc["2"];

            $query_fac = $this->que_dba = "UPDATE detalle_factura
		SET planes_idplanes='" . $idplan . "',
		des_det_fac='" . $des . "',
		mon_det_fac='" . $precio . "'
		WHERE cod_det_fac='" . $this->cod_det_fac . "';";
            $this->ejecutar();

            if ($query_fac) {
                $this->que_dba = "UPDATE factura
			SET mon_fac='" . $this->total_factura . "', mon_ded_fac='" . $this->total_factura . "'
			WHERE cod_fac='" . $this->cod_fac . "';";

                return $this->ejecutar();
            }

        }

        /* CONSULTA ULTIMA FACTURA */
        public function consultar_ultima_factura()
        {
            $ano_fac = date("Y");
            $this->que_dba = "SELECT *
			FROM contratos c,
				detalles_contratos dc,
				factura f,
				detalle_factura df,
				planes p
			WHERE
			c.idcontratos=dc.contratos_idcontratos
			AND dc.planes_idplanes=p.idplanes
			AND c.idcontratos=f.contratos_idcontratos
			AND f.cod_fac=df.factura_cod_fac
			AND f.ano_fac='" . $ano_fac . "'
			AND c.idcontratos='" . $this->contrato . "'
			ORDER BY f.mes_fac DESC";
            return $this->ejecutar();

        }

        /*-----------------------------------------------------------------------------------*/
        /*     CREAR FACTURA DE CLIENTE PERSONAL */

        public function insertar()
        {

            $planes = explode("-", $this->plan);
            $idplanes = $planes["0"];
            $nom_plan = $planes["1"];
            $monto_factura = $planes["2"];

            /* CREA LA FACTURA */
            $fecha_c = date("Y-m-d H:m:s");
            $dia = date("d") + 3;
            $fecha_v = date("Y-m-" . $dia);
            $ano_fac = date("Y");

            $date = date("Y-m-d-H");
            $date_now = date('d-m-Y');
            $date_future = strtotime('+3 day', strtotime($date_now));
            $date_future = date('Y-m-d', $date_future);

            $this->que_dba = "INSERT INTO factura
			(contratos_idcontratos,
			estatus_contable_idestatus_contable,
			fecha_corte_idfecha_corte,
			fec_cre_fac,
			fec_ven_fac,
			mes_fac,
			ano_fac,
			mon_fac,
			mon_ded_fac,
			usuarios_idusuarios)
			VALUES ('" . $this->contrato . "',
			'9',
			'" . $this->fecha_corte . "',
			'" . $fecha_c . "',
			'" . $date_future . "',
			'" . $this->mes_fac . "',
			'" . $ano_fac . "',
			'" . $monto_factura . "',
			'" . $monto_factura . "',
			'" . $_SESSION['idusuarios'] . "'); ";

            $insert_factura = $this->ejecutar();

            if ($this->cod_pag_not != "") {

                $this->que_dba = "UPDATE notificar_pagos
				SET factura_cod_fac=(SELECT cod_fac FROM factura WHERE contratos_idcontratos='" . $this->contrato . "' ORDER BY cod_fac DESC LIMIT 1 )
				WHERE cod_pag_not='" . $this->cod_pag_not . "';";
                $this->ejecutar();
            }

            if ($insert_factura) {

                $detalle_f = $this->que_dba = "INSERT INTO detalle_factura (factura_cod_fac, planes_idplanes,des_det_fac,mon_det_fac)
			SELECT
			cod_fac,
			'" . $idplanes . "',
			'" . $nom_plan . "',
			mon_fac
			FROM factura f, contratos c, detalles_contratos dc
		 WHERE
		 f.contratos_idcontratos=c.idcontratos
		 AND c.idcontratos=dc.contratos_idcontratos
		 AND f.estatus_contable_idestatus_contable = '9'
		 AND f.mes_fac='" . $this->mes_fac . "'
		 AND f.ano_fac='" . $ano_fac . "'
		 AND f.contratos_idcontratos='" . $this->contrato . "' ORDER BY cod_fac DESC;";

                return $this->ejecutar();

            }

        }

    } /// FIN DE CLASE

} else {
    header("location: ../../../index.php");
}
