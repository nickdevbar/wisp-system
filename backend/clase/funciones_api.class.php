<?php
if (!session_id()) {
    session_start();
}

if (isset($_SESSION['cod_usu'])) {

    require_once "api/api_mt.php";
    require_once "plan.class.php";

    class funciones_api extends routeros_api
    {
/*------conexion----------*/
        public $ip_router_api;
        public $login_api;
        public $password_api;
        public $port_api;
        public $interfaz_api;
        public $blacklist_api;
/*----------------*/

        public $ip_contrato;
        public $API;
        public $nombres;
        public $contrato;
        public $cliente;
        public $idplanes;

        public $old_ip;
        public $new_ip;

        public function asignar_valor_api()
        {

            foreach ($_REQUEST as $atributo => $valor) {

                $this->$atributo = $valor;
            }
        }
        /*
        public function __construct()
        {
        $this->connect();
        }
         */
        public function showInfo()
        {

            $this->write("/system/resource/print", true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);
         $first = $ARRAY['0'];
         $memperc = $first['free-memory'] / $first['total-memory'];
         $hddperc = $first['free-hdd-space'] / $first['total-hdd-space'];
         $mem = $memperc * 100;
         $hdd = $hddperc * 100;
         echo "<table border=0 align=center>";
         echo "<tr><td>Platform, board name and Ros version is:</td><td>" . $first['platform'] . " - " . $first['board-name'] . " - " . $first['version'] . " - " . $first['architecture-name'] . "</td></tr>";
         echo "<tr><td>Cpu and available cores:</td><td>" . $first['cpu'] . " at " . $first['cpu-frequency'] . " Mhz with " . $first['cpu-count'] . " core(s) " . "</td></tr>";
         echo "<tr><td>Uptime is:</td><td>" . $first['uptime'] . " (hh/mm/ss)" . "</td></tr>";
         echo "<tr><td>Cpu Load is:</td><td>" . $first['cpu-load'] . " %" . "</td></tr>";
         echo "<tr><td>Total,free memory and memory % is:</td><td>" . $first['total-memory'] . "Kb - " . $first['free-memory'] . "Kb - " . number_format($mem, 3) . "% </td></tr>";
         echo "<tr><td>Total,free disk and disk % is:</td><td>" . $first['total-hdd-space'] . "Kb - " . $first['free-hdd-space'] . "Kb - " . number_format($hdd, 3) . "% </td></tr>";
         echo "<tr><td>Sectors (write,since reboot,bad blocks):</td><td>" . $first['write-sect-total'] . " - " . $first['write-sect-since-reboot'] . " - " . $first['bad-blocks'] . "% </td></tr>";
         echo "</table>";
        }
        //-----------------------------Interfaces-------------------------//
        public function ls_interfaces()
        {

            $this->write("/interface/getall", true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);
            //echo $ARRAY[0]['name'];
            $i = 0;
            $list = count($ARRAY);
            while ($i <= $list) {
                echo "<option value='" . $ARRAY[$i]['name'] . "'>" . $ARRAY[$i]['name']. " // " . $ARRAY[$i]['type'] . "</option>";
                $i++;
            }
            return;
        }
//-----------------------WHITELIST ACTUALIZACION--------------------------//
        public function query_whitelist()
        {

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $this->ip_contrato, false);
            $this->write('?list=' . $this->whitelist_api, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);
            if (count($ARRAY) > 0) {
                echo "<h6 style='color: #1cc88a;'><strong>USUARIO ACTIVO NAVEGANDO.</strong></h6>";
                //echo "<h6 style='color:#e74a3b;'><strong>USUARIO SUSPENDIDO, FALTA DE PAGO.</strong></h6>";
            } else {
                echo "<h6 style='color:#e74a3b;'><strong>USUARIO SUSPENDIDO, FALTA DE PAGO.</strong></h6>";
                //echo "<h6 style='color: #1cc88a;'><strong>USUARIO ACTIVO NAVEGANDO.</strong></h6>";
            }
            return;
        }

        public function remove_whitelist()
        {

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $this->ip_contrato, false);
            $this->write('?list=' . $this->whitelist_api, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo count($ARRAY);
            for ($i = 0; $i < count($ARRAY); $i++) {
                if ($ARRAY[$i]['address'] == $this->ip_contrato && $ARRAY[$i]['list'] == $this->whitelist_api) {
                    $this->write("/ip/firewall/address-list/remove", false);
                    $this->write("=.id=" . $ARRAY[$i]['.id'], true);
                    $READ = $this->read(false);
                    $ARRAY = $this->parseResponse($READ);

                    echo "entro";
                }
            }
        }

        public function crearReglasObl()
        {
            /// VARIABLES DE FORMULARIO
            echo "conecto";
            $this->write("/ip/firewall/filter/getall", true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ); // busco si ya existe
            //echo count($ARRAY);

            // si no existe lo creo

            $this->write("/ip/firewall/filter/add", false);
            $this->write('=action=accept', false); // comentario
            $this->write('=chain=input', false); // comentario
            $this->write('=dst-port=' . $this->port_api, false); // comentario
            $this->write('=protocol=tcp', true); // comentario
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            $this->write("/ip/firewall/filter/add", false);
            $this->write('=action=accept', false); // comentario
            $this->write('=chain=forward', false); // comentario
            $this->write('=comment=Reglas WISPLITE - Activos', false); // comentario
            $this->write('=dst-address-list=' . $this->whitelist_api, true); // comentario
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            $this->write("/ip/firewall/filter/add", false);
            $this->write('=action=drop', false); // comentario
            $this->write('=chain=forward', false); // comentario
            $this->write('=comment=Reglas WISPLITE - Inactivos', false); // comentario
            $this->write('=src-address-list=!' . $this->whitelist_api, true); // comentario
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo "Entraron";
            //   $API->disconnect();

        }

        public function export_whitelist()
        {
            /// VARIABLES DE FORMULARIO

            $cliente = $this->cliente;
            $ip = $this->ip;
            $list = $this->list;

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $ip, false);
            $this->write('?list=' . $list, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ); // busco si ya existe

            //echo count($ARRAY);
            if (count($ARRAY) > 0) {
                echo "Ya estan activos";
            } else {
                // si no existe lo creo
                $this->write("/ip/firewall/address-list/add", false);
                $this->write('=address=' . $ip, false); // IP
                $this->write('=list=' . $list, false); // lista
                $this->write('=comment=' . $cliente, true); // comentario
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
            } //   $API->disconnect();

        }

        public function ip_whitelist()
        {
            ///// CAMBIO IP ARP
            if ($this->connect()) {
                echo "conecto";
                $ip_contrato = $this->old_ip;
                $nueva = $this->new_ip;
                $wl = $this->whitelist;

                $this->write("/ip/firewall/address-list/getall", false);
                $this->write('?address=' . $ip_contrato, false);
                $this->write('?list=' . $wl, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ); // busco si ya existe

                //echo count($ARRAY);
                print_r($ARRAY);
                if (count($ARRAY) > 0) {
                    $this->write("/ip/firewall/address-list/set", false);
                    $this->write("=.id=" . $ARRAY[0]['.id'], false);
                    $this->write('=address=' . $nueva, true);

                    $READ = $this->read(false);
                    $ARRAY = $this->parseResponse($READ);
                } else {
                    // si no existe lo creo
                    echo "No existe";
                }
            }
        }

        public function add_whitelist()
        {
            /// VARIABLES DE FORMULARIO
            $cliente = "Contrato N " . $this->contrato . " " . $this->nombres;

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $this->ip_contrato, false);
            $this->write('?list=' . $this->whitelist_api, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ); // busco si ya existe

            //echo count($ARRAY);
            if (count($ARRAY) > 0) {

            } else {

                // si no existe lo creo
                $this->write("/ip/firewall/address-list/add", false);
                $this->write('=address=' . $this->ip_contrato, false); // IP
                $this->write('=list=' . $this->whitelist_api, false); // lista
                $this->write('=comment=' . $cliente, true); // comentario
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);

            } //   $API->disconnect();

        }

        //------------------Cambiar MAC antena---------------//
        public function arp_antena()
        {
            echo "conecto";
            $old_ip = $this->old_ip;
            $new_ip = $this->new_ip;
            $mac_ip = $this->mac_ip;
            $com = $this->com;
            $int = $this->int;

            $this->write("/ip/arp/getall", false);
            $this->write('?address=' . $old_ip, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo count($ARRAY);

            if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito

                $this->write("/ip/arp/set", false);
                $this->write("=.id=" . $ARRAY[0]['.id'], false);
                $this->write('=address=' . $new_ip, false);
                $this->write('=interface=' . $int, false);
                $this->write('=comment=' . $com, false);
                $this->write('=mac-address=' . $mac_ip, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
                echo "Se edito";

            } else { // si no existe lo agrego
                $this->write("/ip/arp/add", false);
                $this->write('=address=' . $new_ip, false); // IP
                $this->write('=interface=' . $int, false); // IP
                $this->write('=comment=' . $com, false); // IP
                $this->write('=mac-address=' . $mac_ip, true); // MAC
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
            }
        }

        public function crear_arp_antena()
        {
            echo "conecto";
            $ip = $this->ip;
            $mac_ip = $this->mac_ip;
            $com = $this->com;
            $int = $this->int;

            //$new_ip = $this->new_ip;

            $this->write("/ip/arp/getall", false);
            $this->write('?address=' . $ip, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo count($ARRAY);

            if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito
                echo "Ya existe";
            } else { // si no existe lo agrego
                $this->write("/ip/arp/add", false);
                $this->write('=address=' . $ip, false); // IP
                $this->write('=interface=' . $int, false); // IP
                $this->write('=comment=' . $com, false); // IP
                $this->write('=mac-address=' . $mac_ip, true); // MAC
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
                echo "se agrego";
            }
        }

        public function editar_arp_antena()
        {
            echo "conecto";
            $ip = $this->ip;
            $mac_ip = $this->mac;
            $com = $this->com;
            $int = $this->int;

            echo ($ip . $mac_ip . $com . $int);

            $this->write("/ip/arp/getall", false);
            $this->write('?address=' . $ip, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo count($ARRAY);

            if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito

                $this->write("/ip/arp/set", false);
                $this->write("=.id=" . $ARRAY[0]['.id'], false);
                $this->write('=address=' . $ip, false);
                $this->write('=interface=' . $int, false);
                $this->write('=comment=' . $com, false);
                $this->write('=mac-address=' . $mac_ip, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
                echo "Se edito";
            } else { // si no existe lo agrego
                $this->write("/ip/arp/add", false);
                $this->write('=address=' . $ip, false); // IP
                $this->write('=interface=' . $int, false); // IP
                $this->write('=comment=' . $com, false); // IP
                $this->write('=mac-address=' . $mac_ip, true); // MAC
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
                echo "se agrego";
            }
        }

        //-----------------Exportar---------------------------//
        public function export_queue()
        {
            /// VARIABLES DE FORMULARIO

            $cliente = $this->cliente;
            $ip = $this->ip;
            $plan1 = $this->plan;
            $plan2 = $this->plan2;
            $mask = "/32";

            $this->write("/queue/simple/getall", false);
            $this->write('?target=' . $ip . $mask, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            //echo count($ARRAY);

            if (count($ARRAY) > 0) {
                echo "Ya existen";
            } else {
                // si no existe lo creo
                $this->write("/queue/simple/add", false);
                $this->write('=name=' . $cliente, false); // Nombre
                $this->write('=target=' . $ip . $mask, false); // IP
                $this->write('=max-limit=' . $plan1 . "/" . $plan2, true); // comentario
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
                //echo "se agrego";
            }

        }

        public function export_arp()
        {
            /// VARIABLES DE FORMULARIO

            $cliente = $this->cliente;
            $ip = $this->ip;
            $mac = $this->mac;

            $this->write("/queue/simple/getall", false);
            $this->write('?address=' . $ip, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            //echo count($ARRAY);

            if (count($ARRAY) > 0) {
                echo "Ya existen";
            } else {
                // si no existe lo creo
                $this->write("/ip/arp/add", false);
                $this->write('=comment=' . $cliente, false); // Nombre
                $this->write('=address=' . $ip, false); // IP
                $this->write('=interface=LAN', false); // IP
                $this->write('=mac-address=' . $mac, true); // MAC
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
                //echo "se agrego";
            }

        }

        public function export_seg()
        {
            /// VARIABLES DE FORMULARIO

            $ip = $this->ip;
            $com = $this->com;
            $net = $this->net;
            $int = $this->int;

            $this->write("/ip/address/getall", false);
            $this->write('?address=' . $ip, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ); // busco si ya existe

            echo count($ARRAY);
            echo "conecto";

            if (count($ARRAY) > 0) {
                echo "Ya existen";
            } else {

                $this->write("/ip/address/add", false);
                $this->write('=address=' . $ip, false);
                $this->write('=network=' . $net, false);
                $this->write('=comment=' . $com, false);
                $this->write('=interface='. $int, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);

            }
        }

        public function export_blacklist()
        {
            /// VARIABLES DE FORMULARIO

            $cliente = $this->cliente;
            $ip = $this->ip;
            $list = $this->list;

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $ip, false);
            $this->write('?list=' . $list, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ); // busco si ya existe

            //echo count($ARRAY);
            if (count($ARRAY) > 0) {
                echo "Ya estan suspendidos";
            } else {
                // si no existe lo creo
                $this->write("/ip/firewall/address-list/add", false);
                $this->write('=address=' . $ip, false); // IP
                $this->write('=list=' . $list, false); // lista
                $this->write('=comment=' . $cliente, true); // comentario
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
            } //   $API->disconnect();

        }

        //----------------------Agregar SEGMENTO ADDRESS----------------------//
        public function add_segmento()
        {
            /// VARIABLES DE FORMULARIO
            $ip = $this->ip;
            $net = $this->net;
            $com = $this->com;
            $int = $this->int;

            echo $ip . $net . $com;

            $this->write("/ip/address/getall", false);
            $this->write('?address=' . $ip, true);

            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ); // busco si ya existe

            if (count($ARRAY) > 0) {
                echo "1";
            } else {
                // si no existe lo creo
                $this->write("/ip/address/add", false);
                $this->write('=address=' . $ip, false);
                $this->write('=network=' . $net, false);
                $this->write('=comment=' . $com, false);
                $this->write('=interface='. $int, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
                echo "aqui creo";
            } //   $API->disconnect();
        }

        //------------------------------Editar segmento-------------------------//

        public function edit_segmento()
        {
            /// VARIABLES DE FORMULARIO
            $ip = $this->ip;
            $com = $this->com;
            $new_ip = $this->new_ip;
            $int = $this->int;

            $this->write("/ip/address/getall", false);
            $this->write('?address=' . $ip, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ); // busco si ya existe

            if (count($ARRAY) > 0) {
                $this->write("/ip/address/set", false);
                $this->write("=.id=" . $ARRAY[0]['.id'], false);
                $this->write('=address=' . $new_ip, false);
                $this->write('=interface=' . $int, false);
                $this->write('=comment=' . $com, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);

                echo "cambio";
            } else {
                echo "1";
            } //   $API->disconnect();
        }

//-------------------Cambio de Nombre e Información---------------------//

        public function nombre()
        { /////// Cambio nombre simple
            $ip_contrato = $this->ip;
            $name = $this->nom;

            $mask = "/32";

            $this->write("/queue/simple/getall", false);
            $this->write('?target=' . $ip_contrato . $mask, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo count($ARRAY);

            if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito
                $this->write("/queue/simple/set", false);
                $this->write("=.id=" . $ARRAY[0]['.id'], false);
                $this->write('=name=' . $name, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);

                echo "cambio";
            }

        }
        public function nombre_arp()
        { /////// Cambio nombre arp
            $ip_contrato = $this->ip;
            $name = $this->nom;

            //$mask = "/32";

            $this->write("/ip/arp/getall", false);
            $this->write('?address=' . $ip_contrato, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo count($ARRAY);

            if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito
                $this->write("/ip/arp/set", false);
                $this->write("=.id=" . $ARRAY[0]['.id'], false);
                $this->write('=comment=' . $name, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);

                echo "cambio";
            }

        }

        public function nombre_suspendidos()
        { /////// Cambio nombre simple
            $ip_contrato = $this->ip;
            $name = $this->nom;
            $list = $this->blacklist;

            //$mask = "/32";

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $ip_contrato, false);
            $this->write('?list=' . $list, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo count($ARRAY);

            if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito
                $this->write("/ip/firewall/address-list/set", false);
                $this->write("=.id=" . $ARRAY[0]['.id'], false);
                $this->write('=comment=' . $name, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);

                echo "cambio";
            }

        }

//-------------------Cambio de ip---------------------//

        public function ip_arp()
        {
            ///// CAMBIO IP ARP
            if ($this->connect()) {
                echo "conecto";
                $ip_contrato = $this->old_ip;
                $nueva = $this->new_ip;

                $this->write("/ip/arp/getall", false);
                $this->write('?address=' . $ip_contrato, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);

                echo count($ARRAY);

                if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito

                    $this->write("/ip/arp/set", false);
                    $this->write("=.id=" . $ARRAY[0]['.id'], false);
                    $this->write('=address=' . $nueva, true);
                    $READ = $this->read(false);
                    $ARRAY = $this->parseResponse($READ);
                    echo "cambio";

                }
            } else {
                echo "no conecto";
            }
        }

        public function ip_queue()
        { //Funciona
            ///// CAMBIO IP SIMPLE

            if ($this->connect()) {
                echo "conecto";
                $ip_contrato = $this->old_ip;
                $nueva = $this->new_ip;

                $mask = "/32";

                $this->write("/queue/simple/getall", false);
                $this->write('?target=' . $ip_contrato . $mask, true);
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);

                echo count($ARRAY);

                if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito
                    $this->write("/queue/simple/set", false);
                    $this->write("=.id=" . $ARRAY[0]['.id'], false);
                    $this->write('=target=' . $nueva . $mask, true);
                    $READ = $this->read(false);
                    $ARRAY = $this->parseResponse($READ);

                    echo "cambio";
                }
            } else {
                echo "no conecto";
            }
        }

