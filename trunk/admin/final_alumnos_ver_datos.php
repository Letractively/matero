<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_alumnos_ver_datos.php
*                          Autor:   A.U.S. Sánchez, Guido S. , Angeletti, Mariano R.
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:   ninguna
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   muestra los datos del alumno y verifica que ya no esté dado de alta.
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_error=0;
set_file("pagina","final_alumnos_ver_datos.html");
set_var("idf",$idf);
//Valido los datos

//Valido la nùmero de libreta universitaria
/*if (!is_alphanumeric($vf_comision,2,200))
   {
   $vl_mensaje_error.="ERROR: Se ha ingresado un nombre de comisión incorrecto<br>";
   $vl_error=1;
   }

if($vl_error==1){
	set_file("pagina","comision_alta.html");
	set_var("nombre",$vf_nombre);
	set_var("mensaje",$vl_mensaje_error);
	set_var("fecha_alta",date("d-m-Y"));
	set_var("firma",firma());
	parse("datos","datos",true);
	pparse("pagina");
	die();
}
*/

if ($vf_lu==""){
   $vl_mensaje.="ERROR: Ingrese L.U.<br>";
   $vl_error=1;
}

$vl_consulta_alumno=mysql_query("SELECT * FROM examen_final_notas WHERE id_examen_final=$idf and id_alumno=$vf_lu");
if (mysql_num_rows($vl_consulta_alumno)){
	$vl_mensaje.="ERROR: El alumno con L.U. $vf_lu ya fue dado de alta en la comision<br>";
    $vl_error=1;
}

if($vl_error==1){
	header("Location:final_alumnos_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&idf=$idf");	
	die();
}


// busco los datos del examen
$vl_consulta=mysql_query("SELECT * FROM examen_final WHERE id_examen_final = '$idf'");
if (mysql_num_rows($vl_consulta)){
	$vl_fila_comision=mysql_fetch_array($vl_consulta);
	$vl_consulta_datos_alumnos=mysql_query("SELECT *, carrera.nombre as nombre_carrera, alumno.nombre as nombre_alumno FROM alumno,carrera WHERE alumno.id_carrera=carrera.id_carrera and lib_univ=$vf_lu");
	if (mysql_num_rows($vl_consulta_datos_alumnos)){
		$vl_fila_alumno=mysql_fetch_array($vl_consulta_datos_alumnos);
		// si el alumno es de otra carrera le advierto
		$vl_consulta_catedra=mysql_query("SELECT * FROM catedra_carrera WHERE id_catedra='$vs_id_catedra' and id_carrera='$vl_fila_alumno[id_carrera]'");
		if (!mysql_num_rows($vl_consulta_catedra)){
			$vl_mensaje="Advertencia: Estás por dar de alta un alumno que pertenece a otra carrera";
		}
		// validar que el alumno no exista ya en la comision
		set_var("examen","$vl_fila_comision[nombre]");
		set_var("lu","$vf_lu");
		set_var("dni","$vl_fila_alumno[dni]");
		set_var("apellido","$vl_fila_alumno[apellido]");
		set_var("nombre","$vl_fila_alumno[nombre_alumno]");
		set_var("email","$vf_email");
		set_var("carrera","$vl_fila_alumno[nombre_carrera]");
	}
	else {
		$vl_mensaje="No existe el alumno con el L.U.: $vf_lu";
		header("Location:final_alumnos_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&idf=$idf");	
		die();
	}
		set_var("mensaje","$vl_mensaje");
		set_var("firma",firma());
		parse("datos","datos",true);
		pparse("pagina");
}
else{
die("Error con el exámen seleccionado");
} 
																	


?>