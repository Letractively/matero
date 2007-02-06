<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   alumnos_ver_datos.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
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
set_file("pagina","alumnos_ver_datos.html");
//Valido los datos
if (!$vf_id_comision){
	$vl_mensaje.="ERROR: Debes seleccionar una comisión<br>";
    $vl_error=1;
}

//Valido el nombre
if (!is_numeric($vf_lu))
   {$vl_mensaje.="ERROR: Se ha ingresado una L.U. incorrecta<br>";
   $vl_error=1;
}
else{
	$vl_consulta_alumno_comision=mysql_query("SELECT * FROM alumno_comision WHERE id_comision=$vf_id_comision and id_alumno=$vf_lu");
	if (mysql_num_rows($vl_consulta_alumno_comision)){
		$vl_mensaje.="ERROR: El alumno con L.U. $vf_lu ya fue dado de alta en la comisión<br>";
	    $vl_error=1;
	}
}

//Valido el email
if (!is_email($vf_email) && ($vf_email!=""))
   {$vl_mensaje.="ERROR: Se ha ingresado un email incorrecto<br>";
   $vl_error=1;
}

if($vl_error==1){
	set_file("pagina","alumnos_alta.html");
	$vl_consulta=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'");
	$vl_num_comisiones=mysql_num_rows($vl_consulta);
	while($vl_fila_comision=mysql_fetch_array($vl_consulta)){
		set_var("nombre_comision","$vl_fila_comision[nombre]");
		if ($vf_id_comision==$vl_fila_comision[id_comision]) set_var("selected_comision","selected");
		else set_var("selected_comision","");
		set_var("id_comision","$vl_fila_comision[id_comision]");
		parse("datos_comisiones","datos_comisiones",true);
	}
	set_var("mensaje","$vl_mensaje");
	set_var("lu","$vf_lu");
	set_var("email","$vf_email");
	set_var("firma",firma());
	parse("datos","datos",true);
	pparse("pagina");
}


// busco los datos de la comision
$vl_consulta_comision=mysql_query("SELECT * FROM comision WHERE id_comision=$vf_id_comision ");
if (mysql_num_rows($vl_consulta_comision)){
	$vl_fila_comision=mysql_fetch_array($vl_consulta_comision);
	$vl_consulta_datos_alumnos=mysql_query("SELECT *, carrera.nombre as nombre_carrera, alumno.nombre as nombre_alumno FROM alumno,carrera WHERE alumno.id_carrera=carrera.id_carrera and lib_univ=$vf_lu");
	if (mysql_num_rows($vl_consulta_datos_alumnos)){
		$vl_fila_alumno=mysql_fetch_array($vl_consulta_datos_alumnos);
		// si el alumno es de otra carrera le advierto
		$vl_consulta_catedra=mysql_query("SELECT * FROM catedra_carrera WHERE id_catedra='$vs_id_catedra' and id_carrera='$vl_fila_alumno[id_carrera]'");
		if (!mysql_num_rows($vl_consulta_catedra)){
			$vl_mensaje="Advertencia: Estás por dar de alta un alumno que pertenece a otra carrera";
		}
		set_var("nombre_comision","$vl_fila_comision[nombre]");
		set_var("lu","$vf_lu");
		set_var("dni","$vl_fila_alumno[dni]");
		set_var("apellido","$vl_fila_alumno[apellido]");
		set_var("nombre","$vl_fila_alumno[nombre_alumno]");
		set_var("email","$vf_email");
		set_var("id_comision","$vf_id_comision");
		set_var("carrera","$vl_fila_alumno[nombre_carrera]");
	}
	else {
		$vl_mensaje="No existe el alumno con el L.U.: $vf_lu";
		header("Location:alumnos_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");	
		die();
	}
		set_var("mensaje","$vl_mensaje");
		set_var("firma",firma());
		parse("datos","datos",true);
		pparse("pagina");
}
else{
die("Error con la comisión seleccionada");
} 
																	


?>