<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   catedra_hacer_seleccionar.php
*                          Autor:   A.U.S. Sánchez, Guido S.
*                 Fecha Creacion:   01-11-03.
*            Ultima Modificacion:   01-11-03.
*           Campos que lee en BD:   tabla catedras
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   agrega a la sesion las variables que me interesan
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

//Se busca la instancia del objeto de LOGUEO
require_once '../includes/Log/Log.php';
$conf = array('mode' => 0600, 'timeFormat' => '%X %x');
$logger = &Log::singleton('file', 'user.log', 'ident', $conf);

$id_usuario = $_SESSION[usuario_logueado];
$usuario=mysql_query("select *
           from usuario
           where id_usuario = $id_usuario");
$usuario=mysql_fetch_array($usuario);
		   
$catedra=mysql_query("select *
           from catedra
           where id_catedra = $idc");
$catedra=mysql_fetch_array($catedra);		  

// compruevo que la càtedra pertenesca al usuario registrado
$vl_consulta=mysql_query("Select *
                          from usuario_catedra
                          where id_usuario=$id_usuario
                          and id_catedra=$idc");
						  
if(!mysql_num_rows($vl_consulta)){die("No le pertenece la cátedra a la que intenta acceder, HEY!!!");}
else {
      // agrego a la sesion el id de cátedra
	  $_SESSION['vs_id_catedra'] = $idc;

	  // me fijo si tiene alguna comisión cargada
	  $vl_consulta2=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra");
	  if (!mysql_num_rows($vl_consulta2)){ 
	  		$vl_mensaje="<br><b>Atención!!</b>";
			$vl_mensaje.= "su primera tarea como administrador del sitio de la cátedra<br>";
			$vl_mensaje.="debe ser crear y activar una comisión";
      };
}
$data=$usuario['nombre']." ".$usuario['apellido']." ".strtoupper($catedra['nombre']);
$logger->log($data);

header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
?>