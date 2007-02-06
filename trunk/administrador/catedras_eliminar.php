<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   catedras_eliminar.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   18-10-03.
*            Ultima Modificacion:   18-10-03.
*           Campos que lee en BD:   tabla catedra,carrera
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_deleteadas=0;
$vl_consulta_catedra=mysql_query("SELECT id_catedra FROM catedra");
if (mysql_num_rows($vl_consulta_catedra)){
        while($vl_fila=mysql_fetch_array($vl_consulta_catedra)){
       $vl_idc="vf_checkbox_$vl_fila[id_catedra]";
       $vl_idc=$$vl_idc;
        if($vl_idc=='1'){
                   $vl_deleteadas ++;
                   $vl_id=$vl_fila[id_catedra];
                   deldir("../archivos/$vl_id");// borra todos los directorios y subdirectorios de la cátedra
                   mysql_query("Delete from catedra where id_catedra='$vl_id'");
                   mysql_query("Delete from catedra_carrera where id_catedra='$vl_id'");
                   mysql_query("Delete from usuario_catedra where id_catedra='$vl_id'");
				   mysql_query("Delete from alumno_comision where id_catedra='$vl_id'");
				   /*mysql_query("Delete from apuntes where id_catedra='$vl_id'");
				   mysql_query("Delete from biblio where id_catedra='$vl_id'");
				   mysql_query("Delete from biblio_tipo where id_catedra='$vl_id'");
				   mysql_query("Delete from catedra_plan where id_catedra='$vl_id'");

				   $vl_consulta_ef=mysql_query("Select id_examen_final from examen_final where id_catedra='$vl_id'");
				   while ($vl_fila_ef=mysql_fetch_array($vl_consulta_ef)){
				   		mysql_query("Delete from examen_final_notas where id_examen_final=$vl_fila_ef[id_examen_final]");													
				   };
				   $vl_consulta_comi=mysql_query("Select id_comision from comsion where id_catedra='$vl_id'");				   
				   while ($vl_fila_comi=mysql_fetch_array($vl_consulta_comi)){
				   		$vl_consulta_ep=mysql_query("Select id_examen_parcial from examen_parcial_comision where id_comision=$vl_fila_comi[id_comision]");		
						while($vl_fila_ep=mysql_fetch_array($vl_consulta_ep)){
							mysql_query("Delete from e where id_comision=$vl_fila_comisiones[id_comision]");		
						}
						mysql_query("Delete from alumnos_comision where id_comision=$vl_fila_comisiones[id_comision]");							
				   };*/				
				   						   
        }
        }
        if (!$vl_deleteadas){
                $vl_mensaje_error="ERROR: Debe seleccionar las cátedras que desea borrar";
                header("Location:catedras_administrar.php?mensaje=$vl_mensaje_error&PHPSESSID=$PHPSESSID");
        }
        else{
                $vl_mensaje_info="Se han borrado ".negrita($vl_deleteadas)." cátedras";
                header("Location:catedras_administrar.php?mensaje=$vl_mensaje_info&PHPSESSID=$PHPSESSID");
        }
}
else{
        $vl_mensaje_error="ERROR: No existen cátedras cargadas";
        header("Location:catedras_administrar.php?mensaje=$vl_mensaje_error&PHPSESSID=$PHPSESSID");
}
?>