///////////////////////////////////////   ARP ///////////////////////////////////////////////////
        public function arp()
        {
            ///// CAMBIO MAC
            $cliente = "Contrato N " . $this->contrato . " " . $this->nombres;

            $this->write("/ip/arp/getall", false);
            $this->write('?address=' . $this->ip_contrato, false);
            $this->write('?comment=' . $cliente, true);
            $READ = $this->read(false);
            $ARRAY_arp = $this->parseResponse($READ);
            echo count($ARRAY_arp);
            if (count($ARRAY_arp) > 0) { // si el nombre de usuario "ya existe" lo edito

                $this->write("/ip/arp/set", false);
                $this->write("=.id=" . $ARRAY_arp[0]['.id'], false);
                $this->write('=mac-address=' . $this->mac, true); //   2M/2M   [TX/RX]
                $READ = $this->read(false);
                $ARRAY_arp = $this->parseResponse($READ);

            } else {

                $this->comm('/ip/arp/add', array(
                    "address" => $this->ip_contrato,
                    "interface" => 'LAN',
                    "mac-address" => $this->mac,
                    "comment" => $cliente));

            }
        }

        public function print_arp()
        {
            $ARRAY2 = $this->comm("/ip/arp/print", array("?address" => $this->ip_contrato));

            foreach ($ARRAY2 as $row) {
                echo $row['mac-address'];
            }
            return;
        }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        public function print_queue()
        {
            $mask = "/32";
            $ARRAY2 = $this->comm("/queue/simple/getall", array("?target" => $this->ip_contrato . $mask));

            foreach ($ARRAY2 as $row) {

                $vel = $row["max-limit"];
                $target_ip = $row["target"];
                $plan_server = explode("/", $vel);
                $vel_ser_su = round($plan_server["1"] / 1024);
                $vel_ser_des = round($plan_server["0"] / 1024);
                echo $target_ip;
                /* echo "<strong>Vel. Descarga ".round($vel_ser_su/1024)."  Megas</strong>";
            echo "<strong><br>Vel. Subida ".round($vel_ser_des/1024)." Megas</strong>"; */

            }

        }
