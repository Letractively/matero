<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_hacer_actualizar.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   08-11-03.
*            Ultima Modificacion:   08-11-03.
*           Campos que lee en BD:   tabla comision
*      Campos que Modifica en BD:   tabla comision
*  Descripcion de funcionamiento:
*              Funciones que usa:	actualiza los campos activa y publicar de la bd.
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_consulta_comisiones=mysql_query("SELECT id_comision FROM comision WHERE id_catedra=$vs_id_catedra");
if (mysql_num_rows($vl_consulta_comisiones)){
       while($vl_fila=mysql_fetch_array($vl_consulta_comisiones)){
       $vl_publica="vf_publica_$vl_fila[id_catedra]";
       $vl_activa="vf_activa_$vl_fila[id_catedra]";	   
       $vl_idc=$$vl_idc;
        if($vl_idc=='1'){
                   $vl_deleteadas ++;
                   $vl_id=$vl_fila[id_catedra];
                   deldir("../archivos/$vl_id");// borra todos los directorios y subdirectorios de la cátedra
                   mysql_query("Delete from catedra where id_catedra='$vl_id'");
                   mysql_query("Delete from catedra_carrera where id_catedra='$vl_id'");
                   mysql_query("Delete from usuario_catedra where id_catedra='$vl_id'");
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
        $vl_mensaje_error="ERROR: No existen comisiones cargadas";
        header("Location:menu.php?mensaje=$vl_mensaje_error&PHPSESSID=$PHPSESSID");
}
?>