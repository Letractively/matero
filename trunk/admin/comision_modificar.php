<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_modificar.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   08-11-03.
*            Ultima Modificacion:   08-11-03.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de modificaciòn de comisiones
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","comision_modificar.html");

$vl_consulta_comision=mysql_query("SELECT * FROM comision WHERE id_comision=$idc");

if (!mysql_num_rows($vl_consulta_comision)){
	//Mensaje error
	$texto="No existe la comisión que pretende modificar";
	header("Location:comision_administrar.php?PHPSESSID=$PHPSESSID&mensaje=$texto");
} 
$vl_fila_comision=mysql_fetch_array($vl_consulta_comision);
set_var("nombre","$vl_fila_comision[nombre]");
set_var("fecha_alta","$vl_fila_comision[fecha_alta]");
set_var("id_comision","$vl_fila_comision[id_comision]");
set_var("mensaje","$vf_mensaje");
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
die();
?>