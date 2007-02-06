<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   examen_parcial_eliminar.php
*                          Autor:   A.U.S. Sánchez, Guido S.
*                 Fecha Creacion:   28-02-04.
*            Ultima Modificacion:   28-02-04.
*           Campos que lee en BD:   ninguna
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   elimina relaciones comisión-exámen parcial y las notas de los alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_consulta_parciales=mysql_query("SELECT *
                                  FROM examen_parcial_comision
                                  WHERE id_comision=$vf_id_comision");

if (mysql_num_rows($vl_consulta_parciales)){
                        $vl_parciales_eliminados=0;
                        while($vl_fila_parciales=mysql_fetch_array($vl_consulta_parciales)){
                                $vl_elininar_parciales="vf_eliminar".$vl_fila_parciales[id_examen_parcial];
                                if (isset($$vl_elininar_parciales)){
                                   $vl_parciales_eliminados++;
                                   if (!mysql_query("DELETE FROM examen_parcial_comision WHERE id_examen_parcial=$vl_fila_parciales[id_examen_parcial] and id_comision=$vf_id_comision"))
									   	$vl_mensaje.="ERROR: Problemas al eliminar Exámen Parcial, informe al administrador del MaTero";
									else{ // si no hubo problemas elimino las notas del parcial eliminado
										if (!mysql_query("DELETE FROM examen_parcial_notas WHERE id_examen_parcial=$vl_fila_parciales[id_examen_parcial]"))
											$vl_mensaje.="ERROR: Problemas al eliminar las Notas del Exámen Parcial, informe al administrador del MaTero";
											/// estaría bueno que se mando un mail automáticamente al administrador
									}
									
                                }
                        }
                        if ($vl_parciales_eliminados==0){
                                if (!isset($vl_mensaje)) $vl_mensaje.="ERROR: Debes seleccionar un exámen parcial";
                                header("Location:alumnos_administrar.php?PHPSESSID=$PHPSESSID&vl_mensaje=$vl_mensaje&vf_id_comision=$vf_id_comision&vf_pag=$vf_pag");
                                die();
                        }
                        else  if (!isset($vl_mensaje)) $vl_mensaje.="Se eliminaron con éxito $vl_parciales_eliminados Exámenes Parciales";
                }
header("Location:examen_parcial_administrar.php?vf_id_comision=$vf_id_comision&PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");				
die();
?>