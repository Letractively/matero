<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   examen_final_hacer_pasar_notas.php
*                          Autor:   A.U.S. Sánchez, Guido S. , Angeletti, Mariano
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
if (!isset($idf)){
	$vl_mensaje="ERROR:Debes seleccionar un éxamen";
	header("Location:examen_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
}
else{
	//busco los alumnos que tienen asociado el parcial
	$vl_consulta=mysql_query("SELECT *
									  FROM examen_final_notas 
									  WHERE examen_final_notas.id_examen_final=$idf");
	if (mysql_num_rows($vl_consulta)){
		while($vl_fila=mysql_fetch_array($vl_consulta)){
			$vl_nota="vf_nota"."$vl_fila[id_alumno]";$vl_nota=$$vl_nota;
			$vl_comentario="vf_comentario"."$vl_fila[id_alumno]";$vl_comentario=$$vl_comentario;
			if (isset($vl_nota)){
				mysql_query("UPDATE examen_final_notas SET nota='$vl_nota', comentario='$vl_comentario'
								WHERE id_alumno=$vl_fila[id_alumno] 
										and examen_final_notas.id_examen_final=$idf");
			}
		}
	}
	else{
		$vl_mensaje="ERROR: No existen alumnos para el examen seleccionado";
		header("Location:final_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
	}
		$vl_mensaje="Fueron actualizadas exitosamente las notas de los alumnos";
		header("Location:final_pasar_notas.php?PHPSESSID=$PHPSESSID&idf=$idf&mensaje=$vl_mensaje");
}
die();
?>