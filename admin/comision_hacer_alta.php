<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_hacer_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   01-11-03.
*            Ultima Modificacion:   01-11-03.
*           Campos que lee en BD:   tabla comision
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el alta de la comision
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");


$vl_error=0;
//Valido los datos

//Valido el nombre de la comision
if (!is_alphanumeric($vf_comision,2,200))
   {
   $vl_mensaje_error.="ERROR: Se ha ingresado un nombre de comisión incorrecto<br>";
   $vl_error=1;
   }

if($vl_error==1){
	set_file("pagina","comision_alta.html");
	set_var("nombre",$vf_nombre);
	set_var("mensaje",$vl_mensaje_error);
	set_var("fecha_alta",date("d-m-Y"));
	set_var("firma",firma());
	parse("datos","datos",true);
	pparse("pagina");
	die();
}

$vl_fecha_hoy=date("Y-m-d");
if (mysql_query("INSERT INTO comision(
							id_comision,
							id_catedra,
							nombre,
							fecha_alta,
							publicar,
							activa)
							values(
							'NULL',
							'$vs_id_catedra',
							'$vf_comision',
							'$vl_fecha_hoy',
							'1',
							'1')")){
	$vl_mensaje="Se ingresó una cátedra exitosamente ";																	
	}
else{
	$vl_mensaje="Problemas en el alta de comisión, comuníquese con el administrador del MaTero";
}							

header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
?>