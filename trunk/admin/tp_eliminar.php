<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   tp_eliminar.php
*                          Autor:   A.U.S. S�nchez, Guido S.- Angeletti, Mariano
*                 Fecha Creacion:   28-02-04.
*            Ultima Modificacion:   28-02-04.
*           Campos que lee en BD:   ninguna
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   elimina relaciones comisi�n-ex�men parcial y las notas de los alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_consulta_tp=mysql_query("SELECT *
                                  FROM tp_comision
                                  WHERE id_comision=$vf_id_comision");

if (mysql_num_rows($vl_consulta_tp)){
                        $vl_tp_eliminados=0;
                        while($vl_fila_tp=mysql_fetch_array($vl_consulta_tp)){
                                $vl_eliminar_tp="vf_eliminar".$vl_fila_tp[id_tp];
                                if (isset($$vl_eliminar_tp)){
                                   $vl_tp_eliminados++;
                                   if (!mysql_query("DELETE FROM tp_comision WHERE id_tp=$vl_fila_tp[id_tp] and id_comision=$vf_id_comision"))
									   	$vl_mensaje.="ERROR: Problemas al eliminar Trabajo Pr�ctico, informe al administrador del MaTero";
									else{ // si no hubo problemas elimino las notas del parcial eliminado
										if (!mysql_query("DELETE FROM trabajo_practico_notas WHERE id_tp=$vl_fila_tp[id_tp]"))
											$vl_mensaje.="ERROR: Problemas al eliminar las Notas del Trabajo Practico, informe al administrador del MaTero";
											/// estar�a bueno que se mando un mail autom�ticamente al administrador
									}
									
                                }
                        }
                        if ($vl_tp_eliminados==0){
                                if (!isset($vl_mensaje)) $vl_mensaje.="ERROR: Debes seleccionar un trabajo pr�ctico para eliminar";
                                header("Location:tp_administrar.php?PHPSESSID=$PHPSESSID&vl_mensaje=$vl_mensaje&vf_id_comision=$vf_id_comision&vf_pag=$vf_pag");
                                die();
                        }
                        else  if (!isset($vl_mensaje)) $vl_mensaje.="Se eliminaron con �xito $vl_tp_eliminados Trabajos Pr�cticos seleccionados";
                }
header("Location:tp_administrar.php?vf_id_comision=$vf_id_comision&PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");				
die();
?>