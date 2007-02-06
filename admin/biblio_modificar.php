<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   biblio_modificar.php
*                          Autor:   Angeletti, Mariano R.
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
                            from biblio
                            where id_catedra='$vs_id_catedra'");

if(!mysql_num_rows($vl_consulta)){$vl_mensaje="No hay bibliografía cargada en la cátedra";
	 header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");die;}

else{                                                                     
        if($eliminar){
              while($vl_fila=mysql_fetch_array($vl_consulta)){
                                $vl_id="vf_elim_".$vl_fila[id_biblio];
                                $vl_id=$$vl_id;
                                $vl_id_tipo=$vl_fila[id_biblio];
                                if(isset($vl_id)){mysql_query("DELETE FROM biblio
                                                               WHERE id_biblio='$vl_id_tipo'
                                                                     and id_catedra='$vs_id_catedra'");}
                $vl_mensaje="Bibliografía eliminada satisfactoriamente";
			 }
		}                                                 
        if($otro){
                        header("Location:biblio_alta.php?PHPSESSID=$PHPSESSID&menu=1");
                        die;
        }

}
header("Location:biblio_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
die();
?>