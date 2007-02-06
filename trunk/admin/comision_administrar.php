<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_administrar.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   05-11-03.
*            Ultima Modificacion:   05-11-03.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el listado de comisiones
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","comision_administrar.html");

if (!isset($ordenar)) {
	$vl_consulta_comision=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra");
	set_var("ord","asc");
}

else{
	if ($ord=="asc") $ord="desc";
	else $ord="asc";
	set_var("ord","$ord");
	$vl_consulta_comision=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra ORDER BY $ordenar $ord");
}
if (mysql_num_rows($vl_consulta_comision)){
while($vl_fila_comision=mysql_fetch_array($vl_consulta_comision)){
	set_var("nombre","$vl_fila_comision[nombre]");
	set_var("fecha_alta","$vl_fila_comision[fecha_alta]");
	set_var("id_comision","$vl_fila_comision[id_comision]");
	set_var("nombre_check_activa","vf_activa_"."$vl_fila_comision[id_comision]");
	set_var("nombre_check_publicar","vf_publicar_"."$vl_fila_comision[id_comision]");	
	if ($vl_fila_comision[publicar]=='1') set_var("checked_publicar","checked");
	else set_var("checked_publicar","");
	if ($vl_fila_comision[activa]=='1') set_var("checked_activa","checked");
	else set_var("checked_activa","");
	parse("bloque_listado","bloque_listado",true);
}

set_var("mensaje","$mensaje");
set_var("firma",firma());
pparse("pagina");
} // si existen comisiones
else{
        $vl_mensaje_error="ERROR: No existen comisiones cargadas";
        header("Location:menu.php?mensaje=$vl_mensaje_error&PHPSESSID=$PHPSESSID");
}
?>