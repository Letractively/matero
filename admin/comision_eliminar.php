<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_eliminar.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   08-11-03.
*            Ultima Modificacion:   08-11-03.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   elimina una comision de la bd
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","comision_modificar.html");

//mysql_query("DELETE FROM comision WHERE id_comision=$idc");

if ($vf_confirmado){ // variable que es agregada desde javascript
	if (!mysql_query("DELETE FROM comision WHERE id_comision=$idc")){
		//Mensaje error
		$texto="ERROR: Problemas al eliminar la comisión, comuníquese con el administrador del MaTero";
		/// eliminar también todo lo relacionado exàmenes, relaciones con alumnos, etc.
	} 
	else{
		//Mensaje exito
		$texto="Se eliminó satisfactoriamente la comisión";
	}
}
else{$texto="";}
header("Location:comision_administrar.php?PHPSESSID=$PHPSESSID&mensaje=$texto");
die();
?>