<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   profesor_modificaciones.php
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
                                                        from profesor
                                                        where id_catedra='$vs_id_catedra'");

if(!mysql_num_rows($vl_consulta)){$vl_mensaje="No hay profesores cargados en la cátedra";
	 header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");die;}

else{                                                                     
        if($eliminar){
              while($vl_fila=mysql_fetch_array($vl_consulta)){
                                $vl_id="vf_elim_".$vl_fila[id_profesor];
                                $vl_id=$$vl_id;
                                $vl_id_profe=$vl_fila[id_profesor];
                                if(isset($vl_id)){mysql_query("DELETE FROM profesor
                                                               WHERE id_profesor='$vl_id_profe'
                                                                     and id_catedra='$vs_id_catedra'");}
                $vl_mensaje="Integrantes de catedras eliminados satisfactoriamente";
			 }
		}                                                 
        if($guardar){
                        while($vl_fila=mysql_fetch_array($vl_consulta)){
                                $vl_id="vf_pos_$vl_fila[id_profesor]";
                                $vl_id=$$vl_id;
                                mysql_query("UPDATE profesor SET
                                                 posicion='$vl_id'
                                                 WHERE id_profesor='$vl_fila[id_profesor]'
                                                 and id_catedra='$vs_id_catedra' ");}
                $vl_mensaje="Integrantes de catedras MODIFICADOS satisfactoriamente";
        }
        if($otro){
                        header("Location:profesor_alta.php?PHPSESSID=$PHPSESSID&menu=1");
                        die;
        }

}
header("Location:profesor_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
die();
?>