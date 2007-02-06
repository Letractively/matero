<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_hacer_administrar.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   21-01-04.
*            Ultima Modificacion:   21-01-04.
*           Campos que lee en BD:   tabla comision
*      Campos que Modifica en BD:   
*  Descripcion de funcionamiento:   actualiza el estado de una comisión (publica / activa)
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
$vl_consulta_comision=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra");
if (mysql_num_rows($vl_consulta_comision)){
	while($vl_fila_comision=mysql_fetch_array($vl_consulta_comision)){
		$vl_publicar="vf_publicar_".$vl_fila_comision[id_comision];$vl_publicar=$$vl_publicar;
		$vl_activa="vf_activa_".$vl_fila_comision[id_comision];$vl_activa=$$vl_activa;
		if ($vl_publicar!='1') $vl_publicar='0';
		if ($vl_activa!='1') $vl_activa='0';
		if (!mysql_query("UPDATE comision SET publicar='$vl_publicar',
										 activa='$vl_activa'
					WHERE id_comision=$vl_fila_comision[id_comision]")){
			$vl_mensaje="ERROR: Error con la comisión $vl_fila_comision[nombre], comuníquese con el administrador del MaTero";
			header("Location:comision_administrar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");			
			die();
		}
					
	}// while
	session_unregister("vs_id_comision");
	$vl_mensaje="Actualización de comisiones exitosa";							
}
else{
	$vl_mensaje="ERROR: Problemas con las comisiones, comuníquese con el administrador del MaTero";
}
header("Location:comision_administrar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
?>