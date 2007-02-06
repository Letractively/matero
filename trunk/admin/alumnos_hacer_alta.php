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

if (mysql_query("INSERT INTO alumno_comision(
							id_alumno,
							id_catedra,
							id_comision,
							email)
							values(
							'$vf_libreta_universitaria',
							'$vs_id_catedra',
							'$vf_id_comision',
							'$vf_email_alumno'
							)")){
	$vl_mensaje="Se ingresó un alumno exitosamente ";																	
	}
else{
	$vl_mensaje="Problemas en el alta del alumno, comuníquese con el administrador del MaTero";
}							

header("Location:alumnos_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&vf_id_comision=$vf_id_comision");
?>