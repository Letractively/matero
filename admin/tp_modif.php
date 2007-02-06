<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   tp_modif.php
*                          Autor:   Angeletti, Mariano R.
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
include("../includes/fecha.php");

set_file("pagina","tp_modif.html");
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

////////////////////
$vl_comision_tp = mysql_query("SELECT *
								FROM tp_comision
								WHERE id_tp = $vf_id_tp ");
$vl_cantidad_com=0;								
while ($vl_fila = mysql_fetch_array($vl_comision_tp))								
	{	$vl_cantidad_com += 1;
		set_var("selected$vl_fila[id_comision]","selected");	
	}
if ($vl_cantidad_com > 1) $mensaje="Este TP pertenece a más de una comisión, cualquier cambio que efectúe <br>
											afectará a las demás comisiones seleccionadas";
/////////////////////


$vl_consulta = mysql_query("SELECT *
							FROM trabajo_practico as TP
							WHERE TP.id_tp = $vf_id_tp
							");
if (!mysql_num_rows($vl_consulta)){$vl_mensaje="No se encontró el TP seleccionado";
									header("Location:tp_administrar.php?vf_id_comision=$vf_id_comision");
									die;}							
else {
	$vl_fila=mysql_fetch_array($vl_consulta);
	set_var("mensaje","$mensaje$mensaje2");
	set_var("id_comision_actual",$vf_id_comision);
	set_var("nombre",$vl_fila[nombre]);
	if ($vl_fila[publicar]==1) set_var("checked_tp","checked");
	else set_var("checked_tp","");
	set_var("descrip_tp",$vl_fila[descrip]);
	set_var("comentario_notas",$vl_fila[comentario_notas]);
	if (convertir_fecha($vl_fila['fecha_entrega'])!="00-00-0000" ) {
		set_var("anio",obtener_anio($vl_fila[fecha_entrega]));
		$vl_mes=obtener_mes($vl_fila[fecha_entrega]);
		if ($vl_mes[0]==0) set_var("selected_mes$vl_mes[1]","selected");
		else set_var("selected_mes$vl_mes","selected");
		set_var("dia",obtener_dia($vl_fila[fecha_entrega]));
		$f=$vl_fila[hora];
		set_var("hora",$f[0].$f[1]);
		set_var("min",$f[3].$f[4]);
	}
	else{
		set_var("checked_sin_fecha","checked");
		set_var("anio","");
		set_var("dia","");
		set_var("hora","");
		set_var("min","");
	}
	if ($vl_fila[archivo]!=""){
	      set_var("archivo",$vl_fila[archivo]);
		  set_var("comenta",'&nbsp; <input name="vf_eliminar" type="checkbox" id="vf_eliminar" value="1">&nbsp; Si desea eliminar el archivo, habilite el check box');
	}
	else {
	  set_var("archivo","");
	  set_var("comenta","");
	}
	set_var("vf_id_tp",$vf_id_tp);
	set_var("PHPSESSID",$PHPSESSID);						
	set_var("firma",firma());
	parse("datos_tp","datos_tp",true);
	pparse("pagina");

}
									
?>