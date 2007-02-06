<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   examen_parcial_pasar_notas.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   05-03-04.
*            Ultima Modificacion:   25-03-04.
*           Campos que lee en BD:   ninguna
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   Inicializa el template con los alumnos de la comisión 
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

// verifico que esté seleccionada una comisión
if (!isset($vf_id_comision)){
	$vl_mensaje="ERROR:Problemas con la comisión, consulte al administrador del MaTeRo";
	header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
}
else{
	set_file("pagina","examen_parcial_pasar_notas.html");
	// me fijo si no està seteada la variable para ordenar el listado
	if (!isset($ordenar)) {
		$ordenar="apellido";
		$ord="asc";
		set_var("orde","desc");
	}
	else{
		if ($ord=="asc") $ord="desc";
		else $ord="asc";
		set_var("orde","$ord");
	}

	// busco los datos del exámen parcial y la comision
	$vl_consulta_examen=mysql_query("SELECT comision.nombre as nombre_comision,
											examen_parcial.nombre as nombre_examen,
											examen_parcial.fecha as fecha_examen
										FROM comision, examen_parcial_comision, examen_parcial									
										WHERE comision.id_comision='$vf_id_comision' 
										AND	comision.id_comision=examen_parcial_comision.id_comision 
										AND	examen_parcial.id_examen_parcial='$vf_id_examen_parcial'
										AND	examen_parcial.id_examen_parcial=examen_parcial_comision.id_examen_parcial");
	
	//busco los alumnos que pertenecen a la comision seleccionada
	$vl_consulta_alumnos=mysql_query("SELECT alumno.lib_univ, alumno.nombre, alumno.apellido
									  FROM alumno, alumno_comision
									  WHERE alumno.lib_univ=alumno_comision.id_alumno 
									  		and alumno_comision.id_comision=$vf_id_comision
										ORDER BY $ordenar $ord");
	$vl_fila_examen=mysql_fetch_array($vl_consulta_examen);
	set_var("nombre_comision",$vl_fila_examen[nombre_comision]);
	set_var("nombre_examen",$vl_fila_examen[nombre_examen]);
	if (mysql_num_rows($vl_consulta_alumnos)){
		$vl_consulta_examen=mysql_query("SELECT * FROM examen_parcial_notas WHERE id_examen_parcial=$vf_id_examen_parcial");
		while($vf_fila_alumnos=mysql_fetch_array($vl_consulta_alumnos)){
			set_var("lu",$vf_fila_alumnos[lib_univ]);
			set_var("nombre",$vf_fila_alumnos[nombre]);
			set_var("apellido",$vf_fila_alumnos[apellido]);
			if (mysql_num_rows($vl_consulta_examen)){
				mysql_data_seek($vl_consulta_examen,0);
				$vl_estaa=0;
				// para el caso en que no existan notas en la tabla para este exàmen y comision
				while(($vl_estaa==0)&&($vf_fila=mysql_fetch_array($vl_consulta_examen))){
					if ($vf_fila[id_alumno]==$vf_fila_alumnos[lib_univ]) $vl_estaa=1;
				}// while
				if ($vl_estaa){
					set_var("nota","$vf_fila[nota]");
					set_var("comentario","$vf_fila[comentario]");
				}	
				else{
					set_var("nota","");
					set_var("comentario","");
					mysql_query("INSERT INTO examen_parcial_notas (id_examen_parcial_notas,
																id_examen_parcial,
																id_alumno,
																nota,
																comentario) 
										VALUES ('NULL',
												$vf_id_examen_parcial,
												$vf_fila_alumnos[lib_univ],
												'',
												'')");
				}
			} // if
			else{
					 mysql_query("INSERT INTO examen_parcial_notas (id_examen_parcial_notas,
																id_examen_parcial,
																id_alumno,
																nota,
																comentario) 
										VALUES ('NULL',
												$vf_id_examen_parcial,
												$vf_fila_alumnos[lib_univ],
												'',
												'')");
					set_var("nota","");
					set_var("comentario","");
			} // else		
			parse("bloque_listado","bloque_listado",true);
		} //while
	}
	else{
		$vl_mensaje="ERROR: No existen alumnos en la comisión seleccionada";
		header("Location:examen_parcial_administrar.php?vf_id_comision=$vf_id_comision&PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
	}
	set_var("id_examen_parcial",$vf_id_examen_parcial);
	set_var("id_comision",$vf_id_comision);	
	set_var("sesion",$PHPSESSID);
	set_var("firma",firma());
	set_var("mensaje","");
	pparse("pagina");
}
die();
?>