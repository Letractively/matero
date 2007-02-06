<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   alumnos_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de alta de alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","alumnos_alta.html");

set_var("lu","");
set_var("email","");


$vl_consulta=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'");
$vl_num_comisiones=mysql_num_rows($vl_consulta);
if ($vl_num_comisiones > 1){
	while($vl_fila_comision=mysql_fetch_array($vl_consulta)){
		set_var("nombre_comision","$vl_fila_comision[nombre]");
		if ($vf_id_comision==$vl_fila_comision[id_comision]) set_var("selected_comision","selected");
		else set_var("selected_comision","");
		set_var("id_comision","$vl_fila_comision[id_comision]");
		parse("datos_comisiones","datos_comisiones",true);
	}
}
elseif ($vl_num_comisiones == '1') {
	$vl_fila_comision=mysql_fetch_array($vl_consulta);
	set_var("selected_comision","selected");
	set_var("nombre_comision","$vl_fila_comision[nombre]");
	set_var("id_comision","$vl_fila_comision[id_comision]");
	parse("datos_comisiones","datos_comisiones",true);
}
else{
	$vl_mensaje="No existen comisiones activas!!!!!";
	header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
	die();
}

set_var("mensaje","$mensaje");
//set_var("comision_nombre","$vl_fila_comision[nombre]");
set_var("lu","");
set_var("email","");
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
?>