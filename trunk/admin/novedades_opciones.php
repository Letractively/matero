<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   apuntes_modificaciones.php
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

if ($otro) { header("Location:novedades_alta.php?PHPSESSID=$PHPSESSID&menu=1");
              die;   }


if ($eliminar){
                    $vl_query=mysql_query("Select *
                                           from novedades
                                           where id_catedra='$vs_id_catedra'");
     if (!mysql_num_rows($vl_query))
                                       { header("Location:menu.php?PHPSESSID=$PHPSESSID");
                                       die;
                                       }

     else{

      while ($vl_fila=mysql_fetch_array($vl_query)){
                $vl_elim="vf_elim_".$vl_fila[id_novedades];
                  $vl_elim=$$vl_elim;
                   if ($vl_elim==1)    {
                       mysql_query("Delete From novedades where id_novedades='$vl_fila[id_novedades]' and id_catedra='$vs_id_catedra'");
                       $vl_mensaje="Eliminación exitosa";
                    }// if
      }//while
      }//else
}

header("Location:novedades_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");


?>