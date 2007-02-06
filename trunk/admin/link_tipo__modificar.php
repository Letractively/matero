<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:  link_tipo_modificar.php
*                          Autor:    Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   segun la accion que se haya iniciado, puede eliminar, guardad cambios de posicion o ir a la pantalla de agregar otro integrante
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_consulta=mysql_query("Select *
                            from link_tipo
                            where id_catedra='$vs_id_catedra'");

if(!mysql_num_rows($vl_consulta)){$vl_mensaje="No hay tipos de links cargados en la cátedra";
	 header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");die;}

else{                                                                     
        if($eliminar){
              while($vl_fila=mysql_fetch_array($vl_consulta)){
                                $vl_id="vf_elim_".$vl_fila[id_link_tipo];
                                $vl_id=$$vl_id;
                                $vl_id_tipo=$vl_fila[id_link_tipo];
                                if(isset($vl_id)){mysql_query("DELETE FROM link_tipo
                                                               WHERE id_link_tipo='$vl_id_tipo'
                                                                     AND id_catedra='$vs_id_catedra'");
												  mysql_query("DELETE FROm links
												  				WHERE id_catedra = '$vs_id_catedra'
																AND id_link_tipo = '$vl_id_tipo'");					 
																	 }
                $vl_mensaje="Tipos de links eliminados satisfactoriamente";
			 }
		}                                                 
        if($otro){
                        header("Location:link_tipo_alta.php?PHPSESSID=$PHPSESSID&menu=1");
                        die;
        }

}
header("Location:link_tipo_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
die();
?>