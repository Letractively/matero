<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_pasar_notas.php
*                          Autor:   A.U.S. Sánchez, Guido S. , Angeletti, Mariano
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
if (!isset($idf)){
	$vl_mensaje="ERROR:Debes seleccionar un exámen";
	header("Location:final_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
}
else{
	// me fijo si no està seteada la variable para ordenar el listado
	if (!isset($ordenar)) {
	//busco los alumnos que pertenecen a la comision seleccionada
		$vl_consulta_alumnos=mysql_query("SELECT alumno.lib_univ, alumno.nombre, alumno.apellido
									  FROM alumno, examen_final_notas 
									  WHERE alumno.lib_univ=examen_final_notas.id_alumno 
									  		and examen_final_notas.id_examen_final=$idf");
		$ord="asc";
	}
	else{
		if ($ord=="asc") $ord="desc";
		else $ord="asc";

		$vl_consulta_alumnos=mysql_query("SELECT alumno.lib_univ, alumno.nombre, alumno.apellido
									  FROM alumno, examen_final_notas
									  WHERE alumno.lib_univ=examen_final_notas.id_alumno 
									  		and examen_final_notas.id_examen_final=$idf											
										ORDER BY $ordenar $ord");
	}
	
	if (mysql_num_rows($vl_consulta_alumnos)){
		set_file("pagina","final_pasar_notas.html");
		set_var("ord",$ord);
		set_var("nombre_examen",$vf_fila_alumnos[nombre_examen]);
		$vl_consulta_examen=mysql_query("SELECT * FROM examen_final_notas WHERE id_examen_final=$idf");
		while($vf_fila_alumnos=mysql_fetch_array($vl_consulta_alumnos)){
			set_var("lu",$vf_fila_alumnos[lib_univ]);
			set_var("nombre",$vf_fila_alumnos[nombre]);
			set_var("apellido",$vf_fila_alumnos[apellido]);
			if (mysql_num_rows($vl_consulta_examen)){
				mysql_data_seek($vl_consulta_examen,0);
				$vl_estaa=0;
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
					mysql_query("INSERT INTO examen_final_notas (id_examen_final_notas,
																id_examen_final,
																id_alumno,
																nota,
																comentario) 
										VALUES ('NULL',
												$idf,
												$vf_fila_alumnos[lib_univ],
												'',
												'')");
				}
			} // if
			else{
					 mysql_query("INSERT INTO examen_final_notas (id_examen_final_notas,
																id_examen_final,
																id_alumno,
																nota,
																comentario) 
										VALUES ('NULL',
												$idf,
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
		$vl_mensaje="ERROR: No existen alumnos en el exámen seleccionado";
		header("Location:final_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
	}
	set_var("idf",$idf);
	set_var("firma",firma());
	set_var("mensaje",$mensaje);
	set_var("sesion",$PHPSESSID);
	pparse("pagina");
}
die();
?>