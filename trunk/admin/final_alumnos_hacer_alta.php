<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   alumnos_hacer_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:   tabla alumnos_comision
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el alta del alumno en la comision
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

if (mysql_query("INSERT INTO examen_final_notas(
							id_examen_final_notas,
							id_alumno,
							id_examen_final
							)
							values(
							'NULL',
							'$vf_libreta_universitaria',
							'$idf'
							)")){
	$vl_mensaje="Se ingresó un alumno exitosamente ";																	
	}
else{
	$vl_mensaje="Problemas en el alta del alumno, comuníquese con el administrador del MaTero";
}							

header("Location:final_alumnos_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&idf=$idf");
?>