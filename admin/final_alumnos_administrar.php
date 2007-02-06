<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_alumnos_administrar.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   03-02-04.
*            Ultima Modificacion:   03-02-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el listado de alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");


	set_file("pagina","final_alumnos_administrar.html");
	set_var("idf",$idf);
	set_var("sesion",$PHPSESSID);
	if (!isset($ordenar)) {
		$vl_consulta=mysql_query("SELECT *, examen_final.nombre as nombre_examen, alumno.nombre as nombre_alumno 
											FROM examen_final_notas,examen_final,alumno WHERE examen_final_notas.id_examen_final=$idf
																					and examen_final_notas.id_examen_final=examen_final.id_examen_final
																					and examen_final_notas.id_alumno=alumno.lib_univ");
		set_var("ord","asc");
	}
	else{
		if ($ord=="asc") $ord="desc";
		else $ord="asc";
		set_var("ord","$ord");
  	    $vl_consulta=mysql_query("SELECT *, examen_final.nombre as nombre_examen, alumno.nombre as nombre_alumno 
											FROM examen_final_notas,examen_final,alumno WHERE examen_final_notas.id_examen_final=$idf
																					and examen_final_notas.id_examen_final=examen_final.id_examen_final
																					and examen_final_notas.id_alumno=alumno.lib_univ ORDER BY $ordenar $ord");
	}
	if (mysql_num_rows($vl_consulta)){
		while($vl_fila=mysql_fetch_array($vl_consulta)){
			set_var("examen","$vl_fila[nombre_examen]");
			set_var("lu","$vl_fila[lib_univ]");
			set_var("nombre","$vl_fila[nombre_alumno]");
			set_var("apellido","$vl_fila[apellido]");
			set_var("estilo","tabla_cuerpo");
			parse("bloque_listado","bloque_listado",true);
	}

	set_var("mensaje","$mensaje");
	set_var("sesion","$PHPSESSID");
	set_var("firma",firma());
	pparse("pagina");
} // si existen alumnos
else{
			set_var("examen","");
			set_var("lu","");
			set_var("nombre","");
			set_var("apellido","");
			set_var("estilo","tabla_cuerpo");
			parse("bloque_listado","bloque_listado",true);}
	set_var("mensaje","No hay alumnos cargados");
	set_var("sesion","$PHPSESSID");
	set_var("firma",firma());
	pparse("pagina");	
?>