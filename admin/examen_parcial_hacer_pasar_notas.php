<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   examen_parcial_hacer_pasar_notas.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   05-03-04.
*            Ultima Modificacion:   06-03-04
*           Campos que lee en BD:   examen_parcial, alumno
*      Campos que Modifica en BD:   examen_parcial_notas
*  Descripcion de funcionamiento:   Actualiza las notas de los alumnos 
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
	//busco los alumnos que tienen asociado el parcial
	$vl_consulta=mysql_query("SELECT *
								FROM examen_parcial_notas 
								WHERE examen_parcial_notas.id_examen_parcial=$vf_id_examen_parcial");
	if (mysql_num_rows($vl_consulta)){
		while($vl_fila=mysql_fetch_array($vl_consulta)){
			$vl_nota="vf_nota"."$vl_fila[id_alumno]";$vl_nota=$$vl_nota;
			$vl_comentario="vf_comentario"."$vl_fila[id_alumno]";$vl_comentario=$$vl_comentario;
			if (isset($vl_nota)){
				mysql_query("UPDATE examen_parcial_notas SET nota='$vl_nota', comentario='$vl_comentario'
								WHERE id_alumno=$vl_fila[id_alumno] 
										and examen_parcial_notas.id_examen_parcial=$vf_id_examen_parcial");
			}
		}
	}
	else{
		$vl_mensaje="ERROR: No existen alumnos para el parcial seleccionado";
		header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
	}
		$vl_mensaje="Fueron actualizadas exitosamente las notas de los alumnos";
		header("Location:examen_parcial_administrar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
}
die();
?>