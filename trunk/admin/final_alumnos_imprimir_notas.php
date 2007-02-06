<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_alumnos_imprimir.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-02-04.
*            Ultima Modificacion:   27-02-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el listado de alumnos para imprimir
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

// verifico que esté seleccionada una comisión
	set_file("pagina","final_alumnos_imprimir_notas.html");
	$vl_consulta_alumnos=mysql_query("SELECT *, examen_final.nombre as nombre_final, alumno.nombre as nombre_alumno , examen_final_notas.nota, examen_final_notas.comentario as descri
											FROM examen_final_notas,examen_final,alumno WHERE examen_final_notas.id_examen_final=$idf
																					and examen_final_notas.id_examen_final=examen_final.id_examen_final
																					and examen_final_notas.id_alumno=alumno.lib_univ
																				ORDER BY nombre_alumno");
	if (mysql_num_rows($vl_consulta_alumnos)){
		while($vl_fila_alumno=mysql_fetch_array($vl_consulta_alumnos)){
			set_var("nombre_comision","$vl_fila_alumno[nombre_final]");
			set_var("lu","$vl_fila_alumno[lib_univ]");
			set_var("nombre","$vl_fila_alumno[nombre_alumno]");
			set_var("apellido","$vl_fila_alumno[apellido]");
			set_var("nota","$vl_fila_alumno[nota]");
			set_var("descri","$vl_fila_alumno[descri]");			
			parse("bloque_listado","bloque_listado",true);
		}
		set_var("mensaje","$mensaje");
		set_var("firma",firma());
		pparse("pagina");
	}
	else{
        die("ERROR: No existen alumnos en el examen seleccionado seleccionada");
	}

?>