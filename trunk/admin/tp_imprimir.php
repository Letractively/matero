<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   examen_parcial_pimprimir.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-03-04.
*            Ultima Modificacion:   27-03-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   
*  Descripcion de funcionamiento:   Muestra el listado de alumnos y notas con formato para impresión
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

// verifico que esté seleccionada una comisión
if (isset($vs_id_comision)){
	
	// variables para ordenar el listado de alumnos
	$ordenar="apellido";
	$ord="asc";
	//busco los datos del exámen parcial y la comision
	$vl_consulta_examen=mysql_query("SELECT comision.nombre as nombre_comision, trabajo_practico.nombre as nombre_tp,
												trabajo_practico.fecha_entrega as fecha_tp
										FROM comision, trabajo_practico, tp_comision									
										WHERE comision.id_comision=$vs_id_comision and
												comision.id_comision=tp_comision.id_comision and
												tp_comision.id_tp = trabajo_practico.id_tp and
												trabajo_practico.id_tp=$vf_id_tp");

	//busco los alumnos que pertenecen a la comision seleccionada y que 
	$vl_consulta_alumnos=mysql_query("SELECT alumno.lib_univ, alumno.nombre, alumno.apellido, alumno.lib_univ
									  FROM alumno, alumno_comision
									  WHERE alumno.lib_univ=alumno_comision.id_alumno 
									   		and alumno_comision.id_comision=$vs_id_comision
									  ORDER BY $ordenar $ord");
									  
	if (!mysql_num_rows($vl_consulta_examen)) die("No existe el TP, comuníquese con el administrador");
	set_file("pagina","tp_imprimir.html");
	$vl_fila_examen_parcial=mysql_fetch_array($vl_consulta_examen);
	set_var("nombre_tp",$vl_fila_examen_parcial[nombre_tp]);
	set_var("fecha_tp",$vl_fila_examen_parcial[fecha_tp]);		
	set_var("nombre_comision",$vl_fila_examen_parcial[nombre_comision]);		
	parse("datos_examen","datos_examen",true);
	
	if (mysql_num_rows($vl_consulta_alumnos)){
		while($vf_fila_alumnos=mysql_fetch_array($vl_consulta_alumnos)){
			set_var("lu",$vf_fila_alumnos[lib_univ]);
			set_var("nombre",$vf_fila_alumnos[nombre]);
			set_var("apellido",$vf_fila_alumnos[apellido]);
			$vl_consulta_examen=mysql_query("SELECT id_alumno,nota, comentario FROM trabajo_practico_notas WHERE id_tp=$vf_id_tp");
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
					set_var("nota","--");
					set_var("comentario","--");
				}
			} // if
			else die("No existen notas para los alumnos, comuníquese con el administrador del MaTeRo.");
			parse("bloque_listado","bloque_listado",true);
		} //while
	}
	else die("No existen alumnos para la comision, comuníquese con el administrador del MaTeRo.");
	set_var("firma",firma());
	pparse("pagina");
	die();
}
else die("No existe la comision");
?>