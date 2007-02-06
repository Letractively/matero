<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   alumnos_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de alta de alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","final_alumnos_alta.html");
set_var("idf",$idf);
$vl_consulta=mysql_query("SELECT * FROM examen_final WHERE id_examen_final = '$idf'");

	if (mysql_num_rows($vl_consulta)){
		$vl_fila=mysql_fetch_array($vl_consulta);
		set_var("mensaje","$mensaje");
		set_var("examen","$vl_fila[nombre]");
		set_var("lu","");
		set_var("firma",firma());
		parse("datos","datos",true);
		pparse("pagina");
	}
	else{
		$vl_mensaje="No existe el final al que intenta acceder, comuníquese con el administrador";
		header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
		die();
	} 
	
?>