//////////////////////////////////////// BLACKILIST  //////////////////////////////////////////////////////////////////////

        public function add_blacklist()
        {
            /// VARIABLES DE FORMULARIO
            $cliente = "Contrato N " . $this->contrato . " " . $this->nombres;

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $this->ip_contrato, false);
            $this->write('?list=' . $this->blacklist_api, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ); // busco si ya existe

            //echo count($ARRAY);
            if (count($ARRAY) > 0) {
                //echo "Ya esta suspendido";
            } else {

                // si no existe lo creo
                $this->write("/ip/firewall/address-list/add", false);
                $this->write('=address=' . $this->ip_contrato, false); // IP
                $this->write('=list=' . $this->blacklist_api, false); // lista
                $this->write('=comment=' . $cliente, true); // comentario
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
                //echo "Suspendidos exitosamente";

            } //   $API->disconnect();

        }

        public function query_blacklist()
        {

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $this->ip_contrato, false);
            $this->write('?list=' . $this->whitelist_api, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);
            if (count($ARRAY) > 0) {

                echo "<h6 style='color:#e74a3b;'><strong>USUARIO SUSPENDIDO, FALTA DE PAGO.</strong></h6>";
            } else {
                echo "<h6 style='color: #1cc88a;'><strong>USUARIO ACTIVO NAVEGANDO.</strong></h6>";
            }
            return;
        }

        public function remove_blacklist()
        {

            $this->write("/ip/firewall/address-list/getall", false);
            $this->write('?address=' . $this->ip_contrato, false);
            $this->write('?list=' . $this->blacklist_api, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            echo count($ARRAY);
            for ($i = 0; $i < count($ARRAY); $i++) {
                if ($ARRAY[$i]['address'] == $this->ip_contrato && $ARRAY[$i]['list'] == $this->blacklist_api) {
                    $this->write("/ip/firewall/address-list/remove", false);
                    $this->write("=.id=" . $ARRAY[$i]['.id'], true);
                    $READ = $this->read(false);
                    $ARRAY = $this->parseResponse($READ);

                    echo "entro";
                }
            }

        }

///////////////////////////////////// QUEUE SIMPLE //////////////////////////////////////////////////

        public function queue()
        {

            $cliente = "Contrato N " . $this->contrato . " " . $this->nombres;

            $obj_plan = new plan;
            $obj_plan->cod_plan = $this->planes;
            $obj_plan->asignar_valor();
            $obj_plan->puntero = $obj_plan->lisPlan();
            $arre_plan = $obj_plan->extraer_dato();

            echo $maxlimit = $arre_plan["vel_sub_plan"] . $arre_plan["tx"] . "/" . $arre_plan["vel_des_plan"] . $arre_plan["rx"];
            //exit();
            $mask = "/32";
            $this->write("/queue/simple/getall", false);
            $this->write('?target=' . $this->ip_contrato . $mask, true);
            $READ = $this->read(false);
            $ARRAY = $this->parseResponse($READ);

            if (count($ARRAY) > 0) { // si el nombre de usuario "ya existe" lo edito
                $this->write("/queue/simple/set", false);
                $this->write("=.id=" . $ARRAY[0]['.id'], false);
                $this->write('=max-limit=' . $maxlimit, true); //   2M/2M   [TX/RX]
                $READ = $this->read(false);
                $ARRAY = $this->parseResponse($READ);
            } else {
                $add_queue = $this->comm("/queue/simple/add", array(
                    'target' => $this->ip_contrato,
                    "name" => $cliente,
                    'max-limit' => $maxlimit));
            }

            /*
        $result=$this->comm("/queue/simple/getall",array(
        'target='=>$this->ip_contrato));
        foreach ($result as $row ) {
        echo $row["name"];
        exit();
        # code...
        }
        $this->write("/queue/simple/getall",false);
        $this->write('?target='.$this->ip_contrato,true);
        $READ = $this->read(false);
        $ARRAY = $this->parse_response($READ);

        if(count($ARRAY)>0){ // si el nombre de usuario "ya existe" lo edito
        echo "INGRESO";
        exit();
        $this->write("/queue/simple/set",false);
        $this->write("=.id=".$ARRAY[0]['.id'],false);
        $this->write('=max-limit='.$maxlimit,true);   //   2M/2M   [TX/RX]
        $READ = $this->read(false);
        $ARRAY = $this->parse_response($READ);
        }else {

        $this->comm("/queue/simple/add",array(
        'target'=>$this->ip_contrato,
        "name" => $this->cliente,
        'max-limit'=>$maxlimit));
        exit();
        }*/
        }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    } /// FIN CLASE

} else {
    header("location: ../../index.php");
    exit();
}
