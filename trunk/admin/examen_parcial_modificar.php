<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_modificar.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-02-04.
*            Ultima Modificacion:   27-02-04.
*           Campos que lee en BD:   ninguna
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de modificación de parcial
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
include("../includes/fecha.php");

set_file("pagina","examen_parcial_modificar.html");
$vl_consulta=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'");

$vl_num_comisiones=mysql_num_rows($vl_consulta);
if ($vl_num_comisiones > 1){
	// muestro las comisiones 
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

////////////////////
//Verifico a cuantas comisiones pertenece el examen
$vl_comision_ep = mysql_query("SELECT *
								FROM examen_parcial_comision
								WHERE id_examen_parcial = $vf_id_examen_parcial ");
$vl_cantidad_com=0;								
while ($vl_fila = mysql_fetch_array($vl_comision_ep))								
	{	$vl_cantidad_com += 1;
		set_var("selected$vl_fila[id_comision]","selected");	
	}
if ($vl_cantidad_com > 1) $mensaje="Este exámen parcial pertenece a más de una comisión, cualquier cambio que efectúe <br>
											afectará a las demás comisiones seleccionadas";
////////////////////////////////////








$vl_consulta = mysql_query("SELECT *
							FROM examen_parcial EP
							WHERE EP.id_examen_parcial = $vf_id_examen_parcial
							");
if (!mysql_num_rows($vl_consulta)){$vl_mensaje="No se encontró el PARCIAL seleccionado";
									header("Location:examen_parcial_administrar.php?vf_id_comision=$vf_id_comision");
									die;}							
else {
//Si esta todo bien
	if(!isset($vf_mensaje)) $elMensaje=$mensaje;
	else $elMensaje=$vf_mensaje;
	$vl_fila=mysql_fetch_array($vl_consulta);
	set_var("mensaje",$vf_mensaje);
	set_var("id_comision_actual",$vf_id_comision);
	set_var("id_examen_parcial",$vf_id_examen_parcial);
	set_var("nombre_examen",$vl_fila[nombre]);
	if ($vl_fila[publicar]==1) set_var("checked_examen","checked");
	else set_var("checked_examen","");
	set_var("descrip_examen",$vl_fila[descrip]);
	set_var("comentario_notas",$vl_fila[comentario_notas]);
	

		set_var("anio",obtener_anio($vl_fila[fecha]));
		$vl_mes=obtener_mes($vl_fila[fecha]);
		if ($vl_mes[0]==0) set_var("selected_mes$vl_mes[1]","selected");
		else set_var("selected_mes$vl_mes","selected");
		set_var("dia",obtener_dia($vl_fila[fecha]));
		$f=$vl_fila[hora];
		set_var("hora",$f[0].$f[1]);
		set_var("min",$f[3].$f[4]);

	set_var("vf_id_tp",$vf_id_tp);						
	set_var("firma",firma());
	parse("datos_examen_parcial","datos_examen_parcial",true);
	pparse("pagina");

}







die();
?>