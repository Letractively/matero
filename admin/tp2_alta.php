<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-02-04.
*            Ultima Modificacion:   27-02-04.
*           Campos que lee en BD:   ninguna
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de alta de parcial
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");


set_file("pagina","tp2_alta.html");
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
set_var("nombre","");
set_var("checked_examen","checked");
set_var("descrip_tp","");
set_var("comentario_notas","");
$vl_mes=date("n");
set_var("anio",date("Y"));
set_var("selected_mes$vl_mes","selected");
set_var("dia",date("d"));
set_var("hora","");
set_var("min","");
set_var("firma",firma());
parse("datos_tp","datos_tp",true);
pparse("pagina");
die();
?>