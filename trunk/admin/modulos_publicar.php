<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   modulos_listado.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/

include("seguridad_intranet.php");

$vl_consulta=mysql_query("Select *
                            from modulos
                            where id_catedra='$vs_id_catedra'
                            ");

if (!mysql_num_rows($vl_consulta)){
                                      $vl_mensaje="ERROR: No existen modulos cargados";
                                      header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
                                      die;}
while ($vl_fila=mysql_fetch_array($vl_consulta))
{
$vl_publi="vf_publi_".$vl_fila[id_modulo];
$vl_publi=$$vl_publi;
if ($vl_publi != 1) $vl_publi=0;
 mysql_query ("UPDATE `modulos` SET `publicar` = '$vl_publi' WHERE `id_modulo` = '$vl_fila[id_modulo]'");
}

header("Location:modulos_listado.php?PHPSESSID=$PHPSESSID&mensaje=Módulos Actualizados");


?>