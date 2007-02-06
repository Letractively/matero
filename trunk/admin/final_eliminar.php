<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_eliminar.php
*                          Autor:   Mariano Angeletti   
*                 Fecha Creacion:   29-01-04.
*            Ultima Modificacion:   29-01-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   elimina un examen cargado
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

if (isset($otro)){header("Location:final_alta.php?PHPSESSID=$PHPSESSID&menu=1");
				  die;}
if (isset($eliminar)) {
				$vl_query=mysql_query("Select * from examen_final where id_catedra='$vs_id_catedra'");

	if (!mysql_num_rows($vl_query)) {
								$vl_mensaje="No hay exámenes para la cátedra";
								header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
								die;
								}
	$vl_contador = 0;   // verifica la selección de algún exámen 
	while ($vl_fila=mysql_fetch_array($vl_query)){
		$vl_elim = "vf_elim_$vl_fila[id_examen_final]";
 		if($$vl_elim==1){
			$vl_contador++;
			mysql_query("Delete from examen_final Where id_examen_final= $vl_fila[id_examen_final]");
			}
     }
	 if ($vl_contador!=0) $vl_mensaje = "El exámen se eliminó exitosamente";
header("Location:final_listado.php?mensaje=$vl_mensaje&PHPSESSID=$PHPSESSID");
}

?>