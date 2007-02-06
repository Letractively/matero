<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_alumnos_hacer_administrar.php
*                          Autor:   Angeletti,Mariano, AUS Sanchez, Guido T
*                 Fecha Creacion:   21-02-04.
*            Ultima Modificacion:   21-02-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   
*  Descripcion de funcionamiento:   Elimina los alumnos seleccionados y modifica los emails
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

if (isset($vf_otro)) { header("Location:final_alumnos_alta.php?idf=$idf&PHPSESSID=$PHPSESSID"); die;   }


if (isset($vf_elim)) {
		$vl_consulta=mysql_query("SELECT * 
											FROM examen_final_notas
											WHERE id_examen_final=$idf");
		if (mysql_num_rows($vl_consulta)){ 
			$vl_alumnos_eliminados=0;
			while($vl_fila_alumno=mysql_fetch_array($vl_consulta)){
 				$vl_elininar_alumno="vf_eliminar".$vl_fila_alumno[id_alumno];
				if (isset($$vl_elininar_alumno)){ 
					$vl_alumnos_eliminados++;
					mysql_query("DELETE FROM examen_final_notas WHERE id_alumno=$vl_fila_alumno[id_alumno] and id_examen_final=$idf");
				}
			}
			if ($vl_alumnos_eliminados==0){
				$vl_mensaje="ERROR: Debes seleccionar un alumno";
				header("Location:final_alumnos_administrar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&idf=$idf");
				die();
			}
			else  $vl_mensaje="Se eliminaron con éxito $vl_alumnos_eliminados alumnos";
		}
		else{
        	$vl_mensaje_error="ERROR: No existen alumnos en la comision seleccionada";
        	header("Location:final_listado.php?mensaje=$vl_mensaje_error&PHPSESSID=$PHPSESSID");
			die();
		}

	} // if $vf_elim està seteada
	

header("Location:final_alumnos_administrar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&idf=$idf");
die();
?>