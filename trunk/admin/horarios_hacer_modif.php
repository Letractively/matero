<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   horarios_hacer_modif.php
*                          Autor:   Angeletti, Mariano R., Omar, Darío R.
*                 Fecha Creacion:   17-01-04.
*            Ultima Modificacion:   26-01-04.
*           Campos que lee en BD:   tabla horarios
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");


$vf_horario=str_replace("\r\n","",$vf_horario);
$vf_horario=str_replace("\'","&acute;",$vf_horario); //&acute;

if (mysql_query("UPDATE horarios set horarios = '$vf_horario' WHERE id_catedra =  '$vs_id_catedra'")){
	$vl_mensaje = "La actualización del horario ha sido todo un éxito";
  }

header("Location:horarios_modificar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
?>