<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   alumnos_imprimir.php
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
if (isset($vf_id_comision)){
	set_file("pagina","alumnos_imprimir.html");
	$vl_consulta_alumnos=mysql_query("SELECT *, comision.nombre as nombre_comision, alumno.nombre as nombre_alumno 
											FROM alumno_comision,comision,alumno WHERE alumno_comision.id_comision=$vf_id_comision
																					and alumno_comision.id_comision=comision.id_comision
																					and alumno_comision.id_alumno=alumno.lib_univ
																				ORDER BY apellido");
	if (mysql_num_rows($vl_consulta_alumnos)){
		while($vl_fila_alumno=mysql_fetch_array($vl_consulta_alumnos)){
			set_var("nombre_comision","$vl_fila_alumno[nombre_comision]");
			set_var("lu","$vl_fila_alumno[lib_univ]");
			set_var("nombre","$vl_fila_alumno[nombre_alumno]");
			set_var("apellido","$vl_fila_alumno[apellido]");
			set_var("email","$vl_fila_alumno[email]");
			parse("bloque_listado","bloque_listado",true);
		}
		set_var("mensaje","$mensaje");
		set_var("firma",firma());
		pparse("pagina");
	}
	else{
        die("<div align=\"center\"> <b>ERROR: No existen alumnos en la comision seleccionada</b> </div>");
	}
} // si esta seteada vf_id_comision
else{
	die("Debes seleccionar una comisión");
}
?>