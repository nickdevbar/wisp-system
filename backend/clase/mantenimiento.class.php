<?php
 if(!session_id())
session_start();

if (isset($_SESSION['cod_usu'])){

require_once("utilidad.class.php");

class mantenimiento extends utilidad {

  
	
	public $idmantenimientos;
	public $fallas_idfallas;
	public $observacion;
	public $fecha_creacion;
	public $contratos_idcontratos;
	public $usuarios_idusuarios;
	public $estatus_idestatus;

	public $fecha;

	//*Nuevas*//

	public function crearMan(){
			$this->que_dba="INSERT INTO mantenimientos 
			(obs_man,
			fec_man,
			estatus_cod_est,
			usuarios_cod_usu,
			fallas_cod_fallas,
			contratos_cod_contratos,
			company_cod_company)
			VALUES (
			'".$this->obs_man."',
			Now(),
			'3', 
			'".$_SESSION['cod_usu']."',
			'".$this->cod_fallas."',
			'".$this->cod_contratos."',
			'".$_SESSION['cod_usu']."'); ";
		return $this->ejecutar();
	}

	public function pendientes(){
		
			$this->que_dba= "SELECT * FROM mantenimientos m, contratos c, clientes cl, fallas f 
WHERE m.company_cod_company = '" . $_SESSION['cod_usu'] . "'
AND m.estatus_cod_est = 3
AND c.cod_contratos = m.contratos_cod_contratos
AND cl.cod_cli = c.clientes_cod_cli
AND f.cod_fallas = m.fallas_cod_fallas";

		return $this->ejecutar();

	}

	public function realizados(){
		
			$this->que_dba= "SELECT * FROM mantenimientos m, contratos c, clientes cl, fallas f, act_mantenimientos am, usuarios u  
WHERE m.company_cod_company = '" . $_SESSION['cod_usu'] . "'
AND m.estatus_cod_est = 4
AND c.cod_contratos = m.contratos_cod_contratos
AND cl.cod_cli = c.clientes_cod_cli
AND f.cod_fallas = m.fallas_cod_fallas
AND am.mantenimientos_cod_man = m.cod_man
AND am.usuarios_cod_usu = u.cod_usu";

		return $this->ejecutar();

	}

	public function realizadosPorFecha(){
		
		$this->que_dba= "SELECT * FROM mantenimientos m, contratos c, clientes cl, fallas f, act_mantenimientos am, usuarios u  
		WHERE m.company_cod_company = '1'
		AND m.estatus_cod_est = 4
		AND c.cod_contratos = m.contratos_cod_contratos
		AND cl.cod_cli = c.clientes_cod_cli
		AND f.cod_fallas = m.fallas_cod_fallas
		AND am.mantenimientos_cod_man = m.cod_man
		AND am.usuarios_cod_usu = u.cod_usu 
		AND m.fec_man LIKE '%".$this->fecha."%' ;";

	return $this->ejecutar();

}

	public function fallas(){
		
		$this->que_dba= "SELECT * FROM fallas";

	return $this->ejecutar();
	}

	public function consultarMan(){

		$this->que_dba="SELECT *
		FROM contratos c, clientes cl, mantenimientos m, detalles_contratos dc, fallas f,ips ip, planes p, company co
		WHERE cl.cod_cli = c.clientes_cod_cli
		AND c.cod_contratos = dc.contratos_cod_contratos	
		AND dc.ips_cod_ip = ip.cod_ip
		AND c.cod_contratos = m.contratos_cod_contratos
		AND m.fallas_cod_fallas = f.cod_fallas
		AND dc.planes_cod_plan = p.cod_plan
		AND m.estatus_cod_est = '3'
		AND co.cod_company = c.company_cod_company
		AND m.cod_man ='".$this->cod_man."';";

		return $this->ejecutar();
		}

		public function consultarManR(){

			$this->que_dba="SELECT *
			FROM contratos c, clientes cl, mantenimientos m, act_mantenimientos am, detalles_contratos dc, fallas f,ips ip, planes p, company co
			WHERE cl.cod_cli = c.clientes_cod_cli
			AND c.cod_contratos = dc.contratos_cod_contratos	
			AND dc.ips_cod_ip = ip.cod_ip
			AND c.cod_contratos = m.contratos_cod_contratos
			AND m.fallas_cod_fallas = f.cod_fallas
			AND dc.planes_cod_plan = p.cod_plan
			AND m.estatus_cod_est = '4'
			AND co.cod_company = c.company_cod_company
			AND am.mantenimientos_cod_man = m.cod_man
			AND m.cod_man = '".$this->cod_man."';";
	
			return $this->ejecutar();
			}

		public function actualizarMan(){
   
		   $act=$this->que_dba="INSERT INTO  act_mantenimientos
			   (sol_act_man,
			   obs_act_man,
			   img_act_man,
			   fec_act_man,
			   usuarios_cod_usu,
			   mantenimientos_cod_man) 
			   VALUES(
			   '".$this->sol_act_man."',
			   '".$this->obs_act_man."',
			   '".$this->img_act_man."',
			   Now(),
			   '".$this->usuarios_cod_usu."',
			   '".$this->mantenimientos_cod_man."'
				);";
		   $this->ejecutar();
	   
	   if ($act==true){
		   $this->que_dba="UPDATE mantenimientos 
		   SET  estatus_cod_est = '4'  
		   WHERE cod_man = '".$this->mantenimientos_cod_man."'; ";
		   return $this->ejecutar();
		   
	   }// ACTUaliza estatus de mantenimiento
	   
   }

   public function listarUsu(){

	$this->que_dba="SELECT * FROM usuarios WHERE company_cod_company = '".$_SESSION['company']."' ;";

		return $this->ejecutar();

	}




	//---------------------------//




		public function insertar(){
		$fecha=date("Y-m-d H:m:s");
		
			$this->que_dba="INSERT INTO mantenimientos 
			(fallas_idfallas,
			observacion,
			fecha_creacion,
			contratos_idcontratos,
			usuarios_idusuarios,
			estatus_idestatus)
			VALUES ('".$this->falla."',
			'".$this->observacion."',
			'".$fecha."', 
			'".$this->contrato."',
			'".$_SESSION['idusuarios']."',
			'3'); ";

		return $this->ejecutar();

	}

	public function listar(){

$this->que_dba="SELECT contratos.*,mantenimientos.*,mantenimientos.fecha_creacion AS fecha_agendado, act_mantenimientos.*,act_mantenimientos.fecha_act AS fecha_realizado, fallas.*, usuarios.*
  FROM contratos,mantenimientos,act_mantenimientos, fallas, usuarios
  WHERE  contratos.idcontratos=mantenimientos.contratos_idcontratos
  AND mantenimientos.idmantenimientos=act_mantenimientos.mantenimientos_idmantenimientos
  AND mantenimientos.fallas_idfallas=fallas.idfallas
  AND act_mantenimientos.tecnico=usuarios.idusuarios
  AND contratos.idcontratos='".$this->contrato."'; ";

		return $this->ejecutar();

	}

		public function listar_mantenimiento()
		{

			$this->que_dba = "SELECT *
			FROM contratos c ,mantenimientos m, fallas f, usuarios u, clientes cl, estatus e
			WHERE c.cod_contratos = m.contratos_cod_contratos
			AND m.fallas_cod_fallas = f.cod_fallas
			AND m.usuarios_cod_usu = u.cod_usu
			AND cl.cod_cli = c.clientes_cod_cli
			AND m.estatus_cod_est = e.cod_est
			AND m.estatus_cod_est = '3'
			AND c.cod_contratos ='".$this->cod_contratos."'; ";

			return $this->ejecutar();
		}

		public function listar_mantenimiento_realizado()
		{

			$this->que_dba = "SELECT *
			FROM contratos c ,mantenimientos m, fallas f, usuarios u, clientes cl, estatus e, act_mantenimientos am
			WHERE c.cod_contratos = m.contratos_cod_contratos
			AND m.cod_man = am.mantenimientos_cod_man
			AND m.fallas_cod_fallas = f.cod_fallas
			AND m.usuarios_cod_usu = u.cod_usu
			AND cl.cod_cli = c.clientes_cod_cli
			AND m.estatus_cod_est = e.cod_est
			AND m.cod_man = '" . $this->cod_man . "'; ";

			return $this->ejecutar();
		}

	public function filtrar(){

		$this->que_dba="SELECT contratos.*,mantenimientos.*,act_mantenimientos.*, fallas.*, usuarios.*
  FROM contratos,mantenimientos,act_mantenimientos, fallas, usuarios
  WHERE  contratos.idcontratos=mantenimientos.contratos_idcontratos
  AND mantenimientos.idmantenimientos=act_mantenimientos.mantenimientos_idmantenimientos
  AND mantenimientos.fallas_idfallas=fallas.idfallas
  AND act_mantenimientos.tecnico=usuarios.idusuarios
  AND contratos.idcontratos='".$_GET["idc"]."';";
		return $this->ejecutar();
	}

	

		public function consultar_mant_r()
		{

			$this->que_dba = "SELECT contratos.*,clientes.*, detalles_contratos.*, datos_habitacion.*, mantenimientos.*, mantenimientos.fecha_creacion AS fech_man, fallas.*,ips.*, planes.*, act_mantenimientos.*
			FROM contratos, clientes, mantenimientos, detalles_contratos, datos_habitacion, fallas,ips, planes, act_mantenimientos
			WHERE clientes.idclientes=datos_habitacion.clientes_idclientes
			AND contratos.idcontratos=detalles_contratos.contratos_idcontratos
			AND detalles_contratos.ips_idips=ips.idips
			AND contratos.idcontratos=mantenimientos.contratos_idcontratos
			AND mantenimientos.fallas_idfallas=fallas.idfallas
			AND detalles_contratos.planes_idplanes=planes.idplanes
			AND contratos.clientes_idclientes = clientes.idclientes
			AND act_mantenimientos.mantenimientos_idmantenimientos = mantenimientos.idmantenimientos
			AND mantenimientos.estatus_idestatus='4'
			AND mantenimientos.idmantenimientos='" . $this->idm . "';";

			return $this->ejecutar();
		}

	public function l_mantenimientos(){

		$this->que_dba="SELECT clientes.*, datos_habitacion.*, estudios.*, contratos.*, detalles_contratos.*,ips.*, planes.*, mantenimientos.*,mantenimientos.observacion AS observacion_man, mantenimientos.fecha_creacion AS fecha_man, fallas.*
		FROM clientes,datos_habitacion, estudios, contratos,detalles_contratos,ips,planes, mantenimientos,fallas
		WHERE clientes.idclientes=datos_habitacion.clientes_idclientes
		AND datos_habitacion.iddatos_habitacion=estudios.datos_habitacion_iddatos_habitacion
		AND estudios.idestudios=contratos.estudios_idestudios
		AND contratos.idcontratos=detalles_contratos.contratos_idcontratos
		AND detalles_contratos.planes_idplanes=planes.idplanes
		AND detalles_contratos.ips_idips=ips.idips
		AND mantenimientos.contratos_idcontratos=contratos.idcontratos
		AND mantenimientos.estatus_idestatus='3'
		AND mantenimientos.fallas_idfallas=fallas.idfallas
		AND  contratos.estatus_idestatus = '1';";
		return $this->ejecutar();
	}

		public function contar_mantenimientos()
		{

			$this->que_dba = "SELECT COUNT(*) AS total
		FROM clientes,datos_habitacion, estudios, contratos,detalles_contratos,ips,planes, mantenimientos,fallas
		WHERE clientes.idclientes=datos_habitacion.clientes_idclientes
		AND datos_habitacion.iddatos_habitacion=estudios.datos_habitacion_iddatos_habitacion
		AND estudios.idestudios=contratos.estudios_idestudios
		AND contratos.idcontratos=detalles_contratos.contratos_idcontratos
		AND detalles_contratos.planes_idplanes=planes.idplanes
		AND detalles_contratos.ips_idips=ips.idips
		AND mantenimientos.contratos_idcontratos=contratos.idcontratos
		AND mantenimientos.estatus_idestatus='3'
		AND mantenimientos.fallas_idfallas=fallas.idfallas
		AND  contratos.estatus_idestatus = '1';";
			return $this->ejecutar();
		}

		public function l_mantenimientos_r()
		{

			$this->que_dba = "SELECT clientes.*, datos_habitacion.*, estudios.*, contratos.*, detalles_contratos.*,ips.*, planes.*, mantenimientos.*,mantenimientos.observacion AS observacion_man, mantenimientos.fecha_creacion AS fecha_man, fallas.*, act_mantenimientos.*
		FROM clientes,datos_habitacion, estudios, contratos,detalles_contratos,ips,planes, mantenimientos,fallas, act_mantenimientos
		WHERE clientes.idclientes=datos_habitacion.clientes_idclientes
		AND datos_habitacion.iddatos_habitacion=estudios.datos_habitacion_iddatos_habitacion
		AND estudios.idestudios=contratos.estudios_idestudios
		AND contratos.idcontratos=detalles_contratos.contratos_idcontratos
		AND detalles_contratos.planes_idplanes=planes.idplanes
		AND detalles_contratos.ips_idips=ips.idips
		AND mantenimientos.contratos_idcontratos=contratos.idcontratos
		AND mantenimientos.estatus_idestatus='4'
		AND mantenimientos.fallas_idfallas=fallas.idfallas
		AND act_mantenimientos.mantenimientos_idmantenimientos = mantenimientos.idmantenimientos
		AND  contratos.estatus_idestatus = '1';";
			return $this->ejecutar();
		}

		public function listarSemanal()
		{

			$this->que_dba = "SELECT clientes.*, datos_habitacion.*, estudios.*, contratos.*, detalles_contratos.*,ips.*, planes.*, mantenimientos.*,mantenimientos.observacion AS observacion_man, mantenimientos.fecha_creacion AS fecha_man, fallas.*, act_mantenimientos.*
		FROM clientes,datos_habitacion, estudios, contratos,detalles_contratos,ips,planes, mantenimientos,fallas,act_mantenimientos
		WHERE clientes.idclientes=datos_habitacion.clientes_idclientes
		AND datos_habitacion.iddatos_habitacion=estudios.datos_habitacion_iddatos_habitacion
		AND estudios.idestudios=contratos.estudios_idestudios
		AND contratos.idcontratos=detalles_contratos.contratos_idcontratos
		AND detalles_contratos.planes_idplanes=planes.idplanes
		AND detalles_contratos.ips_idips=ips.idips
		AND mantenimientos.contratos_idcontratos=contratos.idcontratos
		AND mantenimientos.estatus_idestatus='4'
		AND mantenimientos.fallas_idfallas=fallas.idfallas
		AND act_mantenimientos.mantenimientos_idmantenimientos = mantenimientos.idmantenimientos
		AND  contratos.estatus_idestatus = '1'
		AND act_mantenimientos.fecha_act BETWEEN '".$this->primera."' AND '".$this->segunda."';";
			return $this->ejecutar();
		}

public function consultar_pendiente(){

	$this->que_dba="SELECT * 
		FROM mantenimientos
		WHERE
		 estatus_idestatus='3'
		AND contratos_idcontratos='".$this->contrato."';";

		return $this->ejecutar();

	}
public function listarUsuario(){

	$this->que_dba="SELECT * 
		FROM act_mantenimientos am, usuarios u
		WHERE u.idusuarios = am.usuarios_idusuarios 
		AND am.usuarios_idusuarios='".$this->idusuarios."';";

		return $this->ejecutar();

	}
		public function consultar_ultimo_mante_r()
		{

			$this->que_dba = "SELECT * FROM mantenimientos mant, act_mantenimientos act_mant
WHERE mant.idmantenimientos=act_mant.mantenimientos_idmantenimientos
AND mant.contratos_idcontratos= '" . $this->contrato . "'
ORDER BY act_mant.fecha_act ASC LIMIT 1";

			return $this->ejecutar();
		}
		public function consultar_ultimo_mante_()
		{

			$this->que_dba = "SELECT * FROM mantenimientos mant, act_mantenimientos act_mant
WHERE mant.contratos_idcontratos= '" . $this->contrato . "'
ORDER BY act_mant.fecha_act ASC LIMIT 1";

			return $this->ejecutar();
		}
	public function consultar_mante(){

		$this->que_dba="SELECT * 
			FROM mantenimientos
			WHERE
			 estatus_idestatus='3'
			AND contratos_idcontratos='".$this->contrato."';";
	
			return $this->ejecutar();
	
		}
	
	public function consultar_mantenimiento_cli(){
		
		$this->que_dba="SELECT clientes.*, contratos.*,mantenimientos.* 
		      FROM clientes, contratos,mantenimientos 
		      WHERE mantenimientos.idmantenimientos='".$this->idm."' 
		      AND clientes.idclientes=contratos.clientes_idclientes 
		      AND contratos.idcontratos=mantenimientos.contratos_idcontratos 
		      AND mantenimientos.estatus_idestatus='3';";
         	 return $this->ejecutar();
          }
      
      
    public function act_mantenimiento(){
   
     		$fecha=date("Y-m-d H:m:s");
    		$carpetaDestino="../../../frontend/img/mantenimientos/";
 
     		$archivo= $this->archivo;
		$tamano = $_FILES["archivo"]['size'];
		$tipo = $_FILES["archivo"]['type'];
		$archivo =$_FILES["archivo"]['name'];

		if ($archivo !="") {
		echo "entro";
		echo $destino = $carpetaDestino.$archivo;
		 copy($img=$_FILES['archivo']['tmp_name'],$destino);
		 $img="../img/mantenimientos/".$archivo;
		
		}/// 
		
	
		    $act=$this->que_dba="INSERT INTO  act_mantenimientos
				(tecnico,
				solucion,
				observaciones,
				img,
				mantenimientos_idmantenimientos,
				usuarios_idusuarios,
				fecha_act) 
				VALUES('".$this->tecnico."',
				'".$this->solucion."',
				'".$this->observacion."',
				'".$img."',
				'".$this->idm."',
				'".$this->tecnico."',
				Now());  ";
			$this->ejecutar();
		
		if ($act==true){
			$this->que_dba="UPDATE mantenimientos SET  estatus_idestatus = '4'  
			WHERE idmantenimientos = '".$this->idm."'; ";
			return $this->ejecutar();
			
		}// ACTUaliza estatus de mantenimiento
		
    }
    
		
} /// FIN DE CLASE
	

}else {
	header("location: ../../../index.php");
}
?>
